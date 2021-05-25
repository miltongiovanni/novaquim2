<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Lista de Clientes de Cotización</title>
    <meta charset="utf-8">
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../css/datatables.css">
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/datatables.js"></script>
    <script src="../js/dataTables.buttons.js"></script>
    <script src="../js/jszip.js"></script>
    <script src="../js/pdfmake.js"></script>
    <script src="../js/vfs_fonts.js"></script>
    <script src="../js/buttons.html5.js"></script>
    <script>
        /* Formatting function for row details - modify as you need */
        function format(d) {
            // `d` is the original data object for the row
            rep = '<table cellpadding="5" cellspacing="0" border="0"  class="display compact" style="padding-left:50px;width:60%;margin:inherit;">' +
                '<thead>' +
                '<tr>' +
                '<th align="center">Dirección</th>' +
                '<th align="center">Ciudad</th>' +
                '<th align="center">Correo Electrónico</th>' +
                '<th align="center">Celular</th>' +
                '<th align="center">Vendedor</th>' +
                '</thead>';
            rep += '<tr>' +
                '<td align="center">' + d.dirCliente + '</td>' +
                '<td align="center">' + d.ciudad + '</td>' +
                '<td align="center">' + d.emailCliente + '</td>' +
                '<td align="center">' + d.celCliente + '</td>' +
                '<td align="center">' + d.nomPersonal + '</td>' +
                '</tr>'
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
                        "data": "idCliente",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "nomCliente",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "contactoCliente",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "cargoContacto",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "telCliente",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "desCatClien",
                        "className": 'dt-body-center'
                    },
                ],
                "order": [[2, 'asc']],
                "deferRender": true,  //For speed
                "dom": 'Blfrtip',
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
                "ajax": "ajax/listaClientesCotizacion.php"
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
<div id="contenedor">
    <div id="saludo1"><h4>LISTA DE CLIENTES DE COTIZACIÓN</h4></div>
    <div class="row flex-end mb-3">
        <div class="col-1">
            <button class="button" onclick="window.location='../menu.php'">
                <span><STRONG>Ir al Menú</STRONG></span></button>
        </div>
    </div>
    <div class="tabla-90">
        <table id="example" class="display compact formatoDatos">
            <thead>
            <tr>
                <th></th>
                <th>Id</th>
                <th>Cliente</th>
                <th>Contacto</th>
                <th>Cargo Contacto</th>
                <th>Teléfono</th>
                <th>Actividad</th>
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