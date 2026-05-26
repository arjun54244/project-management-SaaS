<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Domain;
use App\Models\Hosting;
use App\Enums\DomainStatus;
use App\Enums\HostingStatus;

class CheckExpiries extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-expiries';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for expired domains and hostings and update their status';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $expiredDomains = Domain::where('expiry_date', '<', now())
            ->where('status', DomainStatus::Active)
            ->update(['status' => DomainStatus::Expired]);

        if ($expiredDomains > 0) {
            $this->info("Updated $expiredDomains domains to expired.");
        }

        $expiredHostings = Hosting::where('expiry_date', '<', now())
            ->where('status', HostingStatus::Active)
            ->update(['status' => HostingStatus::Expired]);

        if ($expiredHostings > 0) {
            $this->info("Updated $expiredHostings hostings to expired.");
        }

        $this->info('Expiry check completed.');
    }
}
