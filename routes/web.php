<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Dashboard;
use App\Livewire\ClientList;
use App\Livewire\ClientForm;
use App\Livewire\PackageList;
use App\Livewire\PackageForm;
use App\Livewire\SubscriptionList;
use App\Livewire\SubscriptionForm;
use App\Livewire\SubscriptionEdit;
use App\Livewire\ServiceList;
use App\Livewire\ServiceForm;
use App\Livewire\InvoiceList;
use App\Livewire\InvoiceCreate;
use App\Livewire\InvoiceView;
use App\Livewire\InvoiceEdit;
use App\Livewire\InvoiceReceivePayment;
use App\Livewire\InvoicePaymentHistory;
use App\Livewire\PaymentList;
use App\Livewire\DomainList;
use App\Livewire\DomainForm;
use App\Livewire\HostingList;
use App\Livewire\HostingForm;

Route::get('/', function () {
    return redirect()->route('dashboard');
})->name('home');

Route::get('dashboard', Dashboard::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('clients', ClientList::class)->name('clients.index');
    Route::get('clients/create', ClientForm::class)->name('clients.create');
    Route::get('clients/{client}/edit', ClientForm::class)->name('clients.edit');

    Route::get('packages', PackageList::class)->name('packages.index');
    Route::get('packages/create', PackageForm::class)->name('packages.create');
    Route::get('packages/{package}/edit', PackageForm::class)->name('packages.edit');

    Route::get('subscriptions', SubscriptionList::class)->name('subscriptions.index');
    Route::get('subscriptions/create', SubscriptionForm::class)->name('subscriptions.create');
    Route::get('subscriptions/{subscription}/edit', SubscriptionEdit::class)->name('subscriptions.edit');

    Route::get('services', ServiceList::class)->name('services.index');
    Route::get('services/create', ServiceForm::class)->name('services.create');
    Route::get('services/{service}/edit', ServiceForm::class)->name('services.edit');

    Route::get('invoices', InvoiceList::class)->name('invoices.index');
    Route::get('invoices/create', InvoiceCreate::class)->name('invoices.create');
    Route::get('invoices/{invoice}', InvoiceView::class)->name('invoices.show');
    Route::get('invoices/{invoice}/edit', InvoiceEdit::class)->name('invoices.edit');
    Route::get('invoices/{invoice}/pdf', function (\App\Models\Invoice $invoice) {
        try {
            // PART 3: MEMORY & SIZE FIX
            @ini_set('memory_limit', '256M');
            @ini_set('max_execution_time', 300);

            // PART 1: FIX PDF CORRUPTION
            if (ob_get_length()) {
                ob_end_clean();
            }

            // Eager load relationships
            $invoice->load(['client', 'subscription.package', 'items']);

            // PART 5: SANITIZATION
            $safeInvoice = \App\Services\PdfSanitizer::sanitize($invoice);

            $safeInvoice->invoice_date = $invoice->invoice_date;
            $safeInvoice->due_date = $invoice->due_date;

            $safeInvoice->payment_status = $invoice->payment_status;

            $safeInvoice->payment_method = $invoice->payment_method;

            // Generate PDF using safe data
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('livewire.invoice-pdf', ['invoice' => $safeInvoice]);
            return $pdf->stream('invoice-' . $invoice->invoice_number . '.pdf');

        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error("PDF Generation Failed: " . $e->getMessage());
            return "Error (Safe Mode): " . $e->getMessage();
        }
    })->name('invoices.pdf');

    // PART 5: TEST MODE
    Route::get('/test-pdf', function () {
        if (ob_get_length()) {
            ob_end_clean();
        }
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('test-pdf');
        return $pdf->stream('test.pdf');
    });
    Route::get('invoices/public/{invoice}/pdf', [App\Http\Controllers\PublicInvoiceController::class, 'show'])
        ->name('invoices.public.pdf')
        ->middleware('signed');

    Route::get('payments', PaymentList::class)->name('payments.index');

    Route::get('domains', DomainList::class)->name('domains.index');
    Route::get('domains/create', DomainForm::class)->name('domains.create');
    Route::get('domains/{domain}/edit', DomainForm::class)->name('domains.edit');

    Route::get('hostings', HostingList::class)->name('hostings.index');
    Route::get('hostings/create', HostingForm::class)->name('hostings.create');
    Route::get('hostings/{hosting}/edit', HostingForm::class)->name('hostings.edit');
});

require __DIR__ . '/settings.php';
