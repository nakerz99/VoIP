<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Caller;
use App\Models\CallTicket;
use App\Models\CallLog;
use App\Models\CallNote;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class CallCenterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create test users (agents)
        $users = [
            [
                'name' => 'John Agent',
                'email' => 'john@example.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Jane Supervisor',
                'email' => 'jane@example.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Mike Support',
                'email' => 'mike@example.com',
                'password' => Hash::make('password'),
            ],
        ];

        foreach ($users as $userData) {
            User::create($userData);
        }

        // Create sample callers
        $callers = [
            [
                'phone_number' => '+1-555-0101',
                'name' => 'Alice Johnson',
                'email' => 'alice.johnson@email.com',
                'company' => 'Tech Corp',
                'address' => '123 Main St, Anytown, USA',
            ],
            [
                'phone_number' => '+1-555-0102',
                'name' => 'Bob Smith',
                'email' => 'bob.smith@email.com',
                'company' => 'ABC Industries',
                'address' => '456 Oak Ave, Somewhere, USA',
            ],
            [
                'phone_number' => '+1-555-0103',
                'name' => 'Carol Davis',
                'email' => 'carol.davis@email.com',
                'company' => null,
                'address' => '789 Pine St, Elsewhere, USA',
            ],
            [
                'phone_number' => '+1-555-0104',
                'name' => 'David Wilson',
                'email' => 'david.wilson@email.com',
                'company' => 'Global Solutions',
                'address' => '321 Elm St, Nowhere, USA',
            ],
            [
                'phone_number' => '+1-555-0105',
                'name' => 'Eva Brown',
                'email' => 'eva.brown@email.com',
                'company' => 'StartUp Inc',
                'address' => '654 Maple Dr, Anyplace, USA',
            ],
        ];

        foreach ($callers as $callerData) {
            Caller::create($callerData);
        }

        $allUsers = User::all();
        $allCallers = Caller::all();

        // Create sample call logs (historical data)
        foreach ($allCallers as $caller) {
            // Create 2-5 historical calls per caller
            $numHistoricalCalls = rand(2, 5);
            
            for ($i = 0; $i < $numHistoricalCalls; $i++) {
                $startTime = Carbon::now()->subDays(rand(1, 30))->subMinutes(rand(0, 1440));
                $duration = rand(60, 1800); // 1-30 minutes
                
                CallLog::create([
                    'caller_id' => $caller->id,
                    'agent_id' => $allUsers->random()->id,
                    'phone_number' => $caller->phone_number,
                    'call_type' => collect(['inbound', 'outbound'])->random(),
                    'status' => collect(['completed', 'abandoned', 'transferred'])->random(),
                    'call_started_at' => $startTime,
                    'call_ended_at' => $startTime->copy()->addSeconds($duration),
                    'call_duration' => $duration,
                    'summary' => 'Historical call regarding ' . collect(['billing inquiry', 'technical support', 'product question', 'service complaint', 'general information'])->random(),
                    'voip_call_id' => 'HIST-' . uniqid(),
                ]);
            }
        }

        // Create some active call tickets
        $activeTickets = [
            [
                'caller_id' => $allCallers->random()->id,
                'agent_id' => null, // Unassigned
                'phone_number' => '+1-555-0201',
                'caller_name' => 'Frank Miller',
                'description' => 'Customer calling about billing discrepancy on recent invoice',
                'status' => 'active',
                'priority' => 'medium',
                'call_started_at' => Carbon::now()->subMinutes(15),
                'voip_call_id' => '3CX-' . uniqid(),
            ],
            [
                'caller_id' => $allCallers->random()->id,
                'agent_id' => $allUsers->random()->id,
                'phone_number' => '+1-555-0202',
                'caller_name' => 'Grace Taylor',
                'description' => 'Technical support needed for software installation',
                'status' => 'active',
                'priority' => 'high',
                'call_started_at' => Carbon::now()->subMinutes(8),
                'voip_call_id' => '3CX-' . uniqid(),
            ],
            [
                'caller_id' => $allCallers->random()->id,
                'agent_id' => $allUsers->random()->id,
                'phone_number' => '+1-555-0203',
                'caller_name' => 'Henry Anderson',
                'description' => 'Urgent: Service outage affecting business operations',
                'status' => 'escalated',
                'priority' => 'urgent',
                'call_started_at' => Carbon::now()->subMinutes(25),
                'voip_call_id' => '3CX-' . uniqid(),
            ],
            [
                'caller_id' => $allCallers->random()->id,
                'agent_id' => $allUsers->random()->id,
                'phone_number' => '+1-555-0204',
                'caller_name' => 'Iris White',
                'description' => 'General inquiry about new service plans',
                'status' => 'active',
                'priority' => 'low',
                'call_started_at' => Carbon::now()->subMinutes(5),
                'voip_call_id' => '3CX-' . uniqid(),
            ],
        ];

        foreach ($activeTickets as $ticketData) {
            $ticket = CallTicket::create($ticketData);
            
            // Add some notes to tickets
            if ($ticket->agent_id) {
                CallNote::create([
                    'call_ticket_id' => $ticket->id,
                    'user_id' => $ticket->agent_id,
                    'note' => 'Initial assessment completed. Customer verified identity.',
                    'type' => 'general',
                    'is_internal' => false,
                ]);

                if (rand(0, 1)) {
                    CallNote::create([
                        'call_ticket_id' => $ticket->id,
                        'user_id' => $ticket->agent_id,
                        'note' => 'Customer seems frustrated. Handling with extra care.',
                        'type' => 'general',
                        'is_internal' => true,
                    ]);
                }
            }
        }

        // Create some completed tickets
        $completedTickets = [
            [
                'caller_id' => $allCallers->random()->id,
                'agent_id' => $allUsers->random()->id,
                'phone_number' => '+1-555-0301',
                'caller_name' => 'Jack Robinson',
                'description' => 'Password reset request',
                'status' => 'completed',
                'priority' => 'low',
                'call_started_at' => Carbon::now()->subHours(2),
                'call_ended_at' => Carbon::now()->subHours(2)->addMinutes(8),
                'call_duration' => 480, // 8 minutes
                'voip_call_id' => '3CX-' . uniqid(),
            ],
            [
                'caller_id' => $allCallers->random()->id,
                'agent_id' => $allUsers->random()->id,
                'phone_number' => '+1-555-0302',
                'caller_name' => 'Kelly Green',
                'description' => 'Account update request',
                'status' => 'completed',
                'priority' => 'medium',
                'call_started_at' => Carbon::now()->subHours(1),
                'call_ended_at' => Carbon::now()->subHours(1)->addMinutes(12),
                'call_duration' => 720, // 12 minutes
                'voip_call_id' => '3CX-' . uniqid(),
            ],
        ];

        foreach ($completedTickets as $ticketData) {
            $ticket = CallTicket::create($ticketData);
            
            // Add resolution note
            CallNote::create([
                'call_ticket_id' => $ticket->id,
                'user_id' => $ticket->agent_id,
                'note' => 'Issue resolved successfully. Customer satisfied with solution.',
                'type' => 'resolution',
                'is_internal' => false,
            ]);
        }

        $this->command->info('Call center sample data created successfully!');
        $this->command->info('Test users created:');
        foreach ($users as $user) {
            $this->command->info("- {$user['email']} (password: password)");
        }
    }
}
