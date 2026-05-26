<?php
namespace App\Imports;

use App\Models\Client;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class ClientsImport implements
    ToModel,
    WithHeadingRow,
    WithValidation,
    SkipsOnFailure,
    SkipsEmptyRows
{
    use SkipsFailures;

    /**
     * Create or update client by email
     */
    public function model(array $row)
    {
        // Normalize GST value
        $gstEnabled = false;

        if (!empty($row['gst_enabled'])) {
            $value = strtolower(trim($row['gst_enabled']));
            $gstEnabled = in_array($value, ['yes', '1', 'true']);
        }

        return Client::updateOrCreate(
            ['email' => $row['email']], // unique key
            [
                'name' => $row['client_name'],
                'phone' => $row['phone'] ?? null,
                'company_name' => $row['company'] ?? null,
                'gst_enabled' => $gstEnabled,
                'gst_number' => $row['gst_number'] ?? null,
                'address' => $row['address'] ?? null,
                'status' => 'active',
            ]
        );
    }

    /**
     * Validation rules
     */
    public function rules(): array
    {
        return [
            '*.client_name' => 'required|string|max:255',
            '*.email' => 'required|email',
            '*.gst_number' => 'nullable|string|max:20',
        ];
    }

    /**
     * Custom error messages
     */
    public function customValidationMessages()
    {
        return [
            '*.client_name.required' => 'Client name is required.',
            '*.email.required' => 'Email is required.',
            '*.email.email' => 'Invalid email format.',
        ];
    }
}