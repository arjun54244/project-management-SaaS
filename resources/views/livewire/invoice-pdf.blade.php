<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $invoice->invoice_number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            color: #333;
            padding: 40px;
            max-width: 800px;
            margin: 0 auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 40px;
            border-bottom: 2px solid #4f46e5;
            padding-bottom: 20px;
        }

        .header h1 {
            font-size: 32px;
            color: #4f46e5;
            margin-bottom: 5px;
        }

        .header .invoice-number {
            color: #666;
        }

        .status {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .status-paid {
            background: #dcfce7;
            color: #166534;
        }

        .status-unpaid {
            background: #f3f4f6;
            color: #374151;
        }

        .status-overdue {
            background: #fee2e2;
            color: #991b1b;
        }

        .info-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 40px;
        }

        .info-block h3 {
            font-size: 12px;
            color: #666;
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        .info-block p {
            margin-bottom: 5px;
        }

        .info-block .name {
            font-size: 18px;
            font-weight: bold;
        }

        .dates {
            text-align: right;
        }

        .dates div {
            margin-bottom: 5px;
        }

        .dates span.label {
            color: #666;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        thead {
            background: #f9fafb;
        }

        th,
        td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
        }

        th {
            font-size: 12px;
            text-transform: uppercase;
            color: #666;
        }

        td.qty {
            text-align: center;
        }

        td.price,
        td.total,
        th.price,
        th.total {
            text-align: right;
        }

        .totals {
            display: flex;
            justify-content: flex-end;
        }

        .totals-table {
            width: 250px;
        }

        .totals-table div {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
        }

        .totals-table .grand-total {
            border-top: 2px solid #333;
            margin-top: 10px;
            padding-top: 15px;
            font-size: 18px;
            font-weight: bold;
        }

        .totals-table .grand-total .amount {
            color: #4f46e5;
        }

        .print-button {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 10px 20px;
            background: #4f46e5;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }

        .print-button:hover {
            background: #4338ca;
        }

        @media print {
            .print-button {
                display: none;
            }

            body {
                padding: 20px;
            }
        }
    </style>
</head>

<body>
    <button class="print-button" onclick="window.print()">Print / Download PDF</button>

    <div class="header">
        <div>
            <h1>INVOICE</h1>
            <p class="invoice-number">{{ $invoice->invoice_number }}</p>
        </div>
        <div>
            @php
                $isOverdue = $invoice->payment_status !== \App\Enums\PaymentStatus::Paid && $invoice->due_date->isPast();
            @endphp
            @if($isOverdue)
                <span class="status status-overdue">Overdue</span>
            @elseif($invoice->payment_status === \App\Enums\PaymentStatus::Paid)
                <span class="status status-paid">Paid</span>
            @else
                <span class="status status-unpaid">{{ ucfirst($invoice->payment_status->value) }}</span>
            @endif
        </div>
    </div>

    <div class="info-section">
        <div class="info-block">
            <h3>Bill To</h3>
            <p class="name">{{ $invoice->client->name }}</p>
            @if($invoice->client->company_name)
                <p>{{ $invoice->client->company_name }}</p>
            @endif
            <p>{{ $invoice->client->email }}</p>
            @if($invoice->client->phone)
                <p>{{ $invoice->client->phone }}</p>
            @endif
            @if($invoice->client->gst_number)
                <p>GSTIN: {{ $invoice->client->gst_number }}</p>
            @endif
        </div>
        <div class="info-block dates">
            <div>
                <span class="label">Invoice Date:</span>
                <span>{{ $invoice->invoice_date->format('M d, Y') }}</span>
            </div>
            <div>
                <span class="label">Due Date:</span>
                <span
                    style="{{ $isOverdue ? 'color: #991b1b;' : '' }}">{{ $invoice->due_date->format('M d, Y') }}</span>
            </div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Description</th>
                <th style="text-align: center;">Qty</th>
                <th class="price">Price</th>
                <th class="total">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoice->items as $item)
                <tr>
                    <td>{{ $item->description }}</td>
                    <td class="qty">{{ $item->qty }}</td>
                    <td class="price">₹{{ number_format($item->price, 2) }}</td>
                    <td class="total">₹{{ number_format($item->total, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="totals">
        <div class="totals-table">
            <div>
                <span>Subtotal</span>
                <span>₹{{ number_format($invoice->subtotal, 2) }}</span>
            </div>
            @if($invoice->discount > 0)
                <div>
                    <span>Discount</span>
                    <span style="color: #dc2626;">-₹{{ number_format($invoice->discount, 2) }}</span>
                </div>
            @endif
            @if($invoice->tax > 0)
                <div>
                    <span>Tax</span>
                    <span>₹{{ number_format($invoice->tax, 2) }}</span>
                </div>
            @endif
            <div class="grand-total">
                <span>Total</span>
                <span class="amount">₹{{ number_format($invoice->total_amount, 2) }}</span>
            </div>
        </div>
    </div>
</body>

</html>