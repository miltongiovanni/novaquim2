<?php

function conectarServidor(){
/*
//Orientado a objetos
$mysqli = new mysqli('localhost', 'root', 'novaquim', 'novaquim2');
//$mysqli->set_charset("utf8");
if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') '
            . $mysqli->connect_error);
}
$mysqli->set_charset("utf8");
return $mysqli;
}
*/
//PDO 
$dsn = 'mysql:dbname=novaquim2;host=127.0.0.1;charset=utf8';
$user = 'root';
$password = 'novaquim';

try {
    $pdo = new PDO($dsn, $user, $password);
} catch (PDOException $e) {
    echo 'Connexion échouée : ' . $e->getMessage();
}
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
return $pdo;
}
?>
