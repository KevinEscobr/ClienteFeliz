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
        Schema::create('status_histories', function (Blueprint $table) {

            $table->id();
            // Relación con la aplicación
            $table->foreignId('application_id')
                ->constrained('applications')
                ->onDelete('cascade');

            // Estado (flexible, sin enum)
            $table->string('status');

            // Comentario del cambio
            $table->text('comment')->nullable();

            // Usuario que hizo el cambio
            $table->foreignId('changed_by')
                ->constrained('users')
                ->onDelete('cascade');

            // Fechas
            $table->timestamps();
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('status_histories');
    }
};
