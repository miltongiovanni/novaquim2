<?php
include "../../../includes/valAcc.php";
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Faltante del Pedido</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../../../css/datatables.css">
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>

</head>
<body>

<div id="contenedor" class="container-fluid">
    <div id="saludo1">
        <img src="../../../images/LogoNova.jpg" alt="novaquim" class="img-fluid mb-2">
        <h4>FALTANTE DE LOS PEDIDOS</h4>
    </div>
    <div class="row justify-content-end mb-3">
        <div class="col-1">
            <button class="button" type="button" onclick="window.location='../../../menu.php'">
                <span><STRONG>Ir al Menú</STRONG></span></button>
        </div>
    </div><?php
    if (isset($_POST['seleccion1'])) {
        $selPedidos = $_POST['seleccion1'];
    } else {
        $ruta = "../revisar-pendientes/";
        $mensaje = "Debe escoger algún pedido";
        $icon = "warning";
        mover_pag($ruta, $mensaje, $icon);
    }
    ?>
    <div class="tabla-50">
        <table id="example" class="formatoDatos5 table table-sm table-striped">
            <thead>
            <tr>
                <th class="text-center">Código</th>
                <th class="text-center">Producto</th>
                <th class="text-center">Cantidad</th>
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
<script src="../../../js/jquery-3.3.1.min.js"></script>
<script src="../../../js/datatables.js"></script>
<script src="../../../js/dataTables.buttons.js"></script>

<script>

    $(document).ready(function () {
        let selPedido = <?=json_encode($selPedidos)?>;
        let ruta = "../ajax/listaNecesidades.php?selPedido=" + selPedido;
        $('#example').DataTable({
            "columns": [
                {
                    "data": "codProducto",
                    "className": 'dt-body-center',
                    width: '20%'
                },
                {
                    "data": "producto",
                    "className": 'dt-body-left',
                    width: '60%'
                },
                {
                    "data": "cantidad",
                    "className": 'dt-body-center',
                    width: '20%'
                }
            ],
            "columnDefs": [{
                "searchable": false,
                "orderable": false,
                "targets": 1
            }],
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
            "paging": false,
            "ordering": false,
            "info": false,
            "searching": false,
            "lengthMenu": [[20, 50, 100, -1], [20, 50, 100, "All"]],
            "language": {
                "lengthMenu": "Mostrando _MENU_ datos por página",
                "zeroRecords": "No hacen falta productos",
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
            "ajax": ruta
        });
    });
</script>
</body>
</html>
	   