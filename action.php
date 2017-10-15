<?php
session_start();
//var_dump($_SESSION); exit;
ini_set('display_errors', 1);
require_once(__DIR__ . "/params.php");
require_once(__DIR__ . "/classes/User.php");
require_once(__DIR__ . "/classes/Word.php");
require_once(__DIR__ . "/classes/Validator.php");

//Базу пока включаем костылём
Word::$db = new PDO("mysql:host=".
    $params['host'].";dbname=".$params['dbname'].";charset=".$params['charset'], 
    $params['user'], $params['psw'], [PDO::ATTR_PERSISTENT => true]);


if(isset($_GET['u_word'])){

    $validator = new Validator($_GET['u_word']);
    
    if(!$validator->isFirstLiterRight()) echo '<p>Слово должно начинаться не с той буквы!</p>';
    if(!$validator->isWordUnused())  echo '<p>Это слово уже было!</p>';
    if($validator->isShorterThenThreeLetters()) echo '<p>Слово слишком короткое!</p>';
    if($validator->isThreeOrMoreVowelsInRow()) echo '<p>Много гласных подряд! Таких слов не бывает</p>';
    if($validator->isError()) echo 1;

}


if(isset($_POST['name'])) {
    
    $user = new User($_POST['name']);
    $word = new Word();
   // echo $word->getRandWord(); exit;
    
    if ($user->isValidUser()) {

        $_SESSION['user'] = $_POST['name'];
        //var_dump($word->getRandWord()); exit;
        $_SESSION['word'] = $word->getRandWord();

        header("Location: play_word.php"); exit();
    } else {
        echo 'Вам нельзя играть';
    }
}

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



