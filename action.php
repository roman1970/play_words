<?php
/**
 * Обработчик запросов
 */
session_start();
//var_dump($_SESSION); exit;
ini_set('display_errors', 1);
require_once(__DIR__ . "/params.php");
require_once(__DIR__ . "/classes/User.php");
require_once(__DIR__ . "/classes/Word.php");
require_once(__DIR__ . "/classes/Validator.php");

//Базу пока включаем костылём, массив с параметрами - не под версионным контролем
Word::$db = new PDO("mysql:host=".
    $params['host'].";dbname=".$params['dbname'].";charset=".$params['charset'], 
    $params['user'], $params['psw'], [PDO::ATTR_PERSISTENT => true]);

// Запросы к валидатору слова
if(isset($_GET['u_word'])){

    $validator = new Validator($_GET['u_word']);
    
    if($validator->isEmptyField()) echo '<p>Введите слово!</p>';
    elseif(!$validator->isFirstLiterRight()) echo '<p>Слово начинается не с той буквы!</p>';
    elseif(!$validator->isWordUnused())  echo '<p>Это слово уже было!</p>';
    elseif($validator->isShorterThenThreeLetters()) echo '<p>Слово слишком короткое!</p>';
    elseif($validator->isThreeOrMoreVowelsInRow()) echo '<p>Много гласных подряд! Таких слов не бывает</p>';
    elseif($validator->isError()) echo 1;

}

// Вход пользователя
if(isset($_POST['name'])) {
    
    $user = new User($_POST['name']);
    $word = new Word();
   // echo $word->getRandWord(); exit;

    if($user->isValidUser()) {

        $_SESSION['user'] = $_POST['name'];
        //var_dump($word->getRandWord()); exit;
        $_SESSION['word'] = $word->getRandWord();

        header("Location: play_word.php"); exit();
    } else {
        echo 'Вам нельзя играть';
    }
}

// Вход админа
if(isset($_POST['admin'])){
    $user = new User($_POST['admin']);
    if($user->isAdmin()){
        $_SESSION['admin'] = $_POST['admin'];

        header("Location: admin_panel.php"); exit();
    } else {
        echo 'Вход запрещён!';
    }

}

// Запрос на проверку слова
if(isset($_POST['word']) && isset($_POST['user'])) {
    //echo $_POST['user']; exit;
    $user = $_POST['user'];
    $word = new Word($_POST['word']);

        if($answer = $word->getAnswer()) $_SESSION['word'] = $answer;
    
        else {
            header("Location: game_over.php"); exit();
        }

        header("Location: play_word.php"); exit();

}

// Запрос на редактрование
if(isset($_GET['edit_w'])) {
    // Заглушим, а вообще - перебрасываем на форму:
    // header("Location: admin/edit.php"); exit();
    echo 'Редактировано!';
}

// Запрос на удаление
if(isset($_GET['delete_w'])) {
    //if($word->deleteWord((int)$_GET['delete_w']))
        echo 'Удалено!';
}



