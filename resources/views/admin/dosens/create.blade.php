<x-layouts.app title="Tambah Dosen">
    <div class="container-fluid">
        <div class="d-flex align-items-center mb-4">
            <a href="{{ route('admin.dosens.index') }}" class="btn btn-outline-secondary me-3">
                <i class="bi bi-arrow-left"></i>
            </a>
            <h2 class="page-title mb-0">
                <i class="bi bi-plus-circle me-2"></i> Tambah Dosen Baru
            </h2>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <form action="{{ route('admin.dosens.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @include('admin.dosens._form')

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-2"></i> Simpan
                        </button>
                        <a href="{{ route('admin.dosens.index') }}" class="btn btn-secondary">
                            <i class="bi bi-x-circle me-2"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.app>
