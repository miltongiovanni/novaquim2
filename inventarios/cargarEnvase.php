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
	<title>Cargar Envase como Producto de Distribución</title>
	<meta charset="utf-8">
	<link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
	<script  src="../js/validar.js"></script>
</head>
<body>
<div id="contenedor">
<div id="saludo"><strong>CARGAR ENVASE AL INVENTARIO DE DISTRIBUCIÓN</strong></div>
    <form method="post" action="charge.php" name="form1">
        <div class="form-group row">
            <label class="col-form-label col-3 text-right" for="idDis"><strong>Envase:</strong></label>
            <select class="form-control col-3" name="idDis" id="idDis">
                <option selected disabled value="">----------------------------</option>
                <?php
                $relEnvDisOperador = new RelEnvDisOperaciones();
                $productos = $relEnvDisOperador->getRelsEnvDis();
                for ($i = 0; $i < count($productos); $i++):
                    ?>
                    <option value="<?= $productos[$i]['idDis'] ?>"><?= $productos[$i]['producto'] ?></option>
                <?php
                endfor;
                ?>
            </select>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-3 text-right" for="unidades"><strong>Cantidad:</strong></label>
            <input type="text" class="form-control col-3" name="unidades" id="unidades"
                   onKeyPress="return aceptaNum(event)">
        </div>
        <div class="form-group row">
            <div class="col-1 text-center">
                <button class="button" type="reset"><span>Reiniciar</span></button>
            </div>
            <div class="col-1 text-center">
                <button class="button" onclick="return Enviar(this.form)"><span>Cargar
                    </span></button>
            </div>
        </div>
    </form>
    <div class="row">
        <div class="col-1">
            <button class="button1" onClick="history.back()"><span>VOLVER</span></button>
        </div>
    </div>
</div>
</body>
</html>
	   