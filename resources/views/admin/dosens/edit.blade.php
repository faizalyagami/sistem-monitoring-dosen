@extends('components.layouts.app')

@section('title', 'Edit Dosen - ' . $dosen->nama)

@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex align-items-center mb-4">
            <a href="{{ route('admin.dosens.index') }}" class="btn btn-outline-secondary me-3">
                <i class="bi bi-arrow-left"></i>
            </a>
            <div>
                <h2 class="page-title mb-0">
                    <i class="bi bi-pencil-square me-2"></i> Edit Data Dosen
                </h2>
                <p class="text-muted mb-0">Perbarui informasi profil dan data akademik dosen.</p>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <form action="{{ route('admin.dosens.update', $dosen->id) }}" method="PUT" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Memanggil file partial form --}}
                    @include('admin.dosens._form', ['dosen' => $dosen])

                    <div class="mt-4 pt-3 border-top">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i> Simpan Perubahan
                        </button>
                        <a href="{{ route('admin.dosens.index') }}" class="btn btn-secondary ms-2">
                            <i class="bi bi-x-circle me-1"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
