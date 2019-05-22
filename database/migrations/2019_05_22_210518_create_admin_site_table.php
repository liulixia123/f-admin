<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminSiteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_site', function(Blueprint $table)
        {
            $table->increments('id')->comment('ID');
            $table->string('site_name')->comment('网站名');
            $table->string('qq')->nullable()->comment('联系我QQ');
            $table->string('email')->nullable()->comment('联系我email');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('admin_site');
    }
}
