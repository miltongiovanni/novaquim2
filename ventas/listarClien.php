<?php
include "../includes/valAcc.php";
include "../includes/calcularDias.php";

if(isset($_GET['estadocliente'])){
    $estadoCliente = $_GET['estadocliente'];
}
if ($estadoCliente == 1) {
    $titulo = 'Lista de Clientes Activos';
    $encabezado = 'LISTADO DE CLIENTES ACTIVOS DE INDUSTRIAS NOVAQUIM';
} else {
    $titulo = 'Lista de Clientes No Activos';
    $encabezado = 'LISTADO DE CLIENTES INACTIVOS DE INDUSTRIAS NOVAQUIM';

}


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title><?= $titulo ?></title>


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
            rep = '<table cellpadding="5" cellspacing="0" border="0"  class="display compact" style="padding-left:50px;width:80%;margin:inherit;">' +
                '<thead>' +
                '<tr>' +
                '<th align="center">Contacto</th>' +
                '<th align="center">Cargo Contacto</th>' +
                '<th align="center">Teléfono</th>' +
                '<th align="center">Ciudad</th>' +
                '<th align="center">Celular</th>' +
                '<th align="center">Correo Electrónico</th>' +
                '</thead>';
                rep += '<tr>' +
                    '<td align="center">' + d.contactoCliente + '</td>' +
                    '<td align="center">' + d.cargoCliente + '</td>' +
                    '<td align="center">' + d.telCliente + '</td>' +
                    '<td align="center">' + d.ciudad + '</td>' +
                    '<td align="center">' + d.celCliente + '</td>' +
                    '<td align="center">' + d.emailCliente + '</td>' +
                    '</tr>'
            rep += '</table>';

            return rep;
        }
        /* Formatting function for row details - modify as you need */
        function diffDate(fecha) {
            let fechUltCompra = new Date(fecha);
            let hoy = new Date();

            // The number of milliseconds in one day
            const ONE_DAY = 1000 * 60 * 60 * 24;

            // Calculate the difference in milliseconds
            const differenceMs = hoy - fechUltCompra;
            // Convert back to days and return
            return Math.round(differenceMs / ONE_DAY);
        }
        $(document).ready(function () {
            let estadoCliente = <?=$estadoCliente?>;
            var table = $('#example').DataTable({
                "columns": [
                    {
                        "className": 'details-control',
                        "orderable": false,
                        "data": null,
                        "defaultContent": ''
                    },
                    {
                        "data": "nitCliente",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "nomCliente",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "dirCliente",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "desCatClien",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "nomPersonal",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "ultimaCompra",
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
                "createdRow": function (row, data, dataIndex) {
                if (diffDate(data.ultimaCompra) > 120) {
                    $('td', row).addClass('formatoDataTable1');
                } else if (diffDate(data.ultimaCompra) <= 120 && diffDate(data.ultimaCompra) > 60) {
                    $('td', row).addClass('formatoDataTable2');
                }
            },
                "ajax": "ajax/listaClientes.php?estadoCliente=" + estadoCliente
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
    <div id="saludo1"><strong><?= $encabezado ?></strong></div>
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
                <th></th>
                <th>NIT</th>
                <th>Cliente</th>
                <th>Dirección</th>
                <th>Tipo de Cliente</th>
                <th>Vendedor</th>
                <th>Última compra</th>
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