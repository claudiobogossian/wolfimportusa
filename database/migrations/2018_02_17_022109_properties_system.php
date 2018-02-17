<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;


class PropertiesSystem extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    

    
    
    public function up()
    {
        Schema::dropIfExists('properties');
        Schema::dropIfExists('propertytype');
   
        
        Schema::create('propertytype', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
        });
        
        Schema::create('properties', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('value');
            $table->integer('propertytypeid')->unsigned();
            $table->foreign('propertytypeid')
                ->references('id')
                ->on('propertytype');
        });
        
        DB::table('propertytype')->insert(array(
            'id' => 1,
            'name' => 'Integer'
        ));
        DB::table('propertytype')->insert(array(
            'id' => 2,
            'name' => 'Double'
        ));
        DB::table('propertytype')->insert(array(
            'id' => 3,
            'name' => 'String'
        ));
        
        DB::table('properties')->insert(array(
            'name' => 'currency.dollar.min.value',
            'value' => '2000',
            'propertytypeid' => 1
        ));
        
        DB::table('properties')->insert(array(
            'name' => 'currency.reais.min.value',
            'value' => '5000',
            'propertytypeid' => 1
        ));
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
