<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\View\View;

class InvoiceController extends Controller
{
    public function show(Invoice $invoice): View
    {
        $this->authorizeInvoice($invoice);

        $invoice->load([
            'order.customer',
            'order.merchantProfile.user',
            'order.items',
        ]);

        return view('invoices.show', compact('invoice'));
    }

    private function authorizeInvoice(Invoice $invoice): void
    {
        $user = auth()->user();

        // Admin dapat melihat semua invoice.
        if ($user->isAdmin()) {
            return;
        }

        $isCustomer = $invoice->order->customer_id === $user->id;
        $isMerchant = $user->merchantProfile
            && $invoice->order->merchant_profile_id === $user->merchantProfile->id;

        if (! $isCustomer && ! $isMerchant) {
            abort(403, 'Anda tidak memiliki akses ke invoice ini.');
        }
    }
}
