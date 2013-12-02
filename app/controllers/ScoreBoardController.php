<?php
/**
 * Created by PhpStorm.
 * User: arono_000
 * Date: 10/30/13
 * Time: 4:06 PM
 */

class ScoreBoardController extends BaseController {

    public function getScores() {
        // get the top score list
        $topScores = DB::table('board')
            ->orderBy('score', 'desc')
            ->take(10)
            ->get();

        // pass the top score list into the scoreBoard view
        return View::make('scoreBoard')
            ->with(array(
                'topScores' => $topScores
            ));
    }

    /*
     * for AJAX call
     * parameters: name (varchar), score (int)
     */

    // template for ajax call
    /*
             $.ajax({
                type: "GET",
                url: "scoreboard/addscore",
                data: {
                    name: "ilya",
                    score: 6
                }
            }).fail(function(){
                alert('error');
            }).success(function(d){
                alert(d.name);
            });
     */
    public function storeScore() {
        // get inputs passed in
        $name = Input::get('name');
        $score = Input::get('score');

        // create new row
        $newScore = Board::create(array(
                'name' => $name,
                'score' => $score,
                'ip_address' => $_SERVER['REMOTE_ADDR']
            ));

        return Response::json($newScore);
    }

    public function checkTopScore() {
        // get input
        $score = Input::get('score');

        $count = Board::where('score', '>', $score)->count();
        $count++;
        return Response::json(array(
            'score' => $score,
            'position' => $count,
            'topScore' => ($count < 10) ? true : false
        ));
    }

}
