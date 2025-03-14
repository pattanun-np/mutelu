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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('body');
            $table->integer('rating');
            $table->foreignId('sacredplace_id')->constrained('sacredplaces');
            $table->foreignId('user_id')->constrained('users');
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['sacredplace_id', 'user_id']);
            $table->index('sacredplace_id');
            $table->index('user_id');
            $table->index('title');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
