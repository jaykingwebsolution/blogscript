<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('distribution_payouts')) {
            Schema::create('distribution_payouts', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->decimal('amount', 10, 2);
                $table->string('currency', 3)->default('USD');
                $table->enum('status', ['pending', 'processing', 'completed', 'failed', 'cancelled'])->default('pending');
                $table->enum('method', ['bank_transfer', 'paypal', 'mobile_money'])->default('bank_transfer');
                $table->json('payment_details')->nullable(); // Bank account details, PayPal email, etc.
                $table->string('transaction_reference')->nullable();
                $table->text('notes')->nullable();
                $table->timestamp('requested_at')->nullable();
                $table->timestamp('processed_at')->nullable();
                $table->timestamp('completed_at')->nullable();
                $table->timestamps();
                
                $table->index(['user_id', 'status']);
                $table->index('status');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('distribution_payouts');
    }
};
