<?php

namespace App\Http\Controllers;

use App\Classes\Minesweeper\Minesweeper;
use Illuminate\Http\Request;

class GameController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
    }

    public function NewGame(Request $request)
    {
        //ruleset of validations for request params
        $validateRules = [
            'rows' => 'required|integer|min:1',
            'columns' => 'required|integer|min:1',
            'mines' => 'required|integer|min:1',
        ];
        //lets validate the params
        $this->validate($request, $validateRules);
        $newGame = new Minesweeper();

        return $newGame->newGame($request->rows, $request->columns, $request->mines, null);
    }

    /**
     * Method to pause/Resume Game.
     *
     * @param Request $request
     * @param int     $gameId
     */
    public function PauseResumeGame(Request $request, int $gameId)
    {
    }

    /**
     * Method to make a move on a game.
     *
     * @param Request $request
     * @param int     $gameId
     */
    public function MakeMove(Request $request, int $gameId)
    {
        //ruleset of params
        $validateRules = [
            'row' => 'required|integer|min:0',
            'column' => 'required|integer|min:0',
        ];
        //lets validate the params
        $this->validate($request, $validateRules);
    }
}
