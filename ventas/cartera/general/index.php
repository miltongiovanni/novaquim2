<?php
include "../../../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Facturas por Cobrar</title>
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../../../css/datatables.css">
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
<script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
    <script src="../../../js/jquery-3.3.1.min.js"></script>
    <script src="../../../js/datatables.js"></script>
    <script src="../../../js/dataTables.buttons.js"></script>
    <script src="../../../js/jszip.js"></script>
    <!--<script src="../js/pdfmake.js"></script>-->  <!--Para exportar PDF-->
    <!--<script src="../js/vfs_fonts.js"></script>--> <!--Para exportar PDF-->
    <script src="../../../js/buttons.html5.js"></script>
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
            var perfil = <?=$_SESSION['perfilUsuario']?>;
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
                        "className": 'text-center',
                        "visible": (perfil == 1 || perfil == 11 ) ? true :  false,
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
                        "data": "nomCliente",
                        "className": 'dt-body-left'
                    },
                    {
                        "data": "contactoCliente",
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
                        "data": "totalRFormat",
                        "className": 'text-center'
                    },
                    {
                        "data": "TotalFormat",
                        "className": 'text-center'
                    },
                    {
                        "data": "cobradoFormat",
                        "className": 'text-center'
                    },

                    {
                        "data": "saldo",
                        "className": 'text-center'
                    },
                ],

                "order": [[3, 'asc']],
                "deferRender": true,  //For speed
                initComplete: function (settings, json) {
                    $('#example thead th').removeClass('pe-5');
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
                    if (diffDate(data.fechaVenc) < 0) {
                        $('td', row).addClass('formatoDataTable1');
                    } else if (diffDate(data.fechaVenc) >= 0 && diffDate(data.fechaVenc) < 8) {
                        $('td', row).addClass('formatoDataTable2');
                    }
                },
                "ajax": "../ajax/listaFactXCobrar.php"
            });
        });
    </script>

</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo1">
        <img src="../../../images/LogoNova.jpg" alt="novaquim" class="img-fluid mb-2"><h4>FACTURAS PENDIENTES DE COBRO POR INDUSTRIAS NOVAQUIM S.A.S.</h4></div>
    <div class="row justify-content-end">
        <div class="col-2">
            <form action="Imp_EstadoCobros.php" method="post" target="_blank">
                <button class="button" type="submit">
                    <span><STRONG>Imprimir estado cartera</STRONG></span></button>
            </form>
        </div>
        <div class="col-1">
            <button class="button" type="button" onclick="window.location='../../../menu.php'">
                <span><STRONG>Ir al Menú</STRONG></span></button>
        </div>
    </div>
    <div class="tabla-100">
        <table id="example" class="formatoDatos table table-sm table-striped formatoDatos">
            <thead>
            <tr>
                <th class="width1"></th>
                <th class="width2 text-center">Factura</th>
                <th class="width3 text-center">Fecha de Factura</th>
                <th class="width4 text-center">Fecha Venc</th>
                <th class="width5 text-center">Cliente</th>
                <th class="width6 text-center">Contacto</th>
                <th class="width7 text-center">Teléfono</th>
                <th class="width8 text-center">Celular</th>
                <th class="width9 text-center">Valor Factura</th>
                <th class="width10 text-center">Valor a Cobrar</th>
                <th class="width11 text-center">Valor Cobrado</th>
                <th class="width12 text-center">Saldo</th>
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
