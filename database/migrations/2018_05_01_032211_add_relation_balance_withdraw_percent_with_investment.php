<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRelationBalanceWithdrawPercentWithInvestment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void 
     */
    public function up()
    {
            
        Schema::table('withdraw', function (Blueprint $table) {
            $table->integer('investimentid')->nullable(false);
            
        });
            
        Schema::table('balance', function (Blueprint $table) {
            $table->integer('investimentid')->nullable(false);
            
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
