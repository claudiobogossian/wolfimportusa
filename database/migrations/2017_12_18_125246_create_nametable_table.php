<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNametableTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('email');
            $table->string('document');
            $table->date('birthdate');
            $table->date('registrydate');
        });
	Schema::create('balance', function (Blueprint $table) {
            $table->integer('userid')->unsigned();
            $table->date('date');
            $table->decimal('value');
	    $table->foreign('userid')->references('id')->on('users');
        });
	Schema::create('bankdata', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('userid');
            $table->integer('bankid');
            $table->string('agency');
            $table->string('account');
            $table->boolean('enabled');
	    $table->foreign('userid')->references('id')->on('users');
        });
	Schema::create('useranalysis', function (Blueprint $table) {
            $table->integer('userid');
            $table->boolean('enabled');
            $table->integer('investiment_percent');
            $table->string('requestid');
	    $table->foreign('userid')->references('id')->on('users');
	    $table->foreign('requestid')->references('id')->on('requests');
        });
	Schema::create('investiment', function (Blueprint $table) {
            $table->integer('userid');
            $table->boolean('enabled');
            $table->integer('investiment_percent');
            $table->string('requestid');
	    $table->foreign('userid')->references('id')->on('users');
	    $table->foreign('requestid')->references('id')->on('requests');
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nametable');
    }
}
