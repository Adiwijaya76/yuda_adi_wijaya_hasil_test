<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\Order;

class InvoiceService
{
    /**
     * Membuat invoice untuk order. Unique constraint di order_id mencegah duplikasi.
     */
    public function createForOrder(Order $order): Invoice
    {
        return Invoice::firstOrCreate(
            ['order_id' => $order->id],
            [
                'invoice_number' => $this->generateInvoiceNumber(),
                'issued_at' => now()->toDateString(),
                'total' => $order->total,
            ]
        );
    }

    private function generateInvoiceNumber(): string
    {
        do {
            $number = 'INV-'.now()->format('Ymd').'-'.strtoupper(bin2hex(random_bytes(4)));
        } while (Invoice::where('invoice_number', $number)->exists());

        return $number;
    }
}
