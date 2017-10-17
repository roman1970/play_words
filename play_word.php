<?php
session_start();
ini_set('display_errors', 1);
if(!isset($_SESSION['user']))    {
    header("Location: index.php"); exit();
}
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

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/signin.css" rel="stylesheet">
</head>
<body>

<div class="container">

    <form class="form-signin" role="form" action="action.php" method="post">
        <h2 class="form-signin-heading">Привет! <?=$_SESSION['user']?>! </h2>
        
        <h3> Моё слово: <?=$_SESSION['word']?></h3>
        <p> Тебе нужно набрать слово на
            <?=mb_substr(trim($_SESSION['word']), -1) == 'ь' ? mb_substr(trim($_SESSION['word']), -2, 1) : mb_substr(trim($_SESSION['word']), -1)?></p>
        <input type="text" class="form-control" placeholder="Твоё слово" name="word" id="users_word" onmouseleave="validateWord();" >
        <input type="hidden" class="form-control" name="user" value="<?=$_SESSION['user']?>" id="user" >

        <button class="btn btn-lg btn-primary btn-block" id="sub_button" style="display: none" type="submit">Готово!</button>
        <div id="res"></div>
    </form>
    
</div> <!-- /container -->

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="js/functions.js"></script>

</body>
</html>
