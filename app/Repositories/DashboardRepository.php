<?php

namespace App\Repositories;

use App\Models\Subscription;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Client;
use App\Models\Domain;
use App\Models\Hosting;
use App\Enums\SubscriptionStatus;
use App\Enums\DomainStatus;
use App\Enums\HostingStatus;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardRepository
{
    public function getBirthdaysThisWeek()
    {
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        // Improved logic to handle year-spanning weeks
        $query = Client::query();

        if (DB::getDriverName() === 'sqlite') {
            // For SQLite, we compare M-D strings or use a more complex logic
            // Simplified for now but more robust than original
            $start = $startOfWeek->format('m-d');
            $end = $endOfWeek->format('m-d');

            if ($start <= $end) {
                $query->whereRaw("strftime('%m-%d', dob) BETWEEN ? AND ?", [$start, $end]);
            } else {
                // Spans year end
                $query->where(function ($q) use ($start, $end) {
                    $q->whereRaw("strftime('%m-%d', dob) >= ?", [$start])
                        ->orWhereRaw("strftime('%m-%d', dob) <= ?", [$end]);
                });
            }
        } else {
            // MySQL
            $start = $startOfWeek->format('m-d');
            $end = $endOfWeek->format('m-d');

            if ($start <= $end) {
                $query->whereRaw("DATE_FORMAT(dob, '%m-%d') BETWEEN ? AND ?", [$start, $end]);
            } else {
                // Spans year end
                $query->where(function ($q) use ($start, $end) {
                    $q->whereRaw("DATE_FORMAT(dob, '%m-%d') >= ?", [$start])
                        ->orWhereRaw("DATE_FORMAT(dob, '%m-%d') <= ?", [$end]);
                });
            }
        }

        return $query->get();
    }

    public function getUpcomingRenewals($filter = '7days')
    {
        $now = Carbon::now();
        $startDate = Carbon::today();
        $endDate = Carbon::today()->addDays(7);

        switch ($filter) {
            case 'this_week':
                $startDate = $now->copy()->startOfWeek();
                $endDate = $now->copy()->endOfWeek();
                break;
            case 'this_month':
                $startDate = $now->copy()->startOfMonth();
                $endDate = $now->copy()->endOfMonth();
                break;
            case 'next_month':
                $nextMonth = $now->copy()->addMonth();
                $startDate = $nextMonth->copy()->startOfMonth();
                $endDate = $nextMonth->copy()->endOfMonth();
                break;
            case '7days':
            default:
                $startDate = Carbon::today();
                $endDate = Carbon::today()->addDays(7);
                break;
        }

        $subscriptions = Subscription::with(['client', 'package'])
            ->where('status', SubscriptionStatus::Active)
            ->whereBetween('end_date', [$startDate, $endDate])
            ->get()
            ->map(function ($sub) {
                return $this->formatRenewalItem($sub, 'subscription', $sub->end_date, $sub->client->name, $sub->package->name);
            });

        $domains = Domain::with(['client'])
            ->where('status', DomainStatus::Active)
            ->whereBetween('expiry_date', [$startDate, $endDate])
            ->get()
            ->map(function ($domain) {
                return $this->formatRenewalItem($domain, 'domain', $domain->expiry_date, $domain->client->name, $domain->name);
            });

        $hostings = Hosting::with(['client'])
            ->where('status', HostingStatus::Active)
            ->whereBetween('expiry_date', [$startDate, $endDate])
            ->get()
            ->map(function ($hosting) {
                return $this->formatRenewalItem($hosting, 'hosting', $hosting->expiry_date, $hosting->client->name, $hosting->plan_name . ' (' . $hosting->provider . ')');
            });

        return $subscriptions->concat($domains)->concat($hostings)
            ->sortBy('end_date')
            ->values();
    }

    private function formatRenewalItem($model, $type, $date, $clientName, $itemName)
    {
        $daysRemaining = Carbon::today()->diffInDays($date, false);

        $highlightLevel = 'info';
        if ($daysRemaining <= 3) {
            $highlightLevel = 'danger';
        } elseif ($daysRemaining <= 7) {
            $highlightLevel = 'warning';
        }

        return [
            'id' => $model->id,
            'type' => $type,
            'client_name' => $clientName,
            'package_name' => $itemName,
            'end_date' => $date,
            'days_remaining' => $daysRemaining,
            'highlight_level' => $highlightLevel,
        ];
    }

    public function getRevenueMetrics(int $year, $month = null)
    {
        $invoiceQuery = Invoice::whereYear('created_at', $year);
        $paymentQuery = Payment::whereYear('paid_at', $year);

        if ($month && $month !== '') {
            $monthInt = (int) $month;
            $invoiceQuery->whereMonth('created_at', $monthInt);
            $paymentQuery->whereMonth('paid_at', $monthInt);
        }

        $totalInvoiced = (float) $invoiceQuery->sum('total_amount');
        $totalReceived = (float) $paymentQuery->sum('amount');
        $totalOutstanding = max(0, $totalInvoiced - $totalReceived);

        // Calculate Tax Collected portion of payments
        $taxCollectedQuery = Payment::join('invoices', 'payments.invoice_id', '=', 'invoices.id')
            ->whereYear('payments.paid_at', $year);

        if ($month && $month !== '') {
            $taxCollectedQuery->whereMonth('payments.paid_at', (int) $month);
        }

        $taxCollected = (float) $taxCollectedQuery
            ->where('invoices.total_amount', '>', 0)
            ->sum(DB::raw('payments.amount * (invoices.tax / invoices.total_amount)'));

        $netRevenue = $totalReceived - $taxCollected;

        return [
            'total_invoiced' => $totalInvoiced,
            'total_received' => $totalReceived,
            'total_outstanding' => $totalOutstanding,
            'tax_collected' => $taxCollected,
            'net_revenue' => $netRevenue,
        ];
    }

    public function getQuickStats()
    {
        $now = Carbon::now();
        $today = Carbon::today();
        $thisMonthStart = $now->copy()->startOfMonth();
        $thisMonthEnd = $now->copy()->endOfMonth();

        return [
            'today_received' => (float) Payment::whereDate('paid_at', $today)->sum('amount'),
            'month_received' => (float) Payment::whereBetween('paid_at', [$thisMonthStart, $thisMonthEnd])->sum('amount'),
            'method_summary' => Payment::whereBetween('paid_at', [$thisMonthStart, $thisMonthEnd])
                ->select('payment_method', DB::raw('SUM(amount) as total'))
                ->groupBy('payment_method')
                ->get(),
        ];
    }

    public function getPendingInvoices()
    {
        return Invoice::where('payment_status', '!=', \App\Enums\PaymentStatus::Paid)
            ->with(['client', 'subscription'])
            ->orderBy('due_date', 'asc')
            ->limit(10)
            ->get();
    }
}
