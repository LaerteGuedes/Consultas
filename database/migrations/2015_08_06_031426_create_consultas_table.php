<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConsultasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consultas', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('profissional_id')->unsigned();
            $table->integer('localidade_id')->unsigned();
            $table->date('data_agenda')->nullable();
            $table->time('horario_agenda')->nullable();
            $table->boolean('pessoal')->default(1);
            $table->string('outro')->nullable();
            $table->text('nota')->nullable();
            $table->enum('status',['INFO','AGUARDANDO','CONFIRMADA','REALIZADA','CANCELADA'])->default('INFO');
            $table->softDeletes();
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
        Schema::drop('consultas');
    }
}
