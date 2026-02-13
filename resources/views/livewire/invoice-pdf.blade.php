<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Invoice {{ $invoice->invoice_number }}</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 13px;
            color: #222;
        }

        .container {
            width: 100%;
        }

        h1 {
            font-size: 22px;
            margin-bottom: 5px;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .small {
            font-size: 12px;
        }

        .section {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th {
            background: #f3f3f3;
            border: 1px solid #ddd;
            padding: 8px;
            font-size: 12px;
        }

        table td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        .no-border td {
            border: none;
        }

        .totals td {
            border: none;
            padding: 5px 0;
        }

        .bold {
            font-weight: bold;
        }

        .grand-total {
            font-size: 16px;
            font-weight: bold;
        }

        .footer-box {
            border: 1px solid #ddd;
            padding: 10px;
            font-size: 12px;
        }

        .signature {
            margin-top: 50px;
            text-align: right;
        }

        .line {
            border-top: 1px solid #ccc;
            margin: 10px 0;
        }
    </style>
</head>

<body>
    <div class="container">

        {{-- COMPANY HEADER --}}
        <table class="no-border">
            <tr>
                <td width="60%">
                    <h1>TAX INVOICE</h1>
                    <p class="small">Invoice #: {{ $invoice->invoice_number }}</p>
                    <p class="small">Invoice Date: {{ $invoice->invoice_date->format('d/m/Y') }}</p>
                    <p class="small">Due Date: {{ $invoice->due_date->format('d/m/Y') }}</p>
                </td>
                <td width="40%" class="text-right">
                    <strong>DigiTech Healthcare</strong><br>
                    <!-- Company ID: XXXXXXXX<br> -->
                    B-74, C Block, Sector 2, Noida,<br>
                    Uttar Pradesh - 201301<br>
                    GSTIN: 09TVNPS0530J1ZQ
                </td>
            </tr>
        </table>

        <div class="line"></div>

        {{-- BILL TO --}}
        <div class="section">
            <strong>Bill To:</strong><br>
            {{ $invoice->client->name }}<br>
            {{ $invoice->client->company_name }}<br>
            {{ $invoice->client->email }}<br>
            {{ $invoice->client->phone }}
        </div>

        {{-- ITEMS TABLE --}}
        <table>
            <thead>
                <tr>
                    <th width="5%">#</th>
                    <th>Description</th>
                    <th width="12%">HSN/SAC</th>
                    <th width="10%">Qty</th>
                    <th width="15%">Rate</th>
                    <th width="15%">Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoice->items as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            {{ $item->description }}
                        </td>
                        <td>654321</td>
                        <td class="text-center">{{ $item->qty }}</td>
                        <td class="text-right">₹{{ number_format($item->price, 2) }}</td>
                        <td class="text-right">₹{{ number_format($item->total, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <br>

        {{-- TOTALS --}}
        <table class="totals">
            <tr>
                <td width="70%"></td>
                <td width="30%">
                    <table>
                        <tr>
                            <td>Sub Total</td>
                            <td class="text-right">₹{{ number_format($invoice->subtotal, 2) }}</td>
                        </tr>

                        @if($invoice->discount > 0)
                            <tr>
                                <td>Discount</td>
                                <td class="text-right">-₹{{ number_format($invoice->discount, 2) }}</td>
                            </tr>
                        @endif

                        @if($invoice->tax > 0)
                            <tr>
                                <td>Tax</td>
                                <td class="text-right">₹{{ number_format($invoice->tax, 2) }}</td>
                            </tr>
                        @endif

                        <tr class="grand-total">
                            <td>Total</td>
                            <td class="text-right">₹{{ number_format($invoice->total_amount, 2) }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <br>

        {{-- TOTAL IN WORDS --}}
        <div class="section small">
            <strong>Total In Words:</strong><br>
            Indian Rupee {{ ucfirst($invoice->total_amount) }} Only
        </div>

        {{-- BANK DETAILS --}}
        <div class="footer-box">
            <strong>Bank Details:</strong><br><br>
            Account Name : DIGITECHHEALTHCARE<br>
            Account Number : 44269799065<br>
            IFSC Code : SBIN0062292<br>
            Bank : STATE BANK OF INDIA<br>
            Branch : OMICRON 3, GREATER NOIDA
        </div>

        <br>

        {{-- TERMS --}}
        <div class="footer-box">
            <strong>Terms & Conditions</strong><br><br>
            • If clients avail any monthly service package of Digidotes then they are
            obliged to pay a full chargeable amount prior to the commencement of the work.<br>
            • If Digidotes and the client agree on a fixed quote regarding any services then they are liable to pay 50%
            <br>
            of the billable amount in advance, prior to the commencement of the work. The remaining 50% of the payment
            will have to be made within 7 days of the start date of the
            services.<br>
            • Digidotes shall invoice the clients monthly, in advance.<br>
            • We will use your logo for the Branding purpose for Digidotes.<br>
            • If you have any queries or doubts, please let us know.<br>

            Thanks and Regards
        </div>

        {{-- SIGNATURE --}}
        <div class="signature">
            <br><br>
            ___________________________<br>
            Authorized Signature
        </div>

    </div>
</body>

</html>