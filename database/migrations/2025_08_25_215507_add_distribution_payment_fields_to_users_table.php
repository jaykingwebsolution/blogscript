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
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('distribution_paid')->default(false)->after('role');
            $table->timestamp('distribution_paid_at')->nullable()->after('distribution_paid');
            $table->string('distribution_payment_reference')->nullable()->after('distribution_paid_at');
            $table->decimal('distribution_amount_paid', 10, 2)->nullable()->after('distribution_payment_reference');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['distribution_paid', 'distribution_paid_at', 'distribution_payment_reference', 'distribution_amount_paid']);
        });
    }
};
