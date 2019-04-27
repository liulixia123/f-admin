<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function(Blueprint $table)
        {
            $table->increments('id')->comment('ID');
            $table->string('game_name')->comment('游戏名');
            $table->string('number')->comment('编号');
            $table->float('size_range', 11)->comment('容量大小区间');
            $table->smallInteger('status')->default(1)->comment('状态');
            $table->string('language', 10)->comment('语言');
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
        Schema::drop('games');
    }
}
