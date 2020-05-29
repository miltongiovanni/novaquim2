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
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <title>Eliminar Materias Primas</title>
    <script src="../js/validar.js"></script>
</head>

<body>
<div id="contenedor">
    <div id="saludo"><strong>ELIMINACIÓN DE MATERIA PRIMA</strong></div>
    <form id="form1" name="form1" method="post" action="deleteMP.php">
        <div class="form-group row">
            <label class="col-form-label col-1" for="codMPrima"><strong>Materia Prima</strong></label>
            <select name="codMPrima" id="codMPrima" class="form-control col-2">
                <option selected value="">-----------------------------</option>
                <?php
                $MPrimasOperador = new MPrimasOperaciones();
                $mprimas = $MPrimasOperador->getMPrimasEliminar();
                for ($i = 0; $i < count($mprimas); $i++) {
                    echo '<option value="' . $mprimas[$i]["codMPrima"] . '">' . $mprimas[$i]['nomMPrima'] . '</option>';
                }
                ?>
            </select>
        </div>
        <div class="row form-group">
            <div class="col-1">
                <button class="button" onclick="return Enviar(this.form)">
                    <span>Continuar</span></button>
            </div>
        </div>
    </form>
    <div class="row form-group">
        <div class="col-1">
            <button class="button1" onclick="history.back()"><span>VOLVER</span></button>
        </div>
    </div>
</div>
</body>

</html>