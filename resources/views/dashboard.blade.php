<x-app-layout>
    <!-- Overlay for sidebar on mobile -->
    <div class="overlay"></div>
    
    <div class="container-fluid p-0">
        <div class="row g-0">
            <!-- Sidebar -->
            <div class="bg-dark" id="sidebar">
                <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
                    <div class="d-flex justify-content-between w-100 align-items-center mb-3">
                        <a href="/" class="text-white text-decoration-none">
                            <span class="fs-5 fw-bolder d-none d-sm-inline">CallTrack Pro</span>
                        </a>
                        <!-- Close button for mobile -->
                        <button id="sidebarClose" class="btn btn-sm btn-outline-light d-md-none">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    
                    <!-- User profile section -->
                    <div class="text-center mb-4 w-100">
                        <div class="position-relative d-inline-block">
                            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center mx-auto" style="width: 60px; height: 60px">
                                <span class="fs-3 fw-bold">{{ substr(auth()->user()->name ?? 'U', 0, 1) }}</span>
                            </div>
                            <span class="position-absolute bottom-0 end-0 p-1 bg-success border border-light rounded-circle" style="width: 15px; height: 15px;"></span>
                        </div>
                        <div class="mt-2 small">
                            <p class="mb-0 text-white">{{ auth()->user()->name }}</p>
                            <p class="text-secondary mb-0 small">Supervisor</p>
                        </div>
                    </div>
                    
                    <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start w-100" id="menu">
                        <li class="nav-item w-100">
                            <a href="#" class="nav-link active px-3 py-2 d-flex align-items-center">
                                <i class="fas fa-home me-2"></i>
                                <span class="ms-1 d-none d-sm-inline">Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item w-100">
                            <a href="#" class="nav-link text-white px-3 py-2 d-flex align-items-center">
                                <i class="fas fa-phone me-2"></i>
                                <span class="ms-1 d-none d-sm-inline">Call Tickets</span>
                            </a>
                        </li>
                        <li class="nav-item w-100">
                            <a href="#" class="nav-link text-white px-3 py-2 d-flex align-items-center">
                                <i class="fas fa-user me-2"></i>
                                <span class="ms-1 d-none d-sm-inline">Agents</span>
                            </a>
                        </li>
                        <li class="nav-item w-100">
                            <a href="#" class="nav-link text-white px-3 py-2 d-flex align-items-center">
                                <i class="fas fa-chart-line me-2"></i>
                                <span class="ms-1 d-none d-sm-inline">Reports</span>
                            </a>
                        </li>
                        <li class="nav-item w-100">
                            <a href="#" class="nav-link text-white px-3 py-2 d-flex align-items-center">
                                <i class="fas fa-cog me-2"></i>
                                <span class="ms-1 d-none d-sm-inline">Settings</span>
                            </a>
                        </li>
                        
                        <li class="border-top my-3 w-100"></li>
                        
                        <li class="nav-item w-100">
                            <a href="#" class="nav-link text-white px-3 py-2 d-flex align-items-center">
                                <i class="fas fa-question-circle me-2"></i>
                                <span class="ms-1 d-none d-sm-inline">Help Center</span>
                            </a>
                        </li>
                        <li class="nav-item w-100">
                            <a href="#" class="nav-link text-white px-3 py-2 d-flex align-items-center">
                                <i class="fas fa-sign-out-alt me-2"></i>
                                <span class="ms-1 d-none d-sm-inline">Logout</span>
                            </a>
                        </li>
                    </ul>
                    
                    <div class="mt-auto pb-4 w-100">
                        <div class="d-flex align-items-center px-3 py-2 bg-dark border-top border-secondary">
                            <div class="d-flex align-items-center">
                                <span class="bg-success rounded-circle me-2" style="width: 8px; height: 8px;"></span>
                                <small class="text-white">System Status: Online</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="py-3" id="content">
                <div class="container-fluid">
                    <!-- Top navbar -->
                    <nav class="navbar navbar-expand-lg navbar-light bg-white mb-4 shadow-sm rounded">
                        <div class="container-fluid">
                            <button class="btn btn-dark d-md-none me-2" id="sidebarToggle">
                                <i class="fas fa-bars"></i>
                            </button>
                            <div>
                                <h4 class="mb-0">Operations Dashboard</h4>
                                <p class="text-muted small mb-0">Welcome back, {{ auth()->user()->name }} • Real-time monitoring</p>
                            </div>
                            <div class="d-flex">
                                <button class="btn btn-outline-secondary btn-sm me-2">
                                    <i class="fas fa-filter me-1"></i> Filter
                                </button>
                                <button class="btn btn-primary btn-sm">
                                    <i class="fas fa-plus me-1"></i> New Ticket
                                </button>
                            </div>
                        </div>
                    </nav>

                    <!-- Statistics Summary Row -->
                    <div class="card mb-4">
                        <div class="card-body p-0">
                            <div class="container-fluid">
                                <div class="row">
                                    <!-- Active Calls Column -->
                                    <div class="col-md-3 p-3 border-end">
                                        <div>
                                            <p class="small text-uppercase fw-semibold text-muted mb-2">Active Calls</p>
                                            <div class="d-flex align-items-center">
                                                <div class="fs-2 fw-bold">3</div>
                                                <div class="ms-2">
                                                    <span class="badge bg-primary">3 active</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Calls Today Column -->
                                    <div class="col-md-3 p-3 border-end">
                                        <div>
                                            <p class="small text-uppercase fw-semibold text-muted mb-2">Calls Today</p>
                                            <div class="d-flex align-items-center">
                                                <div class="fs-2 fw-bold">78</div>
                                                <div class="ms-2 d-flex align-items-center text-success">
                                                    <i class="fas fa-arrow-up me-1 small"></i>
                                                    <span>12%</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Average Wait Time Column -->
                                    <div class="col-md-3 p-3 border-end">
                                        <div>
                                            <p class="small text-uppercase fw-semibold text-muted mb-2">Avg Wait Time</p>
                                            <div class="d-flex align-items-center">
                                                <div class="fs-2 fw-bold">40s</div>
                                                <div class="ms-2 small text-muted">
                                                    Target: &lt;30s
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Availability Column -->
                                    <div class="col-md-3 p-3">
                                        <div>
                                            <p class="small text-uppercase fw-semibold text-muted mb-2">Availability</p>
                                            <div class="d-flex align-items-center">
                                                <div class="fs-2 fw-bold">77%</div>
                                                <div class="ms-2">
                                                    <span class="badge bg-info">11 online</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Statistics Chart -->
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title mb-0">Call Volume Analytics</h5>
                                <p class="text-muted small mb-0">Real-time call metrics and trend analysis</p>
                            </div>
                            <div class="btn-group" role="group">
                                <button class="btn btn-primary btn-sm active" data-period="day" onclick="updateChartPeriod('day')">Day</button>
                                <button class="btn btn-outline-secondary btn-sm" data-period="week" onclick="updateChartPeriod('week')">Week</button>
                                <button class="btn btn-outline-secondary btn-sm" data-period="month" onclick="updateChartPeriod('month')">Month</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="chart-container" style="position: relative; height:320px;">
                                <canvas id="callStatsChart"></canvas>
                            </div>
                        </div>
                    </div>

            <!-- Chart.js Implementation -->
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // Sample data for the chart
                    const dailyData = {
                        labels: ['9AM', '10AM', '11AM', '12PM', '1PM', '2PM', '3PM', '4PM', '5PM'],
                        datasets: [
                            {
                                label: 'Incoming Calls',
                                data: [5, 8, 12, 7, 10, 15, 9, 11, 13],
                                borderColor: '#4f46e5',
                                backgroundColor: 'rgba(79, 70, 229, 0.1)',
                                borderWidth: 2,
                                tension: 0.4,
                                fill: true
                            },
                            {
                                label: 'Answered Calls',
                                data: [4, 7, 10, 6, 9, 13, 8, 10, 11],
                                borderColor: '#16a34a',
                                backgroundColor: 'rgba(22, 163, 74, 0.1)',
                                borderWidth: 2,
                                tension: 0.4,
                                fill: true
                            }
                        ]
                    };
                    
                    const weeklyData = {
                        labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                        datasets: [
                            {
                                label: 'Incoming Calls',
                                data: [42, 38, 55, 50, 45, 28, 25],
                                borderColor: '#4f46e5',
                                backgroundColor: 'rgba(79, 70, 229, 0.1)',
                                borderWidth: 2,
                                tension: 0.4,
                                fill: true
                            },
                            {
                                label: 'Answered Calls',
                                data: [38, 35, 48, 45, 40, 25, 22],
                                borderColor: '#16a34a',
                                backgroundColor: 'rgba(22, 163, 74, 0.1)',
                                borderWidth: 2,
                                tension: 0.4,
                                fill: true
                            }
                        ]
                    };
                    
                    const monthlyData = {
                        labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
                        datasets: [
                            {
                                label: 'Incoming Calls',
                                data: [180, 210, 195, 220],
                                borderColor: '#4f46e5',
                                backgroundColor: 'rgba(79, 70, 229, 0.1)',
                                borderWidth: 2,
                                tension: 0.4,
                                fill: true
                            },
                            {
                                label: 'Answered Calls',
                                data: [160, 190, 180, 200],
                                borderColor: '#16a34a',
                                backgroundColor: 'rgba(22, 163, 74, 0.1)',
                                borderWidth: 2,
                                tension: 0.4,
                                fill: true
                            }
                        ]
                    };
                    
                    // Get the canvas element and initialize the chart
                    const ctx = document.getElementById('callStatsChart').getContext('2d');
                    let callChart = new Chart(ctx, {
                        type: 'line',
                        data: dailyData,
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'top',
                                    align: 'end',
                                    labels: {
                                        boxWidth: 12,
                                        usePointStyle: true,
                                        pointStyle: 'circle',
                                        padding: 15,
                                        font: {
                                            size: 12
                                        }
                                    }
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    grid: {
                                        display: true,
                                        drawBorder: false,
                                        color: 'rgba(229, 231, 235, 0.6)'
                                    },
                                    ticks: {
                                        font: {
                                            size: 11
                                        }
                                    }
                                },
                                x: {
                                    grid: {
                                        display: false
                                    },
                                    ticks: {
                                        font: {
                                            size: 11
                                        }
                                    }
                                }
                            }
                        }
                    });
                    
                    // Function to update chart data based on period
                    window.updateChartPeriod = function(period) {
                        // Update active button
                        document.querySelectorAll('[data-period]').forEach(btn => {
                            btn.classList.remove('btn-primary', 'active');
                            btn.classList.add('btn-outline-secondary');
                        });
                        document.querySelector(`[data-period="${period}"]`).classList.remove('btn-outline-secondary');
                        document.querySelector(`[data-period="${period}"]`).classList.add('btn-primary', 'active');
                        
                        // Update chart data
                        if (period === 'day') {
                            callChart.data = dailyData;
                        } else if (period === 'week') {
                            callChart.data = weeklyData;
                        } else if (period === 'month') {
                            callChart.data = monthlyData;
                        }
                        callChart.update();
                    };
                });
            </script>

            <!-- Active Call Queue & Panels -->
            <div class="row mt-4">
                <!-- Call Queue Panel - Takes up 2/3 of width -->
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title mb-0">Active Call Queue</h5>
                                <p class="text-secondary small mb-0">{{ $activeTickets->count() }} active calls waiting</p>
                            </div>
                            <div class="d-flex gap-2">
                                <button class="btn btn-primary btn-sm d-flex align-items-center">
                                    <i class="fas fa-sync-alt me-1"></i>
                                    Refresh
                                </button>
                                <a href="{{ route('call-tickets.index') }}" class="btn btn-outline-secondary btn-sm d-flex align-items-center">
                                    <i class="fas fa-external-link-alt me-1"></i>
                                    View All
                                </a>
                            </div>
                        </div>
                
                @if($activeTickets->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="activeCallsTable">
                            <thead class="table-light">
                                <tr>
                                    <th class="cursor-pointer" onclick="sortTable('activeCallsTable', 0)">
                                        Caller <i class="fas fa-sort text-secondary ms-1"></i>
                                    </th>
                                    <th class="cursor-pointer" onclick="sortTable('activeCallsTable', 1)">
                                        Contact <i class="fas fa-sort text-secondary ms-1"></i>
                                    </th>
                                    <th class="cursor-pointer" onclick="sortTable('activeCallsTable', 2)">
                                        Agent <i class="fas fa-sort text-secondary ms-1"></i>
                                    </th>
                                    <th class="cursor-pointer" onclick="sortTable('activeCallsTable', 3)">
                                        Priority <i class="fas fa-sort text-secondary ms-1"></i>
                                    </th>
                                    <th class="cursor-pointer" onclick="sortTable('activeCallsTable', 4)">
                                        Duration <i class="fas fa-sort text-secondary ms-1"></i>
                                    </th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($activeTickets as $ticket)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center text-white fw-medium me-2" style="width: 32px; height: 32px; font-size: 0.75rem;">
                                                    {{ substr($ticket->caller->name ?? 'U', 0, 1) }}
                                                </div>
                                                <div>
                                                    <div class="fw-medium">
                                                        {{ $ticket->caller->name ?? 'Unknown Caller' }}
                                                    </div>
                                                    <div class="small text-secondary">
                                                        ID: #{{ $ticket->id }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div>{{ $ticket->phone_number }}</div>
                                            @if($ticket->caller->company)
                                                <div class="small text-secondary">{{ $ticket->caller->company }}</div>
                                            @endif
                                        </td>
                                        <td>
                                            @if($ticket->agent)
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-success rounded-circle me-2" style="width: 8px; height: 8px;"></div>
                                                    <span>{{ $ticket->agent->name }}</span>
                                                </div>
                                            @else
                                                <span class="badge bg-warning text-dark">
                                                    Unassigned
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($ticket->priority === 'urgent')
                                                <span class="badge bg-danger">
                                                    🔴 Urgent
                                                </span>
                                            @elseif($ticket->priority === 'high')
                                                <span class="badge bg-warning text-dark">
                                                    High
                                                </span>
                                            @elseif($ticket->priority === 'medium')
                                                <span class="badge bg-primary">
                                                    Medium
                                                </span>
                                            @else
                                                <span class="badge bg-success">
                                                    Low
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <div>
                                                {{ $ticket->call_started_at->diffForHumans() }}
                                            </div>
                                            <div class="small text-secondary">
                                                Started {{ $ticket->call_started_at->format('H:i') }}
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                <a href="{{ route('call-tickets.show', $ticket) }}" 
                                                   class="btn btn-sm btn-primary">
                                                    View
                                                </a>
                                                
                                                @if(!$ticket->agent_id)
                                                    <form method="POST" action="{{ route('call-tickets.assign-to-me', $ticket) }}" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-success">
                                                            Take
                                                        </button>
                                                    </form>
                                                @endif
                                                
                                                <form method="POST" action="{{ route('call-tickets.complete', $ticket) }}" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-danger" 
                                                            onclick="return confirm('Are you sure you want to complete this call?')">
                                                        End
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="card-body text-center py-5">
                        <i class="fas fa-phone-slash fa-3x text-secondary mb-3"></i>
                        <h5>No Active Calls</h5>
                        <p class="text-muted">All quiet on the call center front.</p>
                    </div>
                @endif
            </div>

            <!-- Recent Call History -->
            <div class="row mt-4">
                <!-- Call History Table -->
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Recent Call History</h5>
                            <p class="text-muted small mb-0">Latest customer interactions</p>
                        </div>
                    
                    @if($recentCallLogs->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Caller</th>
                                        <th>Type</th>
                                        <th>Duration</th>
                                        <th>Status</th>
                                        <th>Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentCallLogs as $log)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center text-white fw-medium me-2" style="width: 32px; height: 32px; font-size: 0.75rem;">
                                                        {{ substr($log->caller->name ?? 'U', 0, 1) }}
                                                    </div>
                                                    <div>
                                                        <div class="fw-medium">{{ $log->caller->name ?? 'Unknown' }}</div>
                                                        <div class="small text-secondary">{{ $log->phone_number }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                @if($log->call_type === 'inbound')
                                                    <span class="badge bg-primary">
                                                        ← Inbound
                                                    </span>
                                                @else
                                                    <span class="badge bg-success">
                                                        → Outbound
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                {{ $log->call_duration_formatted }}
                                            </td>
                                            <td>
                                                @if($log->status === 'completed')
                                                    <span class="badge bg-success">✓ Completed</span>
                                                @elseif($log->status === 'abandoned')
                                                    <span class="badge bg-danger">✗ Abandoned</span>
                                                @elseif($log->status === 'transferred')
                                                    <span class="badge bg-primary">↗ Transferred</span>
                                                @else
                                                    <span class="badge bg-secondary">{{ ucfirst($log->status) }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                {{ $log->call_started_at->format('H:i') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-history fa-3x text-secondary mb-3"></i>
                            <p class="text-muted">No recent call history.</p>
                        </div>
                    @endif
                    </div>
                </div>

                <!-- Right Sidebar Content -->
                <div class="col-lg-4">
                    <!-- Performance Panel -->
                    <div class="card p-4 mb-4">
                        <h3 class="fs-5 fw-semibold mb-4">Today's Performance</h3>
                        <div class="d-flex flex-column gap-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="small text-secondary">Calls Handled</span>
                                <span class="fs-5 fw-bold">{{ $recentCallLogs->count() }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="small text-secondary">Avg Call Time</span>
                                <span class="fs-5 fw-bold">
                                    @if($recentCallLogs->count() > 0)
                                        {{ gmdate('i:s', $recentCallLogs->avg('call_duration')) }}
                                    @else
                                        00:00
                                    @endif
                                </span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="small text-secondary">Resolution Rate</span>
                                <span class="fs-5 fw-bold text-success">
                                    @if($recentCallLogs->count() > 0)
                                        {{ round($recentCallLogs->where('status', 'completed')->count() / $recentCallLogs->count() * 100) }}%
                                    @else
                                        0%
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions Panel -->
                    <div class="card p-4 mb-4">
                        <h3 class="fs-5 fw-semibold mb-4">Quick Actions</h3>
                        <div class="d-grid gap-3">
                            <button class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i> Create New Ticket
                            </button>
                            <button class="btn btn-success">
                                <i class="fas fa-chart-bar me-2"></i> View Reports
                            </button>
                            <button class="btn btn-secondary">
                                <i class="fas fa-cog me-2"></i> Settings
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<!-- Bootstrap JS with Popper -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebarClose = document.getElementById('sidebarClose');
        const content = document.getElementById('content');
        const overlay = document.querySelector('.overlay');
        
        // Toggle sidebar on mobile
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('show');
                if (overlay) {
                    overlay.classList.toggle('active');
                }
            });
        }
        
        // Close sidebar on mobile
        if (sidebarClose) {
            sidebarClose.addEventListener('click', function() {
                sidebar.classList.remove('show');
                if (overlay) {
                    overlay.classList.remove('active');
                }
            });
        }
        
        // Close sidebar when clicking on the overlay
        if (overlay) {
            overlay.addEventListener('click', function() {
                sidebar.classList.remove('show');
                overlay.classList.remove('active');
            });
        }
        
        // Handle window resize events
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 768) {
                if (overlay) {
                    overlay.classList.remove('active');
                }
                sidebar.classList.remove('show');
            }
        });
    });
</script>
