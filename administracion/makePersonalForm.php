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
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <title>Creación de Personal</title>
    <meta charset="utf-8">
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
</head>

<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo">
        <img src="../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2"><h4>CREACIÓN DE PERSONAL</h4></div>
    <form name="form2" method="POST" action="makePerson.php">
        <div class="form-group row">
            <label class="col-form-label col-1 text-end" for="nomPersonal"><strong>Nombre</strong></label>
            <input type="text" class="form-control col-2" name="nomPersonal" id="nomPersonal" size=30
                   onkeydown="return aceptaLetra(event)" maxlength="30" required>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-1 text-end"
                   for="celPersonal"><strong>Celular</strong></label>
            <input type="text" class="form-control col-2" name="celPersonal" id="celPersonal" size=30
                   onkeydown="return aceptaNum(event)" maxlength="10">
        </div>
        <div class="form-group row">
            <label class="col-form-label col-1" for="emlPersonal"><strong>E-mail</strong></label>
            <input type="email" class="form-control col-2" id="emlPersonal" name="emlPersonal" size=30>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-1" for="activoPersonal"><strong>Estado</strong></label>
            <select class="form-control col-2" name="activoPersonal" id="activoPersonal" required>
                <?php
                $estadoPersonasOperador = new EstadosPersonasOperaciones();
                $estados = $estadoPersonasOperador->getEstadosPersonas();
                echo '<option value="1" selected>Activo</option>';
                for ($i = 0; $i < count($estados); $i++) {
                    if ($estados[$i]['idEstado'] != 1)
                        echo '<option value="' . $estados[$i]['idEstado'] . '">' . $estados[$i]['estadoPersona'] . '</option>';
                }
                ?>
            </select>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-1" for="areaPersonal"><strong>Área</strong></label>
            <select class="form-control col-2" name="areaPersonal" id="areaPersonal" required>
                <?php
                $areaPersonalOperador = new AreasPersonalOperaciones();
                $areas = $areaPersonalOperador->getAreasPersonal();
                echo '<option value="" disabled selected>----------------------------</option>';
                for ($i = 0; $i < count($areas); $i++) {
                    echo '<option value="' . $areas[$i]['idArea'] . '">' . $areas[$i]['area'] . '</option>';
                }
                ?>
            </select>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-1" for="cargoPersonal"><strong>Cargo</strong></label>
            <select class="form-control col-2" name="cargoPersonal" id="cargoPersonal" required>
                <?php
                $cargoPersonalOperador = new cargosPersonalOperaciones();
                $cargos = $cargoPersonalOperador->getCargosPersonal();
                echo '<option value="" disabled selected>----------------------------</option>';
                for ($i = 0; $i < count($areas); $i++) {
                    echo '<option value="' . $cargos[$i]['idCargo'] . '">' . $cargos[$i]['cargo'] . '</option>';
                }
                ?>
            </select>
        </div>
        <div class="form-group row">
            <div class="col-1 text-center">
                <button class="button" type="reset"><span>Reiniciar</span></button>
            </div>
            <div class="col-1 text-center">
                <button class="button" type="button"
                        onclick="return Enviar(this.form)"><span>Continuar</span></button>
            </div>
        </div>

    </form>
    <div class="row">
        <div class="col-1">
            <button class="button1" id="back"
                    onClick="history.back()">
                <span>VOLVER</span></button>
        </div>
    </div>
</div>
</body>

</html>