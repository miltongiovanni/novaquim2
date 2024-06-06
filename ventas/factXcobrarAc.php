<?php
include "../../../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Facturas Vencidas por Cliente</title>
    <meta charset="utf-8">
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
    <link rel="stylesheet" href="../css/datatables.css">
    <style>
        #example {
            table-layout: fixed;
        }

        .width1 {
            width: 2%;
        }

        .width2 {
            width: 23%;
        }

        .width3 {
            width: 8%;
        }

        .width4 {
            width: 12%;
        }

        .width5 {
            width: 11%;
        }

        .width6 {
            width: 6%;
        }

        .width7 {
            width: 8%;
        }

        .width8 {
            width: 16%;
        }

        .width9 {
            width: 6%;
        }

        .width10 {
            width: 8%;
        }


    </style>
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/datatables.js"></script>

    <script>
        /* Formatting function for row details - modify as you need */
        function format(d) {
            // `d` is the original data object for the row
            rep = '<table class="formatoDatos table table-sm table-striped" style="padding-left:50px;width:100%;margin:inherit;">' +
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
                        "className": 'details-control',
                        "orderable": false,
                        "data": null,
                        "defaultContent": ''
                    },
                    {
                        "data": "nomCliente",
                        "className": 'dt-body-left'
                    },
                    {
                        "data": "nitCliente",
                        "className": 'text-center'
                    },
                    {
                        "data": "contactoCliente",
                        "className": 'dt-body-left'
                    },
                    {
                        "data": "cargoCliente",
                        "className": 'dt-body-left'
                    },
                    {
                        "data": "telCliente",
                        "className": 'text-center'
                    },
                    {
                        "data": "celCliente",
                        "className": 'text-center'
                    },
                    {
                        "data": "dirCliente",
                        "className": 'dt-body-left'
                    },
                    {
                        "data": "totalSaldoFormat",
                        "className": 'dt-body-right'
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
                    },
                ],
                "order": [[8, 'desc']],
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
                "ajax": "../ajax/listaCarteraAcumulada.php"
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
        <img src="../images/LogoNova.jpg" alt="novaquim" class="img-fluid mb-2"><h4>CARTERA VENCIDA POR CLIENTE</h4></div>
    <div class="row flex-end">
        <div class="col-1">
            <button class="button" onclick="window.location='../menu.php'">
                <span><STRONG>Ir al Menú</STRONG></span></button>
        </div>
    </div>
    <div class="tabla-100">
        <table id="example" class="formatoDatos table table-sm table-striped formatoDatos">
            <thead>
            <tr>
                <th class="width1"></th>
                <th class="width2 text-center">Cliente</th>
                <th class="width3 text-center">NIT</th>
                <th class="width4 text-center">Contacto</th>
                <th class="width5 text-center">Cargo</th>
                <th class="width6 text-center">Teléfono</th>
                <th class="width7 text-center">Celular</th>
                <th class="width8 text-center">Dirección</th>
                <th class="width9 text-center">Total adeucado</th>
                <th class="width10 text-center">Total adeucado</th>
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
</body>
</html>