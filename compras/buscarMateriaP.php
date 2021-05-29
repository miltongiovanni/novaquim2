<?php
include "../includes/valAcc.php";
// Función para cargar las clases
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Seleccionar Materia Prima a Consultar Compra</title>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
<script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
</head>

<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo"><h4>SELECCIONAR MATERIA PRIMA A CONSULTAR COMPRA</h4></div>
    <form id="form1" name="form1" method="post" action="listacompraxMP.php">
        <div class="form-group row">
            <label class="col-form-label col-1" for="codMPrima"><strong>Materia prima</strong></label>
            <select name="codMPrima" id="codMPrima" class="form-control col-2" required>
                <option selected disabled value="">-----------------------------</option>
                <?php
                $MPrimasOperador = new MPrimasOperaciones();
                $mprimas = $MPrimasOperador->getMPrimas();
                $filas = count($mprimas);
                for ($i = 0; $i < $filas; $i++) {
                    echo '<option value="' . $mprimas[$i]["codMPrima"] . '">' . $mprimas[$i]['nomMPrima'] . '</option>';
                }
                ?>
            </select>
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