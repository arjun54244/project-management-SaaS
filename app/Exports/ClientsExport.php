<?php

namespace App\Exports;

use App\Models\Client;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ClientsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Client::withCount(['invoices'])->with(['subscriptions', 'domains', 'hostings', 'invoices'])->get();
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
        return [
            $client->id,
            $client->name,
            $client->email,
            $client->phone,
            $client->company_name,
            $client->gst_enabled ? 'Yes' : 'No',
            $client->gst_number,
            $client->address,
            $client->invoices_count,
            $client->invoices->sum('paid_amount'),
            $client->subscriptions->where('status', \App\Enums\SubscriptionStatus::Active)->count(),
            $client->domains->where('status', \App\Enums\DomainStatus::Active)->count(),
            $client->hostings->where('status', \App\Enums\HostingStatus::Active)->count(),
        ];
    }
}
