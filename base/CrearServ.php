<?php
include "../includes/valAcc.php";
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$servicioperador = new ServiciosOperaciones();
$lastservicio = $servicioperador->getLastServicio();
$lastservicio++;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <title>Creación de Servicios</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <script  src="../js/validar.js"></script>
</head>
<body>
<div id="contenedor">
    <div id="saludo"><strong>CREACIÓN DE SERVICIO</strong></div>
    <form name="form2" method="POST" action="makeServ.php">
        <div class="form-group row">
            <label class="col-form-label col-2"
                   for="idServicio"><strong>Código</strong></label>
            <input type="text" class="form-control col-2" name="idServicio" id="idServicio" size=30 maxlength="30"
                   value="<?= $lastservicio ?>" readonly>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-2"  for="desServicio"><strong>Descripción
                    Servicio</strong></label>
            <input type="text" class="form-control col-2" name="desServicio" id="desServicio"
                   onKeyPress="return aceptaLetra(event)">
        </div>
        <div class="form-group row">

            <label class="col-form-label col-2" for="codIva"><strong>Iva</strong></label>
            <?php
            $manager = new TasaIvaOperaciones();
            $tasas = $manager->getTasasIva();
            $filas = count($tasas);
            echo '<select name="codIva" id="codIva" class="form-control col-2">';
            echo '<option selected disabled value="">-----------------------------</option>';
            for ($i = 0; $i < $filas; $i++) {
                echo '<option value="' . $tasas[$i]["idTasaIva"] . '">' . $tasas[$i]['iva'] . '</option>';
            }
            echo '</select>';
            ?>
        </div>
        <div class="form-group row">
            <?php
            $link = Conectar::conexion();
            $qry = "SELECT MAX(siigo) maxsiigo FROM (SELECT MAX(codSiigo) siigo FROM distribucion  WHERE CodIva=3
                    union
                    SELECT MAX(codSiigo) siigo FROM prodpre  WHERE CodIva=3
                    union
                    SELECT MAX(codSiigo) siigo FROM servicios  WHERE CodIva=3
                    ) AS a";
            $stmt = $link->prepare($qry);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            ?>
            <label class="col-form-label col-2" for="codSiigo"><strong>Código Siigo</strong></label>
            <input type="text" name="codSiigo" id="codSiigo" class="form-control col-2"
                   onKeyPress="return aceptaNum(event)" value="<?= ($row['maxsiigo'] + 1) ?>" readonly/>
        </div>
        <div class="form-group row">
            <div class="col-1 text-center" >
                <button class="button" onclick="return Enviar(this.form)"><span>Continuar</span></button>
            </div>
            <div class="col-1 text-center" >
                <button class="button" type="reset"><span>Reiniciar</span></button>
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

