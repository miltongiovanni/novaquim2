<?php
include "../../../includes/valAcc.php";
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$idCliente = $_POST['idCliente'];
$clienteCotizacionOperador = new ClientesCotizacionOperaciones();
$cliente = $clienteCotizacionOperador->getCliente($idCliente);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <title>Actualizar datos del Cliente</title>
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>

</head>

<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo">
        <img src="../../../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2 w-25"><h4>ACTUALIZACIÓN DE CLIENTE DE COTIZACIÓN</h4></div>
    <form id="form1" name="form1" method="post" action="updateClienCot.php">
        <input type="hidden" name="idCliente" value="<?= $cliente['idCliente'] ?>">
        <div class=" row mb-3 ">
            <div class="col-3">
                <label class="form-label" for="nomCliente"><strong>Cliente</strong></label>
                <input type="text" class="form-control" name="nomCliente" id="nomCliente"
                       value="<?= $cliente['nomCliente'] ?>" required>
            </div>
            <div class="col-2">
                <label class="form-label" for="idCiudad"><strong>Ciudad</strong></label>
                <select name="idCiudad" id="idCiudad" class="form-select" required>
                    <option selected value="<?= $cliente['idCiudad'] ?>"><?= $cliente['ciudad'] ?></option>
                    <?php
                    $manager = new CiudadesOperaciones();
                    $ciudades = $manager->getCiudades();
                    $filas = count($ciudades);
                    for ($i = 0; $i < $filas; $i++) {
                        if ($ciudades[$i]["idCiudad"] != $cliente['idCiudad']) {
                            echo '<option value="' . $ciudades[$i]["idCiudad"] . '">' . $ciudades[$i]['ciudad'] . '</option>';
                        }
                    }
                    echo '';
                    ?>
                </select>
            </div>
            <div class="col-3">
                <label class="form-label" for="dirCliente"><strong>Dirección</strong></label>
                <input type="text" class="form-control" name="dirCliente" id="dirCliente"
                       value="<?= $cliente['dirCliente'] ?>" required>
            </div>
        </div>
        <div class="mb-3 row">
            <div class="col-2">
                <label class="form-label" for="telCliente"><strong>Teléfono</strong></label>
                <input type="text" class="form-control" name="telCliente" id="telCliente" maxlength="10"
                       onkeydown="return aceptaNum(event)" value="<?= $cliente['telCliente'] ?>">
            </div>
            <div class="col-3">
                <label class="form-label" for="emailCliente"><strong>Correo electrónico</strong></label>
                <input type="email" class="form-control" name="emailCliente" id="emailCliente"
                       value="<?= $cliente['emailCliente'] ?>">
            </div>
            <div class="col-3">
                <label class="form-label" for="idCatCliente"><strong>Actividad</strong></label>
                <select name="idCatCliente" id="idCatCliente" class="form-select" required>
                    <option selected value="<?= $cliente['idCatCliente'] ?>"><?= $cliente['desCatClien'] ?></option>
                    <?php
                    $manager = new CategoriasCliOperaciones();
                    $categorias = $manager->getCatsCli();
                    $filas = count($categorias);
                    for ($i = 0; $i < $filas; $i++) {
                        if ($categorias[$i]["idCatClien"] != $cliente['idCatCliente']) {
                            echo '<option value="' . $categorias[$i]["idCatClien"] . '">' . $categorias[$i]['desCatClien'] . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="mb-3 row">
            <div class="col-2">
                <label class="form-label" for="contactoCliente"><strong>Nombre Contacto</strong></label>
                <input type="text" class="form-control" name="contactoCliente" id="contactoCliente"
                       value="<?= $cliente['contactoCliente'] ?>" required>
            </div>
            <div class="col-2">
                <label class="form-label" for="cargoContacto"><strong>Cargo Contacto</strong></label>
                <input type="text" class="form-control" name="cargoContacto" id="cargoContacto"
                       value="<?= $cliente['cargoContacto'] ?>" required>
            </div>
            <div class="col-2">
                <label class="form-label" for="cargoContacto"><strong>Celular</strong></label>
                <input type="text" class="form-control" name="celCliente" id="celCliente" maxlength="10"
                       onkeydown="return aceptaNum(event)" value="<?= $cliente['celCliente'] ?>">
            </div>
            <div class="col-2">
                <label class="form-label" for="codVendedor"><strong>Vendedor</strong></label>
                <select name="codVendedor" id="codVendedor" class="form-select" required>
                    <option selected value="<?= $cliente['codVendedor'] ?>"><?= $cliente['nomPersonal'] ?></option>
                    <?php
                    $PersonalOperador = new PersonalOperaciones();
                    $personal = $PersonalOperador->getPersonal(true);
                    for ($i = 0; $i < count($personal); $i++) {
                        if ($personal[$i]["idPersonal"] != $cliente['codVendedor']) {
                            echo '<option value="' . $personal[$i]["idPersonal"] . '">' . $personal[$i]['nomPersonal'] . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>
        </div>

        <div class="mb-3 row">
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
            <button class="button1" id="back" onClick="history.back()"><span>VOLVER</span></button>
        </div>
    </div>
</div>
</body>
</html>
