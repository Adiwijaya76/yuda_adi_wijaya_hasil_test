@extends('layouts.app')

@section('title', 'Tambah Menu')

@section('content')
    <x-page-header title="Tambah Menu" subtitle="Tambahkan menu baru untuk katering Anda" />

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('merchant.menus.store') }}" enctype="multipart/form-data">
                        @csrf
                        @include('merchant.menus._form')
                        <div class="form-actions">
                            <a href="{{ route('merchant.menus.index') }}" class="btn btn-light">Batal</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa-solid fa-floppy-disk me-1"></i> Simpan Menu
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
