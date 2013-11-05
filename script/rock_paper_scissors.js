var Time = 3;
var Timer;
var controller = new Leap.Controller({enableGestures:true});

function StartGame(){
    document.getElementById('out').innerHTML = "<div>" + "Get ready to play" + "</div>";
    Timer = setInterval("CountDownDisplay()", 1000);
}

function CountDownDisplay(){
    document.getElementById('out2').innerHTML = "<div>" + Time + "</div>";
    if(Time <= 0){
        clearInterval(Timer);
        GetFingerCount();
    }
    Time = Time - 1;
}

function GetFingerCount(){
    Time = 3;
    var fingerCount;
    var symbol = null;

    document.getElementById('out2').innerHTML = "<div>" + "Shot!" + "</div>";

    var CurrentFrame = Leap.Frame();
    alert(CurrentFrame.dump());
    /*
    fingerCount = CurrentFrame.pointables.length;

    var pausedFrame = null;
    var latestFrame = null;

        // pause the Frame
        window.onkeypress = function(e) {
            if (e.charCode == 32) {
                if (pausedFrame == null) {
                    pausedFrame = latestFrame;
                } else {
                    pausedFrame = null;
                }
            }
        };

        Leap.loop(function(frame) {
        latestFrame = frame;
        fingerCount = (pausedFrame || latestFrame).pointables.length;
        //var CurrentHand = new Hand(pausedFrame || latestFrame);

        if(fingerCount == 4){
            symbol = "Paper";
            return;
        }
        else if(fingerCount == 2){
            symbol = "Scissors";
            return;
        }
        else{
            symbol =  "Rock";
            return;
        }

    });

    /*if(fingerCount == 4){
         symbol = "Paper";
     }
     else if(fingerCount == 2){
         symbol = "Scissors";
     }
     else{
         symbol = "Rock";
     }

    document.getElementById('out').innerHTML = "<div>" + fingerCount + "</div>";
//    StartGame();*/
}

controller.loop(function(frame) {
   latestFrame = frame;
});
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