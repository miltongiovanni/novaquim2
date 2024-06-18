<?php
include "../../../includes/valAcc.php";
include "../../../includes/calcularDias.php";
$idCliente = $_POST['idCliente'];
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$OperadorCliente = new ClientesOperaciones();
$cliente = $OperadorCliente->getCliente($idCliente);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Estado de Cuenta por Cliente</title>
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
            width: 8%;
        }

        .width3 {
            width: 10%;
        }

        .width4 {
            width: 10%;
        }

        .width5 {
            width: 10%;
        }

        .width6 {
            width: 10%;
        }

        .width7 {
            width: 10%;
        }

        .width8 {
            width: 10%;
        }

        .width9 {
            width: 10%;
        }

        .width10 {
            width: 10%;
        }

        .width11 {
            width: 10%;
        }
    </style>
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/datatables.js"></script>
    

    <script>
        /* Formatting function for row details - modify as you need */
        function format(d) {
            // `d` is the original data object for the row
            rep = '<table class="formatoDatos table table-sm table-striped formatoDatos" style="padding-left:50px;width:50%;margin:inherit;">' +
                '<thead>' +
                '<tr>' +
                '<th class="text-center">Recibo de Caja</th>' +
                '<th class="text-center">Valor</th>' +
                '<th class="text-center">Fecha</th>' +
                '<th class="text-center">Forma de pago</th>' +
                '</thead>';
            for (i = 0; i < d.detEstado.length; i++) {
                rep += '<tr>' +
                    '<td class="text-center">' + d.detEstado[i].idRecCaja + '</td>' +
                    '<td class="text-start">' + d.detEstado[i].pago + '</td>' +
                    '<td class="text-center">' + d.detEstado[i].fechaRecCaja + '</td>' +
                    '<td class="text-center">' + d.detEstado[i].formaPago + '</td>' +
                    '</tr>'
            }

            rep += '</table>';

            return rep;
        }

        $(document).ready(function () {

            let idCliente = <?=$idCliente?>;
            var table = $('#example').DataTable({
                "columns": [
                    {
                        "className": 'details-control',
                        "orderable": false,
                        "data": null,
                        "defaultContent": ''
                    },
                    {
                        "data": "idFactura",
                        "className": 'text-center'
                    },
                    {
                        "data": "fechaFactura",
                        "className": 'text-center'
                    },
                    {
                        "data": "fechaVenc",
                        "className": 'text-center'
                    },
                    {
                        "data": "totalFactura",
                        "className": 'dt-body-right'
                    },
                    {
                        "data": "totalReal",
                        "className": 'dt-body-right'
                    },
                    {
                        "data": "abono",
                        "className": 'dt-body-right'
                    },
                    {
                        "data": "totalNotaC",
                        "className": 'dt-body-right'
                    },
                    {
                        "data": "Saldo",
                        "className": 'dt-body-right'
                    },
                    {
                        "data": "fechaCancelacion",
                        "className": 'text-center'
                    },
                    {
                        "data": "estadoFactura",
                        "className": 'text-center'
                    },
                ],
                "order": [[1, 'desc']],
                "deferRender": true,  //For speed
                "dom": 'Blfrtip',
                "buttons": [
                    'copyHtml5',
                    'excelHtml5'
                ],
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
                "ajax": "../ajax/listaEstadoCuentaCliente.php?idCliente=" + idCliente,
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
        <img src="../images/LogoNova.jpg" alt="novaquim" class="img-fluid mb-2"><h4>ESTADO DE CUENTA <?= strtoupper($cliente['nomCliente']); ?></h4></div>
    <div class="row flex-end mb-3">
        <div class="col-1">
            <button class="button" onclick="window.location='../menu.php'">
                <span><STRONG>Ir al Menú</STRONG></span></button>
        </div>
    </div>
    <div class="tabla-70">
        <table id="example" class="formatoDatos table table-sm table-striped formatoDatos">
            <thead>
            <tr>
                <th class="width1"></th>
                <th class="width2 text-center">Factura</th>
                <th class="width3 text-center">Fecha Factura</th>
                <th class="width4 text-center">Fecha Vencimiento</th>
                <th class="width5 text-center">Total Factura</th>
                <th class="width6 text-center">Valor a Cobrar</th>
                <th class="width7 text-center">Valor cobrado</th>
                <th class="width8 text-center">Nota crédito</th>
                <th class="width9 text-center">Saldo Pendiente</th>
                <th class="width10 text-center">Fecha de Cancelación</th>
                <th class="width11 text-center">Estado</th>
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
