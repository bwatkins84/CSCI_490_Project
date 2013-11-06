var controller = new Leap.Controller({enableGestures:true});
var CurrentFrame;


controller.loop(function(frame){
   CurrentFrame = frame;
});

/**
 * @return {number}
 */
function GetFingerCount(){
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
function HandPresent(){
    if(CurrentFrame.hands.length != 0){
        return true;
    }
    return false;
}

/**
 * @return {boolean}
 */
function PlayAgain(){
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