<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('log')->create('log', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('accion');
            $table->text('valores_nuevos')->nullable();
            $table->text('valores_antiguos')->nullable();
            $table->string('name_user');
            $table->string('rut');
            $table->string('navegador');
            $table->string('ip');
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
        Schema::connection('log')->dropIfExists('log');
    }
}
