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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->foreignId('package_id')->constrained();
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('price_before_discount', 10, 2);
            $table->string('discount_type')->nullable(); // percentage, flat
            $table->decimal('discount_value', 10, 2)->default(0);
            $table->decimal('final_price', 10, 2);
            $table->string('status')->default('active'); // active, expired, cancelled
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
