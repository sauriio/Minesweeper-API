<?php

namespace App\Classes\Minesweeper;

use App\Exceptions\GameNotFoundException;
use App\Exceptions\GameStatusException;
use App\Game;
use App\User;
use Exception;

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
     * @param int $rows
     * @param int $columns
     * @param int $mines
     * @param int $user
     *
     * @return array
     */
    public function newGame(int $rows, int $columns, int $mines, User $user = null): array
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
        //create the board
        $gameBoard = new Board($rows, $columns, $mines);
        //create the game object to persiste the game
        $savedGame = new Game();
        //set some attr
        $savedGame->paused = false;
        $savedGame->rows = $rows;
        $savedGame->columns = $columns;
        $savedGame->mines = $mines;
        $savedGame->payload = json_encode($gameBoard->returnBoardData());
        $savedGame->initializated = false;
        $savedGame->seconds_played = 0;
        $savedGame->is_over = false;
        $savedGame->save();

        return [
            'status' => 'success',
            'status_code' => 200,
            'message' => 'the game has been created successfully.',
            'data' => $savedGame,
        ];
    }

    /**
     * set a new MoveSet on Game.
     *
     * @param int  $row
     * @param int  $column
     * @param int  $gameId
     * @param bool $flagged
     *
     * @return array
     */
    public function setMoveSet(int $row, int $column, int $gameId, bool $flagged = false): array
    {
        try {
            $savedGame = $this->searchGame($gameId);
            $gameBoard = new Board();
            $gameBoard->setPauseResumeState($savedGame->paused);
            $gameBoard->setGameInitStatus($savedGame->initializated);
            $gameBoard->setSavedGrid(json_decode($savedGame->payload));
            $resultSet = $gameBoard->setMoveSet($row, $column, $flagged);
            $savedGame->payload = ($gameBoard->returnBoardData());
            //first move, set the initializated flag for all other moves from here
            if (!$savedGame->initializated) {
                $savedGame->initializated = true;
            }
            //save the status
            $savedGame->save();

            return $gameBoard->returnBoardData();

            return [
                'status' => 'success',
                'status_code' => 200,
                'message' => 'movement has been made on board.',
                'data' => [],
            ];
        } catch (Exception $e) {
            return [
                'status' => 'fail',
                'status_code' => $e->getCode(),
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ];
        }
    }

    /**
     * return the game information.
     *
     * @param int $gameId
     *
     * @return array
     */
    public function getGame(int $gameId): array
    {
        try {
            //return game info
            $savedGame = $this->searchGame($gameId, true);

            return [
                'status' => 'success',
                'status_code' => 200,
                'message' => 'Game Information.',
                'data' => $savedGame,
            ];
        } catch (Exception $e) {
            return [
                'status' => 'fail',
                'status_code' => $e->getCode(),
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * method to pause/Resume a game.
     *
     * @param int $gameId
     *
     * @return array
     */
    public function pauseResumeGame(int $gameId): array
    {
        //search for the game
        try {
            $savedGame = $this->searchGame($gameId);
            //change the paused value
            $savedGame->paused = !$savedGame->paused;
            //save the status on db
            $savedGame->save();
            //return the status of the game, and their data
            return [
                'status' => 'success',
                'status_code' => 200,
                'message' => 'the game status property has been changed.',
                'data' => $savedGame,
            ];
        } catch (Exception $e) {
            return [
                'status' => 'fail',
                'status_code' => $e->getCode(),
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * search for the game info on the DB.
     *
     * @param int  $gameId
     * @param bool $verbose
     *
     * @throws Exception
     *
     * @return Game
     */
    private function searchGame(int $gameId, bool $verbose = false): Game
    {
        $gameInfo = Game::find($gameId);
        if (!empty($gameInfo)) {
            if ($gameInfo->is_over && !$verbose) {
                throw new GameStatusException('Cannot Make more mouvements, game is over.', 412);
            }
            if ($gameInfo->paused && !$verbose) {
                throw new GameStatusException('Cannot Make mouvements, game is paused.', 412);
            }

            return $gameInfo;
        }

        throw new GameNotFoundException("Game doesn't belong to user of has not been found.", 404);
    }

    /**
     * function to know if the value is valid.
     *
     * @param int $val
     *
     * @return bool
     */
    private function _isValidValue(int $val)
    {
        return $val > 0;
    }
}
