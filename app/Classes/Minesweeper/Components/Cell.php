<?php

namespace App\Classes\Minesweeper\Components;

/**
 * Main Class for the game, it contains all the logic to
 * generate new games and to resume/pause old games for the user.
 */
abstract class Cell
{
    /**
     * get Cell Type.
     *
     * @var string
     */
    public $type = 'cell';
    /**
     * Status of cell.
     *
     * @var bool
     */
    protected $hasBeenRevealed = false;
    /**
     * Has a flag.
     *
     * @var bool
     */
    protected $hasBeenFlagged = false;

    public function __construct()
    {
    }

    //string format of Cell Value
    abstract public function __toString();
}
