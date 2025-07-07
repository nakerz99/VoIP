<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                    Call Ticket #{{ $callTicket->id }}
                </h2>
                <p class="text-sm text-gray-600 mt-1">Managing call from {{ $callTicket->caller->name ?? 'Unknown Caller' }}</p>
            </div>
            <div class="flex items-center space-x-3">
                <span class="inline-flex px-4 py-2 text-sm font-semibold rounded-xl 
                    @if($callTicket->status === 'active') bg-green-100 text-green-800 ring-2 ring-green-200
                    @elseif($callTicket->status === 'completed') bg-blue-100 text-blue-800 ring-2 ring-blue-200
                    @elseif($callTicket->status === 'forwarded') bg-yellow-100 text-yellow-800 ring-2 ring-yellow-200
                    @elseif($callTicket->status === 'escalated') bg-red-100 text-red-800 ring-2 ring-red-200
                    @else bg-gray-100 text-gray-800 ring-2 ring-gray-200 @endif">
                    {{ ucfirst($callTicket->status) }}
                </span>
                <span class="inline-flex px-4 py-2 text-sm font-semibold rounded-xl 
                    @if($callTicket->priority === 'urgent') bg-red-100 text-red-800 ring-2 ring-red-200
                    @elseif($callTicket->priority === 'high') bg-orange-100 text-orange-800 ring-2 ring-orange-200
                    @elseif($callTicket->priority === 'medium') bg-yellow-100 text-yellow-800 ring-2 ring-yellow-200
                    @else bg-green-100 text-green-800 ring-2 ring-green-200 @endif">
                    @if($callTicket->priority === 'urgent')
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                    @endif
                    {{ ucfirst($callTicket->priority) }}
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Success/Error Messages -->
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Call Details -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-6">
                        <h3 class="text-lg font-semibold text-gray-900">Call Details</h3>
                        <div class="flex space-x-2">
                            <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full 
                                @if($callTicket->status === 'active') bg-green-100 text-green-800
                                @elseif($callTicket->status === 'completed') bg-blue-100 text-blue-800
                                @elseif($callTicket->status === 'forwarded') bg-yellow-100 text-yellow-800
                                @elseif($callTicket->status === 'escalated') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ ucfirst($callTicket->status) }}
                            </span>
                            <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full 
                                @if($callTicket->priority === 'urgent') bg-red-100 text-red-800
                                @elseif($callTicket->priority === 'high') bg-orange-100 text-orange-800
                                @elseif($callTicket->priority === 'medium') bg-yellow-100 text-yellow-800
                                @else bg-green-100 text-green-800 @endif">
                                {{ ucfirst($callTicket->priority) }}
                            </span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="font-semibold text-gray-700 mb-3">Call Information</h4>
                            <dl class="space-y-2">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Phone Number</dt>
                                    <dd class="text-sm text-gray-900">{{ $callTicket->phone_number }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Caller Name</dt>
                                    <dd class="text-sm text-gray-900">{{ $callTicket->caller->name ?? 'Unknown' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Call Started</dt>
                                    <dd class="text-sm text-gray-900">{{ $callTicket->call_started_at->format('M d, Y H:i:s') }}</dd>
                                </div>
                                @if($callTicket->call_ended_at)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Call Ended</dt>
                                    <dd class="text-sm text-gray-900">{{ $callTicket->call_ended_at->format('M d, Y H:i:s') }}</dd>
                                </div>
                                @endif
                                @if($callTicket->call_duration)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Duration</dt>
                                    <dd class="text-sm text-gray-900">{{ $callTicket->call_duration_formatted }}</dd>
                                </div>
                                @endif
                            </dl>
                        </div>

                        <div>
                            <h4 class="font-semibold text-gray-700 mb-3">Assignment</h4>
                            <dl class="space-y-2">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Assigned Agent</dt>
                                    <dd class="text-sm text-gray-900">{{ $callTicket->agent->name ?? 'Unassigned' }}</dd>
                                </div>
                                @if($callTicket->voip_call_id)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">VOIP Call ID</dt>
                                    <dd class="text-sm text-gray-900 font-mono">{{ $callTicket->voip_call_id }}</dd>
                                </div>
                                @endif
                            </dl>
                        </div>
                    </div>

                    @if($callTicket->description)
                    <div class="mt-6">
                        <h4 class="font-semibold text-gray-700 mb-2">Description</h4>
                        <p class="text-sm text-gray-900 bg-gray-50 p-3 rounded">{{ $callTicket->description }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Caller Information & History -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Caller Information</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="font-semibold text-gray-700 mb-3">Contact Details</h4>
                            <dl class="space-y-2">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Name</dt>
                                    <dd class="text-sm text-gray-900">{{ $callTicket->caller->name ?? 'Unknown' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Phone</dt>
                                    <dd class="text-sm text-gray-900">{{ $callTicket->caller->phone_number }}</dd>
                                </div>
                                @if($callTicket->caller->email)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Email</dt>
                                    <dd class="text-sm text-gray-900">{{ $callTicket->caller->email }}</dd>
                                </div>
                                @endif
                                @if($callTicket->caller->company)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Company</dt>
                                    <dd class="text-sm text-gray-900">{{ $callTicket->caller->company }}</dd>
                                </div>
                                @endif
                            </dl>
                        </div>

                        <div>
                            <h4 class="font-semibold text-gray-700 mb-3">Call History</h4>
                            @if($callTicket->caller->call_history->count() > 0)
                                <div class="space-y-2">
                                    @foreach($callTicket->caller->call_history->take(5) as $log)
                                        <div class="text-sm border-l-4 border-blue-400 pl-3">
                                            <div class="font-medium">{{ $log->call_type }} - {{ $log->status }}</div>
                                            <div class="text-gray-600">{{ $log->call_started_at->format('M d, Y H:i') }} ({{ $log->call_duration_formatted }})</div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-sm text-gray-500">No previous call history.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            @if($callTicket->status === 'active')
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
                    
                    <div class="flex flex-wrap gap-3">
                        @if(!$callTicket->agent_id)
                            <form method="POST" action="{{ route('call-tickets.assign-to-me', $callTicket) }}" class="inline">
                                @csrf
                                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                    Assign to Me
                                </button>
                            </form>
                        @endif

                        <form method="POST" action="{{ route('call-tickets.complete', $callTicket) }}" class="inline">
                            @csrf
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                                    onclick="return confirm('Are you sure you want to complete this call?')">
                                Complete Call
                            </button>
                        </form>

                        <button onclick="document.getElementById('escalate-modal').style.display='block'" 
                                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                            Escalate
                        </button>

                        <button onclick="document.getElementById('forward-modal').style.display='block'" 
                                class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                            Forward
                        </button>
                    </div>
                </div>
            </div>
            @endif

            <!-- Notes Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Call Notes</h3>
                    
                    <!-- Add Note Form -->
                    <form method="POST" action="{{ route('call-tickets.add-note', $callTicket) }}" class="mb-6">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label for="note" class="block text-sm font-medium text-gray-700">Add Note</label>
                                <textarea id="note" name="note" rows="3" required
                                          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                          placeholder="Enter your note here..."></textarea>
                            </div>
                            
                            <div class="flex space-x-4">
                                <div>
                                    <label for="type" class="block text-sm font-medium text-gray-700">Note Type</label>
                                    <select id="type" name="type" class="mt-1 block border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                        <option value="general">General</option>
                                        <option value="escalation">Escalation</option>
                                        <option value="resolution">Resolution</option>
                                        <option value="follow_up">Follow Up</option>
                                    </select>
                                </div>
                                
                                <div class="flex items-center mt-6">
                                    <input id="is_internal" name="is_internal" type="checkbox" value="1"
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <label for="is_internal" class="ml-2 block text-sm text-gray-900">Internal Note</label>
                                </div>
                            </div>
                            
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Add Note
                            </button>
                        </div>
                    </form>

                    <!-- Existing Notes -->
                    @if($callTicket->notes->count() > 0)
                        <div class="space-y-4">
                            @foreach($callTicket->notes->sortByDesc('created_at') as $note)
                                <div class="border-l-4 border-blue-400 pl-4 py-3 bg-gray-50 rounded-r">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <p class="text-sm text-gray-900">{{ $note->note }}</p>
                                            <div class="mt-2 flex items-center space-x-4 text-xs text-gray-500">
                                                <span>{{ $note->user->name }}</span>
                                                <span>{{ $note->created_at->format('M d, Y H:i') }}</span>
                                                <span class="inline-flex px-2 py-1 rounded-full bg-gray-200 text-gray-800">
                                                    {{ ucfirst(str_replace('_', ' ', $note->type)) }}
                                                </span>
                                                @if($note->is_internal)
                                                    <span class="inline-flex px-2 py-1 rounded-full bg-red-200 text-red-800">Internal</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">No notes added yet.</p>
                    @endif
                </div>
            </div>

            <!-- Back Button -->
            <div class="flex justify-between">
                <a href="{{ route('dashboard') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Back to Dashboard
                </a>
                <a href="{{ route('call-tickets.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    View All Tickets
                </a>
            </div>
        </div>
    </div>

    <!-- Escalate Modal -->
    <div id="escalate-modal" style="display:none" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Escalate Call</h3>
            <form method="POST" action="{{ route('call-tickets.escalate', $callTicket) }}">
                @csrf
                <div class="mb-4">
                    <label for="escalate_note" class="block text-sm font-medium text-gray-700">Escalation Reason</label>
                    <textarea id="escalate_note" name="note" rows="3" required
                              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500"
                              placeholder="Please provide reason for escalation..."></textarea>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="document.getElementById('escalate-modal').style.display='none'"
                            class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Cancel
                    </button>
                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                        Escalate
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Forward Modal -->
    <div id="forward-modal" style="display:none" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Forward Call</h3>
            <form method="POST" action="{{ route('call-tickets.forward', $callTicket) }}">
                @csrf
                <div class="mb-4">
                    <label for="agent_id" class="block text-sm font-medium text-gray-700">Forward to Agent</label>
                    <select id="agent_id" name="agent_id" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500">
                        <option value="">Select an agent...</option>
                        @foreach(\App\Models\User::where('id', '!=', auth()->id())->get() as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label for="forward_note" class="block text-sm font-medium text-gray-700">Note (Optional)</label>
                    <textarea id="forward_note" name="note" rows="2"
                              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500"
                              placeholder="Additional context for the receiving agent..."></textarea>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="document.getElementById('forward-modal').style.display='none'"
                            class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Cancel
                    </button>
                    <button type="submit" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                        Forward
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
