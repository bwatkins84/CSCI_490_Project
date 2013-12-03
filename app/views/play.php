<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<link rel="shortcut icon" href="../../assets/ico/favicon.png">

<title>Main Menu</title>

<script src="../app/script/jquery-1.10.2.js"></script>
<script src="../app/script/leap.min.js"></script>
<!-- Bootstrap core CSS -->
<link href="../bootstrap/dist/css/bootstrap.css" rel="stylesheet">

<!-- Custom styles for this template -->
<link href="../bootstrap/examples/signin/signin.css" rel="stylesheet">

<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
<script src="../../bootstrap/assets/js/html5shiv.js"></script>
<script src="../../bootstrap/assets/js/respond.min.js"></script>
<![endif]-->

<script type="text/javascript">

    var pausedFrame = null;
    var latestFrame = null;
    var winCount = 0;
    var tieCount = 0;
    var Time = 3;
    var Timer;


    /*
     receives frames from the controller
     */
    var controller = new Leap.Controller({enableGestures: true});
    controller.loop(function(frame) {
        latestFrame = frame;
        //document.getElementById('out').innerHTML = (pausedFrame ? "<p><b>PAUSED</b></p>" : "") + "<div>"+(pausedFrame || latestFrame).dump()+"</div>";
    })

    // when the device is disconnected
    controller.on('deviceConnected', function() {
        $('#playButton').removeAttr("disabled");
        document.getElementById('CountDown').innerHTML = "";
    })

    // when the device is connected
    controller.on('deviceDisconnected', function() {
        $('#playButton').attr("disabled", "disabled");
        document.getElementById('CountDown').innerHTML = "Connect Device!";
    })

    /*
     Countdown to begin Game
     */
    function GetReadyToPlay(){
        $('#playButton').attr("disabled", "disabled");
        document.getElementById('Instructions').innerHTML = "Get Ready...";
        Timer = setInterval("CountDown()", 1000);
    }

    function CountDown(){
        if(Time < 1){
            clearInterval(Timer);
            document.getElementById('CountDown').innerHTML = "Shoot!";
            document.getElementById('Instructions').innerHTML = "Click \"Play\" to start";
            Time = 3;
            PlayGame();
        }else{
            document.getElementById('CountDown').innerHTML = Time;
            Time--;
        }
    }

    /*
     Checks to see if hand is over leap motion
     */
    function HandPresent(){
        if(latestFrame.hands.length != 0){
            return true;
        }
        return false;
    }

    /*
     returns the count of the fingers being held up
     */
    function getUserSymbolCount() {
        var TheHandPos = latestFrame.hands[0].roll();
        var fingerCount = latestFrame.pointables.length;

        if((TheHandPos < 0.40 && TheHandPos > -0.40)){
            if(fingerCount == 2){
                return 3; // Scissors
            }
            else{
                return 2; // Paper
            }
        }else{
            return 1; // Rock
        }
    }


    /*
     returns corresponding symbol
     */
    function getSymbol(num) {
        switch (num) {
            case 1:
                return "Rock";
            case 2:
                return "Paper";
            case 3:
                return "Scissors";
            default:
                return "Error"
        };
    }

    /*
     checks game status
     */
    function gameStatus(player, cpu) {
        // if win
        if ((player == 1 && cpu == 3) || (player == 2 && cpu == 1) || (player == 3 && cpu == 2)) {
            return 1;
        }
        // if tie
        else if (player == cpu) {
            return 0;
        }
        // if loss
        else {
            return -1;
        }
    }

    /*
        change hand icon
    */
    function changePlayerIcon(num) {
        switch(num) {
            case 1:
                document.getElementById('playerIcon').src='../app/images/rock.jpg';
                break;
            case 2:
                document.getElementById('playerIcon').src='../app/images/paper.jpg';
                break;
            case 3:
                document.getElementById('playerIcon').src='../app/images/scissors2.jpg';
                break;
        };
    }

    function changeCpuIcon(num) {
        switch(num) {
            case 1:
                document.getElementById('cpuIcon').src='../app/images/rock.jpg';
                break;
            case 2:
                document.getElementById('cpuIcon').src='../app/images/paper.jpg';
                break;
            case 3:
                document.getElementById('cpuIcon').src='../app/images/scissors2.jpg';
                break;
        };
    }
    /*
     The Game
     */
    function PlayGame(){
        if(!HandPresent()){
            alert("Make Sure Your Hand is Over the Leap Motion.");
            $('#playButton').removeAttr("disabled");
            return;
        }

        var PlayerThrows = getUserSymbolCount();
        var CPUThrows = Math.floor((Math.random()*3)+1);
        changePlayerIcon(PlayerThrows);
        document.getElementById('playerOptionPane').innerHTML = getSymbol(PlayerThrows);

        // computer Pane
        changeCpuIcon(CPUThrows);
        document.getElementById('compOptionPane').innerHTML = getSymbol(CPUThrows);

        var status = gameStatus(PlayerThrows, CPUThrows);

        if (status >= 0) {
            // if win
            (status == 0) ? tieCount++ : winCount++
            document.getElementById('tieCount').innerHTML = tieCount;
            document.getElementById('winCount').innerHTML = winCount;
            $('#playButton').removeAttr("disabled");
        }
        else {
            // if loss
            alert('You Lost!');
            endGame();
        }
    }

    /*
     exit the game
     */
    function endGame() {
        // checks if player score is top score
        $.ajax({
            type: "GET",
            url: "scoreboard/checkscore",
            data: {
                score: winCount
            }
        }).fail(function(){
                alert('Server Error');
            }).success(function(d){
                if(d.topScore){
                    // if player made topScore
                    $('#game').hide();
                    $('#inputForm').show();
                }
                else {
                    // if player did NOT make topScore
                    alert('did not make top Score. /n Score: ' + winCount);
                }
            });
    }


    //test button JS
    $(document).ready(function() {
        $('#inputForm').hide();
    });

    function buttonSubmit() {
        $('#submitButton').attr("disabled", "disabled");
        var name = document.getElementById("playerName").value;

        $.ajax({
            type: "GET",
            url: "scoreboard/addscore",
            data: {
                name: name,
                score: winCount
            }
        }).fail(function(){
            alert('Server Error');
        }).success(function(d){
            // redirect to scoreboard
            window.location.assign("scoreboard");
        });

    }

