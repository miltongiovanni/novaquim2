<?php
include "../../../includes/valAcc.php";
function cargarClases($classname)
{

    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$codProducto = $_POST['codProducto'];
$ProductoOperador = new ProductosOperaciones();
$producto = $ProductoOperador->getNameProducto($codProducto);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Lista de Envasado por Orden de Producción</title>
    <meta charset="utf-8">
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../../../css/datatables.css">
    <script src="../../../js/jquery-3.3.1.min.js"></script>
    <script src="../../../js/datatables.js"></script>
    <script src="../../../js/dataTables.buttons.js"></script>
    <script>

        /* Formatting function for row details - modify as you need */
        function format(d) {
            // `d` is the original data object for the row
            rep = '<table class="formatoDatos5 table table-sm table-striped" style="padding-left:50px;width:70%;margin:inherit; background-color: white">' +
                '<thead>' +
                '<tr>' +
                '<th class="text-center">Código</th>';
            rep += '<th class="text-center">Presentación</th>' +
                '<th class="text-center">Cantidad</th>' +
                '</tr>' +
                '</thead>';
            for (i = 0; i < d.envasado.length; i++) {
                rep += '<tr>' +
                    '<td class="text-center">' + d.envasado[i].codPresentacion + '</td>';
                rep += '<td class="text-center">' + d.envasado[i].presentacion + '</td>' +
                    '<td class="text-center">' + d.envasado[i].cantPresentacion + '</td>' +
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
                        "defaultContent": '',
                        width: '5%'
                    },
                    {
                        "data": "lote",
                        "className": 'dt-body-center',
                        width: '15%'
                    },
                    {
                        "data": "fechProd",
                        "className": 'dt-body-center',
                        width: '20%'
                    },
                    {
                        "data": "nomPersonal",
                        "className": '',
                        width: '20%'
                    },
                    {
                        "data": "cantidadKg",
                        "className": 'dt-body-right pe-4',
                        width: '15%'
                    },
                    {
                        "data": "descEstado",
                        "className": '',
                        width: '15%'
                    },
                ],
                "order": [[1, 'desc']],
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
                "paging": true,
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
                "ajax": "../ajax/listaEnvasadoProd.php?codProducto=<?=$codProducto?>",
                "deferRender": true,  //For speed
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
        <img src="../../../images/LogoNova.jpg" alt="novaquim" class="img-fluid mb-2"><h4>LISTADO DE ENVASADO DE <?= strtoupper($producto); ?> POR ORDEN DE PRODUCCIÓN</h4>
    </div>
    <div class="row flex-end">
        <div class="col-1">
            <button class="button" onclick="window.location='../../../menu.php'">
                <span><STRONG>Ir al Menú</STRONG></span></button>
        </div>
    </div>
    <div class="tabla-50">
        <table id="example" class="formatoDatos5 table table-sm table-striped">
            <thead>
            <tr>
                <th class=""></th>
                <th class=" text-center">Lote</th>
                <th class=" text-center">Fecha Producción</th>
                <th class=" text-center">Responsable</th>
                <th class=" text-center">Cantidad (Kg)</th>
                <th class=" text-center">Estado</th>
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