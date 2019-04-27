<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function(Blueprint $table)
        {
            $table->increments('id')->comment('ID');
            $table->string('order_num',50)->unique()->comment('订单号');
            $table->string('username',20)->comment('用户名');
            $table->string('mobile', 11)->nullable()->comment('手机号码');
            $table->smallInteger('status')->default(1)->comment('订单状态');
            $table->string('info')->comment('详情');
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
        Schema::drop('orders');
    }
}
