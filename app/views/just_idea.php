<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../../assets/ico/favicon.png">

    <title>Main Menu</title>

    <script src="../script/jquery-1.10.2.js"></script>
    <script src="../../script/leap.min.js"></script>
    <!-- Bootstrap core CSS -->
    <link href="../bootstrap/dist/css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../bootstrap/examples/signin/signin.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="../bootstrap/assets/js/html5shiv.js"></script>
    <script src="../bootstrap/assets/js/respond.min.js"></script>
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
        });

        /*
            Countdown to begin Game
        */
        function GetReadyToPlay(){
            document.getElementById('Instructions').innerHTML = "Get Ready to Play";
            Timer = setInterval("CountDown()", 1000);
        }

        function CountDown(){
            if(Time < 1){
                clearInterval(Timer);
                document.getElementById('CountDown').innerHTML = "Shot!";
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
            The Game
        */
        function PlayGame(){
            if(!HandPresent()){
                document.getElementById('Instructions').innerHTML = "Make Sure Your Hand is Over the Leap Motion";
                document.getElementById('CountDown').innerHTML = "Click Play Game to Start Another Game";
                return;
            }

            var PlayerThrows = getUserSymbolCount();
            var CPUThrows = Math.floor((Math.random()*3)+1);
            document.getElementById('playerOptionPane').innerHTML = getSymbol(PlayerThrows);

            // computer Pane
            document.getElementById('compOptionPane').innerHTML = getSymbol(CPUThrows);

            var status = gameStatus(PlayerThrows, CPUThrows);

            if (status >= 0) {
                // if not a loss
                (status == 0) ? tieCount++ : winCount++;
            }
            else {
                // if loss
                alert("WINS: " + winCount + " TIES: " + tieCount);
                winCount = 0;
                tieCount = 0;
            }
        }



        //test button JS
        $(document).ready(function() {
           $('#inputForm').hide();
        });

        function endGame() {
            $('#game').hide();
            $('#inputForm').show();
            // make form dialog

            // submit name && score to ajax
        }

        function buttonSubmit() {



            alert('submit pressed');
        }

    </script>
</head>

<body>

<div class="container">

    <div id="game">
        <h1 class="text-center">Play</h1>

        <div>
            <h3>Player</h3>
            <span id="playerOptionPane"></span>
        </div>

        <div>
            <h3>Computer</h3>
            <span id="compOptionPane"></span>
        </div>
        <div id="Instructions"></div>
        <div id="CountDown"></div>
        <button onclick="GetReadyToPlay()">Play Game</button><button onclick="endGame()">sumbit score</button>
    </div>

    <div id="inputForm">
        <h1 class="text-center">Submit your score</h1>

        <input type="text" placeholder="Name" name="name" />
        <input type="button" onclick="buttonSubmit()" value="Submit"/>
    </div>


</div> <!-- /container -->


<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
</body>
</html>
