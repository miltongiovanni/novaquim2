<?php
include "../includes/valAcc.php";
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Faltante del Pedido</title>
    <meta charset="utf-8">
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../css/datatables.css">
    <style>
        table {
            table-layout: fixed;
        }

        .width1 {
            width: 20%;
        }

        .width2 {
            width: 60%;
        }

        .width3 {
            width: 20%;
        }
    </style>
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>

</head>
<body>
<?php
if (isset($_POST['seleccion1'])) {
    $selPedidos = $_POST['seleccion1'];
} else {
    $ruta = "selPedEntrega.php";
    $mensaje = "Debe escoger algún pedido";
    $icon = "warning";
    mover_pag($ruta, $mensaje, $icon);
}
$fechaRutero = $_POST['fechaRutero'];
$crearRutero = isset($_POST['crearRutero'])? $_POST['crearRutero'] : 0;
$ruteroOperador = new RuteroOperaciones();
$pedidoOperador = new PedidosOperaciones();

if (isset($_POST['idRutero'])) {
    $idRutero = $_POST['idRutero'];
} elseif (isset($_SESSION['idRutero'])) {
    $idRutero = $_SESSION['idRutero'];
}else{
    $idRutero = $ruteroOperador->makeRutero($fechaRutero, implode(',', $selPedidos) );
    foreach ($selPedidos as $pedido){
        $pedidoOperador->updateEstadoPedido(7, $pedido);
    }
    $_SESSION['idRutero'] = $idRutero;
}
var_dump($selPedidos, $fechaRutero, $idRutero);
?>
<div id="contenedor" class="container-fluid">
    <div id="saludo1">
        <img src="../images/LogoNova.jpg" alt="novaquim" class="img-fluid mb-2"><h4>FALTANTE DE LOS PEDIDOS</h4></div>
    <div class="row flex-end mb-3">
        <div class="col-1">
            <button class="button" type="button" onclick="window.location='../menu.php'">
                <span><STRONG>Ir al Menú</STRONG></span></button>
        </div>
    </div>

    <div class="tabla-50">
        <table id="example" class="display compact">
            <thead>
            <tr>
                <th class="width1 text-center">Código</th>
                <th class="width2 text-center">Producto</th>
                <th class="width3 text-center">Cantidad</th>
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
<script src="../js/jquery-3.3.1.min.js"></script>
<script src="../js/datatables.js"></script>
<script src="../js/dataTables.buttons.js"></script>
<script src="../js/jszip.js"></script> <!--Para exportar Excel-->
<!--<script src="../js/pdfmake.js"></script>-->  <!--Para exportar PDF-->
<!--<script src="../js/vfs_fonts.js"></script>--> <!--Para exportar PDF-->
<script src="../js/buttons.html5.js"></script>
<script>

    $(document).ready(function () {
        let selPedido = <?=json_encode($selPedidos)?>;
        let fechaRutero = <?=$fechaRutero?>;
        let ruta = "ajax/listaRutero.php?selPedido=" + selPedido +'&fechaRutero='+ fechaRutero;
        $('#example').DataTable({
            "columns": [
                {
                    "data": "codProducto",
                    "className": 'dt-body-center'
                },
                {
                    "data": "producto",
                    "className": 'dt-body-left'
                },
                {
                    "data": "cantidad",
                    "className": 'dt-body-center'
                }
            ],
            "columnDefs": [{
                "searchable": false,
                "orderable": false,
                "targets": 1
            }],
            "dom": 'Blfrtip',
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
	   