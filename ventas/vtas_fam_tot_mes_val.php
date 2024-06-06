<?php
include "../../../includes/valAcc.php";
$year = $_POST['year'];
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
            width: 19.7%;
        }

        .width2 {
            width: 1.3%;
        }

        .width3 {
            width: 5.65%;
        }

        table.dataTable.compact thead th, table.dataTable.compact thead td {
            padding: 2px 15px 2px 2px;
        }

        table.dataTable.compact tbody th, table.dataTable.compact tbody td {
            padding: 2px;
        }
    </style>
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/datatables.js"></script>
    <script src="../js/dataTables.buttons.js"></script>
    <script src="../js/jszip.js"></script> <!--Para exportar Excel-->
    <!--<script src="../js/pdfmake.js"></script>-->  <!--Para exportar PDF-->
    <!--<script src="../js/vfs_fonts.js"></script>--> <!--Para exportar PDF-->
    <script src="../js/buttons.html5.js"></script>
    <script>

        $(document).ready(function () {
            let year = <?=$year?>;
            let ruta = "../ajax/listaVtasFamNovaXMes.php?year=" + year;
            $('#example').DataTable({
                "columns": [
                    {
                        "data": "producto",
                        "className": 'text-center'
                    },
                    {
                        "data": "cant_enero",
                        "className": 'text-center'
                    },
                    {
                        "data": function (row) {
                            let rep = '$ ' + commaSplit(Math.round(row.sub_enero));
                            return rep;
                        },
                        "className": 'text-center'
                    },
                    {
                        "data": "cant_febrero",
                        "className": 'text-center'
                    },
                    {
                        "data": "sub_febrero",
                        "className": 'text-center'
                    },
                    {
                        "data": "cant_marzo",
                        "className": 'text-center'
                    },
                    {
                        "data": "sub_marzo",
                        "className": 'text-center'
                    },
                    {
                        "data": "cant_abril",
                        "className": 'text-center'
                    },
                    {
                        "data": "sub_abril",
                        "className": 'text-center'
                    },
                    {
                        "data": "cant_mayo",
                        "className": 'text-center'
                    },
                    {
                        "data": "sub_mayo",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "cant_junio",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "sub_junio",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "cant_julio",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "sub_julio",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "cant_agosto",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "sub_agosto",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "cant_septiembre",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "sub_septiembre",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "cant_octubre",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "sub_octubre",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "cant_noviembre",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "sub_noviembre",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "cant_diciembre",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "sub_diciembre",
                        "className": 'dt-body-center'
                    },
                ],
                /*                "columnDefs": [ {
                                    "searchable": false,
                                    "orderable": false,
                                    "targets": 1
                                } ],*/
                "dom": 'Blfrtip',
                "buttons": [
                    'copyHtml5',
                    'excelHtml5'
                ],
                "paging": true,
                "ordering": true,
                "info": true,
                "searching": true,
                "order": [[2, 'desc']],
                "deferRender": true,  //For speed
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
    <div id="saludo1">
        <img src="../images/LogoNova.jpg" alt="novaquim" class="img-fluid mb-2"><h4>CONSULTA DE VENTAS POR FAMILIA DE PRODUCTOS POR MES AÑO <?= $year ?></h4></div>
    <div class="tabla-100">
        <table id="example" class="formatoDatos table table-sm table-striped formatoDatos5">
            <thead>
            <tr>
                <th class="width1" rowspan="2">Producto</th>
                <th colspan="2">Enero</th>
                <th colspan="2">Febrero</th>
                <th colspan="2">Marzo</th>
                <th colspan="2">Abril</th>
                <th colspan="2">Mayo</th>
                <th colspan="2">Junio</th>
                <th colspan="2">Julio</th>
                <th colspan="2">Agosto</th>
                <th colspan="2">Septiembre</th>
                <th colspan="2">Octubre</th>
                <th colspan="2">Noviembre</th>
                <th colspan="2">Diciembre</th>
            </tr>
            <tr>
                <th class="width2">Un</th>
                <th class="width3">Total</th>
                <th class="width2">Un</th>
                <th class="width3">Total</th>
                <th class="width2">Un</th>
                <th class="width3">Total</th>
                <th class="width2">Un</th>
                <th class="width3">Total</th>
                <th class="width2">Un</th>
                <th class="width3">Total</th>
                <th class="width2">Un</th>
                <th class="width3">Total</th>
                <th class="width2">Un</th>
                <th class="width3">Total</th>
                <th class="width2">Un</th>
                <th class="width3">Total</th>
                <th class="width2">Un</th>
                <th class="width3">Total</th>
                <th class="width2">Un</th>
                <th class="width3">Total</th>
                <th class="width2">Un</th>
                <th class="width3">Total</th>
                <th class="width2">Un</th>
                <th class="width3">Total</th>
            </tr>
            </thead>
        </table>
    </div>
    <div class="row">
        <div class="col-1">
            <button class="button" id="back" onClick="window.location='../menu.php'"><span>Terminar</span>
            </button>
        </div>
    </div>
</div>
</body>
</html>