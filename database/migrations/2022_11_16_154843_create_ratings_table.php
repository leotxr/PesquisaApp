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
            $table->id()->unique()->unsigned();
            $table->string('tipo_agendamento')->nullable();
            $table->date('data_req')->nullable();
            $table->string('pac_name')->nullable();
            $table->integer('pac_id')->nullable();
            $table->string('atend_name')->nullable();
            $table->integer('atend_rate')->nullable();
            $table->string('recep_name')->nullable();
            $table->integer('recep_rate')->nullable();
            $table->integer('nota_clinica')->nullable();
            $table->boolean('finalizado')->nullable();
            $table->string('comentario')->nullable();
            $table->timestamps();

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
