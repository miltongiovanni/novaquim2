<?php
include "../includes/valAcc.php";
// Función para cargar las clases
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');

foreach ($_POST as $nombre_campo => $valor) {
    $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
    //echo $nombre_campo . " = " . $valor . "<br>";
    eval($asignacion);
}
$ProductoDistribucionOperador = new ProductosDistribucionOperaciones();
$producto = $ProductoDistribucionOperador->getProductoDistribucion($idDistribucion);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Lista de Compra por Producto de Distribución</title>
    <meta charset="utf-8">
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../js/validar.js"></script>
    <link rel="stylesheet" href="../css/datatables.css">
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/datatables.js"></script>
    <script src="../js/dataTables.buttons.js"></script>
    <script src="../js/jszip.js"></script>
    <script src="../js/pdfmake.js"></script>
    <script src="../js/vfs_fonts.js"></script>
    <script src="../js/buttons.html5.js"></script>

    <script>
        $(document).ready(function () {
            var idDistribucion = <?= $idDistribucion ?>;
            $('#example').DataTable({
                "columns": [
                    {
                        /*"className": 'details-control',*/
                        /*"orderable": false,*/
                        "data": "fechComp",
                        /*"defaultContent": ''*/
                    },
                    {
                        "data": "nomProv",
                    },
                    {
                        "data": "precioSinIva",
                    },
                    {
                        "data": "precioConIva",
                    },
                    {
                        "data": "cantidad",
                    },
                ],
                "columnDefs":
                    [{
                        "targets": [0, 1, 2, 3, 4],
                        "className": 'dt-body-center'
                    }
                    ],
                "order": [[0, 'desc']],
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
                "ajax": "ajax/listaCompraxDis.php?idDistribucion=" + idDistribucion
            });
        });
    </script>
</head>
<body>
<div id="contenedor">
    <div id="saludo1"><strong>LISTADO DE COMPRAS DE <?= $producto['producto'] ?></strong></div>

    <div class="row flex-end">
        <div class="col-1">
            <button class="button" onclick="window.location='../menu.php'">
                <span><STRONG>Ir al Menú</STRONG></span></button>
        </div>
    </div>
    <div class="tabla-60" >
        <table id="example" class="display compact formatoDatos" >
            <thead>
            <tr>
                <th>Fecha Compra</th>
                <th>Proveedor</th>
                <th>Precio Compra sin IVA</th>
                <th>Precio Compra con IVA</th>
                <th>Cantidad</th>
            </tr>
            </thead>
        </table>
    </div>

    <div class="row">
        <div class="col-1">
            <button class="button"
                    onclick="window.location='../menu.php'">
                <span><STRONG>Ir al Menú</STRONG></span></button>
        </div>
    </div>

</div>
</body>
</html>