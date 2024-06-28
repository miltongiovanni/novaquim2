<?php
include "../../../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Facturas por pagar</title>
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
            width: 4%;
        }

        .width3 {
            width: 6%;
        }

        .width4 {
            width: 26%;
        }

        .width5 {
            width: 8%;
        }

        .width6 {
            width: 6%;
        }

        .width7 {
            width: 6%;
        }

        .width8 {
            width: 7%;
        }

        .width9 {
            width: 7%;
        }

        .width10 {
            width: 7%;
        }

        .width11 {
            width: 7%;
        }

        .width12 {
            width: 7%;
        }

        .width13 {
            width: 7%;
        }
    </style>
    <script src="../../../js/jquery-3.3.1.min.js"></script>
    <script src="../../../js/datatables.js"></script>
    

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
                            let rep = '<form action="../egreso/makeEgreso.php" method="post" name="elimina">' +
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
                        "className": 'pe-4'
                    },
                    {
                        "data": "nomProv",
                        "className": 'dt-body-left'
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
                        "className": 'pe-3'
                    },
                    {
                        "data": "retefuente",
                        "className": 'pe-3'
                    },
                    {
                        "data": "reteica",
                        "className": 'pe-3'
                    },
                    {
                        "data": "reteiva",
                        "className": 'pe-3'
                    },
                    {
                        "data": "aPagar",
                        "className": 'pe-3'
                    },
                    {
                        "data": "pago",
                        "className": 'pe-3'
                    },

                    {
                        "data": "saldo",
                        "className": 'pe-3'
                    },
                ],

                "order": [[6, 'asc']],
                "deferRender": true,  //For speed
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
                    'excelHtml5',
                    /*'pdfHtml5'*/
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
                "createdRow": function (row, data, dataIndex) {
                    if (diffDate(data.fechVenc) < 0) {
                        $('td', row).addClass('formatoDataTable1');
                    } else if (diffDate(data.fechVenc) >= 0 && diffDate(data.fechVenc) < 8) {
                        $('td', row).addClass('formatoDataTable2');
                    }
                },
                "ajax": "../ajax/listaFactXPagar.php"
            });
        });
    </script>
</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo1">
        <img src="../../../images/LogoNova.jpg" alt="novaquim" class="img-fluid mb-2"><h4>FACTURAS PENDIENTES DE PAGO POR INDUSTRIAS NOVAQUIM S.A.S.</h4></div>
    <div class="row flex-end">
        <div class="col-2">
            <form action="Imp_EstadoPagos.php" method="post" target="_blank">
                <button class="button" type="submit">
                    <span><STRONG>Imprimir Estado</STRONG></span></button>
            </form>
        </div>
        <div class="col-1">
            <button class="button" onclick="window.location='../../../menu.php'">
                <span><STRONG>Ir al Menú</STRONG></span></button>
        </div>
    </div>
    <div class="tabla-100">
        <table id="example" class="formatoDatos5 table table-sm table-striped">
            <thead>
            <tr>
                <th class="width1"></th>
                <th class="width2 text-center">Id</th>
                <th class="width3 text-center">Factura</th>
                <th class="width4 text-center">Proveedor</th>
                <th class="width5 text-center">Tipo Compra</th>
                <th class="width6 text-center">Fecha Factura</th>
                <th class="width7 text-center">Fecha Vto</th>
                <th class="width8 text-center">Valor Factura</th>
                <th class="width9 text-center">Retefuente</th>
                <th class="width10 text-center">Rete Ica</th>
                <th class="width10 text-center">Rete Iva</th>
                <th class="width11 text-center">Valor a Pagar</th>
                <th class="width12 text-center">Valor Pagado</th>
                <th class="width13 text-center">Saldo</th>
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
