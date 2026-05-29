<x-layouts.app title="Data Dosen">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="page-title">
                <i class="bi bi-people me-2"></i> Data Dosen
            </h2>
            <a href="{{ route('admin.dosens.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i> Tambah Dosen
            </a>
        </div>

        <!-- Filter Card -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.dosens.index') }}" class="row g-3">
                    <div class="col-md-5">
                        <x-forms.input name="search" label="Cari" value="{{ request('search') }}"
                            placeholder="Nama, NIDN, NIK, Email" />
                    </div>
                    <div class="col-md-4">
                        <x-forms.select name="status" label="Status" :options="[
                            'tetap' => 'Tetap',
                            'kontrak' => 'Kontrak',
                            'luar_biasa' => 'Luar Biasa',
                            'pensiun' => 'Pensiun',
                        ]"
                            selected="{{ request('status') }}" />
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-search me-1"></i> Filter
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Data Table -->
        <div class="table-container">
            <div class="table-responsive">
                <table class="table table-hover align-middle datatable">
                    <thead>
                        <tr>
                            <th width="50">No</th>
                            <th>Foto</th>
                            <th>NIDN / NIK</th>
                            <th>Nama Lengkap</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Pendidikan</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($dosens as $index => $dosen)
                            <tr>
                                <td>{{ $dosens->firstItem() + $index }}</td>
                                <td>
                                    <img src="{{ $dosen->photo_url }}" alt="{{ $dosen->nama }}" class="rounded-circle"
                                        width="40" height="40" style="object-fit: cover;">
                                </td>
                                <td>
                                    <strong>{{ $dosen->nidn }}</strong><br>
                                    <small class="text-muted">{{ $dosen->nik }}</small>
                                </td>
                                <td>
                                    {{ $dosen->nama }}
                                    <br>
                                    <small class="text-muted">{{ $dosen->jabatan_fungsional }}</small>
                                </td>
                                <td>{{ $dosen->email }}</td>
                                <td>{!! $dosen->status_badge !!}</td>
                                <td>{{ $dosen->pendidikan_terakhir }}</td>
                                <td>
                                    <a href="{{ route('admin.dosens.show', $dosen) }}"
                                        class="btn btn-sm btn-info btn-action" title="Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.dosens.edit', $dosen) }}"
                                        class="btn btn-sm btn-warning btn-action" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.dosens.destroy', $dosen) }}" method="POST"
                                        class="d-inline" id="delete-form-{{ $dosen->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-danger btn-action" title="Hapus"
                                            onclick="confirmDelete('delete-form-{{ $dosen->id }}')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <i class="bi bi-inbox fs-1 d-block mb-2 text-muted"></i>
                                    Tidak ada data dosen
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $dosens->withQueryString()->links() }}
            </div>
        </div>
    </div>
</x-layouts.app>
