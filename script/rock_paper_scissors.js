// variables
var Thrown = {"Rock":0, "Scissors":1, "Paper":2};
var controller = new Leap.Controller({enableGestures:true});
var CurrentFrame;
var CurrentGesture;

controller.loop(function(frame){
   CurrentFrame = frame;
});


function KeepBusyOneSecond(){
    var TodaysDate = new Date();
    var Seconds = TodaysDate.getTime();
    var TheOffset = Seconds + 1000;
    var KeepGoing = true;

    while(KeepGoing){
            Seconds = GetCurrentTime();
            if(Seconds <= TheOffset){
                KeepGoing = true;
            }
            else{
                KeepGoing = false;
            }
    }
}


function KeepBusyThreeSeconds(){
    var TodaysDate = new Date();
    var Seconds = TodaysDate.getTime();
    var TheOffset = Seconds + 3000;
    var KeepGoing = true;

    while(KeepGoing){
            document.getElementById('out').innerHTML = "<div>" + "3..2..1.." + "</div>";
            Seconds = GetCurrentTime();
            if(Seconds <= TheOffset){
                KeepGoing = true;
            }
            else{
                KeepGoing = false;
            }
    }
}

/**
 * @return {number}
 */
function GetCurrentTime(){
    var TodaysDate = new Date();
    return TodaysDate.getTime();
}

/**
 * @return {number}
 */
function PlayersThrows(){
    document.getElementById('out2').innerHTML = "<div>" + "Shot!" + "</div>";

    var fingerCount = CurrentFrame.pointables.length;

    if(fingerCount == 2){
        return Thrown.Scissors;
    }
    else if(fingerCount == 4){
        return Thrown.Paper;
    }
    else{
        return Thrown.Rock;
    }
}

/**
 * @return {boolean}
 */
function HandPresent(){
    if(CurrentFrame.hands.length != 0){
        return true;
    }
    return false;
}

/**
 * @return {boolean}
 */
function WantToPlayAgain(){
    var Continue = false;
    var KeepChecking = true;
    document.getElementById('out3').innerHTML = "<div>" + "" + "</div>";
    document.getElementById('out2').innerHTML = "<div>" + "Swipe to play again or ScreenTap to Quit" + "</div>";

    while(KeepChecking){
        if(getGesture() == false){
            break;
        }
    }

    if(CurrentGesture == 'swipe'){
        Continue = true;
        document.getElementById('out3').innerHTML = "<div>" + "Swipe Detected" + "</div>";
    }
    else{
        Continue = false;
        document.getElementById('out3').innerHTML = "<div>" + "Screen Tap Detected" + "</div>";
    }

    return Continue;
}

/**
 *
 * @returns {boolean}
 */
function getGesture(){
    //Checking to make sure a hand is in the frame
    if(handPresent()){
        if(CurrentFrame.gestures.length > 0){
            CurrentGesture = CurrentFrame.gestures[0].type;
            if(CurrentGesture == 'swipe'){
                //Acceptable Gesture, returning false to continue
                return false;
            }
            else if(CurrentGesture == 'screenTap'){
                //Acceptable Gesture, returning false to continue
                return false;
            }
            else{
                //If the gesture is not a swipe or screenTap, returning true to continue
                return true;
            }
        }
        else{
            //If there is not gesture, returning true to continue
            return true;
        }
    }
    else{
        //Default no hand is present in the frame, returning true to continue
        return true;
    }
}

/*
    controller configurations?
 */
controller.on('ready', function() {
         console.log("ready");
});
controller.on('connect', function() {
         console.log("connect");
});
controller.on('disconnect', function() {
    console.log("disconnect");
});
controller.on('focus', function() {
    console.log("focus");
});
controller.on('blur', function() {
    console.log("blur");
});
controller.on('deviceConnected', function() {
    console.log("deviceConnected");
});
controller.on('deviceDisconnected', function() {
    console.log("deviceDisconnected");
});

/**
 * @return {number}
 */
function GetComputerSelection(){
    var ComputersSelection = Math.floor((Math.random() * 3 + 1));
    if(ComputersSelection == 0){
        return Thrown.Rock;
    }
    else if(ComputersSelection == 1){
        return Thrown.Scissors;
    }

    return Thrown.Paper;
}

/**
 * @return {boolean}
 */
function DidPlayerWin(PlayerThrew, OtherThrew){
    if(OtherThrew == Thrown.Rock){
        if(PlayerThrew == Thrown.Rock){
            return false;  // Rock -- Rock (Tie Game, Player did not Win)
        }
        else if(PlayerThrew == Thrown.Scissors){
            return false;  // Scissors -- Rock (Rock Beats Scissors, Player Loses)
        }
        else{
            return true;   // Paper -- Rock (Paper Beats Rock, Player Wins)
        }
    }
    else if(OtherThrew == Thrown.Scissors){
        if(PlayerThrew == Thrown.Rock){
            return true;   // Rock -- Scissors (Rock Beats Scissors, Player Wins)
        }
        else if(PlayerThrew == Thrown.Scissors){
            return false;  // Scissors -- Scissors (Tie Game, Player did not Win)
        }
        else{
            return false;  // Paper -- Scissors (Scissors Beats Paper, Player Loses)
        }
    }
    else{
        //Default Other Player threw Paper
        if(PlayerThrew == Thrown.Rock){
            return false;   // Rock -- Paper (Paper Beats Rock, Player Loses)
        }
        else if(PlayerThrew == Thrown.Scissors){
            return true;    // Scissors -- Paper (Scissors Beats Paper, Player Wins)
        }
        else{
            return false;   // Paper -- Paper (Tie Game, Player did not Win)
        }
    }
}


// function to play the game
function playGame() {
    // game variables
    var winCount = 0;
    var PlayersSelection;
    var ComputerSelection;
    var GameGoing = true;
    var win = true;

    // game - when win
    while (win) {
        while(GameGoing) {
            KeepBusyThreeSeconds();
            if(HandPresent()){
                // Hand Present, Clearing Inner HTML
                document.getElementById('out3').innerHTML = "<div>" + "" + "</div>";
                PlayersSelection = PlayersThrows();
                ComputerSelection = GetComputerSelection();
                win = DidPlayerWin(PlayersSelection, ComputerSelection);
                if(win){
                    // Player has Won
                    winCount++;
                    win = true;
                    GameGoing = false;
                }
                else{
                    // Player has Lost
                    GameGoing = false;
                    win = false;
                }
            }
            else{
                // Hand Not Detected
                document.getElementById('out3').innerHTML = "<div>" + "Keep Hand Over Leap Motion to Throw Rock, Paper, or Scissors" + "</div>";
                GameGoing = true;
            }
        }
    }

    // game - when loss ...

    // prompt for user name
    // call web service to store game info $.AJAX

    /*
        example of possible AJAX call to webservice

    $.ajax({
        method: "post",
        url: "something/something.php",
        data: {
            name: "string name",
            winCount: winCount
        }
    }).fail(function(){

    }).success(function(data){

    });
    */
}