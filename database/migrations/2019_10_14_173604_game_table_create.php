<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GameTableCreate extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        //create the game table
        Schema::create('game', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('paused');
            $table->tinyInteger('rows');
            $table->tinyInteger('columns');
            $table->tinyInteger('mines');
            $table->json('payload');
            $table->tinyInteger('seconds_played');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('game');
    }
}
