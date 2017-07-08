<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('salesman_id')->unsigned();
            $table->decimal('sale_value', 10, 2);
            $table->decimal('sale_commission', 10, 2);
            $table->date('sale_date');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('sales', function($table) {
           $table->foreign('salesman_id')->references('id')->on('salesman');
       });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales');
    }
}
