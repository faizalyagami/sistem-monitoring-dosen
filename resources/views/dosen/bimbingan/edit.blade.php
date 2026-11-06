@extends('components.layouts.app')

@section('title', 'Edit Bimbingan')

@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex align-items-center mb-4">
            <a href="{{ route('dosen.bimbingan.index') }}" class="btn btn-outline-secondary me-3"><i
                    class="bi bi-arrow-left"></i></a>
            <h1 class="h3 mb-0 text-gray-800"><i class="bi bi-pencil-square"></i> Edit Bimbingan</h1>
        </div>

        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <form action="{{ route('dosen.bimbingan.update', $bimbingan->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            @include('dosen.bimbingan._form', ['bimbingan' => $bimbingan])
                            <div class="mt-4 pt-3 border-top">
                                <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Update</button>
                                <a href="{{ route('dosen.bimbingan.index') }}" class="btn btn-secondary ms-2">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
