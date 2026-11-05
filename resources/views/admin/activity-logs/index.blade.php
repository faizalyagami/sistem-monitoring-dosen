{{-- resources/views/admin/activity-logs/index.blade.php --}}
@extends('components.layouts.app')

@section('title', 'Activity Log')

@section('content')
    <div class="container-fluid px-4">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800">
                    <i class="bi bi-clock-history"></i> Activity Log
                </h1>
                <p class="text-muted">Riwayat aktivitas pengguna di dalam sistem</p>
            </div>
            <div>
                <form action="{{ route('admin.activity-logs.clear') }}" method="POST" class="d-inline" id="clear-log-form">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-danger" onclick="confirmClear()">
                        <i class="bi bi-trash"></i> Bersihkan Log Lama
                    </button>
                </form>
            </div>
        </div>

        <!-- Filter Card -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.activity-logs.index') }}" class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Cari Deskripsi</label>
                        <input type="text" name="search" class="form-control" placeholder="Cari aktivitas..."
                            value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Modul</label>
                        <select name="module" class="form-select">
                            <option value="">Semua Modul</option>
                            <option value="auth" {{ request('module') == 'auth' ? 'selected' : '' }}>Auth</option>
                            <option value="dosen" {{ request('module') == 'dosen' ? 'selected' : '' }}>Dosen</option>
                            <option value="pengajaran" {{ request('module') == 'pengajaran' ? 'selected' : '' }}>Pengajaran
                            </option>
                            <option value="riset" {{ request('module') == 'riset' ? 'selected' : '' }}>Penelitian</option>
                            <option value="pkm" {{ request('module') == 'pkm' ? 'selected' : '' }}>PKM</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Aksi</label>
                        <select name="action" class="form-select">
                            <option value="">Semua Aksi</option>
                            <option value="create" {{ request('action') == 'create' ? 'selected' : '' }}>Create</option>
                            <option value="update" {{ request('action') == 'update' ? 'selected' : '' }}>Update</option>
                            <option value="delete" {{ request('action') == 'delete' ? 'selected' : '' }}>Delete</option>
                            <option value="login" {{ request('action') == 'login' ? 'selected' : '' }}>Login</option>
                            <option value="logout" {{ request('action') == 'logout' ? 'selected' : '' }}>Logout</option>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-search"></i> Filter
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Data Table -->
        <div class="card shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="50">No</th>
                                <th>Waktu</th>
                                <th>User</th>
                                <th>Modul</th>
                                <th>Aksi</th>
                                <th>Deskripsi</th>
                                <th>IP Address</th>
                                <th width="80">Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($logs as $index => $log)
                                <tr>
                                    <td>{{ $logs->firstItem() + $index }}</td>
                                    <td>
                                        <strong>{{ $log->created_at->format('d/m/Y') }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $log->created_at->format('H:i:s') }}</small>
                                    </td>
                                    <td>
                                        @if ($log->user)
                                            <strong>{{ $log->user->name }}</strong>
                                            <br>
                                            <small class="text-muted">{{ ucfirst($log->user->role) }}</small>
                                        @else
                                            <span class="text-muted">System</span>
                                        @endif
                                    </td>
                                    <td><span class="badge bg-secondary">{{ ucfirst($log->module) }}</span></td>
                                    <td>{!! $log->action_badge !!}</td>
                                    <td>{{ Str::limit($log->description, 50) }}</td>
                                    <td><code>{{ $log->ip_address }}</code></td>
                                    <td>
                                        <a href="{{ route('admin.activity-logs.show', $log->id) }}"
                                            class="btn btn-sm btn-info" title="Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5">
                                        <i class="bi bi-inbox fs-1 text-muted"></i>
                                        <p class="mt-2 text-muted">Belum ada riwayat aktivitas</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card-footer bg-white">
                {{ $logs->withQueryString()->links() }}
            </div>
        </div>
    </div>

    <script>
        function confirmClear() {
            Swal.fire({
                title: 'Bersihkan Log Lama?',
                text: "Semua log yang lebih tua dari 90 hari akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, bersihkan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('clear-log-form').submit();
                }
            });
        }
    </script>
@endsection
