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
}
