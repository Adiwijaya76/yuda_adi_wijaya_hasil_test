@extends('layouts.app')

@section('title', 'Tambah Pengguna')

@section('content')
    <x-page-header title="Tambah Pengguna" subtitle="Buat akun pengguna baru" />

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('admin.users.store') }}">
                        @csrf
                        @include('admin.users._form')

                        <div class="form-actions">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-light">Batal</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa-solid fa-floppy-disk me-1"></i> Simpan Pengguna
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
