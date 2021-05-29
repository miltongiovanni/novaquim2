<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Lista de Órdenes de Producción de Materia Prima</title>
    <meta charset="utf-8">
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../css/datatables.css">
    <style>
        table {
            table-layout: fixed;
        }

        .width1 {
            width: 3%;
        }

        .width2 {
            width: 5%;
        }

        .width3 {
            width: 32%;
        }

        .width4 {
            width: 20%;
        }

        .width5 {
            width: 25%;
        }

        .width6 {
            width: 15%;
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


        /* Formatting function for row details - modify as you need */
        function format(d) {
            // `d` is the original data object for the row
            rep = '<table cellpadding="5" cellspacing="0" border="0"  class="display compact" style="padding-left:50px;width:80%;margin:inherit;">' +
                '<thead>' +
                '<tr>' +
                '<th align="center">Código</th>' +
                '<th align="center">Materia Prima</th>';
            rep += '<th align="center">Lote MP</th>' +
                '<th align="center">Cantidad</th>' +
                '</tr>' +
                '</thead>';
            for (i = 0; i < d.detOProdMPrima.length; i++) {
                rep += '<tr>' +
                    '<td align="center">' + d.detOProdMPrima[i].idMPrima + '</td>' +
                    '<td align="center">' + d.detOProdMPrima[i].aliasMPrima + '</td>';
                rep += '<td align="center">' + d.detOProdMPrima[i].cantMPrima + '</td>' +
                    '<td align="center">' + d.detOProdMPrima[i].loteMPrima + '</td>' +
                    '</tr>'
            }
            rep += '</table>';

            return rep;
        }

        $(document).ready(function () {
            var table = $('#example').DataTable({
                "columns": [
                    {
                        "className": 'details-control',
                        "orderable": false,
                        "data": null,
                        "defaultContent": ''
                    },
                    {
                        "data": "loteMP",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "nomMPrima",
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
                        "data": function (row) {
                            let rep = row.cantKg + ' Kg'
                            return rep;
                        },
                        "className": 'dt-body-center'
                    },
                ],
                "order": [[1, 'desc']],
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
                "ajax": "ajax/listaOProdMPrima.php",
                "deferRender": true,  //For speed
            });
            // Add event listener for opening and closing details
            $('#example tbody').on('click', 'td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = table.row(tr);

                if (row.child.isShown()) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                } else {
                    // Open this row
                    row.child(format(row.data())).show();
                    tr.addClass('shown');
                }
            });
        });
    </script>
</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo1"><h4>LISTA DE ÓRDENES DE PRODUCCIÓN DE MATERIA PRIMA</h4></div>
    <div class="row flex-end">
        <div class="col-1">
            <button class="button" onclick="window.location='../menu.php'">
                <span><STRONG>Ir al Menú</STRONG></span></button>
        </div>
    </div>
    <div class="tabla-60">
        <table id="example" class="display compact formatoDatos">
            <thead>
            <tr>
                <th class="width1"></th>
                <th class="width2">Lote</th>
                <th class="width3">Materia prima</th>
                <th class="width4">Fecha producción</th>
                <th class="width5">Responsable</th>
                <th class="width6">Cantidad (Kg)</th>
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