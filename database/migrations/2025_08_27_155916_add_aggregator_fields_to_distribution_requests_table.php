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
        if (!Schema::hasTable('distribution_requests')) {
            return;
        }

        Schema::table('distribution_requests', function (Blueprint $table) {
            if (!Schema::hasColumn('distribution_requests', 'aggregator_provider')) {
                $table->string('aggregator_provider')->nullable()->after('dsp_delivery_status');
            }
            if (!Schema::hasColumn('distribution_requests', 'aggregator_release_id')) {
                $table->string('aggregator_release_id')->nullable()->after('aggregator_provider');
            }
            if (!Schema::hasColumn('distribution_requests', 'aggregator_response')) {
                $table->json('aggregator_response')->nullable()->after('aggregator_release_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('distribution_requests')) {
            Schema::table('distribution_requests', function (Blueprint $table) {
                if (Schema::hasColumn('distribution_requests', 'aggregator_provider')) {
                    $table->dropColumn('aggregator_provider');
                }
                if (Schema::hasColumn('distribution_requests', 'aggregator_release_id')) {
                    $table->dropColumn('aggregator_release_id');
                }
                if (Schema::hasColumn('distribution_requests', 'aggregator_response')) {
                    $table->dropColumn('aggregator_response');
                }
            });
        }
    }
};
