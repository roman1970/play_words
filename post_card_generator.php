<?php
//ini_set('display_errors', 1);
require_once(__DIR__ . "/vendor/autoload.php") ;
require_once(__DIR__ . "/classes/FileGenerator.php");

$type = $_POST['file_type'];

$file_gen = new FileGenerator($type);

$file_gen->handler();
