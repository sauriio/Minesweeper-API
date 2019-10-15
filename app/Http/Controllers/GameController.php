<?php

namespace App\Http\Controllers;

use App\Classes\Minesweeper\Minesweeper;
use Illuminate\Http\Request;

class GameController extends Controller
{
    /**
     * Create a new controller instance.
     */
    private $game;

    public function __construct(Minesweeper $mineGame)
    {
        $this->game = $mineGame;
    }

    public function newGame(Request $request)
    {
        //ruleset of validations for request params
        $validateRules = [
            'rows' => 'required|integer|min:1',
            'columns' => 'required|integer|min:1',
            'mines' => 'required|integer|min:1',
        ];
        //lets validate the params
        $this->validate($request, $validateRules);

        return $this->game->newGame($request->rows, $request->columns, $request->mines, null);
    }

    /**
     * Method to pause/Resume Game.
     *
     * @param Request $request
     * @param int     $gameId
     */
    public function pauseResumeGame(Request $request, int $gameId)
    {
        return $this->game->pauseResumeGame($gameId);
    }

    /**
     * get the status of this game, if is over, or paused
     * or the number of seconds played.
     *
     * @param Request $request
     * @param int     $gameId
     */
    public function getGameStatus(Request $request, int $gameId)
    {
        return $this->game->getGame($gameId);
    }

    /**
     * return list of games ids and status of the user.
     *
     * @param Request $request
     */
    public function getUserGames(Request $request)
    {
    }

    /**
     * Method to make a move on a game.
     *
     * @param Request $request
     * @param int     $gameId
     */
    public function makeMove(Request $request, int $gameId)
    {
        //ruleset of params
        $validateRules = [
            'row' => 'required|integer|min:0',
            'column' => 'required|integer|min:0',
            'flagged' => 'required|boolean',
        ];
        //lets validate the params
        $this->validate($request, $validateRules);

        return $this->game->setMoveSet($request->row, $request->column, $gameId, $request->flagged);
    }
}
