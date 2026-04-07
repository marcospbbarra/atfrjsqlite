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
        Schema::create('cadastro', function (Blueprint $table) {
            $table->id();
            $table->text('nome');
            $table->text('email');
            $table->unsignedSmallInteger('ano_filiacao');
            $table->string('local_de_atendimento', 255);
            $table->text('telefone');
            $table->string('formacao', 255);
            $table->boolean('autorizacao_lgpd')->default(false);
            $table->boolean('autorizacao_mailing')->default(false);
            $table->string('status', 15);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cadastro');
    }
};
