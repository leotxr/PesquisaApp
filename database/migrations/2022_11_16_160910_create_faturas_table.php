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
            $table->string('med_name')->nullable();
            $table->integer('med_rate')->nullable();
            $table->string('tec_name')->nullable();
            $table->string('us_name')->nullable();
            $table->integer('us_rate')->nullable();
            $table->string('enf_name')->nullable();
            $table->integer('enf_rate')->nullable();
            $table->string('setor')->nullable();
            $table->timestamps();

            $table->foreignId('rating_id')
                ->constrained('ratings');
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
