@extends('layouts.app')

@section('title', 'Detail Pesanan')

@section('content')
    <x-page-header title="Detail Pesanan" subtitle="Rincian pesanan katering Anda">
        <x-slot:actions>
            <a href="{{ route('customer.orders.index') }}" class="btn btn-light">
                <i class="fa-solid fa-arrow-left me-1"></i> Kembali
            </a>
        </x-slot:actions>
    </x-page-header>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">#{{ $order->order_number }}</h5>
                    @include('components.status-badge', ['status' => $order->status])
                </div>
                <div class="card-body">
                    <div class="row g-3 mb-4">
                        <div class="col-sm-6">
                            <div class="p-3 rounded-3" style="background: var(--km-body-bg);">
                                <p class="text-muted mb-1 small text-uppercase fw-semibold">Katering</p>
                                <h6 class="mb-0">{{ $order->merchantProfile->company_name }}</h6>
                                <p class="text-muted mb-0 small">{{ $order->merchantProfile->address }}</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="p-3 rounded-3" style="background: var(--km-body-bg);">
                                <p class="text-muted mb-1 small text-uppercase fw-semibold">Pengiriman</p>
                                <h6 class="mb-0">{{ $order->delivery_date->format('d M Y') }}</h6>
                                <p class="text-muted mb-0 small">{{ $order->delivery_address }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Menu</th>
                                    <th class="text-end">Harga Satuan</th>
                                    <th class="text-center">Jumlah</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->items as $item)
                                    <tr>
                                        <td class="fw-medium">{{ $item->menu_name }}</td>
                                        <td class="text-end">Rp {{ number_format((float) $item->unit_price, 0, ',', '.') }}</td>
                                        <td class="text-center">{{ $item->quantity }}</td>
                                        <td class="text-end">Rp {{ number_format((float) $item->subtotal, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3" class="text-end fs-6">Total</th>
                                    <th class="text-end fs-6 text-primary">Rp {{ number_format((float) $order->total, 0, ',', '.') }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    @if ($order->invoice)
                        <div class="text-end mt-4">
                            <a href="{{ route('invoices.show', $order->invoice) }}" class="btn btn-primary">
                                <i class="fa-solid fa-file-invoice me-1"></i> Lihat Invoice
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
