<?php
include "../../../includes/valAcc.php";
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$idCliente = $_POST['idCliente'];
$_SESSION['idCliente'] = $idCliente;
$clienteOperador = new ClientesOperaciones();
$cliente = $clienteOperador->getCliente($idCliente);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Actualizar datos del Cliente</title>
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../../../css/datatables.css">
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
    <script src="../../../js/jquery-3.3.1.min.js"></script>
    <script src="../../../js/datatables.js"></script>
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
                dataType: 'text',
                success: function (nitValid) {
                    $("#nitCliente").val(nitValid);
                },
                error: function () {
                    alert("Vous avez un GROS problème");
                }
            });
        }

        $(document).ready(function () {
            let idCliente = document.getElementById("idCliente").value;
            $('#example').DataTable({
                "columns": [
                    {
                        "data": "idSucursal",
                    },
                    {
                        "data": "nomSucursal",
                        "className": 'dt-body-left',
                    },
                    {
                        "data": "telSucursal",
                    },
                    {
                        "data": "dirSucursal",
                        "className": 'dt-body-left',
                    },
                    {
                        "data": "ciudad",
                        "className": 'dt-body-left',
                    },
                ],
                "columnDefs":
                    [{
                        "targets": [0, 2],
                        "className": 'dt-body-center'
                    }
                    ],
                "paging": false,
                "ordering": false,
                "info": false,
                "searching": false,
                "lengthMenu": [[20, 50, 100, -1], [20, 50, 100, "All"]],
                "language": {
                    "emptyTable": "No hay datos disponibles",
                    "lengthMenu": "Mostrando _MENU_ datos por página",
                    "zeroRecords": "Lo siento no encontró nada",
                    "info": "Mostrando página _PAGE_ de _PAGES_",
                    "infoEmpty": "No hay datos disponibles",
                    "search": "Búsqueda:",
                    "paginate": {
                        "first": "Primero",
                        "last": "Último",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    },
                    "infoFiltered": "(Filtrado de _MAX_ en total)"

                },
                "ajax": "../ajax/listaSucursalesCliente.php?idCliente=" + idCliente
            });
        });
    </script>
</head>

