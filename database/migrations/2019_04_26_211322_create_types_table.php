<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('types', function(Blueprint $table)
        {
            $table->increments('id')->comment('ID');
            $table->string('type_name')->unique()->comment('机型名称');
            $table->string('card_type')->comment('卡片类型');            
            $table->smallInteger('status')->default(1)->comment('状态');           
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
        Schema::drop('types');
    }
}
