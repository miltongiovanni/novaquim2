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
$perfilOperador = new PerfilesOperaciones();
$perfiles = $perfilOperador->getPerfiles();

for ($i = 0; $i < count($perfiles); $i++) {
    $idPerfil = $perfiles[$i]['idPerfil'];
    if ($idPerfil == $perfil1) {
        $perfil = $idPerfil;
        break;
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
    <link rel="stylesheet" href="css/styles.css" type="text/css">
    <link href='images/favicon.ico' rel='shortcut icon' type='image/x-icon'>
    <link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
    <title>Menú Principal</title>
</head>

<body>
<div id="contenedor">
    <?php

    $menum = new MenusOperaciones();
    $menuItems = $menum->getMenuItemsPerfil($perfil);
    //print_r($menuItems);
    //echo count($menuItems);

    function getMenuSons($parent, $menuItems)
    {
        //echo '<ul>';

        echo '<ul id="menu">';
        for ($row = 0; $row < count($menuItems); $row++) {
            if ($menuItems[$row]['parentId'] == $parent) {
                echo '<li><a href="' . $menuItems[$row]['link'] . '">' . $menuItems[$row]['title'] . '</a>';
                $son = $menuItems[$row]['id'];
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
                if ($menuItems[$row]['parentId'] == $parent) {
                    echo '<li><a href="' . $menuItems[$row]['link'] . '">' . $menuItems[$row]['title'] . '</a>';
                    $son = $menuItems[$row]['id'];
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
    <div id="saludo2" class="form-group row" style="align-items: center;">
        <div class="col-1"><img src="images/LogoNova.jpg"></div>
        <div class="col-11 text-center">
            <?php
            $idUsuario = $_SESSION['IdUsuario'];
            $usuarioOperador = new UsuariosOperaciones();
            $row = $usuarioOperador->getUser($idUsuario);
            $nombre = $row['nombre'];
            echo $nombre;
            ?> está usando el Sistema de Información de Industrias Novaquim S.A.S.
        </div>
    </div>
    <div class="form-group row" style="justify-content: flex-start">
        <div class="col-4 card">
            <?php include_once ("widgets/facXPagarTotales.php") ; ?>
        </div>
    </div>
</div>
</body>

</html>