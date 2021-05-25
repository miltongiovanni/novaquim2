<?php
include "../includes/valAcc.php";
if (isset($_SESSION['idCliente'])) {
    $idCliente = $_SESSION['idCliente'];
} elseif (isset($_GET['idCliente'])) {
    $idCliente = $_GET['idCliente'];
} elseif (isset($_POST['idCliente'])) {
    $idCliente = $_POST['idCliente'];
}
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$clienteOperador = new ClientesOperaciones();
$cliente = $clienteOperador->getCliente($idCliente);
$nomCliente = $cliente['nomCliente'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Sucursales de <?= $nomCliente ?></title>
    <meta charset="utf-8">
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

        $(document).ready(function () {
            let idCliente = <?=$idCliente ?>;
            $('#example').DataTable({
                "columns": [
                    {
                        "data": function (row) {
                            let rep = '<form action="form_up_SucClien.php" method="post" name="elimina">' +
                                '          <input name="idCliente" type="hidden" value="' + idCliente + '">' +
                                '          <input name="idSucursal" type="hidden" value="' + row.idSucursal + '">' +
                                '          <input type="button" name="Submit" onclick="return Enviar(this.form)" class="formatoBoton"  value="Modificar">' +
                                '      </form>'
                            return rep;
                        },
                        "className": 'dt-body-center'
                    },
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
                    {
                        "data": function (row) {
                            let rep = '<form action="delSucClien.php" method="post" name="elimina">' +
                                '          <input name="idCliente" type="hidden" value="' + idCliente + '">' +
                                '          <input name="idSucursal" type="hidden" value="' + row.idSucursal + '">' +
                                '          <input type="button" name="Submit" onclick="return Enviar(this.form)" class="formatoBoton"  value="Eliminar">' +
                                '      </form>'
                            return rep;
                        },
                        "className": 'dt-body-center'
                    }
                ],
                "columnDefs":
                    [{
                        "targets": [0, 1, 2, 3, 4],
                        "className": 'dt-body-center'
                    }
                    ],
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
    <div id="saludo1"><h4>SUCURSALES DE <?= strtoupper($nomCliente) ?></h4></div>

    <form name="form2" method="POST" action="makeSucursalCliente.php">
        <input name="idCliente" id="idCliente" type="hidden" value="<?= $idCliente ?>">
        <div class=" row ">
            <label class="col-form-label col-3 text-left mx-2" for="nomSucursal"><strong>Cliente</strong></label>
            <label class="col-form-label col-1 text-left mx-2" for="telSucursal"><strong>Teléfono</strong></label>
            <label class="col-form-label col-3 text-left mx-2" for="dirSucursal"><strong>Dirección</strong></label>
            <label class="col-form-label col-2 text-left mx-2" for="ciudadSucursal"><strong>Ciudad</strong></label>
        </div>
        <div class="form-group row">
            <input type="text" class="form-control col-3 mx-2" name="nomSucursal" id="nomSucursal" required>
            <input type="text" class="form-control col-1 mx-2" name="telSucursal" id="telSucursal" maxlength="10"
                   onkeydown="return aceptaNum(event)">
            <input type="text" class="form-control col-3 mx-2" name="dirSucursal" id="dirSucursal" required>
            <select name="ciudadSucursal" id="ciudadSucursal" class="form-control col-2 mx-2" required>
                <option selected value="1">Bogotá D.C.</option>
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
                <button class="button" type="button" onclick="return Enviar(this.form)"><span>Agregar sucursal</span>
                </button>
            </div>
        </div>
    </form>

    <div class="tabla-70 mt-5">
        <table id="example" class="display compact">
            <thead>
            <tr class="text-center">
                <th></th>
                <th>Id</th>
                <th>Nombre Sucursal</th>
                <th>Teléfono</th>
                <th>Direccción Sucursal</th>
                <th>Ciudad Sucursal</th>
                <th></th>
            </tr>
            </thead>
        </table>
    </div>
    <div class="row mt-3">
        <div class="col-1">
            <button class="button1" id="back" onclick="window.location='../menu.php'"><span>Ir al Menú</span></button>
        </div>
    </div>
</div>
</body>
</html>