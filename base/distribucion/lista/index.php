<?php
include "../../../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>Lista de Productos de Distribución</title>
    <meta charset="utf-8">
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../../../css/datatables.css">
    <script src="../../../js/jquery-3.3.1.min.js"></script>
    <script src="../../../js/datatables.js"></script>
    <script>
        var perfilUsuario = '<?=$_SESSION['perfilUsuario']?>';
        function diffDate(fecha) {
            let fechaUltimaCompra = new Date(fecha);
            let hoy = new Date();

            // The number of milliseconds in one day
            const ONE_DAY = 1000 * 60 * 60 * 24;

            // Calculate the difference in milliseconds
            const differenceMs = hoy - fechaUltimaCompra;
            // Convert back to days and return
            return Math.round(differenceMs / ONE_DAY);
        }
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
        $(document).ready(function () {
            $('#example').DataTable({
                "columns": [
                    {
                        /*"className": 'dt-control',*/
                        /*"orderable": false,*/
                        "data": "idDistribucion",
                        className: 'text-center'
                        /*"defaultContent": ''*/
                    },
                    {
                        "data": "producto",
                    },
                    {
                        "data": "precioCompra",
                        "visible": (perfilUsuario == 1 || perfilUsuario == 2) ? true : false,
                        className: 'pe-5',
                        render: DataTable.render.number( '.', null, 0, '$' )
                    },
                    {
                        "data": "precio",
                        className: 'pe-5',
                        render: DataTable.render.number( '.', null, 0, '$' )
                    },
                    {
                        "data": "iva",
                        className: 'pe-5',
                        render: DataTable.render.number( '.', null, 0, '', '%' )
                    },
                    {
                        "data": "catDis",
                    },
                    {
                        "data": "precio_ultima_compra",
                        render: function (data, type, row) {
                            $rep = perfilUsuario == 1 || perfilUsuario == 2 ? '<div class=""><strong>Precio: </strong>$' + data + '</div>' : '';
                            $rep += '<div><strong>Fecha de compra: </strong>' + row.ultima_compra + '</div>' +
                                '<div><strong>Proveedor: </strong>' + row.nomProv + '</div>';
                            return  $rep

                        }
                    },
                    {
                        "data": "coSiigo",
                    },
                    {
                        "orderable": false,
                        "visible": (perfilUsuario == 1 || perfilUsuario == 2) ? true : false,
                        width: '10%',
                        "data": function (row) {
                            let rep = '<form action="../modificar/updateDisPrecioForm.php" method="post" name="elimina">' +
                                '          <input name="idDistribucion" type="hidden" value="' + row.idDistribucion + '">' +
                                '          <button type="submit" onclick="return Enviar(this.form)" class="formatoBoton1" >Actualizar<br> precio de compra</button>' +
                                '       </form>'
                            return rep;
                        },
                        "className": 'dt-body-center'
                    },
                ],
                "columnDefs":
                    [
                        {type: 'chinese-string', targets: 1}
                    ],
                "order": [[1, 'asc']],
                pagingType: 'simple_numbers',
                layout: {
                 topStart: (perfilUsuario == 1 || perfilUsuario == 2) ?'buttons' : '',
                    topStart1: 'search',
                    topEnd: 'pageLength',
                    bottomStart: 'info',
                    bottomEnd: {
                        paging: {
                            numbers: 6
                        }
                    }
                },
                buttons: [
                    {
                        extend: 'copyHtml5',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 7]
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 7]
                        }
                    },
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
                if (diffDate(data.ultima_compra) > 180) {
                    $('td', row).addClass('formatoDataTable1');
                } else if (diffDate(data.ultima_compra) <= 180 && diffDate(data.ultima_compra) > 90) {
                    $('td', row).addClass('formatoDataTable2');
                }
            },
                "ajax": "../ajax/listaProdDis.php"
            });
        });
    </script>
</head>

<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo1">
        <img src="../../../images/LogoNova.jpg" alt="novaquim" class="img-fluid mb-2"><h4>LISTADO DE PRODUCTOS DE DISTRIBUCIÓN </h4></div>
    <div class="row justify-content-end">
        <div class="col-1">
            <button class="button" onclick="window.location='../../../menu.php'">
                <span><STRONG>Ir al Menú</STRONG></span></button>
        </div>
    </div>
    <div class="tabla-100">
        <table id="example" class="formatoDatos5 table table-sm table-striped">
            <thead>
            <tr>
                <th class="text-center">Código</th>
                <th class="text-center">Producto</th>
                <th class="text-center">Precio compra</th>
                <th class="text-center">Precio venta</th>
                <th class="text-center">Iva</th>
                <th class="text-center">Categoría</th>
                <th class="text-center">Última compra</th>
                <th class="text-center">Código Siigo</th>
            </tr>
            </thead>
        </table>
    </div>

    <div class="row">
        <div class="col-1">
            <button class="button"
                    onclick="window.location='../../../menu.php'">
                <span><STRONG>Ir al Menú</STRONG></span></button>
        </div>
    </div>
</div>
</body>

</html>
