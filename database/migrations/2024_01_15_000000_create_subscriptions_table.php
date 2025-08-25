<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('plan_name', ['free', 'artist', 'record_label', 'premium'])->default('free');
            $table->decimal('amount', 10, 2)->default(0.00);
            $table->enum('status', ['pending', 'active', 'expired', 'cancelled'])->default('pending');
            $table->timestamp('expires_at')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->string('paystack_reference')->nullable();
            $table->string('paystack_access_code')->nullable();
            $table->json('metadata')->nullable(); // Store additional payment metadata
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('subscriptions');
    }
};