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
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../css/datatables.css">
    <style>
        table {
            table-layout: fixed;
        }

        .width1 {
            width: 8%;
        }

        .width2 {
            width: 5%;
        }

        .width3 {
            width: 5%;
        }

        .width4 {
            width: 38%;
        }

        .width5 {
            width: 5%;
        }

        .width6 {
            width: 8%;
        }

        .width7 {
            width: 8%;
        }

        .width8 {
            width: 8%;
        }
    </style>
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/datatables.js"></script>
    <script src="../js/dataTables.buttons.js"></script>
    <script src="../js/jszip.js"></script> <!--Para exportar Excel-->
    <!--<script src="../js/pdfmake.js"></script>-->  <!--Para exportar PDF-->
    <!--<script src="../js/vfs_fonts.js"></script>--> <!--Para exportar PDF-->
    <script src="../js/buttons.html5.js"></script>
    <script>
        function redireccion() {
            window.location.href = "../../../menu.php";
        }

        function eliminarSession() {
            let variable = 'idPedido';
            $.ajax({
                url: '../includes/controladorVentas.php',
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
                        "className": 'text-center'
                    },
                    {
                        "data": "id",
                        "className": 'text-center'
                    },
                    {
                        "data": "codProducto",
                        "className": 'text-center'
                    },
                    {
                        "data": "producto",
                        "className": 'dt-body-left'
                    },
                    {
                        "data": "cantProducto",
                        "className": 'text-center'
                    },
                    {
                        "data": "precioProducto",
                        "className": 'text-center'
                    },
                    {
                        "data": "subtotal",
                        "className": 'text-center'
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
                        "className": 'text-center'
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
        <img src="../images/LogoNova.jpg" alt="novaquim" class="img-fluid mb-2"><h4>DETALLE DEL PEDIDO</h4></div>
    <div class="mb-3 row">
        <div class="col-1"><strong>Pedido No.</strong></div>
        <div class="col-1 bg-blue"><?= $idPedido; ?></div>
        <div class="col-1"><strong>Cliente</strong></strong></div>
        <div class="col-4 bg-blue"><?= $pedido['nomCliente'] ?></div>
        <div class="col-2"><strong>Estado</strong></div>
        <div class="col-1 bg-blue"><?= $pedido['estadoPedido'] ?></div>

    </div>
    <div class="mb-3 row">
        <div class="col-1"><strong>Fecha pedido</strong></div>
        <div class="col-1 bg-blue"><?= $pedido['fechaPedido'] ?></div>
        <div class="col-2"><strong>Lugar de entrega</strong></div>
        <div class="col-4 bg-blue"><?= $pedido['nomSucursal'] ?></div>
        <div class="col-1"><strong>Vendedor</strong></div>
        <div class="col-2 bg-blue"><?= $pedido['nomPersonal'] ?></div>
    </div>
    <div class="mb-3 row">
        <div class="col-1 text-end px-2"><strong>Fecha entrega</strong></div>
        <div class="col-1 bg-blue"><?= $pedido['fechaEntrega'] ?></div>
        <div class="col-2"><strong>Dirección de entrega</strong></div>
        <div class="col-4 bg-blue"><?= $pedido['dirSucursal'] ?></div>
        <div class="col-1"><strong>Precio</strong></div>
        <div class="col-1 bg-blue"><?= $pedido['tipoPrecio'] ?></div>
    </div>
    <div class="mb-3 titulo row text-center">
        <strong>Adicionar Detalle</strong>
    </div>
    <?php
    if ($pedido['estado'] == 1):
        ?>

        <form method="post" action="makeDetPedido.php" name="form1">
            <input name="idPedido" type="hidden" value="<?= $idPedido; ?>">
            <input name="tipoPrecio" type="hidden" value="<?= $pedido['idPrecio']; ?>">
            <div class="row">
                <div class="col-4 text-center" style="margin: 0 5px;"><strong>Productos Novaquim</strong></div>
                <div class="col-1 text-center" style="margin: 0 5px;"><strong>Unidades</strong></div>
                <div class="col-2 text-center"></div>
            </div>
            <div class="mb-3 row">
                <select name="codProducto" id="codProducto" class="form-select col-4 me-3">
                    <option selected disabled value="">Escoja un producto Novaquim</option>
                    <?php
                    $productos = $pedidoOperador->getProdTerminadosByIdPedido($idPedido);
                    $filas = count($productos);
                    for ($i = 0; $i < $filas; $i++) {
                        echo '<option value="' . $productos[$i]["codPresentacion"] . '">' . $productos[$i]['presentacion'] . '</option>';
                    }
                    ?>
                </select>
                <input type="text" style="margin: 0 5px 0 0;" class="form-control col-1" name="cantProducto"
                       id="cantProducto" onkeydown="return aceptaNum(event)">
                <div class="col-2 text-center" style="padding: 0 20px;">
                    <button class="button" type="button" onclick="return Enviar(this.form)">
                        <span>Adicionar detalle</span>
                    </button>
                </div>
            </div>
        </form>
        <form method="post" action="makeDetPedido.php" name="form1">
            <input name="idPedido" type="hidden" value="<?= $idPedido; ?>">
            <input name="tipoPrecio" type="hidden" value="<?= $pedido['tipoPrecio']; ?>">
            <div class="row">
                <div class="col-4 text-center" style="margin: 0 5px;"><strong>Productos Distribución</strong></div>
                <div class="col-1 text-center" style="margin: 0 5px;"><strong>Unidades</strong></div>
                <div class="col-2 text-center"></div>
            </div>
            <div class="mb-3 row">
                <select name="codProducto" id="codProducto" class="form-select col-4 me-3">
                    <option selected disabled value="">Escoja un producto de distribución</option>
                    <?php
                    $productos = $pedidoOperador->getProdDistribucionByIdPedido($idPedido);
                    $filas = count($productos);
                    for ($i = 0; $i < $filas; $i++) {
                        echo '<option value="' . $productos[$i]["idDistribucion"] . '">' . $productos[$i]['producto'] . '</option>';
                    }
                    ?>
                </select>
                <input type="text" style="margin: 0 5px 0 0;" class="form-control col-1" name="cantProducto"
                       id="cantProducto" onkeydown="return aceptaNum(event)">
                <div class="col-2 text-center" style="padding: 0 20px;">
                    <button class="button" type="button" onclick="return Enviar(this.form)">
                        <span>Adicionar detalle</span>
                    </button>
                </div>
            </div>
        </form>
        <form method="post" action="makeDetPedido.php" name="form1">
            <input name="idPedido" type="hidden" value="<?= $idPedido; ?>">
            <input name="tipoPrecio" type="hidden" value="<?= $pedido['tipoPrecio']; ?>">
            <div class="row">
                <div class="col-3 text-center mx-2"><strong>Servicios</strong></div>
                <div class="col-1 text-center mx-2"><strong>Cantidad</strong></div>
                <div class="col-1 text-center mx-2"><strong>Precio</strong></div>
                <div class="col-2 text-center"></div>
            </div>
            <div class="mb-3 row">
                <select name="codProducto" id="codProducto" class="form-control col-3 me-3">
                    <option selected disabled value="">Escoja un servicio</option>
                    <?php
                    $productos = $pedidoOperador->getServicioByIdPedido($idPedido);
                    $filas = count($productos);
                    for ($i = 0; $i < $filas; $i++) {
                        echo '<option value="' . $productos[$i]["idServicio"] . '">' . $productos[$i]['desServicio'] . '</option>';
                    }
                    ?>
                </select>
                <input type="text" style="margin: 0 5px 0 0;" class="form-control col-1" name="cantProducto"
                       id="cantProducto" onkeydown="return aceptaNum(event)">
                <input type="text" style="margin: 0 5px 0 0;" class="form-control col-1" name="precioProducto"
                       id="precioProducto" onkeydown="return aceptaNum(event)">
                <div class="col-2 text-center" style="padding: 0 20px;">
                    <button class="button" type="button" onclick="return Enviar(this.form)">
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
        <table id="example" class="formatoDatos table table-sm table-striped">
            <thead>
            <tr>
                <th class="width1"></th>
                <th class="width2">Item</th>
                <th class="width3">Código</th>
                <th class="width4">Producto</th>
                <th class="width5">Cantidad</th>
                <th class="width6">Precio</th>
                <th class="width7">Subtotal</th>
                <th class="width8"></th>
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
	   