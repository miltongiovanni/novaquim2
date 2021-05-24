<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Histórico de Comprobantes de Egreso</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../css/datatables.css">
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <style>
        table {
            table-layout: fixed;
        }

        .width1 {
            width: 5%;
        }

        .width2 {
            width: 4%;
        }

        .width3 {
            width: 5%;
        }

        .width4 {
            width: 7%;
        }

        .width5 {
            width: 7%;
        }

        .width6 {
            width: 20%;
        }

        .width7 {
            width: 7%;
        }

        .width8 {
            width: 7%;
        }

        .width9 {
            width: 7%;
        }

        .width10 {
            width: 2%;
        }
        .width11 {
            width: 7%;
        }
        .width12 {
            width: 7%;
        }
        .width13 {
            width: 5%;
        }

        table.dataTable.compact thead th,
        table.dataTable.compact thead td {
            padding: 4px 4px 4px 4px;
        }
    </style>
<script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
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
                            let rep = '<form action="consultaEgreso.php" method="post" name="elimina">' +
                                '          <input name="idEgreso" type="hidden" value="' + row.idEgreso + '">' +
                                '          <input type="button" name="Submit" onclick="return Enviar(this.form)" class="formatoBoton1"  value="Consultar">' +
                                '       </form>'
                            return rep;
                        },
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "idEgreso",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "idCompra",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "tipoComp",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "nitProv",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "nomProv",
                        "className": 'dt-body-left'
                    },
                    {
                        "data": "numFact",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "vreal",
                        "className": 'dt-body-right'
                    },
                    {
                        "data": "pago",
                        "className": 'dt-body-right'
                    },
                    {
                        "data": "descuento",
                        "className": 'dt-body-right'
                    },
                    {
                        "data": "fechPago",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "formaPago",
                        "className": 'dt-body-center'
                    },

                    {
                        "orderable": false,
                        "data": function (row) {
                            let rep = '<form action="Imp_Egreso.php" method="post" target="_blank" name="impEgreso">' +
                                '          <input name="idEgreso" type="hidden" value="' + row.idEgreso + '">' +
                                '          <input type="button" name="Submit" onclick="return Enviar(this.form)" class="formatoBoton1"  value="Imprimir">' +
                                '       </form>'
                            return rep;
                        },
                        "className": 'dt-body-center'
                    },
                ],

                "order": [[1, 'desc']],
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
                "createdRow": function (row, data, dataIndex) {
                    if (diffDate(data.fechVenc) < 0) {
                        $('td', row).addClass('formatoDataTable1');
                    } else if (diffDate(data.fechVenc) >= 0 && diffDate(data.fechVenc) < 8) {
                        $('td', row).addClass('formatoDataTable2');
                    }
                },
                "ajax": "ajax/listaEgresos.php"
            });
        });
    </script>
</head>
<body>
<div id="contenedor">
    <div id="saludo1"><h4>HISTÓRICO DE COMPROBANTES DE EGRESO</h4></div>
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
                <th class="width1"></th>
                <th class="width2">Id</th>
                <th class="width3">Id Compra</th>
                <th class="width4">Tipo Compra</th>
                <th class="width5">Nit</th>
                <th class="width6">Proveedor</th>
                <th class="width7">Factura</th>
                <th class="width8">Valor a Pagar</th>
                <th class="width9">Valor Pagado</th>
                <th class="width10">Desc</th>
                <th class="width11">Fecha Pago</th>
                <th class="width12">Forma de Pago</th>
                <th class="width13"></th>
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