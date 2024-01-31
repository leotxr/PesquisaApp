<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_fatura', function (Blueprint $table) {
            $table->unsignedBigInteger('employee_id');
            $table->foreign('employee_id')
                ->references('id')
                ->on('employees')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->unsignedInteger('fatura_id');
            $table->foreign('fatura_id')
                ->references('id')
                ->on('faturas')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->integer('rate')->nullable();
            $table->string('role')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_faturas');
    }
};
