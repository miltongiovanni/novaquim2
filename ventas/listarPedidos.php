<?php
include "../includes/valAcc.php";
switch ($estadoPedido) {
    case '6':
        $titulo = ' anulados';
        break;
    case '1':
        $titulo = ' pendientes';
        break;
    case 'N':
        $titulo = '';
        break;
    default:
        $titulo = '';
        break;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Lista de Órdenes de Pedido<?= $titulo ?></title>
    <meta charset="utf-8">
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../css/datatables.css">
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
            width: 26%;
        }

        .width4 {
            width: 5%;
        }

        .width5 {
            width: 5%;
        }

        .width6 {
            width: 26%;
        }

        .width7 {
            width: 17%;
        }

        .width8 {
            width: 7%;
        }
        .width9 {
            width: 7%;
        }
    </style>
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/datatables.js"></script>
    <script src="../js/dataTables.buttons.js"></script>
    <script src="../js/jszip.js"></script>
    <script src="../js/pdfmake.js"></script>
    <script src="../js/vfs_fonts.js"></script>
    <script src="../js/buttons.html5.js"></script>
    <script>
        /* Formatting function for row details - modify as you need */
        function format(d) {
            // `d` is the original data object for the row
            rep = '<table class="display compact formatoDatos" style="padding-left:50px;width:50%;margin:inherit;">' +
                '<thead>' +
                '<tr>' +
                '<th class="text-center">Código</th>' +
                '<th class="text-center">Producto</th>' +
                '<th class="text-center">Cantidad</th>' +
                '<th class="text-center">Precio Venta</th>' +
                '</thead>';
            for(i=0; i<d.detPedido.length; i++){
                rep += '<tr>' +
                    '<td class="text-center">' + d.detPedido[i].codProducto + '</td>' +
                    '<td  class="text-start">' + d.detPedido[i].Producto + '</td>' +
                    '<td class="text-center">' + d.detPedido[i].cantProducto + '</td>' +
                    '<td class="text-center">' + d.detPedido[i].precioProducto + '</td>' +
                    '</tr>'
            }

            rep += '</table>';

            return rep;
        }

        $(document).ready(function () {
            let estadoPedido = '<?=$estadoPedido?>';
            var table = $('#example').DataTable({
                "columns": [
                    {
                        "className": 'details-control',
                        "orderable": false,
                        "searchable": false,
                        "data": null,
                        "defaultContent": ''
                    },
                    {
                        "data": "idPedido",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "nomCliente",
                        "className": 'dt-body-left'
                    },
                    {
                        "data": "fechaPedido",
                        "className": 'dt-body-left'
                    },
                    {
                        "data": "fechaEntrega",
                        "className": 'dt-body-left'
                    },
                    {
                        "data": "nomSucursal",
                        "className": 'dt-body-left'
                    },
                    {
                        "data": "dirSucursal",
                        "className": 'dt-body-left'
                    },
                    {
                        "data": "tipoPrecio",
                        "className": 'dt-body-left'
                    },
                    {
                        "data": "estadoPedido",
                        "className": 'dt-body-left'
                    },
                ],
                "order": [[1, estadoPedido==='1'? 'asc':'desc']],
                "deferRender": true,  //For speed
                "dom": 'Blfrtip',
                "buttons": [
                    'copyHtml5',
                    'excelHtml5'
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
                processing: true,
                serverSide: true,
                "ajax": "ajax/listaPedidos.php?estadoPedido=" + estadoPedido,
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
        <img src="../images/LogoNova.jpg" alt="novaquim" class="img-fluid mb-2"><h4>LISTA DE ÓRDENES DE PEDIDO<?= $titulo ?></h4></div>
    <div class="row flex-end mb-3">
        <div class="col-1">
            <button class="button" onclick="window.location='../menu.php'">
                <span><STRONG>Ir al Menú</STRONG></span></button>
        </div>
    </div>
    <div class="tabla-100">
        <table id="example" class="display compact formatoDatos">
            <thead>
            <tr>
                <th class="width1 text-center"></th>
                <th class="width2 text-center">Pedido</th>
                <th class="width3 text-center">Cliente</th>
                <th class="width4 text-center">Fecha Pedido</th>
                <th class="width5 text-center">Fecha Entrega</th>
                <th class="width6 text-center">Lugar Entrega</th>
                <th class="width7 text-center">Dirección Entrega</th>
                <th class="width8 text-center">Precio</th>
                <th class="width9 text-center">Estado</th>
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