<?
function conectarServidorBD($servidorBD, $usuario, $password){
$link = mysql_connect($servidorBD, $usuario, $password);
if($link)
	return $link;
else
        return false;
}

function conectarBD($database, $link)
{
	$result=mysql_select_db($database, $link);
}

function conectarServidor(){
$servidorBD="localhost";
$usuario="root";
$password="novaquim";

$link = mysql_connect($servidorBD, $usuario, $password);
if($link)
	return $link;
else
        return false;
}
?>
