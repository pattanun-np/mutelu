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
        Schema::create('sacredplaces', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->string('image');
            $table->float('latitude');
            $table->float('longitude');
            $table->json('tag_ids')->nullable();
            $table->json('tags')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index('name');
            $table->index('latitude');
            $table->index('longitude');
            $table->index('created_at');
            $table->index('updated_at');
            $table->index('tag_ids');
            $table->index('tags');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sacredplaces');
    }
};
