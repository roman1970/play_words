<!DOCTYPE html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" lang="ru" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Играем в слова</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/signin.css" rel="stylesheet">
</head>
<style>
    *{ font-family: DejaVu Sans !important;}
</style>
<body>

<div class="container">

    <form class="form-signin" role="form" action="post_card_generator.php" method="post">
        <h2 class="form-signin-heading">Отправитель</h2>
        <input type="text" class="form-control" placeholder="От кого" name="sender_from">
        <input type="text" class="form-control" placeholder="Куда" required="" name="sender_to">
        <h2 class="form-signin-heading">Получатель</h2>
        <input type="text" class="form-control" placeholder="От кого" name="receiver_from">
        <input type="text" class="form-control" placeholder="Куда" required="" name="receiver_to">
        <button class="btn btn-lg btn-primary btn-block" type="submit">Сгенерировать</button>
    </form>

</div> <!-- /container -->

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="js/functions.js"></script>

</body>
</html>