<?php
include "../../../includes/valAcc.php";
$year = $_POST['year'];
$type = $_POST['type'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Consulta de Venta de Productos por Referencia</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="stylesheet" href="../../../css/datatables.css">
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../../../js/validar.js"></script>
    <script src="../../../js/jquery-3.3.1.min.js"></script>
    <script src="../../../js/datatables.js"></script>
    <script src="../../../node_modules/chart.js/dist/chart.js"></script>
    <script>

        $(document).ready(function () {
            let year = '<?=$year?>';
            let type = '<?=$type?>';
            let ruta = "../ajax/listaVtasDistrXMes.php?year=" + year;
            $('#example').DataTable({
                "columns": [
                    {
                        "data": "catDis",
                        "className": 'dt-body-left',
                        width: '23.2%'
                    },
                    {
                        "data": type === '1' ? "cant_enero" : "sub_enero",
                        "className": type === '1' ? "dt-body-center" : "dt-body-right",
                        width: '6.4%'
                    },
                    {
                        "data": type === '1' ? "cant_febrero" : "sub_febrero",
                        "className": type === '1' ? 'dt-body-center' : "dt-body-right",
                        width: '6.4%'
                    },
                    {
                        "data": type === '1' ? "cant_marzo" : "sub_marzo",
                        "className": type === '1' ? 'dt-body-center' : "dt-body-right",
                        width: '6.4%'
                    },
                    {
                        "data": type === '1' ? "cant_abril" : "sub_abril",
                        "className": type === '1' ? 'dt-body-center' : "dt-body-right",
                        width: '6.4%'
                    },
                    {
                        "data": type === '1' ? "cant_mayo" : "sub_mayo",
                        "className": type === '1' ? 'dt-body-center' : "dt-body-right",
                        width: '6.4%'
                    },
                    {
                        "data": type === '1' ? "cant_junio" : "sub_junio",
                        "className": type === '1' ? 'dt-body-center' : "dt-body-right",
                        width: '6.4%'
                    },
                    {
                        "data": type === '1' ? "cant_julio" : "sub_julio",
                        "className": type === '1' ? 'dt-body-center' : "dt-body-right",
                        width: '6.4%'
                    },
                    {
                        "data": type === '1' ? "cant_agosto" : "sub_agosto",
                        "className": type === '1' ? 'dt-body-center' : "dt-body-right",
                        width: '6.4%'
                    },
                    {
                        "data": type === '1' ? "cant_septiembre" : "sub_septiembre",
                        "className": type === '1' ? 'dt-body-center' : "dt-body-right",
                        width: '6.4%'
                    },
                    {
                        "data": type === '1' ? "cant_octubre" : "sub_octubre",
                        "className": type === '1' ? 'dt-body-center' : "dt-body-right",
                        width: '6.4%'
                    },
                    {
                        "data":
                            type === '1' ? "cant_noviembre" : "sub_noviembre",
                        "className":
                            type === '1' ? 'dt-body-center' : "dt-body-right",
                        width: '6.4%'
                    }
                    ,
                    {
                        "data":
                            type === '1' ? "cant_diciembre" : "sub_diciembre",
                        "className":
                            type === '1' ? 'dt-body-center' : "dt-body-right",
                        width: '6.4%'
                    }
                    ,
                ],
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
<div id="contenedor" class="container-fluid">
    <div id="saludo1">
        <img src="../../../images/LogoNova.jpg" alt="novaquim" class="img-fluid mb-2"><h4>CONSULTA DE <?= $type == 1 ? 'UNIDADES' : 'VALOR' ?> POR VENTAS DE CATEGORÍA DE PRODUCTOS DISTRIBUIDOS POR MES AÑO <?= $year ?></h4></div>
    <div class="row">
        <div class="col-6">
            <canvas id="myChart" class="chart"></canvas>
        </div>
    </div>

    <div class="tabla-100">
        <table id="example" class="formatoDatos5 table table-sm table-striped">
            <thead>
            <tr>
                <th class="">Producto</th>
                <th class="text-center">Enero</th>
                <th class="text-center">Febrero</th>
                <th class="text-center">Marzo</th>
                <th class="text-center">Abril</th>
                <th class="text-center">Mayo</th>
                <th class="text-center">Junio</th>
                <th class="text-center">Julio</th>
                <th class="text-center">Agosto</th>
                <th class="text-center">Septiembre</th>
                <th class="text-center">Octubre</th>
                <th class="text-center">Noviembre</th>
                <th class="text-center">Diciembre</th>
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
        let year = '<?=$year?>';
        let type = '<?=$type?>';
        $.ajax({
            url: '../../../includes/controladorVentas.php',
            type: 'POST',
            data: {
                "action": 'prodDistCantTotalYear',
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
                            "backgroundColor": ["rgba(86,168,255, 0.5)", "rgba(122,255,228, 0.5)", "rgba(202,114,255,0.5)", "rgba(87,241,120, 0.5)",
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
                            text: type === '1' ? 'Total unidades año ' + year : 'Total valores año ' + year
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