<x-layouts.app title="Detail Activity Log">
    <div class="container-fluid">
        <div class="d-flex align-items-center mb-4">
            <a href="{{ route('admin.activity-logs.index') }}" class="btn btn-outline-secondary me-3">
                <i class="bi bi-arrow-left"></i>
            </a>
            <h2 class="page-title mb-0">
                <i class="bi bi-info-circle me-2"></i> Detail Activity Log
            </h2>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Informasi Aktivitas</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <th width="200">Waktu</th>
                                <td>{{ $activityLog->created_at->format('d F Y H:i:s') }}</td>
                            </tr>
                            <tr>
                                <th>User</th>
                                <td>
                                    @if ($activityLog->user)
                                        {{ $activityLog->user->name }} ({{ $activityLog->user->role }})
                                    @else
                                        System
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Module</th>
                                <td>{!! $activityLog->module_badge !!}</td>
                            </tr>
                            <tr>
                                <th>Action</th>
                                <td>{!! $activityLog->action_badge !!}</td>
                            </tr>
                            <tr>
                                <th>Deskripsi</th>
                                <td>{{ $activityLog->description }}</td>
                            </tr>
                            <tr>
                                <th>IP Address</th>
                                <td><code>{{ $activityLog->ip_address }}</code></td>
                            </tr>
                            <tr>
                                <th>User Agent</th>
                                <td><small>{{ $activityLog->user_agent }}</small></td>
                            </tr>
                            <tr>
                                <th>URL</th>
                                <td><code>{{ $activityLog->url }}</code></td>
                            </tr>
                            <tr>
                                <th>Method</th>
                                <td>{{ $activityLog->method }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Data Perubahan</h5>
                    </div>
                    <div class="card-body">
                        @if ($activityLog->old_data)
                            <h6>Data Lama:</h6>
                            <pre class="bg-light p-2 rounded small">{{ json_encode($activityLog->old_data, JSON_PRETTY_PRINT) }}</pre>
                        @endif

                        @if ($activityLog->new_data)
                            <h6 class="mt-3">Data Baru:</h6>
                            <pre class="bg-light p-2 rounded small">{{ json_encode($activityLog->new_data, JSON_PRETTY_PRINT) }}</pre>
                        @endif

                        @if ($activityLog->request_data && !$activityLog->old_data && !$activityLog->new_data)
                            <pre class="bg-light p-2 rounded small">{{ json_encode($activityLog->request_data, JSON_PRETTY_PRINT) }}</pre>
                        @endif

                        @if (!$activityLog->old_data && !$activityLog->new_data && !$activityLog->request_data)
                            <p class="text-muted text-center">Tidak ada data perubahan</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
