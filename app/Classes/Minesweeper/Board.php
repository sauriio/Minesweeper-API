<?php

namespace App\Classes\Minesweeper;

use App\Classes\Minesweeper\Components\Cell;
use App\Classes\Minesweeper\Components\MineCell;
use App\Classes\Minesweeper\Components\SafeCell;

class Board
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
     * Number of rows of board.
     *
     * @var int
     */
    private $_rows = 0;
    /**
     * Number of columns of board.
     *
     * @var int
     */
    private $_columns = 0;
    /**
     * has the player made the first moveset?
     *
     * @var bool
     */
    private $_isgameInitializated = false;

    /**
     * Constructor of class.
     *
     * @param int $rows
     * @param int $columns
     * @param int $mines
     */
    public function __construct(int $rows, int $columns, int $mines)
    {
        //set the number of mines of this board.
        $this->_mines = $mines;
        //set the number of rows of this board.
        $this->_rows = $rows;
        //set the number of columns of this board.
        $this->_columns = $columns;
        //let's initializate the game array.
        for ($r = 0; $r < $rows; ++$r) {
            for ($col = 0; $col < $columns; ++$col) {
                $this->_grid[$r][$col] = null;
            }
        }
    }

    public function setMoveSet($row, $column)
    {
        if (!$this->_isgameInitializated) {
            $this->_isgameInitializated = true;
            $this->_fillBoard($row, $column);
        }
    }

    /**
     * Return Raw Array Grid.
     *
     * @return array
     */
    public function returnBoardData(): array
    {
        return $this->_grid;
    }

    /**
     * Fill the board with the game Cell, even the bombs
     * ramdomly, the first movement is bomb-free.
     *
     * @param [type] $row
     * @param [type] $column
     */
    private function _fillBoard($row, $column)
    {
        //we set the mine counter
        $mineCounter = 0;
        //we walk trought the array, and start setting the
        //values for every cell
        for ($r = 0; $r < $this->_rows; ++$r) {
            for ($col = 0; $col < $this->_columns; ++$col) {
                if ($mineCounter < $this->_mines) {
                    //we get a randomize type of cell
                    $newCell = $this->randomizeCellType();
                    if ('mineCell' == $newCell->type) {
                        //if the cell type is mine, count it
                        ++$mineCounter;
                    }
                } else {
                    //in case of having all cell in the board, we
                    //set only safe cells
                    $newCell = new SafeCell();
                }
                //first mouvement, we set it as a safe cell
                if ($r == $row && $col == $column) {
                    $newCell = new SafeCell();
                }
                //and set the value of this cell
                $this->_grid[$r][$col] = $newCell;
            }
        }
    }

    /**
     * return a Cell made by a even number, if it is
     * we return a mine cell, if not we return a safe cell.
     */
    private function randomizeCellType(): Cell
    {
        //even number of 2 to randomize
        return 0 == rand(1, 10) % 2 ? new MineCell() : new SafeCell();
    }
}
