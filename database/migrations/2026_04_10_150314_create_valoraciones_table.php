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
        Schema::create('valoraciones', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('comentario')->nullable();
<<<<<<< HEAD
            $table->decimal('puntuacion', 2, 2);
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('curso_id')->constrained('cursos')->onDelete('cascade');
=======
            $table->unsignedTinyInteger('puntuacion');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('centro_id')->constrained('centros')->onDelete('cascade');
>>>>>>> fb55ae0 (Intregración de las cookies)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('valoraciones');
    }
};
