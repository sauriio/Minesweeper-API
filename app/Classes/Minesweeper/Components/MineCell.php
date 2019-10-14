<?php

namespace App\Classes\Minesweeper\Components;

/**
 * Main Class for the game, it contains all the logic to
 * generate new games and to resume/pause old games for the user.
 */
class MineCell extends Cell
{
    public $type = 'mineCell';

    public function __construct()
    {
    }

    /**
     * implementation of abstract method inherited from parent.
     *
     * @return string
     */
    public function __toString()
    {
        return 'X';
    }
}
