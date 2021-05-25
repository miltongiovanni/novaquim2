<?php
include "../includes/valAcc.php";
$year = $_POST['year'];
$type = $_POST['type'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Consulta de Venta de Productos por Referencia</title>
    <meta charset="utf-8">
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
    <link rel="stylesheet" href="../css/datatables.css">
    <style>
        table {
            table-layout: fixed;
        }

        .width1 {
            width: 23.2%;
        }

        .width2 {
            width: 6.4%;
        }

        table.dataTable.compact thead th, table.dataTable.compact thead td {
            padding: 2px 15px 2px 2px;
        }

        table.dataTable.compact tbody th, table.dataTable.compact tbody td {
            padding: 2px;
        }

        .chart {
            width: 100%;
            height: auto;
        }
    </style>
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/datatables.js"></script>
    <script src="../js/dataTables.buttons.js"></script>
    <script src="../js/jszip.js"></script> <!--Para exportar Excel-->
    <!--<script src="../js/pdfmake.js"></script>-->  <!--Para exportar PDF-->
    <!--<script src="../js/vfs_fonts.js"></script>--> <!--Para exportar PDF-->
    <script src="../js/buttons.html5.js"></script>
    <script src="../node_modules/chart.js/dist/Chart.js"></script>
    <script>

        $(document).ready(function () {
            let year = <?=$year?>;
            let type = <?=$type?>;
            let ruta = "ajax/listaVtasFamNovaXMes.php?year=" + year;
            $('#example').DataTable({
                "columns": [
                    {
                        "data": "producto",
                        "className": 'dt-body-left'
                    },
                    {
                        "data": type == 1 ? "cant_enero" : "sub_enero",
                        "className": type == 1 ? "dt-body-center" : "dt-body-right"
                    },
                    {
                        "data": type == 1 ? "cant_febrero" : "sub_febrero",
                        "className": type == 1 ? 'dt-body-center' : "dt-body-right"
                    },
                    {
                        "data": type == 1 ? "cant_marzo" : "sub_marzo",
                        "className": type == 1 ? 'dt-body-center' : "dt-body-right"
                    },
                    {
                        "data": type == 1 ? "cant_abril" : "sub_abril",
                        "className": type == 1 ? 'dt-body-center' : "dt-body-right"
                    },
                    {
                        "data": type == 1 ? "cant_mayo" : "sub_mayo",
                        "className": type == 1 ? 'dt-body-center' : "dt-body-right"
                    },
                    {
                        "data": type == 1 ? "cant_junio" : "sub_junio",
                        "className": type == 1 ? 'dt-body-center' : "dt-body-right"
                    },
                    {
                        "data": type == 1 ? "cant_julio" : "sub_julio",
                        "className": type == 1 ? 'dt-body-center' : "dt-body-right"
                    },
                    {
                        "data": type == 1 ? "cant_agosto" : "sub_agosto",
                        "className": type == 1 ? 'dt-body-center' : "dt-body-right"
                    },
                    {
                        "data": type == 1 ? "cant_septiembre" : "sub_septiembre",
                        "className": type == 1 ? 'dt-body-center' : "dt-body-right"
                    },
                    {
                        "data": type == 1 ? "cant_octubre" : "sub_octubre",
                        "className": type == 1 ? 'dt-body-center' : "dt-body-right"
                    },
                    {
                        "data":
                            type == 1 ? "cant_noviembre" : "sub_noviembre",
                        "className":
                            type == 1 ? 'dt-body-center' : "dt-body-right"
                    }
                    ,
                    {
                        "data":
                            type == 1 ? "cant_diciembre" : "sub_diciembre",
                        "className":
                            type == 1 ? 'dt-body-center' : "dt-body-right"
                    }
                    ,
                ],
                /*                "columnDefs": [ {
                                    "searchable": false,
                                    "orderable": false,
                                    "targets": 1
                                } ],*/
                "dom":
                    'Blfrtip',
                "buttons":
                    [
                        'copyHtml5',
                        'excelHtml5'
                    ],
                "paging":
                    true,
                "ordering":
                    true,
                "info":
                    true,
                "searching":
                    true,
                "order":
                    [[1, 'desc']],
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
                "ajax":
                ruta
            })
            ;
        });
    </script>
</head>
<body>
<div id="contenedor">
    <div id="saludo1"><h4>CONSULTA DE <?= $type == 1 ? 'UNIDADES' : 'VALOR' ?> POR VENTAS POR FAMILIA DE PRODUCTOS
            POR MES AÑO <?= $year ?></h4>
    </div>
    <div class="row">
        <div class="col-6">
            <canvas id="myChart" class="chart"></canvas>
        </div>
    </div>

    <div class="tabla-90">
        <table id="example" class="display compact formatoDatos5">
            <thead>
            <tr>
                <th class="width1" rowspan="2">Producto</th>
                <th>Enero</th>
                <th>Febrero</th>
                <th>Marzo</th>
                <th>Abril</th>
                <th>Mayo</th>
                <th>Junio</th>
                <th>Julio</th>
                <th>Agosto</th>
                <th>Septiembre</th>
                <th>Octubre</th>
                <th>Noviembre</th>
                <th>Diciembre</th>
            </tr>
            <tr>
                <th class="width2"><?= $type == 1 ? 'Un' : 'Valor' ?></th>
                <th class="width2"><?= $type == 1 ? 'Un' : 'Valor' ?></th>
                <th class="width2"><?= $type == 1 ? 'Un' : 'Valor' ?></th>
                <th class="width2"><?= $type == 1 ? 'Un' : 'Valor' ?></th>
                <th class="width2"><?= $type == 1 ? 'Un' : 'Valor' ?></th>
                <th class="width2"><?= $type == 1 ? 'Un' : 'Valor' ?></th>
                <th class="width2"><?= $type == 1 ? 'Un' : 'Valor' ?></th>
                <th class="width2"><?= $type == 1 ? 'Un' : 'Valor' ?></th>
                <th class="width2"><?= $type == 1 ? 'Un' : 'Valor' ?></th>
                <th class="width2"><?= $type == 1 ? 'Un' : 'Valor' ?></th>
                <th class="width2"><?= $type == 1 ? 'Un' : 'Valor' ?></th>
                <th class="width2"><?= $type == 1 ? 'Un' : 'Valor' ?></th>
            </tr>

            </thead>
        </table>
    </div>
    <div class="row">
        <div class="col-1">
            <button class="button" type="button" id="back" onClick="window.location='../menu.php'"><span>Terminar</span>
            </button>
        </div>
    </div>

    <script>
        let year = <?=$year?>;
        let type = <?=$type?>;
        $.ajax({
            url: '../includes/controladorVentas.php',
            type: 'POST',
            data: {
                "action": 'prodEmprCantTotalYear',
                "year": year,
                "type": type,
            },
            dataType: 'json',
            success: function (totalesXproducto) {
                new Chart(document.getElementById("myChart"), {
                    "type": "doughnut",
                    "data": {
                        "labels": totalesXproducto.productos,
                        "datasets": [{
                            "label": "My First Dataset",
                            "data": totalesXproducto.cant,
                            "backgroundColor": ["rgba(255,123,123,0.5)", "rgba(122,255,228, 0.5)", "rgba(202,114,255,0.5)", "rgba(87,241,120, 0.5)",
                                "rgba(255,127,80, 0.5)", "rgba(255,215,0,0.5)", "rgba(224,116,156,0.5)", "rgba(59,188,238, 0.5)",
                                "rgba(255,205,86, 0.5)", "rgba(151,235,54, 0.5)", "rgba(230,58,248,0.5)", "rgba(255,255,0, 0.5)",
                                "rgba(255,103,103,0.5)", "rgba(104,198,248,0.5)", "rgba(196,86,255, 0.5)", "rgba(28,202,102,0.5)",
                                "rgba(255,127,80, 0.5)", "rgb(255,215,0,0.5)", "rgba(224,116,156,0.5)", "rgba(59,238,77, 0.5)",
                                "rgba(86,168,255, 0.5)"]
                        }]
                    },
                    options: {
                        responsive: true,
                        legend: {
                            display: false,
                        },
                        title: {
                            display: true,
                            text: type == 1 ? 'Total unidades año ' + year : 'Total valores año ' + year
                        },
                        animation: {
                            animateScale: true,
                            animateRotate: true
                        }
                    }
                });
            },
            fail: function () {
                alert("Vous avez un GROS problème");
            }
        });

    </script>
</div>
</body>
</html>