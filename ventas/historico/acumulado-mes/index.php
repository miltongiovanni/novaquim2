<?php
include "../../../includes/valAcc.php";
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$facturaOperador = new FacturasOperaciones();
$maxFecha = $facturaOperador->getMaxFecha();
$detFacOperador = new DetFacturaOperaciones();
$detalle = $detFacOperador->getHistoricoVentas();
$meses = [
    1 => 'Ene',
    2 => 'Feb',
    3 => 'Mar',
    4 => 'Abr',
    5 => 'May',
    6 => 'Jun',
    7 => 'Jul',
    8 => 'Ago',
    9 => 'Sep',
    10 => 'Oct',
    11 => 'Nov',
    12 => 'Dic',
];
foreach ($detalle as &$valor) {
    $valor['mesanio'] = $meses[$valor['mes']] . '-' . $valor['year'];
}
//var_dump($detalle);
$retData = array();

foreach ($detalle as $row => $columns) {
    foreach ($columns as $row2 => $column2) {
        if ($row2 == 'mes') {
            $column2 = $meses[$column2];
        }
        if ($row2 != 'year' && $row2 != 'mes') {
            $retData[$row2][$row] = $column2;
        }
    }
}

$fechaInicial = new DateTime('2011-03-1');
$fechaFinal = new DateTime($maxFecha);

// mostrara las fechas
$months[] = $meses[intval($fechaInicial->format('m'))] . '-' . $fechaInicial->format('Y');

$fecha = $fechaInicial;
// mostrara las fechas
while ($fecha < $fechaFinal) {
    // despliega los meses
    $fecha->add(new DateInterval('P1M'));
    // mostrara las fechas
    $months[] = $meses[intval($fecha->format('m'))] . '-' . $fecha->format('Y');
}
array_pop($months);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Consulta de venta acumulada por mes</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../../../css/datatables.css">
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
    <script src="../../../js/jquery-3.3.1.min.js"></script>
    <script src="../../../js/datatables.js"></script>
    <script src="../../../node_modules/chart.js/dist/chart.js"></script>
    <script>
        $(document).ready(function () {
            let ruta = "../ajax/listaAcumuladoVentas.php";
            $('#example').DataTable({
                "columns": [
                    {
                        "data": "mesanio",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "prod",
                        "render": $.fn.dataTable.render.number(',', '.', 0, '$'),
                        "className": 'dt-body-right'
                    },
                    {
                        "data": "dist",
                        "render": $.fn.dataTable.render.number(',', '.', 0, '$'),
                        "className": 'dt-body-right'
                    },
                    {
                        "data": "servicio",
                        "render": $.fn.dataTable.render.number(',', '.', 0, '$'),
                        "className": 'dt-body-right'
                    },
                    {
                        "data": "total_bruto",
                        "render": $.fn.dataTable.render.number(',', '.', 0, '$'),
                        "className": 'dt-body-right'
                    },
                    {
                        "data": "p_productos",
                        "render": function (data, type, row) {
                            var p_producto = parseFloat(row.p_productos);
                            return p_producto.toFixed(1) + ' %';
                        },
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "p_distribucion",
                        "render": function (data, type, row) {
                            var p_distri = parseFloat(row.p_distribucion);
                            return p_distri.toFixed(1) + ' %';
                        },
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "p_servicio",
                        "render": function (data, type, row) {
                            var p_serv = parseFloat(row.p_servicio);
                            return p_serv.toFixed(1) + ' %';
                        },
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "devolucion",
                        "render": $.fn.dataTable.render.number(',', '.', 0, '$'),
                        "className": 'dt-body-right'
                    },
                    {
                        "data": "total_neto",
                        "render": $.fn.dataTable.render.number(',', '.', 0, '$'),
                        "className": 'dt-body-right'
                    },
                ],
                "columnDefs": [{
                    "searchable": false,
                    "orderable": false,
                    "targets": 1
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
                "buttons":
                    [
                        'copyHtml5',
                        'excelHtml5'
                    ],
                "paging":
                    true,
                "ordering":
                    false,
                "info":
                    true,
                "searching":
                    true,
                /*"order":
                    [[1, 'desc']],*/
                "deferRender":
                    true,  //For speed
                "lengthMenu":
                    [[20, 50, 100, -1], [20, 50, 100, "All"]],
                "language":
                    {
                        "lengthMenu":
                            "Mostrando _MENU_ datos por página",
                        "zeroRecords":
                            "Lo siento no encontró nada",
                        "info":
                            "Mostrando página _PAGE_ de _PAGES_",
                        "infoEmpty":
                            "No hay datos disponibles",
                        "search":
                            "Búsqueda:",
                        "paginate":
                            {
                                "first":
                                    "Primero",
                                "last":
                                    "Último",
                                "next":
                                    "Siguiente",
                                "previous":
                                    "Anterior"
                            }
                        ,
                        "infoFiltered":
                            "(Filtrado de _MAX_ en total)"

                    }
                ,
                "ajax": ruta
            })
            ;
        });
    </script>
</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo1">
        <img src="../../../images/LogoNova.jpg" alt="novaquim" class="img-fluid mb-2"><h4>CONSULTA ACUMULADO VENTAS</h4>
    </div>
    <div class="row">
        <div class="col-11">
            <canvas id="myChart" class="chart"></canvas>
        </div>
    </div>

    <div class="tabla-90">
        <table id="example" class="formatoDatos table table-sm table-striped formatoDatos5">
            <thead>
            <tr>
                <th class="text-center">Mes</th>
                <th class="text-center">Producto</th>
                <th class="text-center">Distribución</th>
                <th class="text-center">Servicio</th>
                <th class="text-center">Total bruto</th>
                <th class="text-center">% Producto</th>
                <th class="text-center">% Distribución</th>
                <th class="text-center">% Servicio</th>
                <th class="text-center">Devolución</th>
                <th class="text-center">Total neto</th>
            </tr>

            </thead>
        </table>
    </div>
    <div class="row">
        <div class="col-1">
            <button class="button" type="button" id="back" onClick="window.location='../../../menu.php'"><span>Terminar</span>
            </button>
        </div>
    </div>

    <script>
        var datos = <?=json_encode($retData) ?>;
        new Chart(document.getElementById("myChart"), {
            "type": "line",
            "data": {
                "labels": datos.mesanio,
                "datasets": [{
                    "label": "Ventas netas",
                    "data": datos.total_neto,
                    "backgroundColor": ["rgba(19,46,187,0.8)"]
                }]
            },
            options: {
                responsive: true,
                legend: {
                    display: false,
                },
                title: {
                    display: false,
                    text: 'Total acumulado por mes'
                },
                animation: {
                    animateScale: true,
                    animateRotate: true
                },
                tooltips: {
                    callbacks: {
                        label: function (context) {
                            var label = context.dataset.label || '';

                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed.y !== null) {
                                label += '$';
                                label += new Intl.NumberFormat('en-US', {style: 'currency', currency: 'USD'}).format(context.parsed.y);
                            }
                            return label;
                        },
                    },
                },
            }
        });


    </script>
</div>
</body>
</html>