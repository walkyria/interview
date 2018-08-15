<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->increments('__pk');
            $table->primary('__pk');
            $table->integer('_fk_location')->unsigned()->nullable();
            $table->foreign('_fk_location')->references('__pk')->on('locations');
            $table->string('property_name')->nullable();
            $table->boolean('near_beach')->nullable();
            $table->boolean('accepts_pets')->nullable();
            $table->tinyInteger('sleeps')->unsigned()->nullable();
            $table->tinyInteger('beds')->unsigned()->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('properties');
    }
}
