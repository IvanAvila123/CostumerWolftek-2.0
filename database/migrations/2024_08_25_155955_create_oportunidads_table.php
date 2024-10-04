<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('oportunidads', function (Blueprint $table) {
            $table->id();
            $table->string('vendedor');
            $table->enum('venta', ['Renovacion', 'Adicion', 'Renovacion Anticipada T-1', 'Renovacion Anticipada', 'Venta Nueva']);
            $table->string('entrega', 500);
            $table->string('autorizada');
            $table->string('acuerdo')->nullable()->default('Sin Acuerdo');
            $table->string(column: 'comentarios')->nullable()->default('Sin comentarios');
            $table->timestamp('actualizacion');
            $table->enum('estado', [
                'Haciendo Contratos', 'Se ingresa Venta', 'Revision', 'Captura', 'Verificacion De Credito',
                'Rechazada Por Credito', 'Verificacion de Credito Rechazada', 'Verificacion De Credito Aprobada',
                'Asignacion De Equipo', 'Cancela/Envios', 'Envios/Por Confirmar', 'Envios/En Ruta',
                'Orden Entregada', 'Pendiente', 'Aprobada', 'Rechazada', 'Revisando Venta'
            ]);
            $table->softDeletes();
            $table->foreignId('id_ejecutivo')->constrained('distribuidors');
            $table->foreignId('user_id')->constrained();
            $table->foreignId('cliente_id')->constrained();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('oportunidads');
    }
};