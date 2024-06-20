<?php
include "../../../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Lista de Proveedores</title>
    <meta charset="utf-8">
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script  src="../../../js/validar.js"></script>
    <link rel="stylesheet" href="../../../css/datatables.css">
    <script src="../../../js/jquery-3.3.1.min.js"></script>
    <script src="../../../js/datatables.js"></script>
    

    <script>
        jQuery.extend(jQuery.fn.dataTableExt.oSort, {
            "chinese-string-asc": function (s1, s2) {
                if (s1 != null && s1 != undefined && s2 != null && s2 != undefined) {
                    return s1.localeCompare(s2);
                } else if (s2 == null || s2 == undefined) {
                    return s1;
                } else if (s1 == null || s1 == undefined) {
                    return s2;
                }
            },

            "chinese-string-desc": function (s1, s2) {
                if (s1 != null && s1 != undefined && s2 != null && s2 != undefined) {
                    return s2.localeCompare(s1);
                } else if (s2 == null || s2 == undefined) {
                    return s1;
                } else if (s1 == null || s1 == undefined) {
                    return s2;
                }
            }
        });
        /* Formatting function for row details - modify as you need */
        function format(d) {
            // `d` is the original data object for the row
            rep = '<table  class="formatoDatos5 table table-sm table-striped" style="padding-left:50px;width:50%;margin:inherit; background-color: white">' +
                '<thead>' +
                '<tr>' +
                '<th class="text-center">Código</th>' +
                '<th class="text-center">Producto</th>' +
                '</tr>' +
                '</thead>';
            for (i = 0; i < d.detProveedor.length; i++) {
                rep += '<tr>' +
                    '<td class="text-center">' + d.detProveedor[i].Codigo + '</td>' +
                    '<td class="text-center">' + d.detProveedor[i].Producto + '</td>' +
                    '</tr>'
            }
            rep += '</table>';

            return rep;
        }

        $(document).ready(function () {
            var table = $('#example').DataTable({
                "columns": [
                    {
                        "className": 'dt-control',
                        "orderable": false,
                        "data": null,
                        "defaultContent": ''
                    },
                    {
                        "data": "nitProv",
                        "className": 'dt-body-right'
                    },
                    {
                        "data": "nomProv",
                        "className": 'dt-body-left'
                    },
                    {
                        "data": "dirProv",
                        "className": 'dt-body-left'
                    },
                    {
                        "data": "contProv",
                        "className": 'dt-body-left'
                    },
                    {
                        "data": "telProv",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "emailProv",
                        "className": 'dt-body-left'
                    },
                    {
                        "data": "desCatProv",
                        "className": 'dt-body-left'
                    },
                ],
                "order": [[2, 'asc']],
                "columnDefs":
                    [
                        {type: 'chinese-string', targets: 2}
                    ],
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
                "ajax": "../ajax/listaProv.php"
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
        <img src="../../../images/LogoNova.jpg" alt="novaquim" class="img-fluid mb-2"><h4>LISTADO DE PROVEEDORES</h4></div>
    <div class="row flex-end">
        <div class="col-1">
            <button class="button" onclick="window.location='../../../menu.php'">
                <span><STRONG>Ir al Menú</STRONG></span></button>
        </div>
    </div>
    <div class="tabla-100">
        <table id="example" class="formatoDatos5 table table-sm table-striped">
            <thead>
            <tr>
                <th></th>
                <th class="text-center">NIT</th>
                <th class="text-center">Proveedor</th>
                <th class="text-center">Dirección</th>
                <th class="text-center">Contacto</th>
                <th class="text-center">Teléfono</th>
                <th class="text-center">Correo Electrónico</th>
                <th class="text-center">Categoría proveedor</th>
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