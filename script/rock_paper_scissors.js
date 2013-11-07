// variables
var controller = new Leap.Controller({enableGestures:true});
var CurrentFrame;

controller.loop(function(frame){
   CurrentFrame = frame;
});

/**
 * @return {number}
 */
function getFingerCount(){
    var fingerCount = 0;

    document.getElementById('out2').innerHTML = "<div>" + "Shot!" + "</div>";
    //while(!HandPresent()){
      //  document.getElementById('out').innerHTML = "<div>" + "Place Hand Over Leap Motion" + "</div>";
    //}

    CurrentFingers = CurrentFrame.pointables.length;

    if(CurrentFingers == 2){
        fingerCount = 2;
        Symbol = "Scissors";
                //return;
    }
    else if(CurrentFingers == 4){
        fingerCount = 4;
        Symbol = "Paper";
                //return;
    }
    else{
        fingerCount = 0;
        Symbol = "Rock";
    }
    document.getElementById('out').innerHTML = "<div>" + "FingerCount: " + fingerCount + " Thrown: "+ Symbol +"</div>";
    return fingerCount;
}

/**
 * @return {boolean}
 */
function handPresent(){
    if(CurrentFrame.hands.length != 0){
        return true;
    }
    return false;
}

/**
 * @return {boolean}
 */
function playAgain(){
    var Continue = false;
    document.getElementById('out2').innerHTML = "<div>" + "Swipe to play again." + "</div>";
    document.getElementById('out3').innerHTML = "<div>" + "" + "</div>";
    if(CurrentFrame.gestures.length > 0){
        var CurrentGesture = CurrentFrame.gestures[0].type;
        switch(CurrentGesture){
            case 'swipe':
                document.getElementById('out3').innerHTML = "<div>" + "Swipe Detected." + "</div>";
                Continue = true;
                break;
            default:
                //Continue = false;
        }
        return Continue;
    }
    return Continue;
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

// function to play the game
function playGame() {
    // game variables
    var winCount = 0;
    var fingerCount;
    var win = true;

    // game - when win
    while (win) {
        while(true) {
            // if hand is present
                // clear INNER HTML

                // fingerCount = getFingerCount();
                // generate random number
                // compare number to fingers
                // determine win/loss

                // if win
                    // winCount++
                    // win = true
                // else loss
                    // win = false
                    // break while(true)

            // if hand NOT present
                // prompt message -- inner HTML
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