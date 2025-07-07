<?php

namespace App\Http\Controllers;

use App\Models\CallTicket;
use App\Models\CallNote;
use App\Services\VoipIntegrationService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class CallTicketController extends Controller
{
    protected VoipIntegrationService $voipService;

    public function __construct(VoipIntegrationService $voipService)
    {
        $this->voipService = $voipService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $tickets = CallTicket::with(['caller', 'agent', 'notes.user'])
            ->orderBy('call_started_at', 'desc')
            ->paginate(20);

        return view('call-tickets.index', compact('tickets'));
    }

    /**
     * Display the specified resource.
     */
    public function show(CallTicket $callTicket): View
    {
        $callTicket->load(['caller.callLogs', 'agent', 'notes.user']);
        
        return view('call-tickets.show', compact('callTicket'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CallTicket $callTicket): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:active,completed,forwarded,escalated',
            'agent_id' => 'nullable|exists:users,id',
            'description' => 'nullable|string',
        ]);

        $callTicket->update($validated);

        // If status changed to completed, end the call via VOIP
        if ($validated['status'] === 'completed' && $callTicket->voip_call_id) {
            $this->voipService->endCall($callTicket->voip_call_id);
        }

        return redirect()->route('call-tickets.show', $callTicket)
            ->with('success', 'Call ticket updated successfully.');
    }

    /**
     * Add a note to the call ticket
     */
    public function addNote(Request $request, CallTicket $callTicket): RedirectResponse
    {
        $validated = $request->validate([
            'note' => 'required|string|max:1000',
            'type' => 'required|in:general,escalation,resolution,follow_up',
            'is_internal' => 'boolean',
        ]);

        $callTicket->notes()->create([
            'user_id' => Auth::id(),
            'note' => $validated['note'],
            'type' => $validated['type'],
            'is_internal' => $validated['is_internal'] ?? false,
        ]);

        return redirect()->route('call-tickets.show', $callTicket)
            ->with('success', 'Note added successfully.');
    }

    /**
     * Assign ticket to current agent
     */
    public function assignToMe(CallTicket $callTicket): RedirectResponse
    {
        $callTicket->update(['agent_id' => Auth::id()]);

        return redirect()->route('call-tickets.show', $callTicket)
            ->with('success', 'Call ticket assigned to you.');
    }

    /**
     * Mark ticket as completed
     */
    public function complete(CallTicket $callTicket): RedirectResponse
    {
        $callTicket->update([
            'status' => 'completed',
            'call_ended_at' => now(),
        ]);

        // End the call via VOIP if applicable
        if ($callTicket->voip_call_id) {
            $this->voipService->endCall($callTicket->voip_call_id);
        }

        return redirect()->route('dashboard')
            ->with('success', 'Call completed successfully.');
    }

    /**
     * Forward ticket to another agent
     */
    public function forward(Request $request, CallTicket $callTicket): RedirectResponse
    {
        $validated = $request->validate([
            'agent_id' => 'required|exists:users,id',
            'note' => 'nullable|string|max:500',
        ]);

        $callTicket->update([
            'agent_id' => $validated['agent_id'],
            'status' => 'forwarded',
        ]);

        // Add forwarding note if provided
        if ($validated['note']) {
            $callTicket->notes()->create([
                'user_id' => Auth::id(),
                'note' => "Forwarded to another agent: " . $validated['note'],
                'type' => 'general',
                'is_internal' => true,
            ]);
        }

        // Transfer call via VOIP if applicable
        if ($callTicket->voip_call_id) {
            $this->voipService->transferCall($callTicket->voip_call_id, $validated['agent_id']);
        }

        return redirect()->route('dashboard')
            ->with('success', 'Call forwarded successfully.');
    }

    /**
     * Escalate ticket
     */
    public function escalate(Request $request, CallTicket $callTicket): RedirectResponse
    {
        $validated = $request->validate([
            'note' => 'required|string|max:500',
        ]);

        $callTicket->update([
            'status' => 'escalated',
            'priority' => 'urgent',
        ]);

        $callTicket->notes()->create([
            'user_id' => Auth::id(),
            'note' => $validated['note'],
            'type' => 'escalation',
            'is_internal' => true,
        ]);

        return redirect()->route('call-tickets.show', $callTicket)
            ->with('success', 'Call escalated successfully.');
    }

    /**
     * Show the form for creating a new call ticket.
     */
    public function create(): View
    {
        $callers = \App\Models\Caller::orderBy('name')->get();
        $agents = \App\Models\User::orderBy('name')->get();
        $priorities = ['low' => 'Low', 'medium' => 'Medium', 'high' => 'High', 'urgent' => 'Urgent'];
        
        return view('call-tickets.create', compact('callers', 'agents', 'priorities'));
    }

    /**
     * Store a newly created call ticket.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'caller_id' => 'required|exists:callers,id',
            'phone_number' => 'required|string',
            'priority' => 'required|in:low,medium,high,urgent',
            'agent_id' => 'nullable|exists:users,id',
            'description' => 'nullable|string',
        ]);
        
        // Get caller info
        $caller = \App\Models\Caller::find($validated['caller_id']);
        
        // Create the call ticket
        $ticket = new CallTicket();
        $ticket->caller_id = $validated['caller_id'];
        $ticket->phone_number = $validated['phone_number'];
        $ticket->caller_name = $caller->name;
        $ticket->priority = $validated['priority'];
        $ticket->agent_id = $validated['agent_id'];
        $ticket->status = 'active';
        $ticket->call_started_at = now();
        $ticket->voip_call_id = 'MANUAL-' . uniqid();
        $ticket->save();
        
        // Add initial note if description provided
        if (!empty($validated['description'])) {
            $note = new CallNote();
            $note->call_ticket_id = $ticket->id;
            $note->user_id = $request->user()->id;
            $note->note = $validated['description'];
            $note->type = 'general';
            $note->save();
        }
        
        // Log activity with VoIP service
        $this->voipService->logManualTicketCreation($ticket);
        
        return redirect()->route('call-tickets.show', $ticket)
            ->with('success', 'Call ticket created successfully.');
    }
}
