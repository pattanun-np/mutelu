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
        Schema::table('sacredplaces', function (Blueprint $table) {
            if (!Schema::hasColumn('sacredplaces', 'tag_ids')) {
                $table->json('tag_ids')->nullable()->after('longitude');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sacredplaces', function (Blueprint $table) {
            if (Schema::hasColumn('sacredplaces', 'tag_ids')) {
                $table->dropColumn('tag_ids');
            }
        });
    }
};
