<?php
include "../../../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Facturas Vencidas por Cliente</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../../../css/datatables.css">
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
    <script src="../../../js/jquery-3.3.1.min.js"></script>
    <script src="../../../js/datatables.js"></script>
    <script>
        /* Formatting function for row details - modify as you need */
        function format(d) {
            // `d` is the original data object for the row
            rep = '<table class="formatoDatos5 table table-sm table-striped" style="padding-left:50px;width:100%;margin:inherit; background-color: white">' +
                '<thead>' +
                '<tr>' +
                '<th class="text-center">Factura</th>' +
                '<th class="text-center">F Factura</th>' +
                '<th class="text-center">F Vencimiento</th>' +
                '<th class="text-center">Subtotal</th>' +
                '<th class="text-center">Reteiva</th>' +
                '<th class="text-center">Reteica</th>' +
                '<th class="text-center">Retefuente</th>' +
                '<th class="text-center">Iva</th>' +
                '<th class="text-center">Total</th>' +
                '<th class="text-center">V Cobrar</th>' +
                '<th class="text-center">Abonos</th>' +
                '<th class="text-center">Saldo</th>' +
                '</thead>';

            for (i = 0; i < d.detCarteraCliente.length; i++) {
                rep += '<tr>' +
                    '<td class="text-center">' + d.detCarteraCliente[i].idFactura + '</td>' +
                    '<td class="text-center">' + d.detCarteraCliente[i].fechaFactura + '</td>' +
                    '<td class="text-center">' + d.detCarteraCliente[i].fechaVenc + '</td>' +
                    '<td class="text-center">' + d.detCarteraCliente[i].SubtotalFormat + '</td>' +
                    '<td class="text-center">' + d.detCarteraCliente[i].retencionIvaFormat + '</td>' +
                    '<td class="text-center">' + d.detCarteraCliente[i].retencionIcaFormat + '</td>' +
                    '<td class="text-center">' + d.detCarteraCliente[i].retencionFteFormat + '</td>' +
                    '<td class="text-center">' + d.detCarteraCliente[i].ivaFormat + '</td>' +
                    '<td class="text-center">' + d.detCarteraCliente[i].totalRFormat + '</td>' +
                    '<td class="text-center">' + d.detCarteraCliente[i].TotalFormat + '</td>' +
                    '<td class="text-center">' + d.detCarteraCliente[i].cobradoFormat + '</td>' +
                    '<td class="text-center">' + d.detCarteraCliente[i].saldo + '</td>' +
                    '</tr>'
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
                        width: '2%'
                    },
                    {
                        "data": "nomCliente",
                        "className": 'dt-body-left',
                        width: '23%'
                    },
                    {
                        "data": "nitCliente",
                        "className": 'text-center',
                        width: '8%'
                    },
                    {
                        "data": "contactoCliente",
                        "className": 'dt-body-left',
                        width: '12%'
                    },
                    {
                        "data": "cargoCliente",
                        "className": 'dt-body-left',
                        width: '11%'
                    },
                    {
                        "data": "telCliente",
                        "className": 'text-center',
                        width: '6%'
                    },
                    {
                        "data": "celCliente",
                        "className": 'text-center',
                        width: '8%'
                    },
                    {
                        "data": "dirCliente",
                        "className": 'dt-body-left',
                        width: '16%'
                    },
                    {
                        "data": "totalSaldoFormat",
                        "className": 'dt-body-right pe-4',
                        width: '6%'
                    },
                    {
                        "orderable": false,
                        "data": function (row) {
                            let rep = '<form action="XlsFactXcobrarAc.php" method="post" name="export">' +
                                '          <input name="idCliente" type="hidden" value="' + row.idCliente + '">' +
                                '          <input name="nomCliente" type="hidden" value="' + row.nomCliente + '">' +
                                '          <input type="button" name="Submit" onclick="return Enviar(this.form)" class="formatoBoton1"  value="Exportar a Excel">' +
                                '       </form>'
                            return rep;
                        },
                        "className": 'text-center',
                        width: '8%'
                    },
                ],
                "order": [[8, 'desc']],
                "deferRender": true,  //For speed
                initComplete: function (settings, json) {
                    $('#example thead th').removeClass('pe-4');
                },
                "lengthMenu": [[20, 50, 100, -1], [20, 50, 100, "All"]],
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
                "ajax": "../ajax/listaCarteraAcumulada.php"
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
        <img src="../../../images/LogoNova.jpg" alt="novaquim" class="img-fluid mb-2"><h4>CARTERA VENCIDA POR CLIENTE</h4></div>
    <div class="row justify-content-end">
        <div class="col-1">
            <button class="button" onclick="window.location='../../../menu.php'">
                <span><STRONG>Ir al Menú</STRONG></span></button>
        </div>
    </div>
    <div class="tabla-100">
        <table id="example" class="formatoDatos5 table table-sm table-striped">
            <thead>
            <tr>
                <th class=""></th>
                <th class="text-center">Cliente</th>
                <th class="text-center">NIT</th>
                <th class="text-center">Contacto</th>
                <th class="text-center">Cargo</th>
                <th class="text-center">Teléfono</th>
                <th class="text-center">Celular</th>
                <th class="text-center">Dirección</th>
                <th class="text-center">Total adeucado</th>
                <th class="text-center">Total adeucado</th>
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
</body>
</html>