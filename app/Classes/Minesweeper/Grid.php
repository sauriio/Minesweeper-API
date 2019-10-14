<?php

namespace App\Classes\Minesweeper;

class Grid
{
    /**
     * array containing the rows and values.
     *
     * @var array
     */
    private $_grid = [];
    /**
     * State of Game.
     *
     * @var bool
     */
    private $_gamePaused = false;
    /**
     * is the game over, cannot continue.
     *
     * @var bool
     */
    private $_gameIsOver = false;
    /**
     * Number of mines on grid.
     *
     * @var int
     */
    private $_mines = 0;

    /**
     * Constructor of class.
     *
     * @param int $rows
     * @param int $columns
     * @param int $mines
     */
    public function __construct(int $rows, int $columns, int $mines)
    {
        //set the number of mines of the game.
        $this->_mines = $mines;
        //let's initializate the game array.
        for ($r = 0; $r < $rows; ++$r) {
            for ($col = 0; $col < $columns; ++$col) {
                $this->_grid[$r][$col] = null;
            }
        }
    }

    /**
     * Return Raw Array Grid.
     *
     * @return array
     */
    public function returnGridData(): array
    {
        return $this->_grid;
    }
}
