<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;


class AlterPlanoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("planos", function($table){
            $table->dropColumn("nome");
            $table->dropColumn("valor");
            $table->dropColumn("descricao");
            $table->string("titulo", 100);
            $table->integer("id_pai")->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("planos", function($table){
           $table->string("nome");
           $table->decimal("valor", 10, 2);
           $table->text("descricao");
           $table->dropColumn("titulo");
           $table->dropColumn("id_pai");
        });
    }
}
