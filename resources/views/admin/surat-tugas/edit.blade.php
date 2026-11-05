@extends('components.layouts.app')
@section('content')
    <div class="container-fluid px-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('admin.surat-tugas.update', $sipp->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT') @include('admin.surat-tugas._form', ['sipp' => $sipp])
                    <button type="submit" class="btn btn-primary mt-3">Update</button>
                </form>
            </div>
        </div>
    </div>
@endsection