</script>
</head>

<body>

<div class="container">

    <div class="row" id="game">
        <h1 class="text-center">Play</h1>

        <div class="col-xs-6 col-md-4 text-center">
            <h3>Player</h3>

            <img id="playerIcon" class="img-thumbnail" src="../app/images/question_mark.jpg" alt="Player Hand" style="min-height: 225px; min-width: 225px;">

            <h2><span class="label label-default" id="playerOptionPane"></span></h2>
        </div>

        <div class="col-xs-6 col-md-4 text-center">
            <h3>Stats:</h3>
            <ul class="nav nav-pills nav-stacked">
                <li class="active">
                    <a href="#">
                        <span id="winCount" class="badge pull-right">0</span>
                        Wins:
                    </a>
                </li>
                <li class="active">
                    <a href="#">
                        <span id="tieCount" class="badge pull-right">0</span>
                        Ties:
                    </a>
                </li>
            </ul>
            <div id="Instructions" class="alert alert-info">Click "Play" to start</div>
            <h1><div id="CountDown"></div></h1>
        </div>

        <div class="col-xs-6 col-md-4 text-center">
            <h3>Computer</h3>

            <img id="cpuIcon" class="img-thumbnail" src="../app/images/question_mark.jpg" alt="CPU Hand" style="min-height: 225px; min-width: 225px;">

            <h2><span class="label label-default" id="compOptionPane"></span></h2>

        </div>


        <div class="text-center" style="clear: both">
            <button id="playButton" onclick="GetReadyToPlay()" class="btn btn-primary">Play Game</button><button id="quitButton" onclick="endGame()" class="btn btn-info">Quit Game</button>
        </div>
    </div>


    <div id="inputForm">
        <h1 class="text-center">Submit your score</h1>

        <input type="text" placeholder="Name" id="playerName" />
        <input type="button" onclick="buttonSubmit()" id="submitButton" value="Submit"/>
    </div>


</div> <!-- /container -->


<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
</body>
</html>
