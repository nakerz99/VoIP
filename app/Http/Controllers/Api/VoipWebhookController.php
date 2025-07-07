<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\VoipIntegrationService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

/**
 * VOIP Webhook Controller
 * 
 * This controller handles incoming webhooks from VOIP systems like 3CX.
 * These endpoints should be secured with proper authentication in production.
 */
class VoipWebhookController extends Controller
{
    protected VoipIntegrationService $voipService;

    public function __construct(VoipIntegrationService $voipService)
    {
        $this->voipService = $voipService;
    }

    /**
     * Handle incoming call webhook from 3CX
     * 
     * Expected payload:
     * {
     *   "call_id": "3CX-12345",
     *   "phone_number": "+1-555-0123",
     *   "caller_name": "John Doe",
     *   "extension": "101",
     *   "timestamp": "2025-07-06T10:30:00Z"
     * }
     */
    public function incomingCall(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'call_id' => 'required|string',
                'phone_number' => 'required|string',
                'caller_name' => 'nullable|string',
                'extension' => 'nullable|string',
                'timestamp' => 'nullable|string',
            ]);

            Log::info('VOIP Webhook: Incoming call received', $validated);

            $callTicket = $this->voipService->initializeCall($validated);

            if ($callTicket) {
                return response()->json([
                    'success' => true,
                    'message' => 'Call ticket created successfully',
                    'ticket_id' => $callTicket->id,
                    'voip_call_id' => $callTicket->voip_call_id,
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Failed to create call ticket',
            ], 422);

        } catch (\Exception $e) {
            Log::error('VOIP Webhook: Error processing incoming call', [
                'error' => $e->getMessage(),
                'payload' => $request->all(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Internal server error',
            ], 500);
        }
    }

    /**
     * Handle call status update webhook from 3CX
     * 
     * Expected payload:
     * {
     *   "call_id": "3CX-12345",
     *   "status": "answered|ended|transferred",
     *   "agent_extension": "102",
     *   "duration": 180,
     *   "timestamp": "2025-07-06T10:33:00Z"
     * }
     */
    public function callStatusUpdate(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'call_id' => 'required|string',
                'status' => 'required|string|in:answered,ended,transferred,abandoned',
                'agent_extension' => 'nullable|string',
                'duration' => 'nullable|integer',
                'timestamp' => 'nullable|string',
            ]);

            Log::info('VOIP Webhook: Call status update received', $validated);

            $success = $this->voipService->updateCallStatus($validated['call_id'], $validated);

            if ($success) {
                return response()->json([
                    'success' => true,
                    'message' => 'Call status updated successfully',
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Call not found or update failed',
            ], 404);

        } catch (\Exception $e) {
            Log::error('VOIP Webhook: Error updating call status', [
                'error' => $e->getMessage(),
                'payload' => $request->all(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Internal server error',
            ], 500);
        }
    }

    /**
     * Handle agent status update webhook from 3CX
     * 
     * Expected payload:
     * {
     *   "agent_extension": "102",
     *   "status": "available|busy|away|on_call",
     *   "agent_id": 1,
     *   "timestamp": "2025-07-06T10:35:00Z"
     * }
     */
    public function agentStatusUpdate(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'agent_extension' => 'required|string',
                'status' => 'required|string|in:available,busy,away,on_call',
                'agent_id' => 'nullable|integer|exists:users,id',
                'timestamp' => 'nullable|string',
            ]);

            Log::info('VOIP Webhook: Agent status update received', $validated);

            // TODO: Implement agent status tracking in database
            // This could involve creating an AgentStatus model to track real-time status

            return response()->json([
                'success' => true,
                'message' => 'Agent status updated successfully',
            ]);

        } catch (\Exception $e) {
            Log::error('VOIP Webhook: Error updating agent status', [
                'error' => $e->getMessage(),
                'payload' => $request->all(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Internal server error',
            ], 500);
        }
    }

    /**
     * Handle call end webhook from 3CX
     * 
     * Expected payload:
     * {
     *   "call_id": "3CX-12345",
     *   "end_reason": "completed|abandoned|transferred",
     *   "total_duration": 300,
     *   "recording_url": "https://3cx.example.com/recordings/12345.wav",
     *   "timestamp": "2025-07-06T10:40:00Z"
     * }
     */
    public function callEnded(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'call_id' => 'required|string',
                'end_reason' => 'required|string|in:completed,abandoned,transferred,error',
                'total_duration' => 'nullable|integer',
                'recording_url' => 'nullable|url',
                'timestamp' => 'nullable|string',
            ]);

            Log::info('VOIP Webhook: Call ended received', $validated);

            $success = $this->voipService->endCall($validated['call_id']);

            if ($success) {
                return response()->json([
                    'success' => true,
                    'message' => 'Call ended successfully',
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Call not found or end failed',
            ], 404);

        } catch (\Exception $e) {
            Log::error('VOIP Webhook: Error ending call', [
                'error' => $e->getMessage(),
                'payload' => $request->all(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Internal server error',
            ], 500);
        }
    }

    /**
     * Test endpoint for VOIP integration
     * This can be used by 3CX administrators to test webhook connectivity
     */
    public function test(Request $request): JsonResponse
    {
        Log::info('VOIP Webhook: Test endpoint called', $request->all());

        return response()->json([
            'success' => true,
            'message' => 'VOIP webhook integration is working',
            'timestamp' => now()->toISOString(),
            'received_data' => $request->all(),
        ]);
    }
}
