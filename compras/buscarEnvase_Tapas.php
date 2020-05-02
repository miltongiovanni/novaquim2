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
<link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
<head>
    <meta charset="utf-8">
    <title>Seleccionar Envase o Tapa a Consultar Compra</title>
    <script src="../js/validar.js"></script>
</head>
<body>
<div id="contenedor">
    <div id="saludo"><strong>SELECCIONAR ENVASE O TAPA A CONSULTAR COMPRA</strong></div>
    <form id="form1" name="form1" method="post" action="listacompraxEnv.php">
        <div class="form-group row">
            <label class="col-form-label col-1" for="idTapOEnv"><strong>Envase o tapa</strong></label>
            <select name="idTapOEnv" id="idTapOEnv" class="form-control col-2">
                <option selected disabled value="">-----------------------------</option>
                <?php
                $EnvasesOperador = new EnvasesOperaciones();
                $envases = $EnvasesOperador->getEnvases();
                $productos=[];
                for($i=0;$i<count($envases);$i++){
                    $productos[$i]['codigo']= $envases[$i]['codEnvase'];
                    $productos[$i]['descripcion']= $envases[$i]['nomEnvase'];
                }

                $TapasOperador = new TapasOperaciones();
                $tapas = $TapasOperador->getTapas();
                for($j=0;$j<count($tapas);$j++){
                    $productos[$i]['codigo']= $tapas[$j]['codTapa'];
                    $productos[$i]['descripcion']= $tapas[$j]['tapa'];
                    $i++;
                }
                $filas = count($productos);
                for ($i = 0; $i < $filas; $i++) {
                    echo '<option value="' . $productos[$i]["codigo"] . '">' . $productos[$i]['descripcion'] . '</option>';
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
            <button class="button1" onclick="history.back()">
                <span>VOLVER</span></button>
        </div>
    </div>
</div>
</body>
</html>
