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
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
    <link rel="stylesheet" href="../../../css/datatables.css">
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
    <script src="../../../js/jquery-3.3.1.min.js"></script>
    <script src="../../../js/datatables.js"></script>


    <script>
        /* Formatting function for row details - modify as you need */
        function format(d) {
            // `d` is the original data object for the row
            rep = '<table class="formatoDatos5 table table-sm table-striped" style="padding-left:50px;width:50%;margin:inherit; background-color: white">' +
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
                        "className": 'dt-control',
                        "orderable": false,
                        "data": null,
                        "defaultContent": '',
                        width: '2%'
                    },
                    {
                        "data": "idFactura",
                        "className": 'text-center',
                        width: '8%'
                    },
                    {
                        "data": "fechaFactura",
                        "className": 'text-center',
                        width: '10%'
                    },
                    {
                        "data": "fechaVenc",
                        "className": 'text-center',
                        width: '10%'
                    },
                    {
                        "data": "totalFactura",
                        "className": 'dt-body-right pe-4',
                        width: '10%'
                    },
                    {
                        "data": "totalReal",
                        "className": 'dt-body-right pe-4',
                        width: '10%'
                    },
                    {
                        "data": "abono",
                        "className": 'dt-body-right pe-4',
                        width: '10%'
                    },
                    {
                        "data": "totalNotaC",
                        "className": 'dt-body-right pe-4',
                        width: '10%'
                    },
                    {
                        "data": "Saldo",
                        "className": 'dt-body-right pe-4',
                        width: '10%'
                    },
                    {
                        "data": "fechaCancelacion",
                        "className": 'text-center',
                        width: '10%'
                    },
                    {
                        "data": "estadoFactura",
                        "className": 'text-center',
                        width: '10%'
                    },
                ],
                "order": [[1, 'desc']],
                "deferRender": true,  //For speed
                initComplete: function (settings, json) {
                    $('#example thead th').removeClass('pe-4');
                },
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
        <img src="../../../images/LogoNova.jpg" alt="novaquim" class="img-fluid mb-2"><h4>ESTADO DE CUENTA <?= strtoupper($cliente['nomCliente']); ?></h4></div>
    <div class="row justify-content-end mb-3">
        <div class="col-1">
            <button class="button" onclick="window.location='../../../menu.php'">
                <span><STRONG>Ir al Menú</STRONG></span></button>
        </div>
    </div>
    <div class="tabla-70">
        <table id="example" class="formatoDatos5 table table-sm table-striped ">
            <thead>
            <tr>
                <th class=""></th>
                <th class="text-center">Factura</th>
                <th class="text-center">Fecha Factura</th>
                <th class="text-center">Fecha Vencimiento</th>
                <th class="text-center">Total Factura</th>
                <th class="text-center">Valor a Cobrar</th>
                <th class="text-center">Valor cobrado</th>
                <th class="text-center">Nota crédito</th>
                <th class="text-center">Saldo Pendiente</th>
                <th class="text-center">Fecha de Cancelación</th>
                <th class="text-center">Estado</th>
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
