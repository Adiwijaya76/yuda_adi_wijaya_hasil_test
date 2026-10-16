@extends('layouts.app')

@section('title', 'Kelola Pengguna')

@section('content')
    <x-page-header title="Kelola Pengguna">
        <x-slot:actions>
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                <i class="fa-solid fa-plus me-1"></i> Tambah Pengguna
            </a>
        </x-slot:actions>
    </x-page-header>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @include('components.datatable-filter', [
                        'tableId' => 'userTable',
                        'fields' => [
                            ['type' => 'text', 'id' => 'keyword', 'placeholder' => 'Cari nama / email...'],
                            [
                                'type' => 'select',
                                'id' => 'role',
                                'options' => [
                                    '' => 'Semua Role',
                                    'admin' => 'Admin',
                                    'merchant' => 'Merchant',
                                    'customer' => 'Customer',
                                ],
                            ],
                        ],
                    ])

                    <div class="table-responsive">
                        <table id="userTable" class="table table-hover align-middle mb-0" style="width:100%">
                            <thead>
                                <tr>
                                    <th style="width: 50px">No</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th class="text-center">Role</th>
                                    <th>Profil Merchant</th>
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
    'tableId' => 'userTable',
    'ajaxUrl' => route('admin.users.index'),
    'filters' => ['keyword', 'role'],
    'columns' => [
        [
            'data' => 'DT_RowIndex',
            'name' => 'DT_RowIndex',
            'orderable' => false,
            'searchable' => false,
            'className' => 'text-center',
        ],
        ['data' => 'name', 'name' => 'name'],
        ['data' => 'email', 'name' => 'email'],
        [
            'data' => 'role_badge',
            'name' => 'role',
            'orderable' => false,
            'searchable' => false,
            'className' => 'text-center',
        ],
        ['data' => 'merchant', 'name' => 'merchant', 'orderable' => false, 'searchable' => false],
        [
            'data' => 'action',
            'name' => 'action',
            'orderable' => false,
            'searchable' => false,
            'className' => 'text-end',
        ],
    ],
])
