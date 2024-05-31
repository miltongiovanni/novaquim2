<?php
include "../../../includes/valAcc.php";
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <title>Actualizar datos del Usuario</title>
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
</head>

<body>
<div id="contenedor" class="container-fluid">

    <div id="saludo1">
        <img src="../../../images/LogoNova.jpg" alt="novaquim" class="img-fluid mb-2"><h4>ACTUALIZACIÓN DE PERSONAL</h4></div>
    <?php
    $idPersonal = $_POST['idPersonal'];
    $manager = new PersonalOperaciones();
    $row = $manager->getPerson($idPersonal);
    ?>

    <form id="form1" name="form1" method="post" action="updatePerson.php">
        <input type="hidden" name="idPersonal" value="<?= $idPersonal ?>">
        <div class="form-group row">
            <div class="col-2 text-end">
                <label class="col-form-label " for="nomPersonal"><strong>Nombre</strong></label>
            </div>
            <div class="col-2 px-0">
                <input type="text" class="form-control" name="nomPersonal" id="nomPersonal" size=30
                       value="<?= $row['nomPersonal']; ?>" onkeydown="return aceptaLetra(event)" maxlength="30">
            </div>

        </div>
        <div class="form-group row">
            <div class="col-2 text-end">
                <label class="col-form-label " for="celPersonal"><strong>Celular</strong></label>
            </div>
            <div class="col-2 px-0">
                <input type="text" class="form-control " name="celPersonal" id="celPersonal" size=30
                       value="<?= $row['celPersonal']; ?>" onkeydown="return aceptaNum(event)" maxlength="30">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-2 text-end">
                <label class="col-form-label " for="emlPersonal"><b>Correo electrónico</b></label>
            </div>
            <div class="col-2 px-0">
                <input type="email" class="form-control " id="emlPersonal" name="emlPersonal" size=30
                       value="<?= $row['emlPersonal']; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-2 text-end">
                <label class="col-form-label " for="activoPersonal"><strong>Estado</strong></label>
            </div>
            <div class="col-2 px-0">
                <select class="form-select " name="activoPersonal" id="activoPersonal">
                    <?php
                    $estadoPersonasOperador = new EstadosPersonasOperaciones();
                    $estados = $estadoPersonasOperador->getEstadosPersonas();
                    echo '<option value="' . $row['activoPersonal'] . '" selected>' . $row['estadoPersona'] . '</option>';
                    for ($i = 0; $i < count($estados); $i++) {
                        if ($estados[$i]['idEstado'] != $row['activoPersonal'])
                            echo '<option value="' . $estados[$i]['idEstado'] . '">' . $estados[$i]['estadoPersona'] . '</option>';
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-2 text-end">
                <label class="col-form-label " for="areaPersonal"><strong>Área</strong></label>
            </div>
            <div class="col-2 px-0">
                <select class="form-select " name="areaPersonal" id="areaPersonal">
                    <?php
                    $areaPersonalOperador = new AreasPersonalOperaciones();
                    $areas = $areaPersonalOperador->getAreasPersonal();
                    echo '<option value="' . $row['areaPersonal'] . '" selected>' . $row['area'] . '</option>';
                    for ($i = 0; $i < count($areas); $i++) {
                        if ($areas[$i]['idArea'] != $row['areaPersonal'])
                            echo '<option value="' . $areas[$i]['idArea'] . '">' . $areas[$i]['area'] . '</option>';
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-2 text-end">
                <label class="col-form-label " for="cargoPersonal"><strong>Cargo</strong></label>
            </div>
            <div class="col-2 px-0">
                <select class="form-select " name="cargoPersonal" id="cargoPersonal">
                    <?php
                    $cargoPersonalOperador = new cargosPersonalOperaciones();
                    $cargos = $cargoPersonalOperador->getCargosPersonal();
                    echo '<option value="' . $row['cargoPersonal'] . '" selected>' . $row['cargo'] . '</option>';
                    for ($i = 0; $i < count($areas); $i++) {
                        if ($cargos[$i]['idCargo'] != $row['cargoPersonal'])
                            echo '<option value="' . $cargos[$i]['idCargo'] . '">' . $cargos[$i]['cargo'] . '</option>';
                    }
                    ?>
                </select>
            </div>
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
            <button class="button1" id="back" onClick="history.back()">
                <span>VOLVER</span></button>
        </div>
    </div>
</div>
</body>
</html>