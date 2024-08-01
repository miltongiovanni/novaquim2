<?php
include "../../../includes/valAcc.php";
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
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
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../../../css/datatables.css">
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
<script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
    <script src="../../../js/jquery-3.3.1.min.js"></script>
    <script src="../../../js/datatables.js"></script>
    
    <script>
        $(document).ready(function () {
            let idPersonal = <?=$idPersonal?>;
            let fechaInicial = '<?=$fechaInicial?>';
            let fechaFinal = '<?=$fechaFinal?>';
            let ruta = "../ajax/listaComisionVendedor.php?idPersonal=" + idPersonal + "&fechaInicial=" + fechaInicial + "&fechaFinal=" + fechaFinal;
            $('#example').DataTable({
                "columns": [
                    {
                        "data": "idFactura",
                        "className": 'dt-body-center',
                        width: '6%'
                    },
                    {
                        "data": "nomCliente",
                        "className": 'dt-body-left',
                        width: '40%'
                    },
                    {
                        "data": "desct",
                        "className": 'dt-body-center',
                        width: '5%'
                    },
                    {
                        "data": "fechaCancelacion",
                        "className": 'dt-body-center',
                        width: '7%'
                    },
                    {
                        "data": "subtot",
                        "className": 'dt-body-right pe-4',
                        width: '7%'
                    },
                    {
                        "data": "vtaEmpresa",
                        "className": 'dt-body-right pe-4',
                        width: '7%'
                    },
                    {
                        "data": "vtaDistribucion",
                        "className": 'dt-body-right pe-4',
                        width: '7%'
                    },
                    {
                        "data": "comEmpresa",
                        "className": 'dt-body-right pe-4',
                        width: '7%'
                    },
                    {
                        "data": "comDistribucion",
                        "className": 'dt-body-right pe-4',
                        width: '7%'
                    },
                    {
                        "data": "comTotal",
                        "className": 'dt-body-right pe-4',
                        width: '7%'
                    },

                ],
                "columnDefs": [{
                    "searchable": false,
                    "orderable": false,
                    "targets": 2
                }],
                pagingType: 'simple_numbers',
                layout: {
                    topStart: 'buttons',
                    topStart1: 'search',
                    topEnd: 'pageLength',
                    bottomStart: 'info',
                    bottomEnd: {
                        paging: {
                            numbers: 6
                        }
                    }
                },
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
                "ajax": ruta,
                initComplete: function (settings, json) {
                    $('#example thead th').removeClass('pe-4');
                },
            });
        });
    </script>
</head>
<body>
<div id="contenedor" class="container-fluid">

    <div id="saludo1">
        <img src="../../../images/LogoNova.jpg" alt="novaquim" class="img-fluid mb-2"><h4>CONSULTA DE COMISIONES DEL
            VENDEDOR <?php echo mb_strtoupper($personal['nomPersonal']); ?></h4></div>
    <div class="tabla-100">
        <table id="example" class="formatoDatos5 table table-sm table-striped">
            <thead>
            <tr>
                <th class="text-center">Factura</th>
                <th class="text-center">Cliente</th>
                <th class="text-center">% Desc</th>
                <th class="text-center">Fech Canc</th>
                <th class="text-center">Subtotal</th>
                <th class="text-center">Vtas Nova</th>
                <th class="text-center">Vtas Dist</th>
                <th class="text-center">Com Nova</th>
                <th class="text-center">Com Dist</th>
                <th class="text-center">Com Total</th>
            </tr>
            </thead>
        </table>
    </div>
    <div class="tabla-100">
        <div class="row formatoDatos">
            <div class="col-11">
                <div class=" text-end">
                    <strong>Comisión Novaquim</strong>
                </div>
            </div>
            <div class="col-1">
                <div class="text-end">
                    <strong><?= $totales['comEmpresa'] ?></strong>
                </div>
            </div>
        </div>
        <div class="row formatoDatos">
            <div class="col-11">
                <div class=" text-end">
                    <strong>Comisión distribución</strong>
                </div>
            </div>
            <div class="col-1">
                <div class="text-end">
                    <strong><?= $totales['comDistribucion'] ?></strong>
                </div>
            </div>
        </div>
        <div class="row formatoDatos">
            <div class="col-11">
                <div class=" text-end">
                    <strong>Comisión Total</strong>
                </div>
            </div>
            <div class="col-1">
                <div class="text-end">
                    <strong><?= $totales['comTotal'] ?></strong>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-1">
            <button class="button"
                    onclick="window.location='../../../menu.php'">
                <span><STRONG>Ir al Menú</STRONG></span></button>
        </div>
    </div>
</div>
</body>
</html>