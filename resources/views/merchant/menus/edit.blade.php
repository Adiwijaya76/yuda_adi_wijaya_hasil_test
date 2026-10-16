@extends('layouts.app')

@section('title', 'Edit Menu')

@section('content')
    <x-page-header title="Edit Menu" subtitle="Perbarui detail menu katering" />

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('merchant.menus.update', $menu) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        @include('merchant.menus._form', ['menu' => $menu])
                        <div class="form-actions">
                            <a href="{{ route('merchant.menus.index') }}" class="btn btn-light">Batal</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa-solid fa-floppy-disk me-1"></i> Perbarui Menu
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
