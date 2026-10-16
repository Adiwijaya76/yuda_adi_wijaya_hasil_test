@extends('layouts.app')

@section('title', 'Edit Pengguna')

@section('content')
    <x-page-header title="Edit Pengguna" subtitle="Perbarui data akun pengguna" />

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('admin.users.update', $user) }}">
                        @csrf
                        @method('PUT')
                        @include('admin.users._form', ['user' => $user])

                        <div class="form-actions">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-light">Batal</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa-solid fa-floppy-disk me-1"></i> Perbarui Pengguna
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
