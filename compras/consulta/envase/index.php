<?php
include "../../../includes/valAcc.php";
// Función para cargar las clases
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <title>Seleccionar Envase o Tapa a Consultar Compra</title>
<script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo">
        <img src="../../../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2 w-25"><h4>SELECCIONAR ENVASE O TAPA A CONSULTAR COMPRA</h4></div>
    <form id="form1" name="form1" method="post" action="listacompraxEnv.php">
        <div class="mb-3 row">
            <div class="col-3">
                <label class="form-label" for="idTapOEnv"><strong>Envase o tapa</strong></label>
                <select name="idTapOEnv" id="idTapOEnv" class="form-control" required>
                    <option selected disabled value="">Seleccione una opción</option>
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

        </div>
        <div class="row mb-3">
            <div class="col-1">
                <button class="button" type="button" onclick="return Enviar(this.form)">
                    <span>Continuar</span></button>
            </div>
        </div>
    </form>
    <div class="row mb-3">
        <div class="col-1">
            <button class="button1" onclick="history.back()">
                <span>VOLVER</span></button>
        </div>
    </div>
</div>
</body>
</html>
