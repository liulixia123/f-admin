<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGameTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_type', function(Blueprint $table)
        {
            $table->integer('game_id')->unsigned();
            $table->integer('type_id')->unsigned()->index('game_type_type_id_foreign');
            $table->primary(['game_id','type_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('game_type');
    }
}
