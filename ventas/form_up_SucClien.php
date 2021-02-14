<?php
include "../includes/valAcc.php";
// On enregistre notre autoload.
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
foreach ($_POST as $nombre_campo => $valor) {
    ${$nombre_campo} = $valor;
    if (is_array($valor)) {
        //echo $nombre_campo.print_r($valor).'<br>';
    } else {
        //echo $nombre_campo. '=' .${$nombre_campo}.'<br>';
    }
}
$clienteSucursalOperador = new ClientesSucursalOperaciones();
$sucursal = $clienteSucursalOperador->getSucursalCliente($idCliente, $idSucursal);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Modificar Sucursal </title>
    <meta charset="utf-8">
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
</head>
<body>
<div id="contenedor">
    <div id="saludo1"><strong>ACTUALIZACIÓN DE SUCURSAL POR CLIENTE</strong></div>
    <form name="form2" method="POST" action="update_sucursal.php">
        <input name="idCliente" id="idCliente" type="hidden" value="<?= $idCliente ?>">
        <input name="idSucursal" id="idSucursal" type="hidden" value="<?= $idSucursal ?>">
        <div class=" row ">
            <label class="col-form-label col-3 text-left mx-2" for="nomSucursal"><strong>Cliente</strong></label>
            <label class="col-form-label col-1 text-left mx-2" for="telSucursal"><strong>Teléfono</strong></label>
            <label class="col-form-label col-3 text-left mx-2" for="dirSucursal"><strong>Dirección</strong></label>
            <label class="col-form-label col-2 text-left mx-2" for="ciudadSucursal"><strong>Ciudad</strong></label>
        </div>
        <div class="form-group row">
            <input type="text" class="form-control col-3 mx-2" name="nomSucursal" id="nomSucursal"
                   value="<?= $sucursal['nomSucursal'] ?>" required>
            <input type="text" class="form-control col-1 mx-2" name="telSucursal" id="telSucursal" maxlength="10"
                   value="<?= $sucursal['telSucursal'] ?>" onKeyPress="return aceptaNum(event)">
            <input type="text" class="form-control col-3 mx-2" name="dirSucursal" id="dirSucursal"
                   value="<?= $sucursal['dirSucursal'] ?>" required>
            <select name="ciudadSucursal" id="ciudadSucursal" class="form-control col-2 mx-2" required>
                <option selected value="<?= $sucursal['idCiudad'] ?>"><?= $sucursal['ciudad'] ?></option>
                <?php
                $manager = new CiudadesOperaciones();
                $ciudades = $manager->getCiudades();
                $filas = count($ciudades);
                for ($i = 0; $i < $filas; $i++) {
                    if ($ciudades[$i]["idCiudad"] != 1) {
                        echo '<option value="' . $ciudades[$i]["idCiudad"] . '">' . $ciudades[$i]['ciudad'] . '</option>';
                    }
                }
                ?>
            </select>
        </div>
        <div class="form-group row mt-3">
            <div class="col-2 text-center">
                <button class="button" type="button" onclick="return Enviar(this.form)"><span>Actualizar sucursal</span>
                </button>
            </div>
        </div>
    </form>
</div>
</body>
</html>