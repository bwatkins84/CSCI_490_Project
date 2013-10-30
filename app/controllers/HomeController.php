<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function showWelcome() {
		return View::make('mainMenu');
	}

    public function scoreBoard() {
        // get the top score list
        $topScores = DB::table('board')
            ->orderBy('score', 'desc')
            ->get();
        
        // pass the top score list into the scoreBoard view
        return View::make('scoreBoard')
            ->with(array(
                'topScores' => $topScores
            ));
    }

    public function play() {
        return "playing";
    }
}