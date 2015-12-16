<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateUserAssinatura extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_assinaturas', function(Blueprint $table){
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('assinatura_id');
            $table->enum('assinatura_status', ['PERIODO_TESTES', 'APROVADO', 'SUSPENSO']);
            $table->timestamp('expiracao');
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
        Schema::drop('user_assinaturas');
    }
}
