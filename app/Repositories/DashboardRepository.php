<?php

namespace App\Repositories;

use App\Models\Subscription;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Client;
use App\Enums\SubscriptionStatus;
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
        $query = Subscription::where('status', SubscriptionStatus::Active);

        $now = Carbon::now();

        switch ($filter) {
            case 'this_week':
                $query->whereBetween('end_date', [$now->copy()->startOfWeek(), $now->copy()->endOfWeek()]);
                break;
            case 'this_month':
                $query->whereBetween('end_date', [$now->copy()->startOfMonth(), $now->copy()->endOfMonth()]);
                break;
            case 'next_month':
                $nextMonth = $now->copy()->addMonth();
                $query->whereBetween('end_date', [$nextMonth->copy()->startOfMonth(), $nextMonth->copy()->endOfMonth()]);
                break;
            case '7days':
            default:
                $query->whereBetween('end_date', [Carbon::today(), Carbon::today()->addDays(7)]);
                break;
        }

        return $query->with(['client', 'package'])
            ->get()
            ->map(function ($subscription) {
                $daysRemaining = Carbon::today()->diffInDays($subscription->end_date, false);

                $highlightLevel = 'info';
                if ($daysRemaining <= 3) {
                    $highlightLevel = 'danger';
                } elseif ($daysRemaining <= 7) {
                    $highlightLevel = 'warning';
                }

                return [
                    'id' => $subscription->id,
                    'client_name' => $subscription->client->name,
                    'package_name' => $subscription->package->name,
                    'end_date' => $subscription->end_date,
                    'days_remaining' => $daysRemaining,
                    'highlight_level' => $highlightLevel,
                ];
            });
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

        return [
            'total_invoiced' => $totalInvoiced,
            'total_received' => $totalReceived,
            'total_outstanding' => $totalOutstanding,
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
