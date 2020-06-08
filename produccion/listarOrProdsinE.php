<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
<title>Lista de Órdenes de Producción sin Envasar</title>
<meta charset="utf-8">
<link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../css/datatables.css">
    <style>
        table {
            table-layout: fixed;
        }

        .width1 {
            width: 2%;
        }

        .width2 {
            width: 4%;
        }

        .width3 {
            width: 25%;
        }

        .width4 {
            width: 24%;
        }

        .width5 {
            width: 12%;
        }

        .width6 {
            width: 16%;
        }

        .width7 {
            width: 9%;
        }

        .width8 {
            width: 8%;
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
            var table = $('#example').DataTable({
                "columns": [
                    {
                        "data": "lote",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "nomProducto",
                        "className": 'dt-body-left'
                    },
                    {
                        "data": "nomFormula",
                        "className": 'dt-body-left'
                    },
                    {
                        "data": "fechProd",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "nomPersonal",
                        "className": 'dt-body-left'
                    },
                    {
                        "data": "cantidadKg",
                        "className": 'dt-body-center'
                    },
                ],
                "order": [[0, 'desc']],
                "dom": 'Blfrtip',
                "paging": true,
                "buttons": [
                    'copyHtml5',
                    'excelHtml5'
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
                "ajax": "ajax/listaOProdSinEnvasar.php",
                "deferRender": true,  //For speed
            });
        });
    </script>
</head>
<body>
<div id="contenedor">
<div id="saludo1"><strong>LISTA DE ÓRDENES DE PRODUCCIÓN SIN ENVASAR</strong></div>
    <div class="row flex-end">
        <div class="col-1">
            <button class="button" onclick="window.location='../menu.php'">
                <span><STRONG>Ir al Menú</STRONG></span></button>
        </div>
    </div>
    <div class="tabla-80">
        <table id="example" class="display compact formatoDatos">
            <thead>
            <tr>
                <th class="width2">Lote</th>
                <th class="width3">Producto</th>
                <th class="width4">Fórmula</th>
                <th class="width5">Fecha Producción</th>
                <th class="width6">Responsable</th>
                <th class="width7">Cantidad (Kg)</th>
            </tr>
            </thead>
        </table>
    </div>

    <div class="row">
        <div class="col-1">
            <button class="button" onclick="window.location='../menu.php'">
                <span><STRONG>Ir al Menú</STRONG></span>
            </button>
        </div>
    </div>
</div>
</body>
</html>