<?php

use Illuminate\Support\Facades\DB;
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
            $table->string('password');
            $table->boolean('isadmin');
	    
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
            $table->string('fullname');
            $table->integer('document');
            $table->string('agency');
            $table->string('account');
            $table->integer('type');
            $table->boolean('enabled');
	    $table->foreign('userid')->references('id')->on('users');

        });
	Schema::create('requesttype', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
           
        });
	Schema::create('requeststatus', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');

           
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
            $table->integer('planid')->unsigned();
            $table->boolean('enabled');
            $table->integer('requestid')->unsigned();
	    $table->foreign('userid')->references('id')->on('users');
	    $table->foreign('requestid')->references('id')->on('requests');
	    $table->foreign('planid')->references('id')->on('plan');

        });

	
	    DB::table('users')->insert(
	        array(
	            'email' => 'claudio.bogossian@gmail.com',
	            'firstname' => 'Claudio',
	            'lastname' => 'Bogossian',
	            'document' => '123456',
	            'birthdate' => '1983/04/28',
	            'registrydate' => '2017/04/28',
	            'password' => md5('123456'),
	            'isadmin' => true
	        )
	    );
	    
	    DB::table('users')->insert(
	        array(
	            'email' => 'jetimports@yahoo.com.br',
	            'firstname' => 'Alexandre',
	            'lastname' => 'Brito',
	            'document' => '123456',
	            'birthdate' => '1983/04/28',
	            'registrydate' => '2017/04/28',
	            'password' => md5('123456'),
	            'isadmin' => true
	        )
	        );
	    
	    DB::table('requesttype')->insert(
	        array(
	            'id' => 1,
	            'name' => 'User Registration Request'
	        )
	        );
	    DB::table('requesttype')->insert(
	        array(
	            'id' => 2,
	            'name' => 'Investiment Request'
	        )
	        );
	    DB::table('requesttype')->insert(
	        array(
	            'id' => 3,
	            'name' => 'Withdraw Request'
	        )
	        );
	    
	    DB::table('requeststatus')->insert(
	        array(
	            'id' => 1,
	            'name' => 'New'
	        )
	        );
	    DB::table('requeststatus')->insert(
	        array(
	            'id' => 2,
	            'name' => 'Accepted'
	        )
	        );
	    DB::table('requeststatus')->insert(
	        array(
	            'id' => 3,
	            'name' => 'Denied'
	        )
	        );
	    
	    DB::table('plan')->insert(
	        array(
	            'id' => 1,
	            'name' => '30 Days',
	            'days' => 30
	        )
	        );
	    
	    DB::table('plan')->insert(
	        array(
	            'id' => 2,
	            'name' => '60 Days',
                'days' => 60
	        )
	        );
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
