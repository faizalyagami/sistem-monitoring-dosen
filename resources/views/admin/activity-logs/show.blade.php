{{-- resources/views/admin/activity-logs/show.blade.php --}}
@extends('components.layouts.app')

@section('title', 'Detail Activity Log')

@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex align-items-center mb-4">
            <a href="{{ route('admin.activity-logs.index') }}" class="btn btn-outline-secondary me-3">
                <i class="bi bi-arrow-left"></i>
            </a>
            <div>
                <h1 class="h3 mb-0 text-gray-800">
                    <i class="bi bi-info-circle"></i> Detail Activity Log
                </h1>
                <p class="text-muted mb-0">Informasi lengkap mengenai aktivitas yang tercatat</p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold">Informasi Aktivitas</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <th width="200" class="bg-light">Waktu</th>
                                <td>{{ $log->created_at->format('d F Y H:i:s') }} ({{ $log->created_at->diffForHumans() }})
                                </td>
                            </tr>
                            <tr>
                                <th class="bg-light">User</th>
                                <td>
                                    @if ($log->user)
                                        {{ $log->user->name }} ({{ ucfirst($log->user->role) }})
                                    @else
                                        System
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th class="bg-light">Modul</th>
                                <td><span class="badge bg-secondary">{{ ucfirst($log->module) }}</span></td>
                            </tr>
                            <tr>
                                <th class="bg-light">Aksi</th>
                                <td>{!! $log->action_badge !!}</td>
                            </tr>
                            <tr>
                                <th class="bg-light">Deskripsi</th>
                                <td>{{ $log->description }}</td>
                            </tr>
                            <tr>
                                <th class="bg-light">IP Address</th>
                                <td><code>{{ $log->ip_address }}</code></td>
                            </tr>
                            <tr>
                                <th class="bg-light">User Agent</th>
                                <td><small class="text-muted">{{ $log->user_agent }}</small></td>
                            </tr>
                            <tr>
                                <th class="bg-light">URL / Method</th>
                                <td>
                                    <code>{{ $log->method }}</code>
                                    <a href="{{ $log->url }}" target="_blank">{{ $log->url }}</a>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold">Data Perubahan</h5>
                    </div>
                    <div class="card-body">
                        @if ($log->old_data || $log->new_data || $log->request_data)

                            @if ($log->old_data)
                                <h6 class="fw-bold text-danger">Data Lama:</h6>
                                <pre class="bg-light p-2 rounded small text-wrap" style="max-height: 200px; overflow-y: auto;">{{ json_encode($log->old_data, JSON_PRETTY_PRINT) }}</pre>
                            @endif

                            @if ($log->new_data)
                                <h6 class="fw-bold text-success mt-3">Data Baru:</h6>
                                <pre class="bg-light p-2 rounded small text-wrap" style="max-height: 200px; overflow-y: auto;">{{ json_encode($log->new_data, JSON_PRETTY_PRINT) }}</pre>
                            @endif

                            @if ($log->request_data && !$log->old_data && !$log->new_data)
                                <h6 class="fw-bold text-primary">Request Data:</h6>
                                <pre class="bg-light p-2 rounded small text-wrap" style="max-height: 200px; overflow-y: auto;">{{ json_encode($log->request_data, JSON_PRETTY_PRINT) }}</pre>
                            @endif
                        @else
                            <div class="text-center py-4 text-muted">
                                <i class="bi bi-database-slash fs-1 mb-2"></i>
                                <p class="mb-0">Tidak ada data perubahan yang dicatat.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
