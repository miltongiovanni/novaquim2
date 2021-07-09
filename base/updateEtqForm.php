<?php
include "../includes/valAcc.php";
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$codEtiqueta = $_POST['codEtiqueta'];
$EtiquetaOperador = new EtiquetasOperaciones();
$envase = $EtiquetaOperador->getEtiqueta($codEtiqueta);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <title>Actualizar datos de Etiqueta</title>
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
</head>

<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo">
        <img src="../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2"><h4>ACTUALIZACIÓN DE ETIQUETAS</h4></div>
    <form id="form1" name="form1" method="post" action="updateEtq.php">
        <div class="form-group row">
            <label class="col-form-label col-1 text-end" for="codEtiqueta"><strong>Código</strong></label>
            <input type="text" class="form-control col-2" name="codEtiqueta" id="codEtiqueta" maxlength="50"
                   value="<?= $envase['codEtiqueta']; ?>" readonly>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-1 text-end" for="nomEtiqueta"><strong>Etiqueta</strong></label>
            <input type="text" class="form-control col-2" name="nomEtiqueta" id="nomEtiqueta"
                   value="<?= $envase['nomEtiqueta']; ?>" maxlength="50">
        </div>
        <div class="form-group row">
            <label class="col-form-label col-1 text-end" for="stockEtiqueta"><strong>Stock Etiqueta</strong></label>
            <input type="text" class="form-control col-2" name="stockEtiqueta" id="stockEtiqueta"
                   onkeydown="return aceptaNum(event)" value="<?= $envase['stockEtiqueta']; ?>">
            <input type="hidden" class="form-control col-2" name="codIva" id="codIva" value="3">
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
                    onClick="history.back()"><span>VOLVER</span></button>
        </div>
    </div>

</div>
</body>

</html>