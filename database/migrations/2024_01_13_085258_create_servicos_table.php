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
        Schema::create('servicos', function (Blueprint $table) {
            $table->id();
            $table->text('titulo');
            $table->text('descricao')->nullable();
            $table->enum('status', ['Em andamento', 'Concluído', 'Interrompido', 'Suspenso', 'Cancelado'])->default('Em andamento');
            $table->integer('preco')->nullable();
            $table->string('arquivos')->nullable();
            $table->unsignedBigInteger('cliente_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
        
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servicos');
    }
};