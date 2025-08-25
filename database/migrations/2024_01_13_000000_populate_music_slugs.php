<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update any existing music records that have null or empty slugs
        $musicRecords = DB::table('music')
            ->whereNull('slug')
            ->orWhere('slug', '')
            ->get();

        foreach ($musicRecords as $music) {
            $slug = $this->generateUniqueSlug($music->title, $music->id);
            DB::table('music')
                ->where('id', $music->id)
                ->update(['slug' => $slug]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No need to reverse - this migration only populates data
    }

    /**
     * Generate a unique slug for a music record.
     */
    private function generateUniqueSlug($title, $ignoreId = null)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $counter = 1;

        while (DB::table('music')
            ->where('slug', $slug)
            ->when($ignoreId, function ($query, $ignoreId) {
                return $query->where('id', '!=', $ignoreId);
            })
            ->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
};