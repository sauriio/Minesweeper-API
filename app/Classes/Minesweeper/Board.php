<?php

namespace App\Classes\Minesweeper;

use App\Classes\Exceptions\InvalidPositionException;
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
     * @param int        $rows
     * @param int        $columns
     * @param int        $mines
     * @param null|mixed $savedGrid
     */
    public function __construct(int $rows = 0, int $columns = 0, int $mines = 0)
    {
        //new game
        if (!empty($rows) && !empty($columns) && !empty($mines)) {
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
    }

    /**
     * set the game status, if is paused of not.
     *
     * @param bool $status
     */
    public function setPauseResumeState(bool $status)
    {
        $this->_gamePaused = $status;
    }

    /**
     * set grid saved on game payload.
     *
     * @param array $savedGrid
     */
    public function setSavedGrid(array $savedGrid)
    {
        $this->_grid = $savedGrid;
    }

    /**
     * set Game Initializated status.
     *
     * @param bool $gameInit
     */
    public function setGameInitStatus(bool $gameInit)
    {
        $this->_isgameInitializated = $gameInit;
    }

    /**
     * make a move on the board, return results of move.
     *
     * @param int   $row
     * @param int   $column
     * @param mixed $flagged
     */
    public function setMoveSet(int $row, int $column, $flagged = false)
    {
        //check if game is paused, if it is
        if (!$this->_gamePaused) {
            //then we check if the params are a valid position on board
            if ($this->isValidPosition($row, $column)) {
                //if game has not been initializated
                if (!$this->_isgameInitializated) {
                    //the first move is bomb-free, so we set this
                    //cell as a clean one
                    $this->_fillBoard($row, $column);
                }
                //and return result of mouvement, all the
                //cell that are clean
                return $this->returnMoveResult($row, $column, $flagged);
            }
            //if not, we throw a new invalid position exception
            throw new InvalidPositionException('Invalid Position.', 412);
        }
        //throw exception
        throw new PausedGameException('Game is Paused, cannot make mouvement.', 412);
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
     * return the result of the moveset, could be a game over if the player
     * has won, or if he found a mine, or in case of clean cells, the results of those
     * actions.
     *
     * @param int $row
     * @param int $column
     */
    private function returnMoveResult(int $row, int $column)
    {
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
        $this->_rows = count($this->_grid);
        $this->_columns = count($this->_grid[0]);
        for ($r = 0; $r < $this->_rows; ++$r) {
            for ($col = 0; $col < $this->_columns; ++$col) {
                if ($mineCounter < $this->_mines) {
                    //we get a randomize type of cell
                    //ToDo, make sure that we are setting the
                    //bombs with the param number
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

    /**
     * function to see if the position is valid.
     *
     * @param int $row
     * @param int $column
     *
     * @return bool
     */
    private function isValidPosition(int $row, int $column)
    {
        return array_key_exists($column, $this->_grid) && array_key_exists($column, $this->_grid);
    }
}
