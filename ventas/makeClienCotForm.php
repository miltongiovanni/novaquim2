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
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <title>Creación de Clientes para Cotización</title>
    <meta charset="utf-8">
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/findCliente.js"></script>
</head>

<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo">
        <img src="../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2 w-25"><h4>CREACIÓN DE CLIENTES PARA COTIZACIÓN</h4></div>
    <form name="form2" method="POST" action="makeClienCot.php">
        <input type="hidden" name="cliExis" value="<?= $cliExis ?>">
        <?php
        if ($cliExis == 1) :
            ?>
            <div class="form-group row">
                <label class="col-form-label col-2" for="busClien"><strong>Cliente</strong></label>
                <input type="text" class="form-control col-2" id="busClien" name="busClien" onkeyup="findCliente()"
                       required/>
            </div>
            <div class="form-group row" id="myDiv">
            </div>
            <div class="row form-group">
                <div class="col-1">
                    <button class="button" type="button" onclick="return Enviar(this.form)">
                        <span>Continuar</span></button>
                </div>
            </div>
        <?php
        else:
            ?>
            <div class=" row ">
                <label class="col-form-label col-3 text-start me-2" for="nomCliente"><strong>Cliente</strong></label>
                <label class="col-form-label col-1 text-start mx-3" for="ciudadCliente"><strong>Ciudad</strong></label>
                <label class="col-form-label col-3 text-start ms-2" for="dirCliente"><strong>Dirección</strong></label>
            </div>
            <div class="form-group row">
                <input type="text" class="form-control col-3 me-2" name="nomCliente" id="nomCliente" required>
                <?php
                $manager = new CiudadesOperaciones();
                $ciudades = $manager->getCiudades();
                $filas = count($ciudades);
                echo '<select name="idCiudad" id="idCiudad" class="form-control col-1 mx-3"  required>';
                for ($i = 0; $i < $filas; $i++) {
                    echo '<option value="' . $ciudades[$i]["idCiudad"] . '">' . $ciudades[$i]['ciudad'] . '</option>';
                }
                echo '</select>';
                ?>
                <input type="text" class="form-control col-3 ms-2" name="dirCliente" id="dirCliente" required>
            </div>
            <div class="row">
                <label class="col-form-label col-2 text-start me-2" for="telCliente"><strong>Teléfono</strong></label>
                <label class="col-form-label col-2 text-start mx-3" for="emailCliente"><strong>Correo
                        electrónico</strong></label>
                <label class="col-form-label col-3 text-start ms-2" for="idCatCliente"><strong>Actividad</strong></label>
            </div>
            <div class="form-group row">
                <input type="text" class="form-control col-2 me-2" name="telCliente" id="telCliente" maxlength="10"
                       onkeydown="return aceptaNum(event)">
                <input type="email" class="form-control col-2 mx-3" name="emailCliente" id="emailCliente">
                <?php
                $manager = new CategoriasCliOperaciones();
                $categorias = $manager->getCatsCli();
                $filas = count($categorias);
                echo '<select name="idCatCliente" id="idCatCliente" class="form-control col-3 ms-2" required>';
                echo '<option disabled selected value="">-----------------------------</option>';
                for ($i = 0; $i < $filas; $i++) {
                    echo '<option value="' . $categorias[$i]["idCatClien"] . '">' . $categorias[$i]['desCatClien'] . '</option>';
                }
                echo '</select>';
                ?>
            </div>
            <div class="row">
                <label class="col-form-label col-2 text-start me-2" for="contactoCliente"><strong>Nombre
                        Contacto</strong></label>
                <label class="col-form-label col-2 text-start mx-2" for="cargoContacto"><strong>Cargo
                        Contacto</strong></label>
                <label class="col-form-label col-1 text-start mx-2" for="cargoContacto"><strong>Celular</strong></label>
                <label class="col-form-label col-2 text-start ms-2" for="codVendedor"><strong>Vendedor</strong></label>
            </div>
            <div class="form-group row">
                <input type="text" class="form-control col-2 me-2" name="contactoCliente" id="contactoCliente" required>
                <input type="text" class="form-control col-2 mx-2" name="cargoContacto" id="cargoContacto" required>
                <input type="text" class="form-control col-1 mx-2" name="celCliente" id="celCliente" maxlength="10"
                       onkeydown="return aceptaNum(event)">
                <?php
                $PersonalOperador = new PersonalOperaciones();
                $personal = $PersonalOperador->getPersonal(true);
                echo '<select name="codVendedor" id="codVendedor" class="form-control col-2 ms-2" required >';
                echo '<option selected disabled value="">-----------------------------</option>';
                for ($i = 0; $i < count($personal); $i++) {
                    echo '<option value="' . $personal[$i]["idPersonal"] . '">' . $personal[$i]['nomPersonal'] . '</option>';
                }
                echo '</select>';
                ?>
            </div>
            <div class="form-group row">
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

