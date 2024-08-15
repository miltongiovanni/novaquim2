<?php
include "../../../includes/valAcc.php";
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
if (isset($_POST['idPedido'])) {
    $idPedido = $_POST['idPedido'];
} elseif (isset($_SESSION['idPedido'])) {
    $idPedido = $_SESSION['idPedido'];
}
$pedidoOperador = new PedidosOperaciones();
$pedido = $pedidoOperador->getPedido($idPedido);
$detPedidoOperador = new DetPedidoOperaciones();
$totalPedido = $detPedidoOperador->getTotalPedido($idPedido);
if (!$pedido) {
    $ruta = "buscarPedido.php";
    $mensaje = "No existe un pedido con ese número.  Intente de nuevo.";
    $icon = "error";
    mover_pag($ruta, $mensaje, $icon);
    exit;
}
date_default_timezone_set('America/Bogota');
$encabfecha = 'USUARIO: ' . $_SESSION['Username'] . ' |   FECHA: ' . date('d-m-Y  h:i:s');
$presentacionOperador = new PresentacionesOperaciones();
$distribucionOperador = new ProductosDistribucionOperaciones();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Ingreso de Productos Hoja de Pedido</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../../../css/datatables.css">
    <link href="../../../node_modules/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css">
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
    <script src="../../../js/jquery-3.3.1.min.js"></script>
    <script src="../../../js/datatables.js"></script>
    <script src="../../../node_modules/select2/dist/js/select2.min.js"></script>
    <script src="../../../node_modules/select2/dist/js/i18n/es.js"></script>
    <script>
        function redireccion() {
            window.location.href = "../../../menu.php";
        }

        function eliminarSession() {
            let variable = 'idPedido';
            $.ajax({
                url: '../../../includes/controladorVentas.php',
                type: 'POST',
                data: {
                    "action": 'eliminarSession',
                    "variable": variable,
                },
                dataType: 'text',
                success: function (res) {
                    redireccion();
                },
                error: function () {
                    alert("Vous avez un GROS problème");
                }
            });
        }

        $(document).ready(function () {
            $('#codProductoN').select2({
                placeholder: 'Seleccione el producto',
                language: "es"
            });
            $('#codProductoD').select2({
                placeholder: 'Seleccione el producto',
                language: "es"
            });
            let idPedido = <?=$idPedido?>;
            let estado = '<?= $pedido['estado'] ?>';
            let ruta = "../ajax/listaDetPedido.php?idPedido=" + idPedido;
            $('#example').DataTable({
                "columns": [
                    {
                        "data": function (row) {
                            let rep = '';
                            if (estado == 1) {
                                rep = '<form action="updateDetallePedido.php" method="post" name="actualiza">' +
                                    '          <input name="idPedido" type="hidden" value="' + idPedido + '">' +
                                    '          <input name="codProducto" type="hidden" value="' + row.codProducto + '">' +
                                    '          <input type="button" name="Submit" onclick="return Enviar(this.form)" class="formatoBoton"  value="Cambiar">' +
                                    '      </form>'
                            }
                            return rep;
                        },
                        "className": 'text-center',
                        width: '8%'
                    },
                    {
                        "data": "id",
                        "className": 'text-center',
                        width: '5%'
                    },
                    {
                        "data": "codProducto",
                        "className": 'text-center',
                        width: '5%'
                    },
                    {
                        "data": "producto",
                        "className": 'dt-body-left',
                        width: '38%'
                    },
                    {
                        "data": "cantProducto",
                        "className": 'text-center',
                        width: '5%'
                    },
                    {
                        "data": "precioProducto",
                        "className": 'text-center',
                        width: '8%'
                    },
                    {
                        "data": "subtotal",
                        "className": 'text-center',
                        width: '8%'
                    },
                    {
                        "data": function (row) {
                            let rep = '';
                            if (estado == 1) {
                                rep = '<form action="delprodPed.php" method="post" name="elimina">' +
                                    '          <input name="idPedido" type="hidden" value="' + idPedido + '">' +
                                    '          <input name="codProducto" type="hidden" value="' + row.codProducto + '">' +
                                    '          <input type="button" name="Submit" onclick="return Enviar(this.form)" class="formatoBoton"  value="Eliminar">' +
                                    '      </form>';
                            }
                            return rep;
                        },
                        "className": 'text-center',
                        width: '8%'
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
                "ajax": ruta
            });
        });
    </script>

</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo1">
        <img src="../../../images/LogoNova.jpg" alt="novaquim" class="img-fluid mb-2"><h4>DETALLE DEL PEDIDO</h4></div>
    <div class="mb-3 row formatoDatos5">
        <div class="col-1">
            <strong>Pedido No.</strong>
            <div class="bg-blue"><?= $idPedido; ?></div>
        </div>
        <div class="col-4">
            <strong>Cliente</strong>
            <div class="bg-blue"><?= $pedido['nomCliente'] ?></div>
        </div>
        <div class="col-1">
            <strong>Fecha pedido</strong>
            <div class="bg-blue"><?= $pedido['fechaPedido'] ?></div>
        </div>
        <div class="col-1">
            <strong>Fecha entrega</strong>
            <div class="bg-blue"><?= $pedido['fechaEntrega'] ?></div>
        </div>
        <div class="col-2">
            <strong>Estado</strong>
            <div class="bg-blue"><?= $pedido['estadoPedido'] ?></div>
        </div>
    </div>
    <div class="mb-3 row formatoDatos5">
        <div class="col-1">
            <strong>Precio</strong>
            <div class="bg-blue"><?= $pedido['tipoPrecio'] ?></div>
        </div>
        <div class="col-3">
            <strong>Lugar de entrega</strong>
            <div class="bg-blue"><?= $pedido['nomSucursal'] ?></div>
        </div>
        <div class="col-3">
            <strong>Dirección de entrega</strong>
            <div class="bg-blue"><?= $pedido['dirSucursal'] ?></div>
        </div>
        <div class="col-2">
            <strong>Vendedor</strong>
            <div class="bg-blue"><?= $pedido['nomPersonal'] ?></div>
        </div>
    </div>
    <div class="mb-3 row">
    </div>
    <div class="mb-3 titulo row text-center">
        <strong>Adicionar Detalle</strong>
    </div>
    <?php
    if ($pedido['estado'] == 1):
        ?>

        <form method="post" action="makeDetPedido.php" class="formatoDatos5" name="form1">
            <input name="idPedido" type="hidden" value="<?= $idPedido; ?>">
            <input name="tipoPrecio" type="hidden" value="<?= $pedido['idPrecio']; ?>">
            <div class="mb-3 row">
                <div class="col-4">
                    <strong>Productos Novaquim</strong>
                    <select name="codProducto" id="codProductoN" class="form-select">
                        <option selected disabled value="">Escoja un producto Novaquim</option>
                        <?php
                        $productos = $pedidoOperador->getProdTerminadosByIdPedido($idPedido);
                        $filas = count($productos);
                        for ($i = 0; $i < $filas; $i++) {
                            echo '<option value="' . $productos[$i]["codPresentacion"] . '">' . $productos[$i]['presentacion'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="col-1">
                    <strong>Unidades</strong>
                    <input type="text" class="form-control col-1" name="cantProducto"
                           id="cantProducto" onkeydown="return aceptaNum(event)">
                </div>
                <div class="col-2 pt-2">
                    <button class="button mt-2" type="button" onclick="return Enviar(this.form)">
                        <span>Adicionar detalle</span>
                    </button>
                </div>
            </div>
        </form>
        <form method="post" action="makeDetPedido.php" class="formatoDatos5" name="form1">
            <input name="idPedido" type="hidden" value="<?= $idPedido; ?>">
            <input name="tipoPrecio" type="hidden" value="<?= $pedido['tipoPrecio']; ?>">
            <div class="row mb-3">
                <div class="col-4">
                    <strong>Productos Distribución</strong>
                    <select name="codProducto" id="codProductoD" class="form-select">
                        <option selected disabled value="">Escoja un producto de distribución</option>
                        <?php
                        $productos = $pedidoOperador->getProdDistribucionByIdPedido($idPedido);
                        $filas = count($productos);
                        for ($i = 0; $i < $filas; $i++) {
                            echo '<option value="' . $productos[$i]["idDistribucion"] . '">' . $productos[$i]['producto'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="col-1">
                    <strong>Unidades</strong>
                    <input type="text" class="form-control" name="cantProducto"
                           id="cantProducto" onkeydown="return aceptaNum(event)">
                </div>
                <div class="col-2 pt-2">
                    <button class="button mt-2" type="button" onclick="return Enviar(this.form)">
                        <span>Adicionar detalle</span>
                    </button>
                </div>
            </div>
        </form>
        <form method="post" action="makeDetPedido.php" class="formatoDatos5" name="form1">
            <input name="idPedido" type="hidden" value="<?= $idPedido; ?>">
            <input name="tipoPrecio" type="hidden" value="<?= $pedido['tipoPrecio']; ?>">
            <div class="row mb-3">
                <div class="col-3">
                    <strong>Servicios</strong>
                    <select name="codProducto" id="codProducto" class="form-select">
                        <option selected disabled value="">Escoja un servicio</option>
                        <?php
                        $productos = $pedidoOperador->getServicioByIdPedido($idPedido);
                        $filas = count($productos);
                        for ($i = 0; $i < $filas; $i++) {
                            echo '<option value="' . $productos[$i]["idServicio"] . '">' . $productos[$i]['desServicio'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="col-1">
                    <strong>Cantidad</strong>
                    <input type="text" class="form-control" name="cantProducto"
                           id="cantProducto" onkeydown="return aceptaNum(event)">
                </div>
                <div class="col-1">
                    <strong>Precio</strong>
                    <input type="text" class="form-control" name="precioProducto"
                           id="precioProducto" onkeydown="return aceptaNum(event)">
                </div>
                <div class="col-2 pt-2">
                    <button class="button mt-2" type="button" onclick="return Enviar(this.form)">
                        <span>Adicionar detalle</span>
                    </button>
                </div>
            </div>
        </form>
    <?php
    endif;
    ?>
    <div class="mb-3 titulo row text-center">
        <strong>Detalle del pedido</strong>
    </div>
    <div class="tabla-80">
        <table id="example" class="formatoDatos5 table table-sm table-striped">
            <thead>
            <tr>
                <th class=""></th>
                <th class="text-center">Item</th>
                <th class="text-center">Código</th>
                <th class="text-center">Producto</th>
                <th class="text-center">Cantidad</th>
                <th class="text-center">Precio</th>
                <th class="text-center">Subtotal</th>
                <th class="text-center"></th>
            </tr>
            </thead>
        </table>
    </div>
    <div class="tabla-70">
        <table width="100% formatoDatos">
            <tr>
                <td width="60%" class="text-end text-bold ">Total Pedido</td>
                <td width="12%" class="text-start text-bold  ps-5"><?= $totalPedido ?></td>
            </tr>
        </table>
    </div>
    <div class="mb-3 row">
        <div class="col-2">
            <form method="post" action="Imp_Ord_ped.php" name="form3" target="_blank">
                <input name="idPedido" type="hidden" value="<?= $idPedido; ?>">
                <button class="button" type="submit"><span>Imprimir pedido</span></button>
            </form>
        </div>
        <?php
        if ((1 == $_SESSION['perfilUsuario'] || 2 == $_SESSION['perfilUsuario']) && $pedido['estado'] == 1):
            ?>
            <div class="col-2">
                <form action="inv_ped.php" method="post">
                    <input name="idPedido" type="hidden" value="<?= $idPedido; ?>">
                    <button class="button" type="button" onclick="return Enviar(this.form)"><span>Verificar existencias</span></button>
                </form>
            </div>
        <?php
        endif;
        ?>
    </div>
    <div class="row">
        <div class="col-1">
            <button class="button" id="back" onClick="eliminarSession()"><span>Terminar</span>
            </button>
        </div>
    </div>
</div>
</body>
</html>
	   