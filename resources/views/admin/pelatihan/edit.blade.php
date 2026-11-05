@extends('components.layouts.app')
@section('content')
    <div class="container-fluid px-4">
        <h1 class="h3 mb-4">Edit Pelatihan</h1>
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <form action="{{ route('admin.pelatihan.update', $pelatihan->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf @method('PUT')
                    @include('admin.pelatihan._form', ['pelatihan' => $pelatihan])
                    <div class="mt-4"><button type="submit" class="btn btn-primary">Update</button> <a
                            href="{{ route('admin.pelatihan.index') }}" class="btn btn-secondary">Batal</a></div>
                </form>
            </div>
        </div>
    </div>
@endsection
