<?php
include "../../../includes/valAcc.php";
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$codEnvase = $_POST['codEnvase'];
$EnvaseOperador = new EnvasesOperaciones();
$envase = $EnvaseOperador->getEnvase($codEnvase);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <title>Actualizar datos de Envase</title>
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
</head>

<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo">
        <img src="../../../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2 w-25"><h4>ACTUALIZACIÓN DE ENVASE</h4></div>
    <form id="form1" name="form1" method="post" action="updateEnv.php">
        <div class="form-group row">
            <div class="col-1 text-end">
                <label class="col-form-label " for="codEnvase"><strong>Código</strong></label>
            </div>
            <div class="col-2 px-0">
                <input type="text" class="form-control " name="codEnvase" id="codEnvase" maxlength="50"
                       value="<?= $envase['codEnvase']; ?>" readonly>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-1 text-end">
                <label class="col-form-label " for="nomEnvase"><strong>Envase</strong></label>
            </div>
            <div class="col-2 px-0">
                <input type="text" class="form-control " name="nomEnvase" id="nomEnvase"
                       value="<?= $envase['nomEnvase']; ?>" maxlength="50">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-1 text-end">
                <label class="col-form-label " for="stockEnvase"><strong>Stock Envase</strong></label>
            </div>
            <div class="col-2 px-0">
                <input type="text" class="form-control " name="stockEnvase" id="stockEnvase"
                       onkeydown="return aceptaNum(event)" value="<?= $envase['stockEnvase']; ?>">
                <input type="hidden" name="codIva" id="codIva" value="3">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-1 text-center">
                <button class="button" type="reset"><span>Reiniciar</span></button>
            </div>
            <div class="col-1 text-center">
                <button class="button" type="button"
                        onclick="return Enviar(this.form)"><span>Continuar</span>
                </button>
            </div>
        </div>
    </form>
    <div class="row">
        <div class="col-1">
            <button class="button1" id="back"
                    onClick="history.back()"><span>VOLVER</span></button>
        </div>
    </div>
</div>
</body>

</html>