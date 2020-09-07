<?php
include "../includes/valAcc.php";
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
if (isset($_POST['idEnvDis'])) {
    $idEnvDis = $_POST['idEnvDis'];
}
else{
    if(isset($_SESSION['idEnvDis'])){
        $idEnvDis = $_SESSION['idEnvDis'];
        unset($_SESSION['idEnvDis']);
    }
}


$relEnvDisOperador = new RelEnvDisOperaciones();
$relacion = $relEnvDisOperador->getRelEnvDis($idEnvDis);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Relación Envase con Productos de Distribución</title>
    <meta charset="utf-8">
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script  src="../js/validar.js"></script>
</head>
<body>
<div id="contenedor">
    <div id="saludo"><strong>ACTUALIZACIÓN RELACIÓN DE ENVASE CON PRODUCTOS DE DISTRIBUCIÓN</strong></div>
    <form method="post" action="updateRelEnvDis.php" name="form1">
        <input id="idEnvDis" name="idEnvDis" type="hidden" value="<?= $idEnvDis ?>">
        <div class="form-group row">
            <label class="col-form-label col-2" for="idDis"><strong>Producto de Distribución</strong></label>
            <select name="idDis" id="idDis" class="form-control col-2" required>
                <option selected value="<?= $relacion['idDistribucion'] ?>"><?= $relacion['producto'] ?></option>
                <?php
                $ProductoDistribucionOperador = new ProductosDistribucionOperaciones();
                $productos = $ProductoDistribucionOperador->getProductosDistribucion(true);
                $filas = count($productos);
                for ($i = 0; $i < $filas; $i++) {
                    if ($relacion['idDistribucion'] != $productos[$i]["idDistribucion"]) {
                        echo '<option value="' . $productos[$i]["idDistribucion"] . '">' . $productos[$i]['producto'] . '</option>';
                    }
                }
                ?>
            </select>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-2" for="idEnv"><strong>Envase</strong></label>
            <select name="idEnv" id="idEnv" class="form-control col-2" required>
                <option selected value="<?= $relacion['codEnvase'] ?>"><?= $relacion['nomEnvase'] ?></option>
                <?php
                $EnvasesOperador = new EnvasesOperaciones();
                $envases = $EnvasesOperador->getEnvases();
                $filas = count($envases);
                for ($i = 0; $i < $filas; $i++) {
                    if ($relacion['codEnvase'] != $envases[$i]["codEnvase"]) {
                        echo '<option value="' . $envases[$i]["codEnvase"] . '">' . $envases[$i]['nomEnvase'] . '</option>';
                    }
                }
                ?>
            </select>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-2" for="idTapa"><strong>Tapa</strong></label>
            <select name="idTapa" id="idTapa" class="form-control col-2" required>
                <option selected value="<?= $relacion['codTapa'] ?>"><?= $relacion['tapa'] ?></option>
                <?php
                $TapasOperador = new TapasOperaciones();
                $tapas = $TapasOperador->getTapas();
                $filas = count($tapas);
                for ($i = 0; $i < $filas; $i++) {
                    if ($relacion['codTapa'] != $tapas[$i]["codTapa"]) {
                        echo '<option value="' . $tapas[$i]["codTapa"] . '">' . $tapas[$i]['tapa'] . '</option>';
                    }
                }
                ?>
            </select>
        </div>
        <div class="row form-group">
            <div class="col-1">
                <button class="button" onclick="return Enviar(this.form)"><span>Continuar</span></button>
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
	   