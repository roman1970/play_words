<?php
/**
 * Обработчик запросов
 */
session_start();
//var_dump($_SESSION); exit;
ini_set('display_errors', 1);
require_once(__DIR__ . "/params.php");
require_once(__DIR__ . "/bd_connection.php");
require_once(__DIR__ . "/classes/User.php");
require_once(__DIR__ . "/classes/Word.php");
require_once(__DIR__ . "/classes/Validator.php");

// Запросы к валидатору слова
if(isset($_GET['u_word'])){

    $validator = new Validator($_GET['u_word']);
    $word = new Word($db_connection);
    
    if($validator->isEmptyField()) echo '<p>Введите слово!</p>';
    elseif(!$validator->isFirstLiterRight()) echo '<p>Слово начинается не с той буквы!</p>';
    elseif(!$validator->isWordUnused())  echo '<p>Это слово уже было!</p>';
    elseif($validator->isShorterThenThreeLetters()) echo '<p>Слово слишком короткое!</p>';
    elseif($validator->isThreeOrMoreVowelOrConsonantsIsInRow()) echo '<p>Много гласных или согласных подряд!</p>';
    elseif($validator->isOnlyVowel()) echo '<p>Одни гласные!</p>';
    elseif($validator->isOnlyConsonants()) echo '<p>Одни согласные!</p>';
    elseif($validator->hasNonRightSymbols()) echo '<p>Можно использовать только буквы русского алфавита!</p>';
    elseif($validator->isError()) echo 1;

}

// Вход пользователя
if(isset($_POST['name'])) {
    
    $user = new User($_POST['name']);

    //var_dump($user->getId()); exit();
    $word = new Word($db_connection, $user->getId());
   // echo $word->getRandWord(); exit;

    if($user->isValidUser()) {

        $_SESSION['user'] = $_POST['name'];
        //var_dump(session_id()); exit;
        $_SESSION['word'] = $word->getRandWord();

        header("Location: play_word.php"); exit();
    } else {
        unset($_SESSION['user']);
        session_destroy();
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
        unset($_SESSION['user']);
        session_destroy();
        echo 'Вход запрещён!';
    }

}

// Запрос на проверку слова
if(isset($_POST['word']) && isset($_POST['user'])) {
    //echo $_POST['user']; exit;
    //$user = $_POST['user'];
    $user = new User($_POST['user']);
    $word = new Word($db_connection, $user->getId(), $_POST['word']);

        //echo $word->getAnswer(); exit();

        if($answer = $word->getAnswer()) $_SESSION['word'] = $answer;
    
        else {
            session_regenerate_id();
            header("Location: game_over.php"); exit();
        }

        header("Location: play_word.php"); exit();

}

// Запрос на редактрование
if(isset($_GET['id']) && isset($_GET['e_word'])) {
    $word = new Word($db_connection);
    if($word->editWord($_GET['id'], $_GET['e_word']))
        echo 'Редактировано!';
    else
        echo 'Ошибка';
}

// Запрос на удаление
if(isset($_GET['delete_w'])) {
    $word = new Word($db_connection);
    if($word->deleteWord($_GET['delete_w']))
       echo 1;
}

