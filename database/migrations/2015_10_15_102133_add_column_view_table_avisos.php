<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnViewTableAvisos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('avisos', function (Blueprint $table){

                $table->integer('profissional_id')->unsigned()->nullable();
                $table->integer('cliente_id')->unsigned()->nullable();
                $table->boolean('profissional_view')->default(0);
                $table->boolean('cliente_view')->default(0);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('avisos', function (Blueprint $table){
                
                $table->dropColumn('profissional_id');
                $table->dropColumn('cliente_id');
                $table->dropColumn('profissional_view');
                $table->dropColumn('cliente_view');
        });
    }
}
