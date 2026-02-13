<?php
namespace App\Exports;

use App\Models\Client;
use App\Models\Payment;
use App\Enums\SubscriptionStatus;
use App\Enums\DomainStatus;
use App\Enums\HostingStatus;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ClientsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Client::with([
            'subscriptions',
            'domains',
            'hostings',
            'invoices.payments'
        ])->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Email',
            'Phone',
            'Company',
            'GST Enabled',
            'GST Number',
            'Address',
            'Total Invoices',
            'Total Paid Amount',
            'Active Subscriptions',
            'Active Domains',
            'Active Hostings',
        ];
    }

    public function map($client): array
    {
        $totalPaid = $client->invoices->sum(function ($invoice) {
            return $invoice->payments->sum('amount');
        });

        return [
            $client->id,
            $client->name,
            $client->email,
            $client->phone,
            $client->company_name,
            $client->gst_enabled ? 'Yes' : 'No',
            $client->gst_number,
            $client->address,
            $client->invoices->count(),
            $totalPaid,
            $client->subscriptions->where('status', SubscriptionStatus::Active)->count(),
            $client->domains->where('status', DomainStatus::Active)->count(),
            $client->hostings->where('status', HostingStatus::Active)->count(),
        ];
    }
}