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
        // Check if the tag table exists
        if (Schema::hasTable('tag')) {
            // Rename the table from tag to tags
            Schema::rename('tag', 'tags');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Check if the tags table exists
        if (Schema::hasTable('tags')) {
            // Rename the table back from tags to tag
            Schema::rename('tags', 'tag');
        }
    }
};
