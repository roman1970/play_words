<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Играем в слова</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/signin.css" rel="stylesheet">
</head>
<body>

<div class="container">

    <form class="form-signin" role="form" action="action.php" method="post">
        <h2 class="form-signin-heading">Компьютер проиграл</h2>
        <input type="hidden" class="form-control" placeholder="Ваше имя" name="name" value="<?=$_SESSION['user']?>">

        <button class="btn btn-lg btn-primary btn-block" type="submit">Играть ещё</button>
    </form>

</div> <!-- /container -->

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="js/functions.js"></script>

</body>
</html>