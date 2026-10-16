@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
    <x-page-header title="Dashboard Admin" subtitle="Ringkasan aktivitas marketplace" />

    <div class="row g-3">
        <div class="col-xl-3 col-md-6">
            <x-stat-card label="Total Pengguna" :value="$stats['user_count']" icon="fa-solid fa-users" color="primary" />
        </div>
        <div class="col-xl-3 col-md-6">
            <x-stat-card label="Total Merchant" :value="$stats['merchant_count']" icon="fa-solid fa-store" color="info" />
        </div>
        <div class="col-xl-3 col-md-6">
            <x-stat-card label="Total Pesanan" :value="$stats['order_count']" icon="fa-solid fa-cart-shopping" color="warning" />
        </div>
        <div class="col-xl-3 col-md-6">
            <x-stat-card label="Pendapatan (Terkirim)" :value="'Rp '.number_format((float) $stats['revenue'], 0, ',', '.')" icon="fa-solid fa-sack-dollar" color="success" />
        </div>
    </div>

    <div class="row mt-1">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-transparent border-0 pt-3 pb-0 d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Pesanan Terbaru</h5>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-light">Lihat semua</a>
                </div>
                <div class="card-body">
                    @if ($recentOrders->isEmpty())
                        <p class="text-muted mb-0">Belum ada pesanan.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>No. Pesanan</th>
                                        <th>Customer</th>
                                        <th>Merchant</th>
                                        <th class="text-end">Total</th>
                                        <th class="text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($recentOrders as $order)
                                        <tr>
                                            <td>{{ $order->order_number }}</td>
                                            <td>{{ $order->customer->name }}</td>
                                            <td>{{ $order->merchantProfile->company_name }}</td>
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
