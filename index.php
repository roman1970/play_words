<?php
session_start();
$_SESSION=[];
session_unset();
setcookie(session_name(), "", time()-3600);
session_destroy();
?>
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
        <h2 class="form-signin-heading">Поиграем в слова!</h2>
        <input type="text" class="form-control" placeholder="Ваше имя" name="name">
       
        <button class="btn btn-lg btn-primary btn-block" type="submit">Войти</button>
        
        <a href="post_form.php">Сгенерировать документ (задание 2)</a>
    </form>

</div> <!-- /container -->

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->

<script src="./bardzilla.js"></script>
</body>
</html>
