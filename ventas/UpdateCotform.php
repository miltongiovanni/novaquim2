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

<?php
$cotizacionOperador = new CotizacionesOperaciones();
$cotizacion = $cotizacionOperador->getCotizacion($idCotizacion);
if (!$cotizacion) {
    $ruta = "buscarCotiza.php";
    $mensaje = "No existe una cotización con ese número.  Intente de nuevo.";
    $icon = "warning";
    mover_pag($ruta, $mensaje, $icon);
    exit;
} else {
    $seleccionProd = explode(",", $cotizacion['productos']);
    $seleccionDis = explode(",", $cotizacion['distribucion']);
}
?>
<div id="contenedor" class="container-fluid">
    <div id="saludo1">
        <img src="../images/LogoNova.jpg" alt="novaquim" class="img-fluid mb-2"><h4>MODIFICAR COTIZACIÓN</h4></div>

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
            <label class="col-form-label col-2 text-end" for="fechaCotizacion"><strong>Fecha de
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
            <label class="col-form-label col-2 text-end" for="fechaCotizacion"><strong>Familia de
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
            <label class="col-form-label col-2 text-end" for="fechaCotizacion"><strong>Familia
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
</div>
</body>
</html>
