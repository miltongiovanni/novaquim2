<?php
include "../includes/valAcc.php";
switch ($tipoCompra) {
    case 1:
        $titulo = ' materias primas';
        break;
    case 2:
        $titulo = ' envases y/o tapas';
        break;
    case 3:
        $titulo = ' etiquetas';
        break;
    case 5:
        $titulo = ' productos de distribución';
        break;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Lista de compras<?= $titulo ?></title>
    <meta charset="utf-8">
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
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
            var tipoCompra = <?= $tipoCompra ?>;
            switch (tipoCompra) {
                case 1:
                    tituloCampo = 'Materia Prima';
                    break
                case 2:
                    tituloCampo = 'Envase o Tapa';
                    break;
                case 3:
                    tituloCampo = 'Etiqueta';
                    break;
                case 5:
                    tituloCampo = 'Producto de distribución';
                    break;
            }
            // `d` is the original data object for the row
            rep = '<table cellpadding="5" cellspacing="0" border="0"  class="display compact" style="padding-left:50px;width:50%;margin:inherit;">' +
                '<thead>' +
                '<tr>' +
                '<th align="center">Código</th>' +
                '<th align="center">' + tituloCampo + '</th>';
            if (tipoCompra == 1) {
                rep += '<th align="center">Lote</th>';
            }
            rep += '<th align="center">Cantidad</th>' +
                '<th align="center">Precio</th>' +
                '</tr>' +
                '</thead>';
            for (i = 0; i < d.detCompra.length; i++) {
                rep += '<tr>' +
                    '<td align="center">' + d.detCompra[i].codigo + '</td>' +
                    '<td align="center">' + d.detCompra[i].Producto + '</td>';
                if (tipoCompra == 1) {
                    rep += '<td align="center">' + d.detCompra[i].lote + '</td>';
                }
                rep += '<td align="center">' + d.detCompra[i].cantidad + '</td>' +
                    '<td align="center">' + d.detCompra[i].precio + '</td>' +
                    '</tr>'
            }
            rep += '</table>';

            return rep;
        }

        $(document).ready(function () {
            var tipoCompra = <?= $tipoCompra ?>;
            var table = $('#example').DataTable({
                "columns": [
                    {
                        "className": 'details-control',
                        "orderable": false,
                        "data": null,
                        "defaultContent": ''
                    },
                    {
                        "data": "idCompra",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "nitProv",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "nomProv",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "numFact",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "fechComp",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "fechVenc",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "descEstado",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "totalCompra",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "retefuenteCompra",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "reteicaCompra",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "vreal",
                        "className": 'dt-body-center'
                    },
                ],
                "order": [[0, 'desc']],
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
                "ajax": "ajax/listaCompras.php?tipoCompra=" + tipoCompra
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
    <div id="saludo1"><h4>LISTADO DE COMPRAS<?= $titulo ?></h4></div>
    <div class="row flex-end">
        <div class="col-1">
            <button class="button" type="button" onclick="window.location='../menu.php'">
                <span><STRONG>Ir al Menú</STRONG></span></button>
        </div>
    </div>
    <div class="tabla-100">
        <table id="example" class="display compact formatoDatos">
            <thead>
            <tr>
                <th></th>
                <th width="6%">Id Compra</th>
                <th width="9%">NIT</th>
                <th width="22%">Proveedor</th>
                <th width="6%">Factura</th>
                <th width="8%">Fech Compra</th>
                <th width="7%">Fecha Vto</th>
                <th width="8%">Estado</th>
                <th width="8%">Valor Factura</th>
                <th width="8%">Retefuente</th>
                <th width="9%">Rete Ica</th>
                <th width="8%">Valor Real</th>
            </tr>
            </thead>
        </table>
    </div>

    <div class="row">
        <div class="col-1">
            <button class="button" type="button" onclick="window.location='../menu.php'">
                <span><STRONG>Ir al Menú</STRONG></span>
            </button>
        </div>
    </div>
</div>
</body>
</html>