<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->integer('year');
            $table->string('color');
            $table->string('price');
            $table->morphs('vehicle');
            $table->timestamps();
        });
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('machine');
            $table->string('capacity');
            $table->string('car_type');
            $table->timestamps();
        });
        Schema::create('motorcycles', function (Blueprint $table) {
            $table->id();
            $table->string('transmision_type');
            $table->string('suspension_type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicles');
        Schema::dropIfExists('motorcyles');
        Schema::dropIfExists('cars');
    }
}