<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo1">
        <img src="../../../images/LogoNova.jpg" alt="novaquim" class="img-fluid mb-2"><h4>ACTUALIZACIÓN DE CLIENTE</h4></div>
    <form name="form2" method="POST" action="updateClien.php">
        <input name="idCliente" id="idCliente" type="hidden" value="<?= $idCliente ?>">
        <div class="row mb-3 ">
            <div class="col-2">
                <label class="form-label"><strong>Tipo</strong></label>
                <div class="form-check-inline form-control d-flex">
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
                <input type="text" class="form-control" name="numero" id="numero" onkeydown="return aceptaNum(event)" onkeyup="nitClientes()">
            </div>
            <div class="col-2">
                <label class="form-label" for="nitCliente"><strong>NIT</strong></label>
                <input type="text" class="form-control" name="nitCliente" id="nitCliente" value="<?= $cliente['nitCliente'] ?>" onkeydown="return aceptaNum(event)" readOnly required>
            </div>
            <div class="col-4">
                <label class="form-label" for="nomCliente"><strong>Cliente</strong></label>
                <input type="text" class="form-control" name="nomCliente" id="nomCliente" value="<?= $cliente['nomCliente'] ?>" required>
            </div>
        </div>
        <div class="mb-3 row">
            <div class="col-2">
                <label class="form-label" for="telCliente"><strong>Teléfono</strong></label>
                <input type="text" class="form-control" name="telCliente" id="telCliente" maxlength="10" onkeydown="return aceptaNum(event)" value="<?= $cliente['telCliente'] ?>">
            </div>
            <div class="col-3">
                <label class="form-label" for="emailCliente"><strong>Correo electrónico</strong></label>
                <input type="email" class="form-control" name="emailCliente" id="emailCliente" value="<?= $cliente['emailCliente'] ?>">
            </div>
            <div class="col-2">
                <label class="form-label" for="ciudadCliente"><strong>Ciudad</strong></label>
                <select name="ciudadCliente" id="ciudadCliente" class="form-select" required>
                    <option selected value="<?= $cliente['ciudadCliente'] ?>"><?= $cliente['ciudad'] ?></option>
                    <?php
                    $manager = new CiudadesOperaciones();
                    $ciudades = $manager->getCiudades();
                    $filas = count($ciudades);
                    for ($i = 0; $i < $filas; $i++) {
                        if ($ciudades[$i]["idCiudad"] != $cliente['ciudadCliente']) {
                            echo '<option value="' . $ciudades[$i]["idCiudad"] . '">' . $ciudades[$i]['ciudad'] . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="col-3">
                <label class="form-label" for="dirCliente"><strong>Dirección</strong></label>
                <input type="text" class="form-control" name="dirCliente" id="dirCliente" value="<?= $cliente['dirCliente'] ?>" required>
            </div>
        </div>
        <div class="mb-3 row">
            <div class="col-3">
                <label class="form-label" for="contactoCliente"><strong>Nombre Contacto</strong></label>
                <input type="text" class="form-control" name="contactoCliente" id="contactoCliente" value="<?= $cliente['contactoCliente'] ?>" required>
            </div>
            <div class="col-2">
                <label class="form-label" for="cargoCliente"><strong>Cargo Contacto</strong></label>
                <input type="text" class="form-control" name="cargoCliente" id="cargoCliente" value="<?= $cliente['cargoCliente'] ?>" required>
            </div>
            <div class="col-2">
                <label class="form-label" for="celCliente"><strong>Celular Contacto</strong></label>
                <input type="text" class="form-control" name="celCliente" id="celCliente" onkeydown="return aceptaNum(event)" maxlength="10" value="<?= $cliente['celCliente'] ?>" required>
            </div>
            <div class="col-3">
                <label class="form-label" for="idCatCliente"><strong>Actividad</strong></label>
                <select name="idCatCliente" id="idCatCliente" class="form-select" required>
                    <option selected
                            value="<?= $cliente['idCatCliente'] ?>"><?= $cliente['desCatClien'] ?></option>
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
            <div class="col-1">
                <label class="form-label" for="retIva"><strong>Autoret Iva</strong></label>
                <select name="retIva" id="retIva" class="form-select">
                    <?php
                    if ($cliente['retIva'] == 1):
                        ?>
                        <option value="0">No</option>
                        <option value="1" selected>Si</option>
                    <?php
                    else:
                        ?>
                        <option value="0" selected>No</option>
                        <option value="1">Si</option>
                    <?php
                    endif;
                    ?>
                </select>
            </div>
            <div class="col-1">
                <label class="form-label" for="retFte"><strong>Retefuente</strong></label>
                <select name="retFte" id="retFte" class="form-select">
                    <?php
                    if ($cliente['retFte'] == 1):
                        ?>
                        <option value="0">No</option>
                        <option value="1" selected>Si</option>
                    <?php
                    else:
                        ?>
                        <option value="0" selected>No</option>
                        <option value="1">Si</option>
                    <?php
                    endif;
                    ?>
                </select>
            </div>
            <div class="col-1">
                <label class="form-label" for="retIca"><strong>Autoret Ica</strong></label>
                <select name="retIca" id="retIca" class="form-select">
                    <?php
                    if ($cliente['retIca'] == 1):
                        ?>
                        <option value="0">No</option>
                        <option value="1" selected>Si</option>
                    <?php
                    else:
                        ?>
                        <option value="0" selected>No</option>
                        <option value="1">Si</option>
                    <?php
                    endif;
                    ?>
                </select>
            </div>
            <div class="col-2">
                <label class="form-label" for="exenIva"><strong>Exen Iva</strong></label>
                <select name="exenIva" id="exenIva" class="form-select">
                    <?php
                    if ($cliente['exenIva'] == 1):
                        ?>
                        <option value="0">No</option>
                        <option value="1" selected>Si</option>
                    <?php
                    else:
                        ?>
                        <option value="0" selected>No</option>
                        <option value="1">Si</option>
                    <?php
                    endif;
                    ?>
                </select>
            </div>
            <div class="col-2">
                <label class="form-label" for="estadoCliente"><strong>Estado</strong></label>
                <select name="estadoCliente" id="estadoCliente" class="form-select">
                    <?php
                    if ($cliente['estadoCliente'] == 1):
                        ?>
                        <option value="0">Inactivo</option>
                        <option value="1" selected>Activo</option>
                    <?php
                    else:
                        ?>
                        <option value="0" selected>Inactivo</option>
                        <option value="1">Activo</option>
                    <?php
                    endif;
                    ?>
                </select>
            </div>
            <div class="col-3">
                <label class="form-label" for="codVendedor"><strong>Vendedor</strong></label>
                <select name="codVendedor" id="codVendedor" class="form-control" required>
                    <option selected value="<?= $cliente['codVendedor'] ?>"><?= $cliente['nomPersonal'] ?></option>
                    <?php
                    $PersonalOperador = new PersonalOperaciones();
                    $personal = $PersonalOperador->getPersonal(true);
                    for ($i = 0; $i < count($personal); $i++) {
                        if ($personal[$i]["idPersonal"] != $cliente['codVendedor']) {
                            echo '<option value="' . $personal[$i]["idPersonal"] . '">' . $personal[$i]['nomPersonal'] . '</option>';
                        }
                    }
                    echo '';
                    ?>
                </select>
            </div>
        </div>

        <div class="mb-3 row">
            <div class="col-2 text-center">
                <button class="button" type="button" onclick="return Enviar(this.form)"><span>Actualizar cliente</span></button>
            </div>
        </div>
    </form>
    <div class="mb-3 row">
        <div class="col-3 text-center">
            <button class="button" onclick="self.location='../detalle/'"><span>Adicionar o Cambiar Sucursales</span>
            </button>
        </div>
    </div>

    <div class="tabla-70">
        <table id="example" class="formatoDatos5 table table-sm table-striped">
            <thead>
            <tr>
                <th class="text-center">Id</th>
                <th class="text-center">Nombre Sucursal</th>
                <th class="text-center">Teléfono</th>
                <th class="text-center">Dirección Sucursal</th>
                <th class="text-center">Ciudad Sucursal</th>
            </tr>
            </thead>
        </table>
    </div>

    <div class="row mt-3">
        <div class="col-1">
            <button class="button1" id="back" onClick="history.back()"><span>VOLVER</span></button>
        </div>
    </div>

</div>
</body>
</html>
