{{-- resources/views/admin/pengajaran/index.blade.php --}}
<x-layouts.app title="Data Pengajaran">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="page-title">
                <i class="bi bi-book me-2"></i> Data Pengajaran
            </h2>
            <a href="{{ route('admin.pengajaran.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i> Tambah Pengajaran
            </a>
        </div>

        <!-- Filter Card -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.pengajaran.index') }}" class="row g-3">
                    <div class="col-md-4">
                        <x-forms.select name="dosen_id" label="Dosen" :options="$dosens->pluck('nama', 'id')->toArray()" :selected="request('dosen_id')" />
                    </div>
                    <div class="col-md-4">
                        <x-forms.select name="academic_period_id" label="Periode Akademik" :options="$periods->pluck('display_name', 'id')->toArray()"
                            :selected="request('academic_period_id')" />
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
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
                            <th>No</th>
                            <th>Kode MK</th>
                            <th>Nama Mata Kuliah</th>
                            <th>Dosen</th>
                            <th>Kelas</th>
                            <th>SKS</th>
                            <th>Jumlah Mahasiswa</th>
                            <th>Periode</th>
                            <th width="100">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pengajarans as $index => $pengajaran)
                            <tr>
                                <td>{{ $pengajarans->firstItem() + $index }}</td>
                                <td>{{ $pengajaran->kode_mk }}</td>
                                <td>{{ $pengajaran->nama_mk }}</td>
                                <td>{{ $pengajaran->dosen->nama }}</td>
                                <td>{{ $pengajaran->kelas }}</td>
                                <td>{{ $pengajaran->sks }}</td>
                                <td>{{ $pengajaran->jumlah_mahasiswa }}</td>
                                <td>{{ $pengajaran->academicPeriod->display_name ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('admin.pengajaran.edit', $pengajaran) }}"
                                        class="btn btn-sm btn-warning btn-action">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.pengajaran.destroy', $pengajaran) }}" method="POST"
                                        class="d-inline" id="delete-form-{{ $pengajaran->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-danger btn-action"
                                            onclick="confirmDelete('delete-form-{{ $pengajaran->id }}')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-5">
                                    <i class="bi bi-inbox fs-1 d-block mb-2 text-muted"></i>
                                    Tidak ada data pengajaran
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $pengajarans->withQueryString()->links() }}
            </div>
        </div>
    </div>
</x-layouts.app>
