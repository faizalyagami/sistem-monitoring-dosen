@extends('components.layouts.app')
@section('content')
    <div class="container-fluid px-4">
        <h1 class="h3 mb-4">Tambah Pelatihan</h1>
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <form action="{{ route('admin.pelatihan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @include('admin.pelatihan._form')
                    <div class="mt-4"><button type="submit" class="btn btn-primary">Simpan</button> <a
                            href="{{ route('admin.pelatihan.index') }}" class="btn btn-secondary">Batal</a></div>
                </form>
            </div>
        </div>
    </div>
@endsection
