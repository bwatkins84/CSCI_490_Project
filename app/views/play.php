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
    <script src="../script/leap.min.js"></script>
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
        /*
            receives frames from the controller
        */
        var controller = new Leap.Controller({enableGestures: true});
        controller.loop(function(frame) {
            latestFrame = frame;
            //document.getElementById('out').innerHTML = (pausedFrame ? "<p><b>PAUSED</b></p>" : "") + "<div>"+(pausedFrame || latestFrame).dump()+"</div>";
        });

        /*
            returns the count of the fingers being held up
        */
        function getUserSybmbolCount() {
            var fingerCount = latestFrame.pointables.length;

            switch (fingerCount) {
                case 0:
                    return 1; // rock
                case 1:
                case 2:
                case 3:
                    return 3; // scissors
                case 4:
                case 5:
                    return 2; // paper
                default:
                    return 1; // rock
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


        window.onkeypress = function(e) {
            //alert(e.charCode);
            /*
            if (e.charCode == 32) {
                if (pausedFrame == null) {
                    pausedFrame = latestFrame;
                } else {
                    pausedFrame = null;
                }
            }
            */

            // when 's' key is pressed
            if (e.charCode == 115) {
                // player Pane
                document.getElementById('playerOptionPane').innerHTML = getSymbol(getUserSybmbolCount());

                // computer Pane
                var ranNum = Math.floor((Math.random()*3)+1);
                document.getElementById('compOptionPane').innerHTML = getSymbol(ranNum)

                var status = gameStatus(getUserSybmbolCount(), ranNum);

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
        };




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

        <button onclick="endGame()">sumbit score</button>
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
