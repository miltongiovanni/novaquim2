<?php
include "../includes/valAcc.php";
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
foreach ($_POST as $nombre_campo => $valor) {
    ${$nombre_campo} = $valor;
    if (is_array($valor)) {
        //echo $nombre_campo.print_r($valor).'<br>';
    } else {
        //echo $nombre_campo. '=' .${$nombre_campo}.'<br>';
    }
}
$personalOperador = new PersonalOperaciones();
$personal = $personalOperador->getPerson($idPersonal);
$totales = $personalOperador->getTotalComisionVendedor($idPersonal, $fechaInicial, $fechaFinal);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Consulta de Venta de Productos por Referencia</title>
    <meta charset="utf-8">
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../css/datatables.css">
    <style>
        table {
            table-layout: fixed;
        }

        .width1 {
            width: 6%;
        }

        .width2 {
            width: 40%;
        }

        .width3 {
            width: 5%;
        }

        .width4 {
            width: 7%;
        }

        .width5 {
            width: 7%;
        }

        .width6 {
            width: 7%;
        }

        .width7 {
            width: 7%;
        }

        .width8 {
            width: 7%;
        }

        .width9 {
            width: 7%;
        }

        .width10 {
            width: 7%;
        }

        table.dataTable.compact thead th,
        table.dataTable.compact thead td {
            padding: 4px 4px 4px 4px;
        }
    </style>
<script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/datatables.js"></script>
    <script src="../js/dataTables.buttons.js"></script>
    <script src="../js/jszip.js"></script> <!--Para exportar Excel-->
    <!--<script src="../js/pdfmake.js"></script>-->  <!--Para exportar PDF-->
    <!--<script src="../js/vfs_fonts.js"></script>--> <!--Para exportar PDF-->
    <script src="../js/buttons.html5.js"></script>
    <script>
        $(document).ready(function () {
            let idPersonal = <?=$idPersonal?>;
            let fechaInicial = '<?=$fechaInicial?>';
            let fechaFinal = '<?=$fechaFinal?>';
            let ruta = "ajax/listaComisionVendedor.php?idPersonal=" + idPersonal + "&fechaInicial=" + fechaInicial + "&fechaFinal=" + fechaFinal;
            $('#example').DataTable({
                "columns": [
                    {
                        "data": "idFactura",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "nomCliente",
                        "className": 'dt-body-left'
                    },
                    {
                        "data": "desct",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "fechaCancelacion",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "subtot",
                        "className": 'dt-body-right'
                    },
                    {
                        "data": "vtaEmpresa",
                        "className": 'dt-body-right'
                    },
                    {
                        "data": "vtaDistribucion",
                        "className": 'dt-body-right'
                    },
                    {
                        "data": "comEmpresa",
                        "className": 'dt-body-right'
                    },
                    {
                        "data": "comDistribucion",
                        "className": 'dt-body-right'
                    },
                    {
                        "data": "comTotal",
                        "className": 'dt-body-right'
                    },

                ],
                "columnDefs": [{
                    "searchable": false,
                    "orderable": false,
                    "targets": 2
                }],
                "dom": 'Blfrtip',
                "buttons": [
                    'copyHtml5',
                    'excelHtml5'
                ],
                "paging": true,
                "ordering": true,
                "info": true,
                "searching": true,
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
                "ajax": ruta
            });
        });
    </script>
</head>
<body>
<div id="contenedor" class="container-fluid">

    <div id="saludo1"><h4>CONSULTA DE COMISIONES DEL
            VENDEDOR <?php echo mb_strtoupper($personal['nomPersonal']); ?></h4></div>
    <div class="tabla-100">
        <table id="example" class="display compact formatoDatos">
            <thead>
            <tr>
                <th class="width1 text-center">Factura</th>
                <th class="width2 text-center">Cliente</th>
                <th class="width3 text-center">% Desc</th>
                <th class="width4 text-center">Fech Canc</th>
                <th class="width5 text-center">Subtotal</th>
                <th class="width6 text-center">Vtas Nova</th>
                <th class="width7 text-center">Vtas Dist</th>
                <th class="width8 text-center">Com Nova</th>
                <th class="width9 text-center">Com Dist</th>
                <th class="width10 text-center">Com Total</th>
            </tr>
            </thead>
        </table>
    </div>
    <div class="tabla-100">
        <div class="row formatoDatos">
            <div class="col-10">
                <div class=" text-end">
                    <strong>Comisión Novaquim</strong>
                </div>
            </div>
            <div class="col-1 ms-3 px-0">
                <div class="text-end">
                    <strong><?= $totales['comEmpresa'] ?></strong>
                </div>
            </div>
        </div>
        <div class="row formatoDatos">
            <div class="col-10">
                <div class=" text-end">
                    <strong>Comisión distribución</strong>
                </div>
            </div>
            <div class="col-1 ms-3 px-0">
                <div class="text-end">
                    <strong><?= $totales['comDistribucion'] ?></strong>
                </div>
            </div>
        </div>
        <div class="row formatoDatos">
            <div class="col-10">
                <div class=" text-end">
                    <strong>Comisión Total</strong>
                </div>
            </div>
            <div class="col-1 ms-3 px-0">
                <div class="text-end">
                    <strong><?= $totales['comTotal'] ?></strong>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-1">
            <button class="button"
                    onclick="window.location='../menu.php'">
                <span><STRONG>Ir al Menú</STRONG></span></button>
        </div>
    </div>
</div>
</body>
</html>