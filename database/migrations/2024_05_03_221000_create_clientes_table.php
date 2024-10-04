<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('razon');
            $table->integer('cuenta');
            $table->integer('id_cliente');
            $table->string('representante');
            $table->string('telefono', 10);
            $table->string('correo');
            $table->string('fiscal');
            $table->string('entrega');
            $table->string('rfc', 50);
            $table->string('vendedor_adquisicion')->nullable();
            $table->timestamp('fecha_adquisicion')->nullable();
            $table->foreignId('ejecutivo')->nullable()->constrained('distribuidors');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('clientes');
    }
};
