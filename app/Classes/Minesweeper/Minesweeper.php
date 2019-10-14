<?php

namespace App\Classes\Minesweeper;

/**
 * Main Class for the game, it contains all the logic to
 * generate new games and to resume/pause old games for the user.
 */
class Minesweeper
{
    public function __construct()
    {
    }

    /**
     * generate a new grid and a new game, it returns the game id
     * that is related with the user.
     *
     * @param int    $rows
     * @param int    $columns
     * @param int    $mines
     * @param [type] $user
     */
    public function newGame(int $rows, int $columns, int $mines, $user)
    {
        //check value of params
        if (!$this->_isValidValue($rows)) {
            $rows = 8;
        }
        if (!$this->_isValidValue($columns)) {
            $columns = 8;
        }
        if (!$this->_isValidValue($mines)) {
            $columns = 10;
        }
        $newGame = new Grid($rows, $columns, $mines);

        return $newGame->returnGridData();
    }

    /**
     * return the gamegrid of the game that is saved with the gameId
     * param.
     *
     * @param int $gameId
     */
    public function getGame(int $gameId)
    {
    }

    private function _isValidValue(int $val)
    {
        return $val > 0;
    }
}
