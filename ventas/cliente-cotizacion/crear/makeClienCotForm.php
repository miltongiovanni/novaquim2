<?php
include "../../../includes/valAcc.php";
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');

$cliExis = $_POST['cliExis'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <title>Creación de Clientes para Cotización</title>
    <meta charset="utf-8">
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
    <script src="../../../js/jquery-3.3.1.min.js"></script>
    <script src="../../../js/findCliente.js"></script>
</head>

<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo">
        <img src="../../../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2 w-25"><h4>CREACIÓN DE CLIENTES PARA COTIZACIÓN</h4></div>
    <form name="form2" method="POST" action="makeClienCot.php">
        <input type="hidden" name="cliExis" value="<?= $cliExis ?>">
        <?php
        if ($cliExis == 1) :
            ?>
            <div class="mb-3 row">
                <div class="col-4">
                    <label class="form-label" for="busClien"><strong>Cliente</strong></label>
                    <input type="text" class="form-control" id="busClien" name="busClien" onkeyup="findCliente()" required/>
                </div>
            </div>
            <div class="mb-3 row" id="myDiv">
            </div>
            <div class="row mb-3">
                <div class="col-1">
                    <button class="button" type="button" onclick="return Enviar(this.form)">
                        <span>Continuar</span></button>
                </div>
            </div>
        <?php
        else:
            ?>
            <div class=" row mb-3">
                <div class="col-3">
                    <label class="form-label" for="nomCliente"><strong>Cliente</strong></label>
                    <input type="text" class="form-control" name="nomCliente" id="nomCliente" required>
                </div>
                <div class="col-2">
                    <label class="form-label" for="ciudadCliente"><strong>Ciudad</strong></label>
                    <?php
                    $manager = new CiudadesOperaciones();
                    $ciudades = $manager->getCiudades();
                    $filas = count($ciudades);
                    echo '<select name="idCiudad" id="idCiudad" class="form-select"  required>';
                    for ($i = 0; $i < $filas; $i++) {
                        echo '<option value="' . $ciudades[$i]["idCiudad"] . '">' . $ciudades[$i]['ciudad'] . '</option>';
                    }
                    echo '</select>';
                    ?>
                </div>
                <div class="col-3">
                    <label class="form-label" for="dirCliente"><strong>Dirección</strong></label>
                    <input type="text" class="form-control" name="dirCliente" id="dirCliente" required>
                </div>
            </div>
            <div class="mb-3 row">
                <div class="col-2">
                    <label class="form-label" for="telCliente"><strong>Teléfono</strong></label>
                    <input type="text" class="form-control" name="telCliente" id="telCliente" maxlength="10" onkeydown="return aceptaNum(event)">
                </div>
                <div class="col-3">
                    <label class="form-label" for="emailCliente"><strong>Correo electrónico</strong></label>
                    <input type="email" class="form-control" name="emailCliente" id="emailCliente">
                </div>
                <div class="col-3">
                    <label class="form-label" for="idCatCliente"><strong>Actividad</strong></label>
                    <?php
                    $manager = new CategoriasCliOperaciones();
                    $categorias = $manager->getCatsCli();
                    $filas = count($categorias);
                    echo '<select name="idCatCliente" id="idCatCliente" class="form-select" required>';
                    echo '<option disabled selected value="">Seleccione una opción</option>';
                    for ($i = 0; $i < $filas; $i++) {
                        echo '<option value="' . $categorias[$i]["idCatClien"] . '">' . $categorias[$i]['desCatClien'] . '</option>';
                    }
                    echo '</select>';
                    ?>
                </div>
            </div>
            <div class="mb-3 row">
                <div class="col-2">
                    <label class="form-label" for="contactoCliente"><strong>Nombre Contacto</strong></label>
                    <input type="text" class="form-control" name="contactoCliente" id="contactoCliente" required>
                </div>
                <div class="col-2">
                    <label class="form-label" for="cargoContacto"><strong>Cargo Contacto</strong></label>
                    <input type="text" class="form-control" name="cargoContacto" id="cargoContacto" required>
                </div>
                <div class="col-2">
                    <label class="form-label" for="celCliente"><strong>Celular</strong></label>
                    <input type="text" class="form-control" name="celCliente" id="celCliente" maxlength="10" onkeydown="return aceptaNum(event)">
                </div>
                <div class="col-2">
                    <label class="form-label" for="codVendedor"><strong>Vendedor</strong></label>
                    <?php
                    $PersonalOperador = new PersonalOperaciones();
                    $personal = $PersonalOperador->getPersonal(true);
                    echo '<select name="codVendedor" id="codVendedor" class="form-select" required >';
                    echo '<option selected disabled value="">Seleccione una opción</option>';
                    for ($i = 0; $i < count($personal); $i++) {
                        echo '<option value="' . $personal[$i]["idPersonal"] . '">' . $personal[$i]['nomPersonal'] . '</option>';
                    }
                    echo '</select>';
                    ?>
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
        <?php
        endif;
        ?>
    </form>
    <div class="row">
        <div class="col-1">
            <button class="button1" id="back" onClick="history.back()"><span>VOLVER</span></button>
        </div>
    </div>
</div>
</body>
</html>

