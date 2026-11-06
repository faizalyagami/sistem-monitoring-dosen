@extends('components.layouts.app')

@section('title', 'Edit Surat Tugas')

@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex align-items-center mb-4">
            <a href="{{ route('dosen.surat-tugas.index') }}" class="btn btn-outline-secondary me-3"><i
                    class="bi bi-arrow-left"></i></a>
            <div>
                <h1 class="h3 mb-0 text-gray-800"><i class="bi bi-pencil-square"></i> Edit Surat Tugas</h1>
                <p class="text-muted mb-0">Perbarui data surat tugas</p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <form action="{{ route('dosen.surat-tugas.update', $suratTugas->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            @include('dosen.surat-tugas._form', ['suratTugas' => $suratTugas])
                            <div class="mt-4 pt-3 border-top">
                                <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Update</button>
                                <a href="{{ route('dosen.surat-tugas.index') }}" class="btn btn-secondary ms-2">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
