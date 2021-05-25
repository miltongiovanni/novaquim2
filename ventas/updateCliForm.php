<?php
include "../includes/valAcc.php";
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$idCliente = $_POST['idCliente'];
$clienteOperador = new ClientesOperaciones();
$cliente = $clienteOperador->getCliente($idCliente);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Actualizar datos del Cliente</title>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../css/datatables.css">
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/datatables.js"></script>
    <script src="../js/jszip.js"></script>
    <script src="../js/pdfmake.js"></script>
    <script src="../js/vfs_fonts.js"></script>
    <script>
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

        $(document).ready(function () {
            let idCliente = document.getElementById("idCliente").value;
            $('#example').DataTable({
                "columns": [
                    {
                        /*"className": 'details-control',*/
                        /*"orderable": false,*/
                        "data": "idSucursal",
                        /*"defaultContent": ''*/
                    },
                    {
                        "data": "nomSucursal",
                    },
                    {
                        "data": "telSucursal",
                    },
                    {
                        "data": "dirSucursal",
                    },
                    {
                        "data": "ciudad",
                    },
                ],
                "columnDefs":
                    [{
                        "targets": [0, 1, 2, 3, 4],
                        "className": 'dt-body-center'
                    }
                    ],
                "paging": false,
                "ordering": false,
                "info": false,
                "searching": false,
                "lengthMenu": [[20, 50, 100, -1], [20, 50, 100, "All"]],
                "language": {
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
                "ajax": "ajax/listaSucursalesCliente.php?idCliente=" + idCliente
            });
        });
    </script>
</head>

<body>
<div id="contenedor">
    <div id="saludo1"><h4>ACTUALIZACIÓN DE CLIENTE</h4></div>
    <form name="form2" method="POST" action="updateClien.php">
        <input name="idCliente" id="idCliente" type="hidden" value="<?= $idCliente ?>">
        <div class=" row ">
            <label class="col-form-label col-2 text-left mx-2"><strong>Tipo</strong></label>
            <label class="col-form-label col-2 text-left mx-2"
                   for="numero"><strong>Número</strong></label>
            <label class="col-form-label col-2 text-left mx-2" for="nitCliente"><strong>NIT</strong></label>
            <label class="col-form-label col-3 text-left mx-2" for="nomCliente"><strong>Cliente</strong></label>
        </div>
        <div class="form-group row">
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
                   onkeyup="nitClientes()">
            <input type="text" class="form-control col-2 mx-2" name="nitCliente" id="nitCliente"
                   value="<?= $cliente['nitCliente'] ?>" onkeydown="return aceptaNum(event)" readOnly required>
            <input type="text" class="form-control col-3 mx-2" name="nomCliente" id="nomCliente"
                   value="<?= $cliente['nomCliente'] ?>" required>
        </div>
        <div class="row">
            <label class="col-form-label col-2 text-left mx-2" for="telCliente"><strong>Teléfono</strong></label>
            <label class="col-form-label col-2 text-left mx-2" for="emailCliente"><strong>Correo
                    electrónico</strong></label>
            <label class="col-form-label col-2 text-left mx-2" for="ciudadCliente"><strong>Ciudad</strong></label>
            <label class="col-form-label col-3 text-left mx-2" for="dirCliente"><strong>Dirección</strong></label>
        </div>
        <div class="form-group row">
            <input type="text" class="form-control col-2 mx-2" name="telCliente" id="telCliente" maxlength="10"
                   onkeydown="return aceptaNum(event)" value="<?= $cliente['telCliente'] ?>">
            <input type="email" class="form-control col-2 mx-2" name="emailCliente" id="emailCliente"
                   value="<?= $cliente['emailCliente'] ?>">
            <select name="ciudadCliente" id="ciudadCliente" class="form-control col-2 mx-2" required>
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
            <input type="text" class="form-control col-3 mx-2" name="dirCliente" id="dirCliente"
                   value="<?= $cliente['dirCliente'] ?>" required>
        </div>
        <div class="row">
            <label class="col-form-label col-2 text-left mx-2" for="contactoCliente"><strong>Nombre
                    Contacto</strong></label>
            <label class="col-form-label col-2 text-left mx-2" for="cargoCliente"><strong>Cargo
                    Contacto</strong></label>
            <label class="col-form-label col-2 text-left mx-2" for="celCliente"><strong>Celular
                    Contacto</strong></label>
            <label class="col-form-label col-3 text-left mx-2" for="idCatCliente"><strong>Actividad</strong></label>
        </div>
        <div class="form-group row">
            <input type="text" class="form-control col-2 mx-2" name="contactoCliente" id="contactoCliente"
                   value="<?= $cliente['contactoCliente'] ?>" required>
            <input type="text" class="form-control col-2 mx-2" name="cargoCliente" id="cargoCliente"
                   value="<?= $cliente['cargoCliente'] ?>" required>
            <input type="text" class="form-control col-2 mx-2" name="celCliente" id="celCliente"
                   onkeydown="return aceptaNum(event)" maxlength="10" value="<?= $cliente['celCliente'] ?>" required>
            <select name="idCatCliente" id="idCatCliente" class="form-control col-3 mx-2" required>
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
        <div class="row">
            <label class="col-form-label col-1 text-left mx-2" for="retIva"><strong>Autoret Iva</strong></label>
            <label class="col-form-label col-1 text-left mx-2" for="retFte"><strong>Retefuente</strong></label>
            <label class="col-form-label col-1 text-left mx-2" for="retIca"><strong>Autoret Ica</strong></label>
            <label class="col-form-label col-1 text-left mx-2" for="exenIva"><strong>Exen Iva</strong></label>
            <label class="col-form-label col-1 text-left mx-2" for="estadoCliente"><strong>Estado</strong></label>
            <label class="col-form-label col-2 text-left mx-2" for="codVendedor"><strong>Vendedor</strong></label>

        </div>
        <div class="form-group row">

            <select name="retIva" id="retIva" class="form-control col-1 mx-2">
                <?php
                if ($cliente['retIva'] = 1):
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
            <select name="retFte" id="retFte" class="form-control col-1 mx-2">
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
            <select name="retIca" id="retIca" class="form-control col-1 mx-2">
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
            <select name="exenIva" id="exenIva" class="form-control col-1 mx-2">
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
            <select name="estadoCliente" id="estadoCliente" class="form-control col-1 mx-2">
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
            <select name="codVendedor" id="codVendedor" class="form-control col-2 mx-2" required>
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
        <div class="form-group row">
            <div class="col-2 text-center">
                <button class="button" type="button" onclick="return Enviar(this.form)"><span>Actualizar cliente</span></button>
            </div>
        </div>
    </form>
    <div class="form-group row">
        <div class="col-3 text-center">
            <button class="button" onclick="self.location='detCliente.php?idCliente=<?= $idCliente ?>'"><span>Adicionar o Cambiar Sucursales</span>
            </button>
        </div>
    </div>

    <div class="tabla-70">
        <table id="example" class="display compact">
            <thead>
            <tr class="text-center">
                <th>Id</th>
                <th>Nombre Sucursal</th>
                <th>Teléfono</th>
                <th>Direccción Sucursal</th>
                <th>Ciudad Sucursal</th>
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
