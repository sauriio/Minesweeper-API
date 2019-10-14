<?php

namespace App\Http\Controllers;

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
        ];
        //lets validate the params
        $request->validate($validateRules);
    }
}
