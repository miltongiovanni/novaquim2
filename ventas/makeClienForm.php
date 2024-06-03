<?php
include "../../../includes/valAcc.php";
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <title>Creación de Clientes</title>
    <meta charset="utf-8">
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script>

        //var idCatProd = $('idCatProd').value;

        function nitClientes() {
            let tipo = document.getElementById("tipo_0").checked === true ? 1 : 2;
            let numero = document.getElementById("numero").value;
            $.ajax({
                url: '../includes/controladorVentas.php',
                type: 'POST',
                data: {
                    "action": 'nitCliente',
                    "tipo": tipo,
                    "numero": numero,
                },
                dataType: 'text',
                success: function (nitValid) {
                    $("#nitCliente").val(nitValid);
                },
                error: function () {
                    alert("Vous avez un GROS problème");
                }
            });
        }
    </script>
</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo">
        <img src="../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2 w-25"><h4>CREACIÓN DE CLIENTES</h4></div>
    <form name="form2" method="POST" action="makeClien.php">
        <div class=" row ">
            <label class="form-label col-2 text-start mx-2"><strong>Tipo NIT</strong></label>
            <label class="form-label col-2 text-start mx-2"
                   for="numero"><strong>Número</strong></label>
            <label class="form-label col-2 text-start mx-2" for="nitCliente"><strong>NIT</strong></label>
            <label class="form-label col-3 text-start mx-2" for="nomCliente"><strong>Cliente</strong></label>
        </div>
        <div class="mb-3 row">
            <div class="col-2 form-check-inline form-control mx-2" style="display: flex">
                <label for="tipo_0" class="col-6 form-check-label" style="text-align: center">
                    <input type="radio" id="tipo_0" name="tipo" value="1" checked onchange="nitClientes()">&nbsp;&nbsp;Nit
                </label>
                <label for="tipo_1" class="col-6 form-check-label" style="text-align: center">
                    <input type="radio" id="tipo_1" name="tipo" value="2" onchange="nitClientes()">&nbsp;&nbsp;Cédula
                </label>
            </div>
            <input type="text" class="form-control col-2 mx-2" name="numero" id="numero"
                   onkeydown="return aceptaNum(event)"
                   onkeyup="nitClientes()" required>
            <input type="text" class="form-control col-2 mx-2" name="nitCliente" id="nitCliente"
                   onkeydown="return aceptaNum(event)" readOnly required>
            <input type="text" class="form-control col-3 mx-2" name="nomCliente" id="nomCliente" required>
        </div>
        <div class="row">
            <label class="form-label col-2 text-start mx-2" for="telCliente"><strong>Teléfono</strong></label>
            <label class="form-label col-2 text-start mx-2" for="emailCliente"><strong>Correo
                    electrónico</strong></label>
            <label class="form-label col-2 text-start mx-2" for="ciudadCliente"><strong>Ciudad</strong></label>
            <label class="form-label col-3 text-start mx-2" for="dirCliente"><strong>Dirección</strong></label>
        </div>
        <div class="mb-3 row">
            <input type="text" class="form-control col-2 mx-2" name="telCliente" id="telCliente" maxlength="10"
                   onkeydown="return aceptaNum(event)">
            <input type="email" class="form-control col-2 mx-2" name="emailCliente" id="emailCliente">
            <?php
            $manager = new CiudadesOperaciones();
            $ciudades = $manager->getCiudades();
            $filas = count($ciudades);
            echo '<select name="ciudadCliente" id="ciudadCliente" class="form-control col-2 mx-2"  required>';
            for ($i = 0; $i < $filas; $i++) {
                echo '<option value="' . $ciudades[$i]["idCiudad"] . '">' . $ciudades[$i]['ciudad'] . '</option>';
            }
            echo '</select>';
            ?>
            <input type="text" class="form-control col-3 mx-2" name="dirCliente" id="dirCliente" required>
        </div>
        <div class="row">
            <label class="form-label col-2 text-start mx-2" for="contactoCliente"><strong>Nombre
                    Contacto</strong></label>
            <label class="form-label col-2 text-start mx-2" for="cargoCliente"><strong>Cargo
                    Contacto</strong></label>
            <label class="form-label col-2 text-start mx-2" for="celCliente"><strong>Celular
                    Contacto</strong></label>
            <label class="form-label col-3 text-start mx-2" for="idCatCliente"><strong>Actividad</strong></label>
        </div>
        <div class="mb-3 row">
            <input type="text" class="form-control col-2 mx-2" name="contactoCliente" id="contactoCliente" required>
            <input type="text" class="form-control col-2 mx-2" name="cargoCliente" id="cargoCliente" required>
            <input type="text" class="form-control col-2 mx-2" name="celCliente" id="celCliente"
                   onkeydown="return aceptaNum(event)" maxlength="10" required>
            <?php
            $manager = new CategoriasCliOperaciones();
            $categorias = $manager->getCatsCli();
            $filas = count($categorias);
            echo '<select name="idCatCliente" id="idCatCliente" class="form-control col-3 mx-2" required>';
            echo '<option disabled selected value="">-----------------------------</option>';
            for ($i = 0; $i < $filas; $i++) {
                echo '<option value="' . $categorias[$i]["idCatClien"] . '">' . $categorias[$i]['desCatClien'] . '</option>';
            }
            echo '</select>';
            ?>
        </div>
        <div class="row">
            <label class="form-label col-2 text-start mx-2" for="retIva"><strong>Autoret Iva</strong></label>
            <label class="form-label col-2 text-start mx-2" for="retFte"><strong>Retefuente</strong></label>
            <label class="form-label col-2 text-start mx-2" for="retIca"><strong>Autoret Ica</strong></label>
            <label class="form-label col-3 text-start mx-2" for="codVendedor"><strong>Vendedor</strong></label>

        </div>
        <div class="mb-3 row">

            <select name="retIva" id="retIva" class="form-control col-2 mx-2">
                <option value="0" selected>No</option>
                <option value="1">Si</option>
            </select>

            <select name="retFte" id="retFte" class="form-control col-2 mx-2">
                <option value="0">No</option>
                <option value="1" selected>Si</option>
            </select>
            <select name="retIca" id="retIca" class="form-control col-2 mx-2">
                <option value="0" selected>No</option>
                <option value="1">Si</option>
            </select>

            <?php
            $PersonalOperador = new PersonalOperaciones();
            $personal = $PersonalOperador->getPersonal(true);
            echo '<select name="codVendedor" id="codVendedor" class="form-control col-3 mx-2" required >';
            echo '<option selected disabled value="">-----------------------------</option>';
            for ($i = 0; $i < count($personal); $i++) {
                echo '<option value="' . $personal[$i]["idPersonal"] . '">' . $personal[$i]['nomPersonal'] . '</option>';
            }
            echo '</select>';
            ?>
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

