<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnavailablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unavailables', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->dateTime('start');
            $table->dateTime('end');
            $table->integer('user_id');
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
        Schema::dropIfExists('unavailables');
    }
}
