<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Facturas por pagar</title>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
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
        function diffDate(fecha) {
            let fechVenc = new Date(fecha);
            let hoy = new Date();

            // The number of milliseconds in one day
            const ONE_DAY = 1000 * 60 * 60 * 24;

            // Calculate the difference in milliseconds
            const differenceMs = fechVenc - hoy;
            // Convert back to days and return
            return Math.round(differenceMs / ONE_DAY);
        }

        $(document).ready(function () {

            var table = $('#example').DataTable({
                "columns": [
                    {
                        "orderable": false,
                        "data": function (row) {
                            let rep = '<form action="makeEgreso.php" method="post" name="elimina">' +
                                '          <input name="tipoCompra" type="hidden" value="' + row.tipoCompra + '">' +
                                '          <input name="idCompra" type="hidden" value="' + row.id + '">' +
                                '          <input type="button" name="Submit" onclick="return Enviar(this.form)" class="formatoBoton1"  value="Pagar">' +
                                '       </form>'
                            return rep;
                        },
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "id",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "numFact",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "nomProv",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "tipoComp",
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
                        "data": "total",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "retefuente",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "reteica",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "aPagar",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "pago",
                        "className": 'dt-body-center'
                    },

                    {
                        "data": "saldo",
                        "className": 'dt-body-center'
                    },
                ],

                "order": [[5, 'asc']],
                "deferRender": true,  //For speed
                "dom": 'Blfrtip',
                "buttons": [
                    'copyHtml5',
                    'excelHtml5',
                    /*'pdfHtml5'*/
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
                "createdRow": function ( row, data, dataIndex ) {
                    if ( diffDate(data.fechVenc) < 0 ) {
                        $('td', row).addClass('formatoDataTable1');
                    }
                    else if ( diffDate(data.fechVenc) >= 0 && diffDate(data.fechVenc) < 8 ){
                        $('td', row).addClass('formatoDataTable2');
                    }
                },
                "ajax": "ajax/listaFactXPagar.php"
            });
        });
    </script>
</head>
<body>
<div id="contenedor">
    <div id="saludo1"><strong>FACTURAS PENDIENTES DE PAGO POR INDUSTRIAS NOVAQUIM S.A.S.</strong></div>
    <div class="row" style="justify-content: flex-end;">
        <div class="col-2">
            <form action="Imp_EstadoPagos.php" method="post" target="_blank">
                <button class="button" type="submit">
                    <span><STRONG>Imprimir Estado</STRONG></span></button>
            </form>
        </div>
        <div class="col-1">
            <button class="button" onclick="window.location='../menu.php'">
                <span><STRONG>Ir al Menú</STRONG></span></button>
        </div>
    </div>
    <div class="tabla-100">
        <table id="example" class="display compact formatoDatos">
            <thead>
            <tr>
                <th width="2%"></th>
                <th width="4%">Id</th>
                <th width="6%">Factura</th>
                <th width="26%">Proveedor</th>
                <th width="8%">Tipo Compra</th>
                <th width="6%">Fecha Factura</th>
                <th width="6%">Fecha Vto</th>
                <th width="7%">Valor Factura</th>
                <th width="7%">Retefuente</th>
                <th width="7%">Rete Ica</th>
                <th width="7%">Valor a Pagar</th>
                <th width="7%">Valor Pagado</th>
                <th width="7%">Saldo</th>
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
