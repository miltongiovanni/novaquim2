<?php
include "../../../includes/valAcc.php";
switch ($tipoCompra) {
    case 1:
        $titulo = ' materias primas';
        break;
    case 2:
        $titulo = ' envases y/o tapas';
        break;
    case 3:
        $titulo = ' etiquetas';
        break;
    case 5:
        $titulo = ' productos de distribución';
        break;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Lista de compras<?= $titulo ?></title>
    <meta charset="utf-8">
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
            width: 6%;
        }

        .width3 {
            width: 8%;
        }

        .width4 {
            width: 21%;
        }

        .width5 {
            width: 6%;
        }

        .width6 {
            width: 8%;
        }

        .width7 {
            width: 7%;
        }

        .width8 {
            width: 8%;
        }
        .width9 {
            width: 8%;
        }
        .width10 {
            width: 8%;
        }

        .width11 {
            width: 9%;
        }
        .width12 {
            width: 9%;
        }
    </style>
    <script src="../../../js/jquery-3.3.1.min.js"></script>
    <script src="../../../js/datatables.js"></script>
    

    <script>


        /* Formatting function for row details - modify as you need */
        function format(d) {
            var tipoCompra = <?= $tipoCompra ?>;
            switch (tipoCompra) {
                case 1:
                    tituloCampo = 'Materia Prima';
                    break
                case 2:
                    tituloCampo = 'Envase o Tapa';
                    break;
                case 3:
                    tituloCampo = 'Etiqueta';
                    break;
                case 5:
                    tituloCampo = 'Producto de distribución';
                    break;
            }
            // `d` is the original data object for the row
            rep = '<table class="table-sm formatoDatos5 table table-striped " style="padding-left:50px;width:50%;margin:inherit; background-color: white ">' +
                '<thead>' +
                '<tr>' +
                '<th class="text-center">Código</th>' +
                '<th class="text-center">' + tituloCampo + '</th>';
            if (tipoCompra == 1) {
                rep += '<th class="text-center">Lote</th>';
            }
            rep += '<th class="text-center">Cantidad</th>' +
                '<th class="text-center">Precio</th>' +
                '</tr>' +
                '</thead>';
            for (i = 0; i < d.detCompra.length; i++) {
                rep += '<tr>' +
                    '<td class="text-center">' + d.detCompra[i].codigo + '</td>' +
                    '<td class="text-start">' + d.detCompra[i].Producto + '</td>';
                if (tipoCompra == 1) {
                    rep += '<td class="text-center">' + d.detCompra[i].lote + '</td>';
                }
                rep += '<td class="text-center">' + d.detCompra[i].cantidad + '</td>' +
                    '<td class="text-center">' + d.detCompra[i].precio + '</td>' +
                    '</tr>'
            }
            rep += '</table>';

            return rep;
        }

        $(document).ready(function () {
            var tipoCompra = <?= $tipoCompra ?>;
            var table = $('#example').DataTable({
                "columns": [
                    {
                        "className": 'dt-control',
                        "orderable": false,
                        "data": null,
                        "defaultContent": ''
                    },
                    {
                        "data": "idCompra",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "nitProv",
                        "className": 'dt-body-right pe-3'
                    },
                    {
                        "data": "nomProv",
                        "className": 'dt-body-left'
                    },
                    {
                        "data": "numFact",
                        "className": 'dt-body-right pe-3'
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
                        "data": "descEstado",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "totalCompra",
                        "className": 'dt-body-right pe-4'
                    },
                    {
                        "data": "retefuenteCompra",
                        "className": 'dt-body-right pe-4'
                    },
                    {
                        "data": "reteicaCompra",
                        "className": 'dt-body-right pe-4'
                    },
                    {
                        "data": "reteivaCompra",
                        "className": 'dt-body-right pe-4'
                    },
                    {
                        "data": "vreal",
                        "className": 'dt-body-right pe-4'
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
                "ajax": "../../compras/ajax/listaCompras.php?tipoCompra=" + tipoCompra
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
        <img src="../../../images/LogoNova.jpg" alt="novaquim" class="img-fluid mb-2"><h4>LISTADO DE COMPRAS<?= $titulo ?></h4></div>
    <div class="row justify-content-end">
        <div class="col-1">
            <button class="button" type="button" onclick="window.location='../../../menu.php'">
                <span><STRONG>Ir al Menú</STRONG></span></button>
        </div>
    </div>
    <div class="tabla-100">
        <table id="example" class="table-sm formatoDatos5 table table-striped">
            <thead>
            <tr>
                <th class="width1"></th>
                <th class="width2 text-center">Id Compra</th>
                <th class="width3 text-center">NIT</th>
                <th class="width4 text-center">Proveedor</th>
                <th class="width5 text-center">Factura</th>
                <th class="width6 text-center">Fech Compra</th>
                <th class="width7 text-center">Fecha Vto</th>
                <th class="width8 text-center">Estado</th>
                <th class="width9 text-center">Valor Factura</th>
                <th class="width10 text-center">Retefuente</th>
                <th class="width11 text-center">Rete Ica</th>
                <th class="width11 text-center">Rete Iva</th>
                <th class="width12 text-center">Valor Real</th>
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