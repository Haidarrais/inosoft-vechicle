<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStocksTable extends Migration{
    
    public function up(){
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->integer('vehicle_id');
            $table->integer('qty');
            $table->timestamps();
        });
    }

    public function down(){
        Schema::dropIfExists('stocks');
    }
}