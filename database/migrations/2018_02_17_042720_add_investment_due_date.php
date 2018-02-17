<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddInvestmentDueDate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::table('balance', function (Blueprint $table) {
            $table->integer('requestid')->unsigned();
            $table->foreign('requestid')->references('id')->on('requests');
        });
        
        Schema::table('investiment', function (Blueprint $table) {
            $table->date('duedate')->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
