<?php

namespace App\Http\Controllers;

use App\Models\CallTicket;
use App\Models\CallLog;
use App\Services\VoipIntegrationService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    protected VoipIntegrationService $voipService;

    public function __construct(VoipIntegrationService $voipService)
    {
        $this->voipService = $voipService;
    }

    /**
     * Display the agent dashboard
     */
    public function index(): View
    {
        // Get active call tickets
        $activeTickets = CallTicket::with(['caller', 'agent', 'notes.user'])
            ->active()
            ->orderBy('call_started_at', 'desc')
            ->get();

        // Get recent call logs for context
        $recentCallLogs = CallLog::with(['caller', 'agent'])
            ->orderBy('call_started_at', 'desc')
            ->limit(10)
            ->get();

        // Get VOIP statistics (placeholder data)
        $statistics = $this->voipService->getCallStatistics();

        return view('dashboard', compact('activeTickets', 'recentCallLogs', 'statistics'));
    }
}
