<?php
include "../includes/valAcc.php";
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$idCliente = $_POST['idCliente'];
$clienteCotizacionOperador = new ClientesCotizacionOperaciones();
$cliente = $clienteCotizacionOperador->getCliente($idCliente);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <title>Actualizar datos del Cliente</title>
    <script src="../js/validar.js"></script>

</head>

<body>
<div id="contenedor">
    <div id="saludo"><strong>ACTUALIZACIÓN DE CLIENTE DE COTIZACIÓN</strong></div>
    <form id="form1" name="form1" method="post" action="updateClienCot.php">
        <input type="hidden" name="idCliente" value="<?= $cliente['idCliente'] ?>">
        <div class=" row ">
            <label class="col-form-label col-3 text-left mr-2" for="nomCliente"><strong>Cliente</strong></label>
            <label class="col-form-label col-1 text-left mx-3" for="ciudadCliente"><strong>Ciudad</strong></label>
            <label class="col-form-label col-3 text-left ml-2" for="dirCliente"><strong>Dirección</strong></label>
        </div>
        <div class="form-group row">
            <input type="text" class="form-control col-3 mr-2" name="nomCliente" id="nomCliente"
                   value="<?= $cliente['nomCliente'] ?>" required>
            <select name="idCiudad" id="idCiudad" class="form-control col-1 mx-3" required>
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
            <input type="text" class="form-control col-3 ml-2" name="dirCliente" id="dirCliente"
                   value="<?= $cliente['dirCliente'] ?>" required>
        </div>
        <div class="row">
            <label class="col-form-label col-2 text-left mr-2" for="telCliente"><strong>Teléfono</strong></label>
            <label class="col-form-label col-2 text-left mx-3" for="emailCliente"><strong>Correo
                    electrónico</strong></label>
            <label class="col-form-label col-3 text-left ml-2" for="idCatCliente"><strong>Actividad</strong></label>
        </div>
        <div class="form-group row">
            <input type="text" class="form-control col-2 mr-2" name="telCliente" id="telCliente" maxlength="10"
                   onKeyPress="return aceptaNum(event)" value="<?= $cliente['telCliente'] ?>">
            <input type="email" class="form-control col-2 mx-3" name="emailCliente" id="emailCliente"
                   value="<?= $cliente['emailCliente'] ?>">
            <select name="idCatCliente" id="idCatCliente" class="form-control col-3 ml-2" required>
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
        <div class="row">
            <label class="col-form-label col-2 text-left mr-2" for="contactoCliente"><strong>Nombre
                    Contacto</strong></label>
            <label class="col-form-label col-2 text-left mx-2" for="cargoContacto"><strong>Cargo
                    Contacto</strong></label>
            <label class="col-form-label col-1 text-left mx-2" for="cargoContacto"><strong>Celular</strong></label>
            <label class="col-form-label col-2 text-left ml-2" for="codVendedor"><strong>Vendedor</strong></label>
        </div>
        <div class="form-group row">
            <input type="text" class="form-control col-2 mr-2" name="contactoCliente" id="contactoCliente"
                   value="<?= $cliente['dirCliente'] ?>" required>
            <input type="text" class="form-control col-2 mx-2" name="cargoContacto" id="cargoContacto"
                   value="<?= $cliente['dirCliente'] ?>" required>
            <input type="text" class="form-control col-1 mx-2" name="celCliente" id="celCliente" maxlength="10"
                   onKeyPress="return aceptaNum(event)" value="<?= $cliente['celCliente'] ?>">
            <select name="codVendedor" id="codVendedor" class="form-control col-2 ml-2" required>
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
            <button class="button1" id="back" onClick="history.back()"><span>VOLVER</span></button>
        </div>
    </div>
</div>
</body>
</html>
