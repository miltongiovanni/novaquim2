<?php
include "../../../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Lista de Kits</title>
    <meta charset="utf-8">
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../../../css/datatables.css">
    <script src="../../../js/jquery-3.3.1.min.js"></script>
    <script src="../../../js/datatables.js"></script>
    <script>
        /* Formatting function for row details - modify as you need */
        function format(d) {
            // `d` is the original data object for the row
            rep = '<table  class="formatoDatos table table-sm table-striped" style="padding-left:50px;width:80%;margin:inherit; background-color: white">' +
                '<thead>' +
                '<tr>' +
                '<th class="text-center w-25">Código</th>' +
                '<th class="text-center w-75">Producto</th>';
            rep += '</thead>';
            for (i = 0; i < d.detKit.length; i++) {
                rep += '<tr>' +
                    '<td class="text-center">' + d.detKit[i].codProducto + '</td>' +
                    '<td class="text-center">' + d.detKit[i].producto + '</td>' +
                    '</tr>';
            }
            rep += '</table>';

            return rep;
        }

        $(document).ready(function () {
            var table = $('#example').DataTable({
                "columns": [
                    {
                        "className": 'dt-control',
                        "orderable": false,
                        "data": null,
                        "defaultContent": '',
                        width: '5%'
                    },
                    {
                        "data": "idKit",
                        "className": 'dt-body-center',
                        width: '5%'
                    },
                    {
                        "data": "codigo",
                        "className": 'dt-body-center',
                        width: '20%'
                    },
                    {
                        "data": "producto",
                        "className": 'dt-body-center',
                        width: '50%'
                    },
                    {
                        "data": "nomEnvase",
                        "className": 'dt-body-center',
                        width: '20%'
                    },
                ],
                "order": [[1, 'asc']],
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
                "paging": true,
                "buttons": [
                    'copyHtml5',
                    'excelHtml5'
                ],
                "lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
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
                "ajax": "../ajax/listaKits.php",
                "deferRender": true,  //For speed
            });
            // Add event listener for opening and closing details
            table.on('click', 'td.dt-control', function (e) {
                var tr = e.target.closest('tr');
                var row = table.row(tr);

                if (row.child.isShown()) {
                    // This row is already open - close it
                    row.child.hide();
                } else {
                    // Open this row
                    row.child(format(row.data())).show();
                }
            });
        });
    </script>
</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo1">
        <img src="../../../images/LogoNova.jpg" alt="novaquim" class="img-fluid mb-2"><strong>LISTADO DE KITS</strong></div>
    <div class="row flex-end">
        <div class="col-1">
            <button class="button" onclick="window.location='../../../menu.php'">
                <span><STRONG>Ir al Menú</STRONG></span></button>
        </div>
    </div>
    <div class="tabla-50">
        <table id="example" class="formatoDatos5 table table-sm table-striped">
            <thead>
            <tr>
                <th class=""></th>
                <th class="text-center">Id</th>
                <th class="text-center">Código</th>
                <th class="text-center">Producto</th>
                <th class="text-center">Envase</th>
            </tr>
            </thead>
        </table>
    </div>

    <div class="row">
        <div class="col-1">
            <button class="button" onclick="window.location='../../../menu.php'">
                <span><STRONG>Ir al Menú</STRONG></span>
            </button>
        </div>
    </div>

</div>
</body>
</html>