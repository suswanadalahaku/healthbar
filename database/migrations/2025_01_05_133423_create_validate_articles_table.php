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
        Schema::create('validate_articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_artikel')->constrained('articles')->onDelete('cascade');
            $table->text('message')->nullable(); // Pesan dari dokter
            $table->string('status', 15)->default('pending'); // Status validasi
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('validate_articles');
    }
};
