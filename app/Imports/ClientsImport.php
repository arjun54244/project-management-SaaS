<?php

namespace App\Imports;

use App\Models\Client;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Validation\Rule;

class ClientsImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        return new Client([
            'name' => $row['client_name'],
            'email' => $row['email'],
            'phone' => $row['phone'] ?? null,
            'company_name' => $row['company'] ?? null,
            'gst_enabled' => isset($row['gst_enabled']) && strtolower($row['gst_enabled']) === 'yes',
            'gst_number' => $row['gst_number'] ?? null,
            'address' => $row['address'] ?? null,
            'status' => 'active',
        ]);
    }

    public function rules(): array
    {
        return [
            'client_name' => 'required',
            'email' => 'required|email|unique:clients,email',
            'gst_enabled' => 'nullable|in:yes,no,Yes,No,YES,NO',
            'gst_number' => 'nullable|string|max:20',
        ];
    }
}
