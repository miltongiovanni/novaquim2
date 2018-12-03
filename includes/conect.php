<?php

function conectarServidor(){

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

?>
