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
            $table->foreignId('rating_id')
            ->constrained('ratings');
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
