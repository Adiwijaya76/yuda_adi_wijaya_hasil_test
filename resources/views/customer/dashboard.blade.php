@extends('layouts.app')

@section('title', 'Dashboard Kantor')

@section('content')
    <x-page-header title="Dashboard Kantor" subtitle="Ringkasan pesanan katering kantor Anda">
        <x-slot:actions>
            <a href="{{ route('customer.caterings.index') }}" class="btn btn-primary">
                <i class="fa-solid fa-magnifying-glass me-1"></i> Cari Katering
            </a>
        </x-slot:actions>
    </x-page-header>

    <div class="row g-3">
        <div class="col-xl-4 col-md-6">
            <x-stat-card label="Total Pesanan" :value="$stats['order_count']" icon="fa-solid fa-receipt" color="primary" />
        </div>
        <div class="col-xl-4 col-md-6">
            <x-stat-card label="Pesanan Pending" :value="$stats['pending_count']" icon="fa-solid fa-clock" color="warning" />
        </div>
        <div class="col-xl-4 col-md-6">
            <x-stat-card label="Pesanan Terkirim" :value="$stats['delivered_count']" icon="fa-solid fa-circle-check" color="success" />
        </div>
    </div>

    <div class="row mt-1">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-transparent border-0 pt-3 pb-0 d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Pesanan Terbaru</h5>
                    <a href="{{ route('customer.orders.index') }}" class="btn btn-sm btn-light">Lihat semua</a>
                </div>
                <div class="card-body">
                    @if ($recentOrders->isEmpty())
                        <p class="text-muted mb-0">Belum ada pesanan. Mulai cari katering!</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>No. Pesanan</th>
                                        <th>Katering</th>
                                        <th>Tanggal Kirim</th>
                                        <th class="text-end">Total</th>
                                        <th class="text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($recentOrders as $order)
                                        <tr>
                                            <td><a href="{{ route('customer.orders.show', $order) }}">{{ $order->order_number }}</a></td>
                                            <td>{{ $order->merchantProfile->company_name }}</td>
                                            <td>{{ $order->delivery_date->format('d M Y') }}</td>
                                            <td class="text-end">Rp {{ number_format((float) $order->total, 0, ',', '.') }}</td>
                                            <td class="text-center">@include('components.status-badge', ['status' => $order->status])</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
