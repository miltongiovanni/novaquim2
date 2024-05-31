<?php
include "../../../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Lista de órdenes de producción</title>
    <meta charset="utf-8">
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../css/datatables.css">
    <style>
        #example {
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


        /* Formatting function for row details - modify as you need */
        function format(d) {
            // `d` is the original data object for the row
            rep = '<table  class="display compact" style="padding-left:50px;width:50%;margin:inherit;">' +
                '<thead>' +
                '<tr>' +
                '<th class="text-center">Código</th>' +
                '<th class="text-center">Materia Prima</th>';
            rep += '<th class="text-center">Lote MP</th>' +
                '<th class="text-center">Cantidad</th>' +
                '</tr>' +
                '</thead>';
            for (i = 0; i < d.detOProd.length; i++) {
                rep += '<tr>' +
                    '<td class="text-center">' + d.detOProd[i].codMPrima + '</td>' +
                    '<td class="text-center">' + d.detOProd[i].aliasMPrima + '</td>';
                rep += '<td class="text-center">' + d.detOProd[i].cantidadMPrima + '</td>' +
                    '<td class="text-center">' + d.detOProd[i].loteMP + '</td>' +
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
                        "searchable": false,
                        "data": null,
                        "defaultContent": ''
                    },
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
                    {
                        "data": "descEstado",
                        "className": 'dt-body-left'
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
                processing: true,
                serverSide: true,
                "ajax": "ajax/listaOProd.php",
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
    <div id="saludo1">
        <img src="../images/LogoNova.jpg" alt="novaquim" class="img-fluid mb-2"><h4>LISTA DE ÓRDENES DE PRODUCCIÓN</h4></div>
    <div class="row flex-end">
        <div class="col-1">
            <button class="button" onclick="window.location='../menu.php'">
                <span><STRONG>Ir al Menú</STRONG></span></button>
        </div>
    </div>
    <div class="tabla-100">
        <table id="example" class="display compact formatoDatos">
            <thead>
            <tr>
                <th class="width1"></th>
                <th class="width2 text-center">Lote</th>
                <th class="width3 text-center">Producto</th>
                <th class="width4 text-center">Fórmula</th>
                <th class="width5 text-center">Fecha Producción</th>
                <th class="width6 text-center">Responsable</th>
                <th class="width7 text-center">Cantidad (Kg)</th>
                <th class="width8 text-center">Estado</th>
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