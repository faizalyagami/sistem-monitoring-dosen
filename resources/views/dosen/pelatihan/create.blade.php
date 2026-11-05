@extends('components.layouts.app')
@section('title', 'Tambah Pelatihan')
@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex align-items-center mb-4">
            <a href="{{ route('dosen.pelatihan.index') }}" class="btn btn-outline-secondary me-3"><i
                    class="bi bi-arrow-left"></i></a>
            <h1 class="h3 mb-0 text-gray-800"><i class="bi bi-plus-circle"></i> Tambah Pelatihan</h1>
        </div>
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <form action="{{ route('dosen.pelatihan.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @include('dosen.pelatihan._form')
                            <div class="mt-4 pt-3 border-top">
                                <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Simpan</button>
                                <a href="{{ route('dosen.pelatihan.index') }}" class="btn btn-secondary ms-2">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
