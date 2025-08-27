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
        Schema::table('distribution_requests', function (Blueprint $table) {
            // Enhanced metadata fields
            $table->string('isrc')->nullable()->after('genre');
            $table->string('upc')->nullable()->after('isrc');
            $table->json('contributors')->nullable()->after('upc'); // Array of contributors
            $table->boolean('explicit_content')->default(false)->after('contributors');
            $table->json('territories')->nullable()->after('explicit_content'); // Distribution territories
            $table->string('record_label')->nullable()->after('territories');
            $table->text('lyrics')->nullable()->after('record_label');
            
            // DSP delivery tracking
            $table->enum('dsp_delivery_status', ['pending', 'processing', 'delivered', 'failed'])->default('pending')->after('status');
            $table->json('dsp_platforms')->nullable()->after('dsp_delivery_status'); // Platform delivery status
            $table->datetime('delivered_at')->nullable()->after('dsp_platforms');
            
            // Additional tracking
            $table->decimal('distribution_fee', 8, 2)->nullable()->after('delivered_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('distribution_requests', function (Blueprint $table) {
            $table->dropColumn([
                'isrc', 'upc', 'contributors', 'explicit_content', 'territories',
                'record_label', 'lyrics', 'dsp_delivery_status', 'dsp_platforms', 
                'delivered_at', 'distribution_fee'
            ]);
        });
    }
};
