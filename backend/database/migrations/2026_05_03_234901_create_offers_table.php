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
        Schema::create('offers', function (Blueprint $table) {
            $table->id();

            // Información de la oferta
            $table->string('title');
            $table->text('description');

            // Estado
            $table->string('status')->default('active');

            // Usuario creador (reclutador)
            $table->foreignId('created_by')
                ->constrained('users')
                ->onDelete('cascade');

            // Fechas
            $table->timestamps();

            // Soft delete (no elimina físicamente)
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offers');
    }
};
