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
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <title>Creación de Clientes</title>
    <meta charset="utf-8">
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
    <script src="../../../js/jquery-3.3.1.min.js"></script>
    <script>
        function nitClientes() {
            let tipo = document.getElementById("tipo_0").checked === true ? 1 : 2;
            let numero = document.getElementById("numero").value;
            $.ajax({
                url: '../../../includes/controladorVentas.php',
                type: 'POST',
                data: {
                    "action": 'nitCliente',
                    "tipo": tipo,
                    "numero": numero,
                },
                dataType: 'json',
                success: function (response) {
                    if(response.clienteExiste){
                        alerta('Cliente ya existe', 'warning', '../modificar/updateCliForm.php', '');
                    }else{
                        $("#nitCliente").val(response.nit);
                    }

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
        <img src="../../../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2 w-25">
        <h4>CREACIÓN DE CLIENTES</h4>
    </div>
    <form name="form2" method="POST" action="makeClien.php">
        <div class="mb-3 row ">
            <div class="col-2">
                <label class="form-label"><strong>Tipo NIT</strong></label>
                <div class="form-check-inline form-control" style="display: flex">
                    <label for="tipo_0" class="col-6 form-check-label" style="text-align: center">
                        <input type="radio" id="tipo_0" name="tipo" value="1" checked onchange="nitClientes()">&nbsp;&nbsp;Nit
                    </label>
                    <label for="tipo_1" class="col-6 form-check-label" style="text-align: center">
                        <input type="radio" id="tipo_1" name="tipo" value="2" onchange="nitClientes()">&nbsp;&nbsp;Cédula
                    </label>
                </div>
            </div>
            <div class="col-2">
                <label class="form-label" for="numero"><strong>Número</strong></label>
                <input type="text" class="form-control" name="numero" id="numero" onkeydown="return aceptaNum(event)" onkeyup="nitClientes()" required>
            </div>
            <div class="col-2">
                <label class="form-label" for="nitCliente"><strong>NIT</strong></label>
                <input type="text" class="form-control" name="nitCliente" id="nitCliente" onkeydown="return aceptaNum(event)" readOnly required>
            </div>
            <div class="col-4">
                <label class="form-label" for="nomCliente"><strong>Cliente</strong></label>
                <input type="text" class="form-control" name="nomCliente" id="nomCliente" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-2">
                <label class="form-label" for="telCliente"><strong>Teléfono</strong></label>
                <input type="text" class="form-control" name="telCliente" id="telCliente" maxlength="10" onkeydown="return aceptaNum(event)">
            </div>
            <div class="col-3">
                <label class="form-label" for="emailCliente"><strong>Correo electrónico</strong></label>
                <input type="email" class="form-control" name="emailCliente" id="emailCliente">
            </div>
            <div class="col-2">
                <label class="form-label" for="ciudadCliente"><strong>Ciudad</strong></label>
                <?php
                $manager = new CiudadesOperaciones();
                $ciudades = $manager->getCiudades();
                $filas = count($ciudades);
                echo '<select name="ciudadCliente" id="ciudadCliente" class="form-select"  required>';
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
            <div class="col-3">
                <label class="form-label" for="contactoCliente"><strong>Nombre Contacto</strong></label>
                <input type="text" class="form-control" name="contactoCliente" id="contactoCliente" required>
            </div>
            <div class="col-2">
                <label class="form-label" for="cargoCliente"><strong>Cargo Contacto</strong></label>
                <input type="text" class="form-control" name="cargoCliente" id="cargoCliente" required>
            </div>
            <div class="col-2">
                <label class="form-label" for="celCliente"><strong>Celular Contacto</strong></label>
                <input type="text" class="form-control" name="celCliente" id="celCliente" onkeydown="return aceptaNum(event)" maxlength="10" required>
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
                <label class="form-label" for="retIva"><strong>Autoret Iva</strong></label>
                <select name="retIva" id="retIva" class="form-select">
                    <option value="0" selected>No</option>
                    <option value="1">Si</option>
                </select>
            </div>
            <div class="col-2">
                <label class="form-label" for="retFte"><strong>Retefuente</strong></label>
                <select name="retFte" id="retFte" class="form-select">
                    <option value="0">No</option>
                    <option value="1" selected>Si</option>
                </select>
            </div>
            <div class="col-2">
                <label class="form-label" for="retIca"><strong>Autoret Ica</strong></label>
                <select name="retIca" id="retIca" class="form-select">
                    <option value="0" selected>No</option>
                    <option value="1">Si</option>
                </select>
            </div>
            <div class="col-4">
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
    </form>
    <div class="row">
        <div class="col-1">
            <button class="button1" id="back" onClick="history.back()"><span>VOLVER</span></button>
        </div>
    </div>
</div>
</body>
</html>

