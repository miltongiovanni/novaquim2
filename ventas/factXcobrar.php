<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Facturas por Cobrar</title>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../css/datatables.css">
    <style>
        #example {
            table-layout: fixed;
        }

        .width1 {
            width: 3%;
        }

        .width2 {
            width: 3%;
        }

        .width3 {
            width: 6%;
        }

        .width4 {
            width: 6%;
        }

        .width5 {
            width: 29%;
        }

        .width6 {
            width: 13%;
        }

        .width7 {
            width: 5%;
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

    </style>
<script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/datatables.js"></script>
    <script src="../js/dataTables.buttons.js"></script>
    <script src="../js/jszip.js"></script>
    <!--<script src="../js/pdfmake.js"></script>-->  <!--Para exportar PDF-->
    <!--<script src="../js/vfs_fonts.js"></script>--> <!--Para exportar PDF-->
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
            var perfil = <?=$_SESSION['Perfil']?>;
            var table = $('#example').DataTable({
                "columns": [
                    {
                        "orderable": false,
                        "data": function (row) {
                            let rep = '<form action="makeRecCaja.php" method="post" name="elimina">' +
                                '          <input name="idFactura" type="hidden" value="' + row.idFactura + '">' +
                                '          <input type="button" name="Submit" onclick="return Enviar(this.form)" class="formatoBoton1"  value="Cobrar">' +
                                '       </form>'
                            return rep;
                        },
                        "className": 'dt-body-center',
                        "visible": (perfil === '1' ||perfil === '11') ? false : true,
                    },
                    {
                        "data": "idFactura",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "fechaFactura",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "fechaVenc",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "nomCliente",
                        "className": 'dt-body-left'
                    },
                    {
                        "data": "contactoCliente",
                        "className": 'dt-body-left'
                    },
                    {
                        "data": "telCliente",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "celCliente",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "totalRFormat",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "TotalFormat",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "cobradoFormat",
                        "className": 'dt-body-center'
                    },

                    {
                        "data": "saldo",
                        "className": 'dt-body-center'
                    },
                ],

                "order": [[3, 'asc']],
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
                    if (diffDate(data.fechaVenc) < 0) {
                        $('td', row).addClass('formatoDataTable1');
                    } else if (diffDate(data.fechaVenc) >= 0 && diffDate(data.fechaVenc) < 8) {
                        $('td', row).addClass('formatoDataTable2');
                    }
                },
                "ajax": "ajax/listaFactXCobrar.php"
            });
        });
    </script>

</head>
<body>
<div id="contenedor">
    <div id="saludo1"><h4>FACTURAS PENDIENTES DE COBRO POR INDUSTRIAS NOVAQUIM S.A.S.</h4></div>
    <div class="row flex-end">
        <div class="col-2">
            <form action="Imp_EstadoCobros.php" method="post" target="_blank">
                <button class="button" type="submit">
                    <span><STRONG>Imprimir estado cartera</STRONG></span></button>
            </form>
        </div>
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
                <th class="width2">Factura</th>
                <th class="width3">Fecha de Factura</th>
                <th class="width4">Fecha Venc</th>
                <th class="width5">Cliente</th>
                <th class="width6">Contacto</th>
                <th class="width7">Teléfono</th>
                <th class="width8">Celular</th>
                <th class="width9">Valor Factura</th>
                <th class="width10">Valor a Cobrar</th>
                <th class="width11">Valor Cobrado</th>
                <th class="width12">Saldo</th>
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
