<?php
$db_connection = new PDO("mysql:host=".
    $params['host'].";dbname=".$params['dbname'].";charset=".$params['charset'],
    $params['user'], $params['psw'], [PDO::ATTR_PERSISTENT => true]);