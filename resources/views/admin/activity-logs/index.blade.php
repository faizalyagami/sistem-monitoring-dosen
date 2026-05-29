{{-- resources/views/admin/activity-logs/index.blade.php --}}
<x-layouts.app title="Activity Log">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="page-title">
                <i class="bi bi-clock-history me-2"></i> Activity Log
            </h2>
            <div>
                <button type="button" class="btn btn-danger" onclick="confirmDelete('clear-form')">
                    <i class="bi bi-trash me-2"></i> Hapus Log Lama
                </button>
                <form id="clear-form" action="{{ route('admin.activity-logs.clear') }}" method="POST" class="d-none">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h6>Total Aktivitas</h6>
                        <h3>{{ number_format($stats['total']) }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h6>Hari Ini</h6>
                        <h3>{{ number_format($stats['today']) }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <h6>Minggu Ini</h6>
                        <h3>{{ number_format($stats['this_week']) }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <h6>Bulan Ini</h6>
                        <h3>{{ number_format($stats['this_month']) }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Form -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.activity-logs.index') }}" class="row g-3">
                    <div class="col-md-3">
                        <x-forms.select name="user_id" label="User" :options="$users->pluck('name', 'id')->toArray()" :selected="request('user_id')" />
                    </div>
                    <div class="col-md-2">
                        <x-forms.select name="module" label="Module" :options="$modules->mapWithKeys(fn($m) => [$m => ucfirst($m)])->toArray()" :selected="request('module')" />
                    </div>
                    <div class="col-md-2">
                        <x-forms.select name="action" label="Action" :options="$actions->mapWithKeys(fn($a) => [$a => ucfirst($a)])->toArray()" :selected="request('action')" />
                    </div>
                    <div class="col-md-2">
                        <x-forms.input name="date_from" label="Dari Tanggal" type="date"
                            value="{{ request('date_from') }}" />
                    </div>
                    <div class="col-md-2">
                        <x-forms.input name="date_to" label="Sampai Tanggal" type="date"
                            value="{{ request('date_to') }}" />
                    </div>
                    <div class="col-md-1 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Chart Row -->
        <div class="row mb-4">
            <div class="col-md-6 mb-3">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white">
                        <h6 class="mb-0">Aktivitas per Module</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="moduleChart" height="250"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white">
                        <h6 class="mb-0">Aktivitas per Action</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="actionChart" height="250"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Logs Table -->
        <div class="table-container">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Waktu</th>
                            <th>User</th>
                            <th>Module</th>
                            <th>Action</th>
                            <th>Deskripsi</th>
                            <th>IP Address</th>
                            <th width="50">Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                            <tr>
                                <td>
                                    <small>{{ $log->created_at->format('d/m/Y H:i:s') }}</small><br>
                                    <small class="text-muted">{{ $log->time_ago }}</small>
                                </td>
                                <td>
                                    @if ($log->user)
                                        <strong>{{ $log->user->name }}</strong><br>
                                        <small class="text-muted">{{ $log->user->role }}</small>
                                    @else
                                        <span class="text-muted">System</span>
                                    @endif
                                </td>
                                <td>{!! $log->module_badge !!}</td>
                                <td>{!! $log->action_badge !!}</td>
                                <td>{{ Str::limit($log->description, 60) }}</td>
                                <td><code>{{ $log->ip_address }}</code></td>
                                <td>
                                    <a href="{{ route('admin.activity-logs.show', $log) }}"
                                        class="btn btn-sm btn-info btn-action">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <i class="bi bi-inbox fs-1 d-block mb-2 text-muted"></i>
                                    Tidak ada activity log
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $logs->withQueryString()->links() }}
            </div>
        </div>
    </div>
</x-layouts.app>

@push('scripts')
    <script>
        // Module chart
        const moduleCtx = document.getElementById('moduleChart').getContext('2d');
        new Chart(moduleCtx, {
            type: 'bar',
            data: {
                labels: @json($stats['by_module']->pluck('module')->map(fn($m) => ucfirst($m))),
                datasets: [{
                    label: 'Jumlah Aktivitas',
                    data: @json($stats['by_module']->pluck('total')),
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'top'
                    }
                }
            }
        });

        // Action chart
        const actionCtx = document.getElementById('actionChart').getContext('2d');
        new Chart(actionCtx, {
            type: 'pie',
            data: {
                labels: @json($stats['by_action']->pluck('action')->map(fn($a) => ucfirst($a))),
                datasets: [{
                    data: @json($stats['by_action']->pluck('total')),
                    backgroundColor: ['#27ae60', '#f39c12', '#e74c3c', '#3498db', '#95a5a6'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    </script>
@endpush
