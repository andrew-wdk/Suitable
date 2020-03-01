<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepeatablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repeatables', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->time('start');
            $table->time('end');
            $table->bigInteger('user_id');
            $table->string('title')->nullable();
            $table->boolean('Mon')->nullable();
            $table->boolean('Tue')->nullable();
            $table->boolean('Wed')->nullable();
            $table->boolean('Thu')->nullable();
            $table->boolean('Fri')->nullable();
            $table->boolean('Sat')->nullable();
            $table->boolean('Sun')->nullable();
            $table->smallInteger('priority')->nullable();
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
        Schema::dropIfExists('repeatables');
    }
}
