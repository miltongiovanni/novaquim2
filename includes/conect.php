<?php
function conectarServidorBD($servidorBD, $usuario, $password){
$link = mysql_connect($servidorBD, $usuario, $password);
if($link)
	return $link;
else
        return false;
}

function conectarServidor(){
/*
$servidorBD="localhost";
$usuario="root";
$password="novaquim";
$database="novaquim";

$link = mysqli_connect($servidorBD, $usuario, $password, $database);
if($link)
	return $link;
else
        return false;
*/
//Orientado a objetos
$mysqli = new mysqli('localhost', 'root', 'novaquim', 'novaquim');

if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') '
            . $mysqli->connect_error);
}
return $mysqli;
}
?>
