<?php
include "../includes/valAcc.php";
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Crear Cotización</title>
    <meta charset="utf-8">
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/findCliente.js"></script>
</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo1"><h4>CREAR COTIZACIÓN</h4></div>
    <form method="post" action="makeCotizacion.php" name="form1">
        <div class="form-group row">
            <label class="col-form-label col-2" for="busClien"><strong>Cliente</strong></label>
            <input type="text" class="form-control col-1" id="busClien" name="busClien"
                   onkeyup="findClienteCotizacion()"
                   required/>
            <div class="col-4" id="myDiv"></div>
        </div>

        <div class="form-group row">
            <label class="col-form-label col-2 text-end" for="fechaCotizacion"><strong>Fecha de
                    Cotización</strong></label>
            <input type="date" class="form-control col-5" name="fechaCotizacion" id="fechaCotizacion" required>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-2"><strong>Destino</strong></label>
            <div class="col-form-label col-5 ">
                <input name="destino" type="radio" id="Destino_0" value="1" checked>
                <label for="Destino_0">Impresión</label>
                <input type="radio" name="destino" value="2" id="Destino_1">
                <label for="Destino_1">Correo electrónico</label>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-2"><strong>Presentación</strong></label>
            <div class="col-form-label col-5 ">
                <input name="presentaciones" type="radio" id="Presentaciones_0" value="1" checked>
                <label for="Presentaciones_0">Todas</label>
                <input type="radio" name="presentaciones" value="2" id="Presentaciones_1">
                <label for="Presentaciones_1">Pequeñas</label>
                <input type="radio" name="presentaciones" value="3" id="Presentaciones_2">
                <label for="Presentaciones_2">Grandes</label>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-2"><strong>Precio</strong></label>
            <div class="col-form-label col-5 ">
                <input name="precio" type="radio" id="precio_0" value="1" checked>
                <label for="precio_0">Fábrica</label>
                <input type="radio" name="precio" value="2" id="precio_1">
                <label for="precio_1">Distribuidor</label>
                <input type="radio" name="precio" value="3" id="precio_2">
                <label for="precio_2">Detal</label>
                <input type="radio" name="precio" value="4" id="precio_3">
                <label for="precio_3">Mayorista</label>
                <input type="radio" name="precio" value="5" id="precio_4">
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
                           value="<?= $categorias[$i]['idCatProd'] ?>">
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
                           value="<?= $categorias[$i]['idCatDis'] ?>">
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
            <button class="button1" onclick="window.location='../menu.php'">
                <span>VOLVER</span></button>
        </div>
    </div>
</div>
</body>
</html>
