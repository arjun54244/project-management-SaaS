<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use NumberFormatter;

class PublicInvoiceController extends Controller
{
    public function numberToWords($number)
    {
        $formatter = new NumberFormatter('en_IN', NumberFormatter::SPELLOUT);

        $amount = floor($number);
        $decimal = round(($number - $amount) * 100);

        $words = ucfirst($formatter->format($amount)) . ' rupees';

        if ($decimal > 0) {
            $words .= ' and ' . $formatter->format($decimal) . ' paise';
        }

        return $words . ' only';
    }
    public function show(Invoice $invoice)
    {
        // PART 3: MEMORY & SIZE FIX
        @ini_set('memory_limit', '256M');
        @ini_set('max_execution_time', 300);

        // PART 1: FIX PDF CORRUPTION (Clear Output Buffer)
        if (ob_get_length()) {
            ob_end_clean();
        }

        if (!request()->hasValidSignature()) {
            abort(403);
        }

        // Eager load relationships
        $invoice->load(['client', 'subscription.package', 'items']);

        // PART 5: SANITIZATION
        $safeInvoice = \App\Services\PdfSanitizer::sanitize($invoice);


        // Manual hydration for specific fields used in View
        $safeInvoice->invoice_date = $invoice->invoice_date;
        $safeInvoice->due_date = $invoice->due_date;
        $safeInvoice->payment_status = $invoice->payment_status;
        $safeInvoice->payment_method = $invoice->payment_method;

        $amountInWords = $this->numberToWords($invoice->total_amount);
        

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('livewire.invoice-pdf', ['invoice' => $safeInvoice, 'amountInWords' => $amountInWords]);
        return $pdf->stream('invoice-' . $invoice->invoice_number . '.pdf');
    }
}
