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

Route::get('/', function () {
    return view('welcome');
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
        $invoice->load(['client', 'subscription.package', 'items']);
        return view('livewire.invoice-pdf', ['invoice' => $invoice]);
    })->name('invoices.pdf');

    Route::get('payments', PaymentList::class)->name('payments.index');
});

require __DIR__ . '/settings.php';
