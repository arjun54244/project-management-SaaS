<?php

namespace App\Console\Commands;

use App\Models\Client;
use App\Models\Package;
use App\Models\Subscription;
use App\Enums\DiscountType;
use App\Services\SubscriptionService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class AssignPackageCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'assign:package 
                            {--client= : Client ID}
                            {--package= : Package ID}
                            {--discount_type= : Discount type (percentage or flat)}
                            {--discount_value=0 : Discount value}
                            {--start_date= : Start date (YYYY-MM-DD)}
                            {--force : Skip confirmation for existing subscriptions}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assign or renew a package for a client';

    /**
     * Execute the console command.
     */
    public function handle(SubscriptionService $subscriptionService)
    {
        // Validate required options
        if (!$this->option('client') || !$this->option('package')) {
            $this->error('Both --client and --package options are required.');
            return 1;
        }

        // Find client and package
        $client = Client::find($this->option('client'));
        if (!$client) {
            $this->error('Client not found.');
            return 1;
        }

        $package = Package::find($this->option('package'));
        if (!$package) {
            $this->error('Package not found.');
            return 1;
        }

        // Parse discount
        $discountType = null;
        if ($this->option('discount_type')) {
            $discountType = DiscountType::tryFrom($this->option('discount_type'));
            if (!$discountType) {
                $this->error('Invalid discount type. Use "percentage" or "flat".');
                return 1;
            }
        }

        $discountValue = (float) $this->option('discount_value');

        // Parse start date
        $startDate = null;
        if ($this->option('start_date')) {
            try {
                $startDate = Carbon::parse($this->option('start_date'));
            } catch (\Exception $e) {
                $this->error('Invalid start date format. Use YYYY-MM-DD.');
                return 1;
            }
        }

        // Check for existing active subscription
        $existingSubscription = Subscription::where('client_id', $client->id)
            ->where('status', 'active')
            ->first();

        if ($existingSubscription) {
            $this->warn("Client {$client->name} already has an active subscription:");
            $this->line("  Package: {$existingSubscription->package->name}");
            $this->line("  End Date: {$existingSubscription->end_date->format('Y-m-d')}");

            if (!$this->option('force') && !$this->confirm('Do you want to continue and create a new subscription?')) {
                $this->info('Operation cancelled.');
                return 0;
            }
        }

        // Create subscription
        try {
            $subscription = $subscriptionService->assignViaCommand(
                $client,
                $package,
                $discountType,
                $discountValue,
                $startDate
            );

            $this->info('✓ Subscription created successfully!');
            $this->line('');
            $this->line("Client: {$client->name}");
            $this->line("Package: {$package->name}");
            $this->line("Start Date: {$subscription->start_date->format('Y-m-d')}");
            $this->line("End Date: {$subscription->end_date->format('Y-m-d')}");
            $this->line("Final Price: ₹" . number_format($subscription->final_price, 2));

            return 0;
        } catch (\Exception $e) {
            $this->error('Failed to create subscription: ' . $e->getMessage());
            return 1;
        }
    }
}
