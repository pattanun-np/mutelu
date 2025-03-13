<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('sacredplaces', function (Blueprint $table) {
            $table->string('slug')->nullable()->after('name');
            $table->index('slug');
        });

        // Generate slugs for existing records
        $this->generateSlugs();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sacredplaces', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }

    /**
     * Generate slugs for existing records
     */
    private function generateSlugs(): void
    {
        $sacredPlaces = DB::table('sacredplaces')->get();

        foreach ($sacredPlaces as $place) {
            $slug = \Illuminate\Support\Str::slug($place->name);
            $originalSlug = $slug;
            $count = 1;

            // Check if the slug already exists
            while (DB::table('sacredplaces')->where('slug', $slug)->where('id', '!=', $place->id)->exists()) {
                $slug = $originalSlug . '-' . $count++;
            }

            DB::table('sacredplaces')->where('id', $place->id)->update(['slug' => $slug]);
        }
    }
};
