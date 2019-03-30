<?php
include "includes/valAcc.php";
include "includes/conect.php";
$perfil1 = $_SESSION['Perfil'];
// On enregistre notre autoload.

function cargarClases($classname)
{
    require 'clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
//Busca el valor del perfil
$con = Conectar::conexion();
$QRY = "select IdPerfil, Descripcion from perfiles;";
$result = $con->query($QRY);

while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $idPerfil = $row['IdPerfil'];
    if (md5($idPerfil) == $perfil1) {
        $perfil = $idPerfil;
    }
}
//echo "perfil1 ".$perfil1;
//echo "perfil ".$perfil;

?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/styles.css">
  <link href='images/favicon.ico' rel='shortcut icon' type='image/x-icon'>
	<link href="css/formatoTabla.css" rel="stylesheet">
  <title>Menú Principal</title>
</head>

<body>
<div id="contenedor">
<?php

$menum = new MenusOperaciones();
$menuItems = $menum->getMenuItems($perfil);
//print_r($menuItems);
//echo count($menuItems);
//var_dump($menuItems);

function getMenuSons($parent, $menuItems)
{
    //echo '<ul>';

    echo '<ul id="menu">';
    for ($row = 0; $row < count($menuItems); $row++) {
        if ($menuItems[$row][3] == $parent) {
            echo '<li><a href="' . $menuItems[$row][2] . '">' . $menuItems[$row][1] . '</a>';
            $son = $menuItems[$row][0];
            //echo "son ".$son;
            //getMenuSons($son, $menuItems);
            getMenuGrandSons($son, $menuItems);
            echo '</li>';
        }
    }
    echo "</ul>";

}
function getMenuGrandSons($parent, $menuItems)
{
    if ($parent < 1000) {
        echo "<ul>";
        for ($row = 0; $row < count($menuItems); $row++) {
            if ($menuItems[$row][3] == $parent) {
                echo '<li><a href="' . $menuItems[$row][2] . '">' . $menuItems[$row][1] . '</a>';
                $son = $menuItems[$row][0];
                //echo "son ".$son;
                getMenuGrandSons($son, $menuItems);
                echo '</li>';
            }
        }
        echo "</ul>";
    }
}
getMenuSons(0, $menuItems);
?>
<div id="saludo"> <p>
<?php

$user1 = $_SESSION['User'];
$qry = "select Nombre from usuarios WHERE Usuario='$user1'";
$result = $con->query($qry);

$row = $row = $result->fetch(PDO::FETCH_ASSOC);
echo $row['Nombre'];
$result = null;
/* cerrar la conexión */
$con = null;
?> está usando el Sistema de Información de Industrias Novaquim S.A.S.</p>
	</div>
</body>

</html>