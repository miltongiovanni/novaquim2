<?php
include "../../../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Pedidos rutero</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../css/datatables.css">
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <style>
        table {
            table-layout: fixed;
        }

        .width1 {
            width: 6%;
        }

        .width2 {
            width: 6%;
        }

        .width3 {
            width: 6%;
        }

        .width4 {
            width: 6%;
        }

        .width5 {
            width: 30%;
        }

        .width6 {
            width: 30%;
        }

        .width7 {
            width: 6%;
        }

        .width8 {
            width: 6%;
        }
        .width9 {
            width: 10%;
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
                        "data": "idPedido",
                        "className": 'text-center'
                    },
                    {
                        "data": "idFactura",
                        "className": 'text-center'
                    },
                    {
                        "data": "idRemision",
                        "className": 'text-center'
                    },
                    {
                        "data": "fechaPedido",
                        "className": 'text-center'
                    },
                    {
                        "data": "nomCliente",
                        "className": 'dt-body-left'
                    },
                    {
                        "data": "nomSucursal",
                        "className": 'dt-body-left'
                    },
                    {
                        "data": "idRutero",
                        "className": 'text-center'
                    },
                    {
                        "data": "fechaRutero",
                        "className": 'text-center'
                    },

                    {
                        "orderable": false,
                        "data": function (row) {
                            let rep = '<form action="confirmarEntregaForm.php" method="post" name="confirmarEntrega">' +
                                '          <input name="idPedido" type="hidden" value="' + row.idPedido + '">' +
                                '          <input name="fechaRutero" type="hidden" value="' + row.fechaRutero + '">' +
                                '          <input type="button" name="Submit" onclick="return Enviar(this.form)" class="formatoBoton1"  value="Confirmar entrega">' +
                                '       </form>'
                            return rep;
                        },
                        "className": 'text-center'
                    },
                ],

                "order": [[1, 'desc']],
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
                "ajax": "../ajax/listaPedEnRuta.php"
            });
        });
    </script>
</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo1">
        <img src="../images/LogoNova.jpg" alt="novaquim" class="img-fluid mb-2"><h4>PEDIDOS EN RUTA</h4></div>
    <div class="row justify-content-end">
        <div class="col-1">
            <button class="button" onclick="window.location='../menu.php'">
                <span><STRONG>Ir al Menú</STRONG></span></button>
        </div>
    </div>
    <div class="tabla-90">
        <table id="example" class="formatoDatos table table-sm table-striped formatoDatos">
            <thead>
            <tr>
                <th class="width1">Pedido</th>
                <th class="width2 text-center">Factura</th>
                <th class="width3 text-center">Remisión</th>
                <th class="width4 text-center">Fecha pedido</th>
                <th class="width5 text-center">Cliente</th>
                <th class="width6 text-center">Lugar entrega</th>
                <th class="width7 text-center">Rutero</th>
                <th class="width8 text-center">Fecha Rutero</th>
                <th class="width9 text-center"></th>

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