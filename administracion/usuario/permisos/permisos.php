<?php
include "../../../includes/valAcc.php";
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Asignación de Permisos al Usuario</title>
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../../../js/md5.js"></script>
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
    <script>
        function todos(form) {
            for (i = 0; i < form.casilla1.length; i++)
                form.casilla1[i].checked = true;
            form.desmarcatodos.checked = false;
        }

        function ninguno(form) {
            for (i = 0; i < form.casilla1.length; i++)
                form.casilla1[i].checked = false;
            form.marcatodos.checked = false;
        }

        function seleccionar1(form) {
            for (i = 0; i < form.casilla1.length; i++)
                if (form.casilla1[i].type == "checkbox")
                    if (form.seleccionar.checked == true)
                        form.casilla1[i].checked = true
                    else if (form.seleccionar.checked == false)
                        form.casilla1[i].checked = false
        }

        function seleccionar2(form) { //seleccion2[][]
            document.writeln(perr1.value);
            for (i = 0; i < form.casilla1.length; i++)
                if (form.casilla1[i].type == "checkbox")
                    if (form.seleccionar.checked == true)
                        form.casilla1[i].checked = true
                    else if (form.seleccionar.checked == false)
                        form.casilla1[i].checked = false
        }

        /*function buscar2(form, texto)
        {
            //document.writeln (form.seleccion3[2][2][2].value);
            var sel2[][] = document.getElementsByName('seleccion2[][]');
            document.writeln (sel2[1][1].value);
            document.writeln (document.forms[1].seleccion3[2][2][2].value);
            //document.writeln (texto);
            for(ind=0; ind<lista.length; ind++)
            {
                if (lista[ind] == valor)
                  break;
            }
            for (i=0;i<10;i++)
            {
                for (j=0;j<10;j++)
                {
                     document.write(i + "-" + j)
                }
            }
        }*/
    </script>
</head>

<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo1">
        <img src="../../../images/LogoNova.jpg" alt="novaquim" class="img-fluid mb-2">
        <?php
        foreach ($_POST as $nombre_campo => $valor) {
            ${$nombre_campo} = $valor;
            if (is_array($valor)) {
                //echo $nombre_campo.print_r($valor).'<br>';
            } else {
                //echo $nombre_campo. '=' .${$nombre_campo}.'<br>';
            }
        }
        $usuarioOperador = new UsuariosOperaciones();
        $row = $usuarioOperador->getUser($idUsuario);
        $idPerfil = $row['idPerfil'];
        $nombre = $row['nombre'];

        echo "Permisos para el usuario <strong>" . $nombre . "</strong>";
        ?> en el Sistema de Inventarios de Industrias Novaquim
    </div>
    <div class="tabla-50">
        <form name="PERMISOS" method="post" action="asig_permisos.php">
            <?php
            $menuOperador = new MenusOperaciones();
            $menuItems = $menuOperador->getMenuItems();
            $k = 0;

            for ($i = 0; $i < count($menuItems); $i++) {
                $id = $menuItems[$i]['id'];
                $title = $menuItems[$i]['title'];
                $parentId = $menuItems[$i]['parentId'];
                $codUser = $menuItems[$i]['codUser'];
                $usuarios_p = explode(",", $codUser);

                $k++;
                $menu_1[0] = "";
                $menu_1_i[0] = "";
                if ($parentId == 0) {
                    $menu_1[] = $title;
                    $menu_1_i[] = $id;

                } else {
                    if ($clave = array_search($parentId, $menu_1_i)) {
                        $menu_2[$clave][0] = "";
                        $menu_2_i[$clave][0] = "";
                        $menu_2[$clave][] = $title;
                        $menu_2_i[$clave][] = $id;
                    } else {
                        foreach ($menu_2_i as $indice => $elemento) {
                            foreach ($elemento as $clave => $valor) {
                                if ($parentId == $valor) {
                                    $menu_3[$indice][$clave][0] = "";
                                    $menu_3_i[$indice][$clave][0] = "";
                                    $menu_3[$indice][$clave][] = $title;
                                    $menu_3_i[$indice][$clave][] = $id;
                                    break;
                                }
                            }
                        }
                    }
                }
            }
            $id2 = 0;
            foreach ($menu_3 as $indice1 => $auxiliar) {
                //echo "El indice1 es $indice1 <br>";
                if ($indice1 > 0) {
                    echo '<table class="text-center"><tr><td colspan="2" class="text-center titulo">';
                    echo $menu_1[$indice1];
                    echo "</td></tr><tr>";
                }
                $id3 = 0;
                foreach ($auxiliar as $indice2 => $elemento) {
                    //echo "El indice2 es $indice2 <br>";
                    echo '<td class="text-center resaltado w-50">';
                    $idmenu2 = "menu2" . $id2++;
                    echo $menu_2[$indice1][$indice2];
                    echo "</td>";
                    echo '<td class="text-end">';
                    foreach ($elemento as $clave => $valor) {
                        if ($clave > 0) {
                            $aaaaa = $menu_3_i[$indice1][$indice2][$clave];
                            $menuItem = $menuOperador->getMenuItem($aaaaa);
                            $codUser = $menuItem['codUser'];
                            $usuarios_p = explode(",", $codUser);
                            if (in_array($idPerfil, $usuarios_p)) {
                                echo $valor . '<input type="checkbox" name="seleccion3[][][]" id="menu3' . $id3++ . '" class="text-end mx-2" value="' . $menu_3_i[$indice1][$indice2][$clave] . '" checked ><br>';
                            } else {
                                echo $valor . '<input type="checkbox" name="seleccion3[][][]" id="menu3' . $id3++ . '" class="text-end mx-2" value="' . $menu_3_i[$indice1][$indice2][$clave] . '" ><br>';
                            }

                        }
                    }
                    echo "</td></tr><tr><td>&nbsp;</td></tr><tr>";
                }
                echo "</tr>";
                echo "</table>";
            }
            //echo "el valor del indice1 final es $indice";
            ?>
            <div class="mb-3 row">
                <div class="col-2 text-center">
                    <button class="button" type="reset"><span>Reiniciar</span></button>
                </div>
                <div class="col-2 text-center">
                    <button class="button" type="button"
                            onclick="return Enviar(this.form)"><span>Guardar</span></button>
                </div>
            </div>

            <input type="hidden" name="idPerfil" value="<?= $idPerfil ?>">
            <input type="hidden" name="idUsuario" value="<?= $idUsuario ?>">
        </form>
    </div>
    <div class="row">
        <div class="col-1">
            <button class="button" id="back"
                    onClick="window.location='../../../menu.php'">
                <span>Terminar</span></button>
        </div>
    </div>
</div>
</body>

</html>