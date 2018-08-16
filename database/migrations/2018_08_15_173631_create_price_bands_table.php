<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePriceBandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('price_bands', function (Blueprint $table) {
            $table->increments('__pk');
            $table->integer('_fk_property');
            $table->foreign('_fk_property')->references('__pk')->on('properties');
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('price',10,2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('price_bands');
    }
}
