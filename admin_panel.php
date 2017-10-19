<?php
require_once(__DIR__ . "/params.php");
require_once(__DIR__ . "/bd_connection.php");
require_once(__DIR__ . "/classes/Word.php");

$word = new Word($db_connection);

$arr_request = $word->selectAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Панель администратора</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/signin.css" rel="stylesheet">
    <link href="css/dashboard.css" rel="stylesheet">
</head>
    <body>
        <div class="container">
            <div class="main">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                              <th>N</th>
                              <th>СЛОВО</th>
                              <th>Редактировать</th>
                              <th>Удалить</th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php foreach ($arr_request as $word) : ?>
                            <tr>
                              <td><?=$word['id']?></td>
                              <td contenteditable="true" id="word_<?=$word['id']?>"><?=$word['word']?></td>
                              <td id="edit_<?=$word['id']?>" style="cursor: pointer" onclick="editWord(<?=$word['id']?>)">Редактровать</td>
                              <td id="delete_<?=$word['id']?>" style="cursor: pointer" onclick="deleteWord(<?=$word['id']?>)">Удалить</td>
                            </tr>
                        <?php endforeach; ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="js/functions.js"></script>
    </body>
</html>