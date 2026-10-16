@extends('layouts.app')

@section('title', 'Riwayat Pesanan')

@section('content')
    <x-page-header title="Riwayat Pesanan" subtitle="Seluruh pesanan katering Anda" />

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
                                    <th>No. Pesanan</th>
                                    <th>Katering</th>
                                    <th>Tanggal Kirim</th>
                                    <th class="text-end">Total</th>
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
    'tableId' => 'orderTable',
    'ajaxUrl' => route('customer.orders.index'),
    'filters' => ['keyword', 'filter-status' => 'status'],
    'columns' => [
        ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => false, 'searchable' => false, 'className' => 'text-center'],
        ['data' => 'order_number', 'name' => 'order_number'],
        ['data' => 'merchant_name', 'name' => 'merchant_name', 'orderable' => false, 'searchable' => false],
        ['data' => 'delivery_date', 'name' => 'delivery_date'],
        ['data' => 'total', 'name' => 'total', 'className' => 'text-end'],
        ['data' => 'status_badge', 'name' => 'status', 'orderable' => false, 'searchable' => false, 'className' => 'text-center'],
        ['data' => 'action', 'name' => 'action', 'orderable' => false, 'searchable' => false, 'className' => 'text-end'],
    ],
])
