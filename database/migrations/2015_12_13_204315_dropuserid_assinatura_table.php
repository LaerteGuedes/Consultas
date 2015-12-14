<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class DropuseridAssinaturaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('assinaturas', function(Blueprint $table){
            $table->dropColumn('user_id');
        });

        Schema::table('users', function(Blueprint $table){
            $table->integer('assinatura_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('assinaturas', function(Blueprint $table){
            $table->integer('user_id');
        });

        Schema::table('users', function(Blueprint $table){
            $table->drop('assinatura_id');
        });
    }
}
