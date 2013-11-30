<html>
    <head>
        <title>Rock-Scissors-Paper</title>
        <script type="text/javascript" src="script/leap.js"></script>
        <script type="text/javascript" src="rock_paper_scissors.js"></script>
    </head>
    <body>
        <h2>What is Held Up:</h2>
        <div id="out"></div>
        <form action="the_game.php" method="post">
            <input type="submit" name="play" value="Play Game">
        </form>
        <div id='log'></div>
    </body>
        <?php
            $Num = 4;
            //These are the two example functions to run the javascript functions
            echo "<script type='text/javascript'> Printer($Num) </script>";
            //echo "<script type='text/javascript'> isPositive($Num) </script>";
            //$Value = $_GET['Value'];
            //echo $Value;
        ?>
</html>