<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBalanceNewPk extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::drop('balance');
        
        Schema::create('balance', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('userid')->unsigned();
            $table->date('date');
            $table->decimal('value');
            $table->integer('requestid')->unsigned();
            $table->foreign('requestid')->references('id')->on('requests');
            $table->foreign('userid')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
