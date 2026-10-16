@extends('layouts.app')

@section('title', 'Invoice')

@section('content')
    @php $order = $invoice->order; @endphp

    <x-page-header title="Invoice" subtitle="{{ $invoice->invoice_number }}">
        <x-slot:actions>
            <button type="button" class="btn btn-primary" data-print-invoice>
                <i class="fa-solid fa-file-pdf me-1"></i> Cetak / Simpan PDF
            </button>
        </x-slot:actions>
    </x-page-header>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card" id="invoice">
                <div class="card-body p-4 p-sm-5">
                    <div class="row mb-4">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <div class="d-flex align-items-center mb-2">
                                <span class="stat-icon text-white me-2" style="width:40px;height:40px;font-size:.95rem;background: linear-gradient(135deg, #2563eb, #1d4ed8);">
                                    <i class="fa-solid fa-utensils"></i>
                                </span>
                                <h5 class="text-primary mb-0">Katering Marketplace</h5>
                            </div>
                            <h4 class="mb-1 fw-bold">{{ $invoice->invoice_number }}</h4>
                            <p class="text-muted mb-0 small">Tanggal Terbit: {{ $invoice->issued_at->format('d M Y') }}</p>
                        </div>
                        <div class="col-sm-6 text-sm-end">
                            <p class="text-muted mb-1 small text-uppercase fw-semibold">Diterbitkan oleh</p>
                            <h6 class="mb-1">{{ $order->merchantProfile->company_name }}</h6>
                            <p class="text-muted mb-0 small">{{ $order->merchantProfile->address }}</p>
                            @if ($order->merchantProfile->phone)
                                <p class="text-muted mb-0 small">{{ $order->merchantProfile->phone }}</p>
                            @endif
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="row mb-4">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <p class="text-muted mb-1 small text-uppercase fw-semibold">Ditagihkan ke</p>
                            <h6 class="mb-0">{{ $order->customer->name }}</h6>
                            <p class="text-muted mb-0 small">{{ $order->customer->email }}</p>
                        </div>
                        <div class="col-sm-6 text-sm-end">
                            <p class="text-muted mb-1 small text-uppercase fw-semibold">Pengiriman</p>
                            <h6 class="mb-0">{{ $order->delivery_date->format('d M Y') }}</h6>
                            <p class="text-muted mb-0 small">{{ $order->delivery_address }}</p>
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
                                    <th colspan="3" class="text-end fs-6">Total Tagihan</th>
                                    <th class="text-end fs-5 text-primary">Rp {{ number_format((float) $invoice->total, 0, ',', '.') }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="mt-4 pt-3 border-top text-muted small text-center">
                        Terima kasih telah menggunakan Katering Marketplace.
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
