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
        Schema::table('distribution_pricings', function (Blueprint $table) {
            $table->text('description')->nullable()->after('duration');
            $table->json('features')->nullable()->after('description');
            $table->boolean('is_active')->default(true)->after('features');
            $table->string('type')->default('standard')->after('is_active'); // standard, premium, ultimate
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('distribution_pricings', function (Blueprint $table) {
            $table->dropColumn(['description', 'features', 'is_active', 'type']);
        });
    }
};
