@extends('layouts.app')

@section('title', 'Semua Pesanan')

@section('content')
    <x-page-header title="Semua Pesanan" subtitle="Seluruh transaksi dari semua merchant" />

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @include('components.datatable-filter', [
                        'tableId' => 'orderTable',
                        'fields' => [
                            ['type' => 'text', 'id' => 'keyword', 'placeholder' => 'Cari no. pesanan...'],
                            ['type' => 'select', 'id' => 'filter-status', 'options' => [
                                '' => 'Semua Status',
                                'pending' => 'Menunggu',
                                'confirmed' => 'Diterima',
                                'preparing' => 'Disiapkan',
                                'ready' => 'Siap',
                                'delivered' => 'Terkirim',
                                'rejected' => 'Ditolak',
                                'cancelled' => 'Dibatalkan',
                            ]],
                        ],
                    ])

                    <div class="table-responsive">
                        <table id="orderTable" class="table table-hover align-middle mb-0" style="width:100%">
                            <thead>
                                <tr>
                                    <th style="width: 50px">No</th>
                                    <th style="min-width: 180px">No. Pesanan</th>
                                    <th style="min-width: 140px">Customer</th>
                                    <th style="min-width: 140px">Merchant</th>
                                    <th class="text-end" style="width: 120px">Total</th>
                                    <th class="text-center" style="width: 110px">Status</th>
                                    <th class="text-end" style="width: 100px">Aksi</th>
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
    'tableId' => 'orderTable',
    'ajaxUrl' => route('admin.orders.index'),
    'filters' => ['keyword', 'filter-status' => 'status'],
    'columns' => [
        ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => false, 'searchable' => false, 'className' => 'text-center', 'width' => '50px'],
        ['data' => 'order_number', 'name' => 'order_number'],
        ['data' => 'customer_name', 'name' => 'customer_name', 'orderable' => false, 'searchable' => false],
        ['data' => 'merchant_name', 'name' => 'merchant_name', 'orderable' => false, 'searchable' => false],
        ['data' => 'total', 'name' => 'total', 'className' => 'text-end', 'width' => '120px'],
        ['data' => 'status_badge', 'name' => 'status', 'orderable' => false, 'searchable' => false, 'className' => 'text-center', 'width' => '110px'],
        ['data' => 'action', 'name' => 'action', 'orderable' => false, 'searchable' => false, 'className' => 'text-end', 'width' => '100px'],
    ],
])
