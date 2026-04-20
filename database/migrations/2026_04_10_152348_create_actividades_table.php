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
        Schema::create('actividades', function (Blueprint $table) {
            $table->id();
            $table->string('titulo')->unique();
            $table->string('nivel');
            $table->text('descripcion');
            $table->string('imagen')->nullable();
<<<<<<< HEAD
            $table->foreignId('tipos_id')->constrained('tipos')->onDelete('cascade');
=======
            $table->foreignId('tipo_id')->constrained('tipos')->onDelete('cascade');
>>>>>>> fb55ae0 (Intregración de las cookies)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actividades');
    }
};
