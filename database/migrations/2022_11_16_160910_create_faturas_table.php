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
        Schema::create('faturas', function (Blueprint $table) {

            $table->increments('id')->unique();
            $table->integer('fatura_id')->nullable();
            $table->date('fatura_data')->nullable();
            $table->unsignedBigInteger('rating_id');
            $table->foreign('rating_id')->references('id')->on('ratings')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->integer('requisicao_id');
            $table->string('livro_name')->nullable();
            $table->integer('livro_rate')->nullable();
            #$table->integer('grp_livro')->nullable();
            $table->string('tec_name')->nullable();
            $table->string('us_name')->nullable();
            $table->integer('us_rate')->nullable();
            $table->string('enf_name')->nullable();
            $table->integer('enf_rate')->nullable();
            $table->string('setor')->nullable();
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
        Schema::dropIfExists('faturas');
    }
};
