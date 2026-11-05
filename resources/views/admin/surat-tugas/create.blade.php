@extends('components.layouts.app')
@section('content')
    <div class="container-fluid px-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('admin.surat-tugas.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf @include('admin.surat-tugas._form')
                    <button type="submit" class="btn btn-primary mt-3">Simpan</button>
                </form>
            </div>
        </div>
    </div>
@endsection
