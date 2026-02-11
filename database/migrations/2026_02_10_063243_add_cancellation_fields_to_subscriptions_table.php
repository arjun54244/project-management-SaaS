<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('subscriptions', function (Blueprint $blueprint) {
            $blueprint->timestamp('cancelled_at')->nullable()->after('status');
            $blueprint->text('cancellation_reason')->nullable()->after('cancelled_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subscriptions', function (Blueprint $blueprint) {
            $blueprint->dropColumn(['cancelled_at', 'cancellation_reason']);
        });
    }
};
