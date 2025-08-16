<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('empresas', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('cnpj');
            $table->text('sobre');
            $table->string('imagem');
            $table->boolean('status')->default(true); 
            $table->timestamps();
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('empresas');
    }
};
