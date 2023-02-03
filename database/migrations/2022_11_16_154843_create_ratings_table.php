<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('requisicao_id')->nullable();
            $table->string('pac_name')->nullable();
            $table->integer('pac_id')->nullable();
            $table->integer('grp_agendamento')->nullable();
            $table->date('data_req')->nullable();
            $table->string('atend_name')->nullable();
            $table->integer('atend_rate')->nullable();
            $table->string('recep_name')->nullable();
            $table->integer('recep_rate')->nullable();
            $table->integer('nota_clinica')->nullable();            
            $table->string('comentario')->nullable();
            $table->integer('tipo_atraso')->nullable();
            $table->boolean('recomenda')->nullable();
            $table->boolean('finalizado')->nullable();
            $table->timestamps();
            $table->engine = "InnoDB";

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
