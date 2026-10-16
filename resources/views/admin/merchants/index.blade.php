@extends('layouts.app')

@section('title', 'Kelola Merchant')

@section('content')
    <x-page-header title="Kelola Merchant" subtitle="Daftar perusahaan katering terdaftar" />

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @include('components.datatable-filter', [
                        'tableId' => 'merchantTable',
                        'fields' => [
                            ['type' => 'text', 'id' => 'keyword', 'placeholder' => 'Cari nama / alamat / jenis...'],
                        ],
                    ])

                    <div class="table-responsive">
                        <table id="merchantTable" class="table table-hover align-middle mb-0" style="width:100%">
                            <thead>
                                <tr>
                                    <th style="width: 50px">No</th>
                                    <th>Perusahaan</th>
                                    <th>Pemilik</th>
                                    <th>Jenis Makanan</th>
                                    <th class="text-center">Menu</th>
                                    <th class="text-center">Pesanan</th>
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
    'tableId' => 'merchantTable',
    'ajaxUrl' => route('admin.merchants.index'),
    'filters' => ['keyword'],
    'columns' => [
        ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => false, 'searchable' => false, 'className' => 'text-center'],
        ['data' => 'company', 'name' => 'company_name', 'orderable' => false, 'searchable' => false],
        ['data' => 'owner', 'name' => 'owner', 'orderable' => false, 'searchable' => false],
        ['data' => 'food_type', 'name' => 'food_type'],
        ['data' => 'menus_count', 'name' => 'menus_count', 'className' => 'text-center', 'searchable' => false],
        ['data' => 'orders_count', 'name' => 'orders_count', 'className' => 'text-center', 'searchable' => false],
    ],
])
