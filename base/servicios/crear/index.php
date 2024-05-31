<?php
include "../../../includes/valAcc.php";
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$servicioperador = new ServiciosOperaciones();
$lastservicio = $servicioperador->getLastServicio();
$lastservicio++;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <title>Creación de Servicios</title>
    <meta charset="utf-8">
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo">
        <img src="../../../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2 w-25"><h4>CREACIÓN DE SERVICIO</h4></div>
    <form name="form2" method="POST" action="makeServ.php">
        <div class="form-group row">
            <div class="col-2 text-end">
                <label class="col-form-label " for="idServicio"><strong>Código</strong></label>
            </div>
            <div class="col-2 px-0">
                <input type="text" class="form-control " name="idServicio" id="idServicio" size=30 maxlength="30"
                       value="<?= $lastservicio ?>" readonly>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-2 text-end">
                <label class="col-form-label " for="desServicio"><strong>Descripción Servicio</strong></label>
            </div>
            <div class="col-2 px-0">
                <input type="text" class="form-control " name="desServicio" id="desServicio"
                       onkeydown="return aceptaLetra(event)" required>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-2 text-end">
                <label class="col-form-label " for="codIva"><strong>Iva</strong></label>
            </div>
            <div class="col-2 px-0">
                <?php
                $manager = new TasaIvaOperaciones();
                $tasas = $manager->getTasasIva();
                $filas = count($tasas);
                echo '<select name="codIva" id="codIva" class="form-control " required>';
                echo '<option selected disabled value="">-----------------------------</option>';
                for ($i = 0; $i < $filas; $i++) {
                    echo '<option value="' . $tasas[$i]["idTasaIva"] . '">' . $tasas[$i]['iva'] . '</option>';
                }
                echo '</select>';
                ?>
            </div>
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
            <div class="col-2 text-end">
                <label class="col-form-label " for="codSiigo"><strong>Código Siigo</strong></label>
            </div>
            <div class="col-2 px-0">
                <input type="text" name="codSiigo" id="codSiigo" class="form-control "
                       onkeydown="return aceptaNum(event)" value="<?= ($row['maxsiigo'] + 1) ?>"/>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-1 text-center">
                <button class="button" type="reset"><span>Reiniciar</span></button>
            </div>
            <div class="col-1 text-center">
                <button class="button" type="button" onclick="return Enviar(this.form)"><span>Continuar</span></button>
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

