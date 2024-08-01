<?php
include "../../../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Histórico de Comprobantes de Egreso</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../../../css/datatables.css">
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
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
                            let rep = '<form action="../egreso/consultaEgreso.php" method="post" name="elimina">' +
                                '          <input name="idEgreso" type="hidden" value="' + row.idEgreso + '">' +
                                '          <input type="button" name="Submit" onclick="return Enviar(this.form)" class="formatoBoton1"  value="Consultar">' +
                                '       </form>'
                            return rep;
                        },
                        "className": 'dt-body-center',
                        width: '5%'
                    },
                    {
                        "data": "idEgreso",
                        "className": 'dt-body-center',
                        width: '4%'
                    },
                    {
                        "data": "idCompra",
                        "className": 'dt-body-center',
                        width: '5%'
                    },
                    {
                        "data": "tipoComp",
                        "className": '',
                        width: '7%'
                    },
                    {
                        "data": "nitProv",
                        "className": 'dt-body-right pe-4',
                        width: '7%'
                    },
                    {
                        "data": "nomProv",
                        "className": 'dt-body-left',
                        width: '20%'
                    },
                    {
                        "data": "numFact",
                        "className": 'pe-4',
                        width: '7%'
                    },
                    {
                        "data": "vreal",
                        "className": 'pe-4',
                        width: '7%'
                    },
                    {
                        "data": "pago",
                        "className": 'pe-4',
                        width: '7%'
                    },
                    {
                        "data": "descuento",
                        "className": 'pe-4',
                        width: '2%'
                    },
                    {
                        "data": "fechPago",
                        "className": 'dt-body-center',
                        width: '7%'
                    },
                    {
                        "data": "formaPago",
                        "className": '',
                        width: '7%'
                    },

                    {
                        "orderable": false,
                        "data": function (row) {
                            let rep = '<form action="../egreso/Imp_Egreso.php" method="post" target="_blank" name="impEgreso">' +
                                '          <input name="idEgreso" type="hidden" value="' + row.idEgreso + '">' +
                                '          <input type="button" name="Submit" onclick="return Enviar(this.form)" class="formatoBoton1"  value="Imprimir">' +
                                '       </form>'
                            return rep;
                        },
                        "className": 'dt-body-center',
                        width: '5%'
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
                "ajax": "../ajax/listaEgresos.php"
            });
        });
    </script>
</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo1">
        <img src="../../../images/LogoNova.jpg" alt="novaquim" class="img-fluid mb-2"><h4>HISTÓRICO DE COMPROBANTES DE EGRESO</h4></div>
    <div class="row justify-content-end">
        <div class="col-1">
            <button class="button" type="button" onclick="window.location='../../../menu.php'">
                <span><STRONG>Ir al Menú</STRONG></span></button>
        </div>
    </div>
    <div class="tabla-100">
        <table id="example" class="formatoDatos5 table table-sm table-striped">
            <thead>
            <tr>
                <th class="width1 text-center"></th>
                <th class="width2 text-center">Id</th>
                <th class="width3 text-center">Id Compra</th>
                <th class="width4 text-center">Tipo Compra</th>
                <th class="width5 text-center">Nit</th>
                <th class="width6 text-center">Proveedor</th>
                <th class="width7 text-center">Factura</th>
                <th class="width8 text-center">Valor a Pagar</th>
                <th class="width9 text-center">Valor Pagado</th>
                <th class="width10 text-center">Desc</th>
                <th class="width11 text-center">Fecha Pago</th>
                <th class="width12 text-center">Forma de Pago</th>
                <th class="width13 text-center"></th>
            </tr>
            </thead>
        </table>
    </div>
    <div class="row">
        <div class="col-1">
            <button class="button" type="button" onclick="window.location='../../../menu.php'">
                <span><STRONG>Ir al Menú</STRONG></span>
            </button>
        </div>
    </div>

</div>
</body>
</html>