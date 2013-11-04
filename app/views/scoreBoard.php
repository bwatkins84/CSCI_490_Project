
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../../assets/ico/favicon.png">

    <title>Score Board</title>

    <script src="../app/script/jquery-1.10.2.js"></script>
    <!-- Bootstrap core CSS -->
    <link href="../bootstrap/dist/css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../bootstrap/examples/signin/signin.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="../bootstrap/assets/js/html5shiv.js"></script>
    <script src="../bootstrap/assets/js/respond.min.js"></script>
    <script src="../app/script/jquery-1.10.2.js"></script>
    <![endif]-->
</head>

<body>

<div class="container">

    <h1 class="text-center">Score Board</h1>

    <table class="table">
        <th>Rank</th>
        <th>Score</th>
        <th>Name</th>

        <!-- foreach loop here to print high scores -->
        <?php
            $counter = 1;
            foreach($topScores as $user) {
                echo<<<USER
            <tr>
                <td>{$counter}</td>
                <td>{$user->score}</td>
                <td>{$user->name}</td>
            </tr>
USER;
                $counter++;
            }
        ?>
    </table>

    <a href="home" class="btn btn-primary btn-lg btn-block btn-info">Home</a>

</div> <!-- /container -->


<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
</body>
</html>
