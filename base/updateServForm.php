<?php
include "../includes/valAcc.php";
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$idServicio = $_POST['idServicio'];
$servicioperador = new ServiciosOperaciones();
$servicio = $servicioperador->getServicio($idServicio);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <title>Actualizar Servicio</title>
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script  src="../js/validar.js"></script>
</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo">
        <img src="../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2"><h4>ACTUALIZACIÓN DE SERVICIO</h4></div>
    <form id="form1" name="form1" method="post" action="updateServ.php">
        <div class="form-group row">
            <label class="col-form-label col-2 text-end"
                   for="idServicio"><strong>Código</strong></label>
            <input type="text" class="form-control col-2" name="idServicio" id="idServicio" size=30 maxlength="30"
                   value="<?= $servicio['idServicio'] ?>" readonly>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-2 text-end"  for="desServicio"><strong>Descripción
                    Servicio</strong></label>
            <input type="text" class="form-control col-2" name="desServicio" id="desServicio"
                   value="<?= $servicio['desServicio'] ?>" onkeydown="return aceptaLetra(event)">
        </div>
        <div class="form-group row">

            <label class="col-form-label col-2" for="codIva"><strong>Iva</strong></label>
            <?php
            $manager = new TasaIvaOperaciones();
            $tasas = $manager->getTasasIva();
            $filas = count($tasas);
            echo '<select name="codIva" id="codIva" class="form-control col-2" required>';
            echo '<option selected value="' . $servicio['codIva'] . '">' . $servicio['iva'] . '</option>';
            for ($i = 0; $i < $filas; $i++) {
                if ($servicio['codIva'] != $tasas[$i]["idTasaIva"]) {
                    echo '<option value="' . $tasas[$i]["idTasaIva"] . '">' . $tasas[$i]['iva'] . '</option>';
                }
            }
            echo '</select>';
            ?>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-2" for="cotiza"><strong>Activo</strong></label>
            <?php
            if ($servicio['activo'] == 0) {
                echo '<select name="activo" id="activo" class="form-control col-2">
                    <option value="0" selected>No</option>
                    <option value="1">Si</option>
                </select>';
            } else {
                echo '<select name="activo" id="activo" class="form-control col-2">
                    <option value="1" selected>Si</option>
                    <option value="0">No</option>
                </select>';
            }
            ?>
        </div>
        <div class="form-group row">
                        <div class="col-1 text-center" >
                <button class="button" type="reset"><span>Reiniciar</span></button>
            </div><div class="col-1 text-center" >
                <button class="button" type="button" onclick="return Enviar(this.form)"><span>Continuar</span></button>
            </div>
        </div>

    </form>
    <div class="row">
        <div class="col-1">
            <button class="button1" id="back" onClick="history.back()"><span>VOLVER</span></button>
        </div>
    </div>
</div>
</body>
</html>
