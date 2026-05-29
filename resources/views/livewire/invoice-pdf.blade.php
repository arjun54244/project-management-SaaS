<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Invoice PDF</title>

    <style>
        @page {
            margin: 12px 15px 12px 15px;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #000;
            line-height: 1.4;
        }

        @page {
            size: A4 portrait;
            margin: 8px;
        }

        html,
        body {
            padding: 12px;
        }

        * {
            box-sizing: border-box;
        }

        .invoice-wrapper {
            width: 100%;
            border: 1px solid #999;
        }


        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .header-table td {
            vertical-align: middle;
            padding: 10px;
        }

        .logo {
            width: 90px;
            height: auto;
        }

        .company-name {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .invoice-title {
            font-size: 22px;
            font-weight: bold;
            text-align: right;
        }

        .invoice-details td {
            border-top: 1px solid #999;
            padding: 8px 10px;
            vertical-align: top;
        }

        .invoice-details .left {
            border-right: 1px solid #999;
            width: 50%;
        }

        .label {
            display: inline-block;
            width: 120px;
            color: #444;
        }

        .address-table th {
            background: #f2f2f2;
            border-top: 1px solid #999;
            border-bottom: 1px solid #999;
            text-align: left;
            padding: 8px 10px;
            font-size: 12px;
        }

        .address-table td {
            padding: 10px;
            vertical-align: top;
            line-height: 18px;
        }

        .customer-name {
            font-size: 13px;
            font-weight: bold;
        }

        .items-table {
            border-top: 1px solid #999;
        }

        .items-table th {
            background: #f2f2f2;
            border: 1px solid #999;
            padding: 8px 5px;
            font-weight: bold;
            font-size: 11px;
        }

        .items-table td {
            border: 1px solid #999;
            padding: 8px 5px;
            font-size: 11px;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .totals-section {
            width: 100%;
            margin-top: 0;
        }

        .notes-section {
            width: 56%;
            float: left;
        }

        .summary-section {
            width: 40%;
            float: right;
        }

        .summary-table td {
            padding: 7px 10px;
            border-bottom: 1px solid #ddd;
        }

        .summary-table .total-row td {
            font-weight: bold;
            font-size: 13px;
        }

        .summary-table .balance-row td {
            font-weight: bold;
            border-bottom: 1px solid #999;
        }

        .section-title {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .notes-text,
        .terms-text {
            line-height: 16px;
            text-align: left;
        }

        .signature-box {
            margin-top: 60px;
            text-align: center;
        }

        .signature-line {
            border-top: 1px solid #999;
            margin-top: 55px;
            padding-top: 5px;
        }

        .clearfix::after {
            content: "";
            display: block;
            clear: both;
        }

        .small-text {
            font-size: 10px;
        }

        .amount-words {
            margin-bottom: 20px;
        }

        td,
        th,
        div,
        p,
        span {
            word-wrap: break-word;
        }
    </style>
</head>

<body>

    <div class="invoice-wrapper">

        <!-- HEADER -->
        <table class="header-table">
            <tr>

                <td style="width: 18%;">
                    <img src="/logo.png" class="logo">
                </td>

                <td style="width: 52%;">
                    <div class="company-name">
                        Digitechhealthcare
                    </div>

                    <div>
                        The First Business Brick B74 Sector 2 Noida Uttar Pradesh 201301 India
                    </div>

                    <div>
                        GSTIN 09TVNPS0530J1ZQ
                    </div>

                    <div>
                        9289738874
                    </div>

                    <div>
                        ritusinghhealthcare@gmail.com
                    </div>

                    <div>
                        https://digitechhealthcare.com/
                    </div>
                </td>

                <td style="width: 30%;" class="invoice-title">
                    TAX INVOICE
                </td>

            </tr>
        </table>

        <!-- INVOICE DETAILS -->
        <table class="invoice-details">
            <tr>

                <td class="left">

                    <div>
                        <span class="label">#</span>
                        <strong>: {{ $invoice->invoice_number }}</strong>
                    </div>

                    <div>
                        <span class="label">Invoice Date</span>
                        <strong>:
                            {{ $invoice->invoice_date ? \Carbon\Carbon::parse($invoice->invoice_date)->format('d/m/Y') : '-' }}
                        </strong>
                    </div>

                    <div>
                        <span class="label">Terms</span>
                        <strong>: Due on Receipt</strong>
                    </div>

                    <div>
                        <span class="label">Due Date</span>
                        <strong>:
                            {{ $invoice->due_date ? \Carbon\Carbon::parse($invoice->due_date)->format('d/m/Y') : '-' }}
                        </strong>
                    </div>

                </td>

                <td>

                    <div>
                        <span class="label">Place Of Supply</span>
                        <strong>: Uttar Pradesh</strong>
                    </div>

                </td>

            </tr>
        </table>

        <!-- BILL TO -->
        <table class="address-table">
            <thead>
                <tr>
                    <th>
                        Bill To
                    </th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td>

                        <div class="customer-name">
                            {{ $invoice->client->name }}
                        </div>

                        <div>
                            {{ $invoice->client->company_name }}
                        </div>

                        <div>
                            {{ $invoice->client->email }}
                        </div>

                        <div>
                            {{ $invoice->client->phone }}
                        </div>

                    </td>
                </tr>
            </tbody>
        </table>

        <!-- ITEMS -->
        <table class="items-table">

            <thead>

                <tr>

                    <th rowspan="2" style="width:5%">
                        #
                    </th>

                    <th rowspan="2">
                        Item & Description
                    </th>

                    <th rowspan="2" style="width:10%">
                        Qty
                    </th>

                    <th rowspan="2" style="width:13%">
                        Rate
                    </th>

                    <th colspan="2" style="width:18%">
                        IGST
                    </th>

                    <th rowspan="2" style="width:15%">
                        Amount
                    </th>

                </tr>

                <tr>

                    <th style="width:9%">
                        %
                    </th>

                    <th style="width:9%">
                        Amt
                    </th>

                </tr>

            </thead>

            <tbody>

                @forelse ($invoice->items as $index => $item)

                    <tr>

                        <td class="text-center">
                            {{ $index + 1 }}
                        </td>

                        <td>
                            {{ $item->description }}
                        </td>

                        <td class="text-right">
                            {{ number_format($item->qty, 2) }}
                        </td>

                        <td class="text-right">
                            ₹{{ number_format($item->price, 2) }}
                        </td>

                        <td class="text-right">
                            0%
                        </td>

                        <td class="text-right">
                            ₹0.00
                        </td>

                        <td class="text-right">
                            ₹{{ number_format($item->total, 2) }}
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="7" class="text-center">
                            No items found
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

        <!-- TOTAL SECTION -->
        <div class="totals-section clearfix">

            <!-- LEFT -->
            <div class="notes-section">

                @if (isset($amountInWords))
                    <div class="amount-words">

                        <div class="section-title">
                            Total In Words
                        </div>

                        <strong>
                            <i>{{ $amountInWords }}</i>
                        </strong>

                    </div>
                @endif

                <!-- NOTES -->
                <div>

                    <div class="section-title" style="margin-left:3px;">
                        Notes
                    </div>

                    <div class="notes-text small-text" style="margin-left:3px;">
                        Thank you for your business.

                        Name : DIGITECH HEALTHCARE
                        Bank : STATE BANK OF INDIA
                        Account No. : 44269799065
                        IFSC Code : SBIN0062292
                        Branch : OMICRON 3
                    </div>

                </div>

                <!-- TERMS -->
                <!-- TERMS -->
                <div style="margin-top:20px; margin-left:3px;">

                    <div class="section-title">
                        Terms &amp; Conditions
                    </div>

                    <div class="terms-text small-text">

                        <table style="width:100%; border-collapse:collapse;">

                            <tr>
                                <td style="padding-bottom:6px;">
                                    • If clients choose any monthly service package from Digitech Healthcare,
                                    they are required to pay the full amount in advance before commencement of work.
                                </td>
                            </tr>

                            <tr>
                                <td style="padding-bottom:6px;">
                                    • If Digitech Healthcare and the client agree on a fixed quote regarding services,
                                    then 50% advance payment is required before work starts.
                                </td>
                            </tr>

                            <tr>
                                <td style="padding-bottom:6px;">
                                    • Remaining payment must be completed within 7 days.
                                </td>
                            </tr>

                            <tr>
                                <td style="padding-bottom:6px;">
                                    • Digitech Healthcare shall invoice monthly in advance.
                                </td>
                            </tr>

                            <tr>
                                <td style="padding-bottom:6px;">
                                    • We may use your logo for branding purposes.
                                </td>
                            </tr>

                            <tr>
                                <td style="padding-bottom:6px;">
                                    • For any queries please contact us.
                                </td>
                            </tr>

                        </table>

                        <div style="margin-top:12px; margin-left:5px;">
                            Thanks &amp; Regards
                            <br>
                            <strong>Digitech Healthcare</strong>
                        </div>

                    </div>

                </div>

            </div>

            <!-- RIGHT -->
            <div class="summary-section">

                <table class="summary-table">

                    <tr>
                        <td>
                            Sub Total
                        </td>

                        <td class="text-right">
                            ₹{{ number_format($invoice->subtotal, 2) }}
                        </td>
                    </tr>

                    @if ($invoice->discount > 0)
                        <tr>
                            <td>
                                Discount
                            </td>

                            <td class="text-right">
                                ₹{{ number_format($invoice->discount, 2) }}
                            </td>
                        </tr>
                    @endif

                    <tr>
                        <td>
                            IGST (0%)
                        </td>

                        <td class="text-right">
                            ₹{{ number_format($invoice->tax, 2) }}
                        </td>
                    </tr>

                    <tr class="total-row">

                        <td>
                            Total
                        </td>

                        <td class="text-right">
                            ₹{{ number_format($invoice->total_amount, 2) }}
                        </td>

                    </tr>

                    <tr class="balance-row">

                        <td>
                            Balance Due
                        </td>

                        <td class="text-right">
                            ₹{{ number_format($invoice->total_amount, 2) }}
                        </td>

                    </tr>

                </table>

                <!-- SIGNATURE -->
                <div class="signature-box">

                    <div class="signature-line">
                        Authorized Signature
                    </div>

                </div>

            </div>

        </div>

    </div>

</body>

</html>