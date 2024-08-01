<?php
include "../../../includes/valAcc.php";
if (isset($_SESSION['idCliente'])) {
    $idCliente = $_SESSION['idCliente'];
} elseif (isset($_GET['idCliente'])) {
    $idCliente = $_GET['idCliente'];
} elseif (isset($_POST['idCliente'])) {
    $idCliente = $_POST['idCliente'];
}
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
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
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../../../css/datatables.css">
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
    <script src="../../../js/jquery-3.3.1.min.js"></script>
    <script src="../../../js/datatables.js"></script>

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
                        /*"className": 'dt-control',*/
                        /*"orderable": false,*/
                        "data": "idSucursal",
                        /*"defaultContent": ''*/
                    },
                    {
                        "data": "nomSucursal",
                    },
                    {
                        "data": "telSucursal",
                        className: 'pe-5'
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
                    [
                        {
                            "targets": [0, 1, 6],
                            "className": 'dt-body-center'
                        },
                        {
                            "targets": [0, 6],
                            "orderable": false,
                            searchable: false
                        }
                    ],
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
                "order": [[1, 'asc']],
                initComplete: function (settings, json) {
                    $('#example thead th').removeClass('pe-5');
                },
                "ajax": "../ajax/listaSucursalesCliente.php?idCliente=" + idCliente
            });
        });
    </script>
</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo1">
        <img src="../../../images/LogoNova.jpg" alt="novaquim" class="img-fluid mb-2">
        <h4>SUCURSALES DE <?= strtoupper($nomCliente) ?></h4>
    </div>

    <form name="form2" class="formatoDatos5" method="POST" action="makeSucursalCliente.php">
        <input name="idCliente" id="idCliente" type="hidden" value="<?= $idCliente ?>">
        <div class=" row ">
            <div class="col-3">
                <label class="form-label" for="nomSucursal"><strong>Sucursal</strong></label>
                <input type="text" class="form-control" name="nomSucursal" id="nomSucursal" required>
            </div>
            <div class="col-1">
                <label class="form-label" for="telSucursal"><strong>Teléfono</strong></label>
                <input type="text" class="form-control" name="telSucursal" id="telSucursal" maxlength="10" onkeydown="return aceptaNum(event)">
            </div>
            <div class="col-3">
                <label class="form-label" for="dirSucursal"><strong>Dirección</strong></label>
                <input type="text" class="form-control" name="dirSucursal" id="dirSucursal" required>
            </div>
            <div class="col-2">
                <label class="form-label" for="ciudadSucursal"><strong>Ciudad</strong></label>
                <select name="ciudadSucursal" id="ciudadSucursal" class="form-select" required>
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
        </div>
        <div class="mb-3 row mt-3">
            <div class="col-2 text-center">
                <button class="button" type="button" onclick="return Enviar(this.form)"><span>Agregar sucursal</span>
                </button>
            </div>
        </div>
    </form>
    <div class="tabla-70 mt-5">
        <table id="example" class="formatoDatos5 table table-sm table-striped">
            <thead>
            <tr>
                <th></th>
                <th class="text-center">Id</th>
                <th class="text-center">Nombre Sucursal</th>
                <th class="text-center">Teléfono</th>
                <th class="text-center">Direccción Sucursal</th>
                <th class="text-center">Ciudad Sucursal</th>
                <th class="text-center"></th>
            </tr>
            </thead>
        </table>
    </div>
    <div class="row mt-3">
        <div class="col-1">
            <button class="button1" id="back" onclick="window.location='../../../menu.php'"><span>Ir al Menú</span></button>
        </div>
    </div>
</div>
</body>
</html>