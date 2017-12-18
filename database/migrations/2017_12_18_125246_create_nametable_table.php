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

 Schema::dropIfExists('investiment');
        Schema::dropIfExists('plan');
        Schema::dropIfExists('useranalysis');
        Schema::dropIfExists('withdraw');
        Schema::dropIfExists('requests');
        Schema::dropIfExists('requeststatus');
        Schema::dropIfExists('requesttype');
        Schema::dropIfExists('bankdata');
        Schema::dropIfExists('balance');
        Schema::dropIfExists('users');



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
	    $table->primary('userid');
        });
	Schema::create('bankdata', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('userid')->unsigned();
            $table->integer('bankid');
            $table->string('agency');
            $table->string('account');
            $table->boolean('enabled');
	    $table->foreign('userid')->references('id')->on('users');

        });
	Schema::create('requesttype', function (Blueprint $table) {
            $table->increments('id');
            $table->date('name');
           
        });
	Schema::create('requeststatus', function (Blueprint $table) {
            $table->increments('id');
            $table->date('name');

           
        });
	Schema::create('requests', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->integer('requesttypeid')->unsigned();
            $table->integer('requeststatusid')->unsigned();
            $table->boolean('approved');
	    $table->foreign('requesttypeid')->references('id')->on('requesttype');
	    $table->foreign('requeststatusid')->references('id')->on('requeststatus');

           
        });
	Schema::create('withdraw', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->date('enddate');
            $table->integer('requestid')->unsigned();
            $table->integer('userid')->unsigned();
            $table->decimal('value');
	    $table->foreign('userid')->references('id')->on('users');
	    $table->foreign('requestid')->references('id')->on('requests');

        });
	Schema::create('useranalysis', function (Blueprint $table) {
            $table->integer('userid')->unsigned();
            $table->boolean('enabled');
            $table->integer('investimentpercent');
            $table->integer('requestid')->unsigned();
	    $table->foreign('userid')->references('id')->on('users');
	    $table->foreign('requestid')->references('id')->on('requests');
	    $table->primary('userid');
        });
	Schema::create('plan', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('days');

        });
	Schema::create('investiment', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('userid')->unsigned();
            $table->decimal('value');
            $table->date('initdate');
            $table->date('enddate');
            $table->integer('planid')->unsigned();
            $table->boolean('enabled');
            $table->integer('requestid')->unsigned();
	    $table->foreign('userid')->references('id')->on('users');
	    $table->foreign('requestid')->references('id')->on('requests');
	    $table->foreign('planid')->references('id')->on('plan');

        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('investiment');
        Schema::dropIfExists('plan');
        Schema::dropIfExists('useranalysis');
        Schema::dropIfExists('withdraw');
        Schema::dropIfExists('requests');
        Schema::dropIfExists('requeststatus');
        Schema::dropIfExists('requesttype');
        Schema::dropIfExists('bankdata');
        Schema::dropIfExists('balance');
        Schema::dropIfExists('users');

    }
}
