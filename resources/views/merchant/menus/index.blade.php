@extends('layouts.app')

@section('title', 'Kelola Menu')

@section('content')
    <x-page-header title="Daftar Menu" subtitle="Kelola menu katering Anda">
        <x-slot:actions>
            <a href="{{ route('merchant.menus.create') }}" class="btn btn-primary">
                <i class="fa-solid fa-plus me-1"></i> Tambah Menu
            </a>
        </x-slot:actions>
    </x-page-header>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @include('components.datatable-filter', [
                        'tableId' => 'menuTable',
                        'fields' => [
                            ['type' => 'text', 'id' => 'keyword', 'placeholder' => 'Cari nama menu...'],
                        ],
                    ])

                    <div class="table-responsive">
                        <table id="menuTable" class="table table-hover align-middle mb-0" style="width:100%">
                            <thead>
                                <tr>
                                    <th style="width: 50px">No</th>
                                    <th>Foto</th>
                                    <th>Nama</th>
                                    <th class="text-end">Harga</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-end">Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@include('components.datatable-script', [
    'tableId' => 'menuTable',
    'ajaxUrl' => route('merchant.menus.index'),
    'filters' => ['keyword'],
    'columns' => [
        ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => false, 'searchable' => false, 'className' => 'text-center'],
        ['data' => 'photo_html', 'name' => 'photo_html', 'orderable' => false, 'searchable' => false],
        ['data' => 'name', 'name' => 'name'],
        ['data' => 'price', 'name' => 'price', 'className' => 'text-end'],
        ['data' => 'availability', 'name' => 'is_available', 'orderable' => false, 'searchable' => false, 'className' => 'text-center'],
        ['data' => 'action', 'name' => 'action', 'orderable' => false, 'searchable' => false, 'className' => 'text-end'],
    ],
])
