<?php
include "../includes/valAcc.php";
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
if (isset($_POST['idCotizacion'])) {
    $idCotizacion = $_POST['idCotizacion'];
} elseif (isset($_SESSION['idCotizacion'])) {
    $idCotizacion = $_SESSION['idCotizacion'];
}

$cotizacionOperador = new CotizacionesOperaciones();
$cotizacion = $cotizacionOperador->getCotizacion($idCotizacion);
if (!$cotizacion) {
    $ruta = "buscarCotiza.php";
    $mensaje = "No existe una cotización con ese número.  Intente de nuevo.";
    mover_pag($ruta, $mensaje, $icon);
    exit;
} else {
    $seleccionProd = explode(",", $cotizacion['productos']);
    $seleccionDis = explode(",", $cotizacion['distribucion']);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Actualizar Cotización</title>
    <meta charset="utf-8">
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
<script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
</head>
<body>
<div id="contenedor">
    <div id="saludo1"><strong>MODIFICAR COTIZACIÓN</strong></div>

    <form method="post" action="update_cotiza.php" name="form1">
        <div class="form-group row">
            <label class="col-form-label col-2" for="idCotizacion"><strong>Id Cotización</strong></label>
            <input type="text" class="form-control col-4" id="idCotizacion" name="idCotizacion" readonly
                   value="<?= $idCotizacion ?>" required/>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-2" for="idCliente"><strong>Cliente Cotización</strong></label>
            <select name="idCliente" id="idCliente" class="form-control col-4 " required>
                <option selected value="<?= $cotizacion['idCliente'] ?>"><?= $cotizacion['nomCliente'] ?></option>
                <?php
                $manager = new ClientesCotizacionOperaciones();
                $clientes = $manager->getClientes();
                $filas = count($clientes);
                echo '';
                for ($i = 0; $i < $filas; $i++) {
                    if ($cotizacion['idCliente'] != $clientes[$i]["idCliente"]) {
                        echo '<option value="' . $clientes[$i]["idCliente"] . '">' . $clientes[$i]['nomCliente'] . '</option>';
                    }
                }
                echo '';
                ?>
            </select>
        </div>

        <div class="form-group row">
            <label class="col-form-label col-2 text-right" for="fechaCotizacion"><strong>Fecha de
                    Cotización</strong></label>
            <input type="date" class="form-control col-4" name="fechaCotizacion" id="fechaCotizacion"
                   value="<?= $cotizacion['fechaCotizacion'] ?>" required>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-2"><strong>Destino</strong></label>
            <div class="col-form-label col-4 ">
                <input name="destino" type="radio" id="Destino_0"
                       value="1" <?php if ($cotizacion['destino'] == 1) echo 'checked'; ?>>
                <label for="Destino_0">Impresión</label>
                <input type="radio" name="destino" value="2"
                       id="Destino_1" <?php if ($cotizacion['destino'] == 2) echo 'checked'; ?>>
                <label for="Destino_1">Correo electrónico</label>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-2"><strong>Presentación</strong></label>
            <div class="col-form-label col-4 ">
                <input name="presentaciones" type="radio" id="Presentaciones_0"
                       value="1" <?php if ($cotizacion['presentaciones'] == 1) echo 'checked'; ?>>
                <label for="Presentaciones_0">Todas</label>
                <input type="radio" name="presentaciones" value="2"
                       id="Presentaciones_1" <?php if ($cotizacion['presentaciones'] == 2) echo 'checked'; ?>>
                <label for="Presentaciones_1">Pequeñas</label>
                <input type="radio" name="presentaciones" value="3"
                       id="Presentaciones_2" <?php if ($cotizacion['presentaciones'] == 3) echo 'checked'; ?>>
                <label for="Presentaciones_2">Grandes</label>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-2"><strong>Precio</strong></label>
            <div class="col-form-label col-4 ">
                <input name="precio" type="radio" id="precio_0"
                       value="1" <?php if ($cotizacion['precioCotizacion'] == 1) echo 'checked'; ?>>
                <label for="precio_0">Fábrica</label>
                <input type="radio" name="precio" value="2"
                       id="precio_1" <?php if ($cotizacion['precioCotizacion'] == 2) echo 'checked'; ?>>
                <label for="precio_1">Distribuidor</label>
                <input type="radio" name="precio" value="3"
                       id="precio_2" <?php if ($cotizacion['precioCotizacion'] == 3) echo 'checked'; ?>>
                <label for="precio_2">Detal</label>
                <input type="radio" name="precio" value="4"
                       id="precio_3" <?php if ($cotizacion['precioCotizacion'] == 4) echo 'checked'; ?>>
                <label for="precio_3">Mayorista</label>
                <input type="radio" name="precio" value="5"
                       id="precio_4" <?php if ($cotizacion['precioCotizacion'] == 5) echo 'checked'; ?>>
                <label for="precio_4">Superetes</label>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-2 text-right" for="fechaCotizacion"><strong>Familia de
                    Productos</strong></label>
            <div class="col-2">
                <?php
                $catProdOperador = new CategoriasProdOperaciones();
                $categorias = $catProdOperador->getCatsProd();
                for ($i = 0; $i < count($categorias); $i++):
                    ?>
                    <input type="checkbox" name="seleccionProd[]" id="categoriaProd<?= $i ?>"
                           value="<?= $categorias[$i]['idCatProd'] ?>"
                        <?php
                        if (in_array($categorias[$i]['idCatProd'], $seleccionProd)):
                            ?>
                            checked
                        <?php
                        endif;
                        ?>
                    >
                    <label for="categoriaProd<?= $i ?>"> <?= $categorias[$i]['catProd'] ?></label><br>
                <?php
                endfor;
                ?>
            </div>
            <label class="col-form-label col-2 text-right" for="fechaCotizacion"><strong>Familia
                    Distribución</strong></label>
            <div class="col-2">
                <?php
                $catDisOperador = new CategoriasDisOperaciones();
                $categorias = $catDisOperador->getCatsDis();
                for ($i = 0; $i < count($categorias); $i++):
                    ?>
                    <input type="checkbox" name="seleccionDis[]" id="categoriaDis<?= $i ?>"
                           value="<?= $categorias[$i]['idCatDis'] ?>"
                        <?php
                        if (in_array($categorias[$i]['idCatDis'], $seleccionDis)):
                            ?>
                            checked
                        <?php
                        endif;
                        ?>
                    >
                    <label for="categoriaDis<?= $i ?>"> <?= $categorias[$i]['catDis'] ?></label><br>
                <?php
                endfor;
                ?>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-1">
                <button class="button" type="button" onclick="return Enviar(this.form)">
                    <span>Continuar</span></button>
            </div>
        </div>
    </form>
    <div class="row form-group">
        <div class="col-1">
            <button class="button1" onclick="history.back()">
                <span>VOLVER</span></button>
        </div>
    </div>


    <!--        <table align="center" width="55%">
            <tr>
                <td width="22%" align="right"><strong>No. Cotización</strong></td>
                <td colspan="3"><input type="text" name="cotiza" id="sel1" value="<?php /*echo $cotiza; */ ?>" readonly
                                       size=20></td>
            </tr>
            <tr>
                <td align="right"><strong>Cliente</strong></td>
                <td colspan="3">
                    <?php
    /*                    echo '<select name="cliente" id="combo">';
                        $result = mysqli_query($link, "select idCliente, nomCliente from clientes_cotiz order BY nomCliente;");
                        echo '<option selected value="' . $id_cliente . '">' . $nom_cliente . '</option>';
                        while ($row = mysqli_fetch_array($result)) {
                            if ($row['Id_cliente'] <> $id_cliente)
                                echo '<option value=' . $row['Id_cliente'] . '>' . $row['Nom_clien'] . '</option>';
                        }
                        echo '</select>';
                        */ ?>
                </td>
            </tr>
            <tr>
                <td align="right"><strong>Fecha de Cotización</strong></td>
                <td colspan="3"><input type="text" name="FchCot" id="sel1"
                                       value="<?php /*echo $rows['Fech_Cotizacion']; */ ?>" readonly size=20><input
                            type="reset" value=" ... "
                            onclick="return showCalendar('sel1', '%Y-%m-%d', '12', true);"></td>
            </tr>
            <input name="Crear" type="hidden" value="3">
            <tr>
                <td align="right"><strong>Destino</strong></td>
                <td colspan="3">
                    <input name="Destino" type="radio" id="Destino_0" value="1" checked>
                    Impresión
                    <input type="radio" name="Destino" value="2" id="Destino_1">
                    Correo electrónico
                </td>
            </tr>
            <tr>
                <td align="right"><strong>Presentación</strong></td>
                <td colspan="3">
                    <?php
    /*                    if ($presentaciones == 1) {
                            echo '<input name="Presentaciones" type="radio" id="Presentaciones_0" value="1" checked>
                    Todas
                    <input type="radio" name="Presentaciones" value="2" id="Presentaciones_1">
                    Peque&ntilde;as
                    <input type="radio" name="Presentaciones" value="3" id="Presentaciones_2">
                    Grandes		';
                        }
                        if ($presentaciones == 2) {
                            echo '<input name="Presentaciones" type="radio" id="Presentaciones_0" value="1">
                    Todas
                    <input type="radio" name="Presentaciones" value="2" id="Presentaciones_1" checked>
                    Peque&ntilde;as
                    <input type="radio" name="Presentaciones" value="3" id="Presentaciones_2">
                    Grandes		';
                        }
                        if ($presentaciones == 3) {
                            echo '<input name="Presentaciones" type="radio" id="Presentaciones_0" value="1">
                    Todas
                    <input type="radio" name="Presentaciones" value="2" id="Presentaciones_1">
                    Peque&ntilde;as
                    <input type="radio" name="Presentaciones" value="3" id="Presentaciones_2" checked>
                    Grandes		';
                        }
                        */ ?>
                </td>
            </tr>
            <tr>
                <td align="right"><strong>Precio</strong></td>
                <td colspan="3">
                    <?php
    /*                    if ($precio == 1) {
                            echo '<input type="radio" name="precio" value="1" id="precio_0"  checked>
                Fábrica
                <input name="precio" type="radio" value="2" id="precio_1">
                Distribuidor
                <input type="radio" name="precio" value="3" id="precio_2">
                Detal
                <input type="radio" name="precio" value="4" id="precio_3">
                Mayorista
                <input type="radio" name="precio" value="5" id="precio_4">
                Superetes';
                        }
                        if ($precio == 2) {
                            echo '<input type="radio" name="precio" value="1" id="precio_0">
                Fábrica
                <input name="precio" type="radio" value="2" id="precio_1"  checked>
                Distribuidor
                <input type="radio" name="precio" value="3" id="precio_2">
                Detal
                <input type="radio" name="precio" value="4" id="precio_3">
                Mayorista
                <input type="radio" name="precio" value="5" id="precio_4">
                Superetes';
                        }
                        if ($precio == 3) {
                            echo '<input type="radio" name="precio" value="1" id="precio_0">
                Fábrica
                <input name="precio" type="radio" value="2" id="precio_1">
                Distribuidor
                <input type="radio" name="precio" value="3" id="precio_2"  checked>
                Detal
                <input type="radio" name="precio" value="4" id="precio_3">
                Mayorista
                <input type="radio" name="precio" value="5" id="precio_4">
                Superetes';
                        }
                        if ($precio == 4) {
                            echo '<input type="radio" name="precio" value="1" id="precio_0">
                Fábrica
                <input name="precio" type="radio" value="2" id="precio_1">
                Distribuidor
                <input type="radio" name="precio" value="3" id="precio_2">
                Detal
                <input type="radio" name="precio" value="4" id="precio_3"  checked>
                Mayorista
                <input type="radio" name="precio" value="5" id="precio_4">
                Superetes';
                        }
                        if ($precio == 5) {
                            echo '<input type="radio" name="precio" value="1" id="precio_0">
                Fábrica
                <input name="precio" type="radio" value="2" id="precio_1">
                Distribuidor
                <input type="radio" name="precio" value="3" id="precio_2">
                Detal
                <input type="radio" name="precio" value="4" id="precio_3">
                Mayorista
                <input type="radio" name="precio" value="5" id="precio_4  checked">
                Superetes';
                        }
                        */ ?>
                </td>
            </tr>
            <tr>
                <td align="right"><strong>Familia de Productos</strong></td>
                <td width="31%" align="left">
                    <?php
    /*                    $resultnova = mysqli_query($link, "select Id_cat_prod, Des_cat_prod from cat_prod where Id_cat_prod<8;");
                        while ($rownova = mysqli_fetch_array($resultnova)) {
                            echo $rownova['Des_cat_prod'] . '<input type="checkbox" name="seleccion1[]"  align="right" value="' . $rownova['Id_cat_prod'] . '"';
                            if (in_array($rownova['Id_cat_prod'], $seleccion1))
                                echo " checked ";
                            echo '><br>';
                        }

                        */ ?>       </td>
                <td width="18%" align="right"><strong>Familia Distribución</strong></td>
                <td width="29%" colspan="2" align="left"><?php
    /*                    $resultdist = mysqli_query($link, "select Id_cat_dist, Des_cat_dist from cat_dist;");
                        while ($rowdist = mysqli_fetch_array($resultdist)) {
                            echo $rowdist['Des_cat_dist'] . '<input type="checkbox" name="seleccion[]"  align="right" value="' . $rowdist['Id_cat_dist'] . '"';
                            if (in_array($rowdist['Id_cat_dist'], $seleccion))
                                echo " checked ";
                            echo '><br>';
                        }
                        mysqli_close($link);
                        */ ?></td>
            </tr>
            <tr>
                <td colspan="3" align="right"><input name="button" type="button" onClick="return Enviar(this.form);"
                                                     value="Continuar"></td>
            </tr>
            <tr>
                <td colspan="3">
                    <div align="center"><input type="button" class="resaltado" onClick="history.back()"
                                               value="  VOLVER  "></div>
                </td>
            </tr>
        </table>
    </form>-->
</div>
</body>
</html>
