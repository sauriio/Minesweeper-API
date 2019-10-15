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
            $table->boolean('paused')->default(false);
            $table->tinyInteger('rows')->default(0);
            $table->tinyInteger('columns')->default(0);
            $table->tinyInteger('mines')->default(0);
            $table->json('payload');
            $table->boolean('initializated')->default(false);
            $table->tinyInteger('seconds_played')->default(0);
            $table->boolean('is_over')->default(0);
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
