<x-app-layout>
    <!-- Overlay for sidebar on mobile -->
    <div class="overlay"></div>
    
    <div class="container-fluid p-0">
        <div class="row g-0">
            <!-- Sidebar included via app layout -->
            
            <!-- Main Content -->
            <div class="py-3" id="content">
                <div class="container-fluid">
                    <!-- Top navbar with back button -->
                    <nav class="navbar navbar-expand-lg navbar-light bg-white mb-4 shadow-sm rounded">
                        <div class="container-fluid">
                            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-sm me-2">
                                <i class="fas fa-arrow-left me-1"></i> Back to Dashboard
                            </a>
                            <div>
                                <h4 class="mb-0">Create New Call Ticket</h4>
                                <p class="text-muted small mb-0">Create a new call ticket manually</p>
                            </div>
                        </div>
                    </nav>

                    <!-- Create Form -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <form method="POST" action="{{ route('call-tickets.store') }}">
                                @csrf
                                
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="caller_id" class="form-label">Caller <span class="text-danger">*</span></label>
                                        <select name="caller_id" id="caller_id" class="form-select @error('caller_id') is-invalid @enderror" required>
                                            <option value="">Select a caller</option>
                                            @foreach($callers as $caller)
                                                <option value="{{ $caller->id }}" 
                                                    data-phone="{{ $caller->phone_number }}"
                                                    {{ old('caller_id') == $caller->id ? 'selected' : '' }}>
                                                    {{ $caller->name }} {{ $caller->company ? '(' . $caller->company . ')' : '' }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('caller_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="phone_number" class="form-label">Phone Number <span class="text-danger">*</span></label>
                                        <input type="text" name="phone_number" id="phone_number" 
                                            class="form-control @error('phone_number') is-invalid @enderror" 
                                            value="{{ old('phone_number') }}" required>
                                        @error('phone_number')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="priority" class="form-label">Priority <span class="text-danger">*</span></label>
                                        <select name="priority" id="priority" class="form-select @error('priority') is-invalid @enderror" required>
                                            @foreach($priorities as $value => $label)
                                                <option value="{{ $value }}" {{ old('priority', 'medium') == $value ? 'selected' : '' }}>
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('priority')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="agent_id" class="form-label">Assign to Agent</label>
                                        <select name="agent_id" id="agent_id" class="form-select @error('agent_id') is-invalid @enderror">
                                            <option value="">Unassigned</option>
                                            @foreach($agents as $agent)
                                                <option value="{{ $agent->id }}" {{ old('agent_id') == $agent->id ? 'selected' : '' }}>
                                                    {{ $agent->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('agent_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="description" class="form-label">Initial Notes</label>
                                    <textarea name="description" id="description" rows="4" 
                                        class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                                        <i class="fas fa-times me-1"></i> Cancel
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-1"></i> Create Ticket
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- JavaScript for form functionality -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-populate phone number when caller is selected
            const callerSelect = document.getElementById('caller_id');
            const phoneInput = document.getElementById('phone_number');
            
            callerSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const phoneNumber = selectedOption.getAttribute('data-phone');
                
                if (phoneNumber) {
                    phoneInput.value = phoneNumber;
                }
            });
        });
    </script>
</x-app-layout>
