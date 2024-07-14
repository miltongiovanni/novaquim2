<?php
include "../../../includes/valAcc.php";
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
if (isset($_POST['idCotPersonalizada'])) {
    $idCotPersonalizada = $_POST['idCotPersonalizada'];
} elseif (isset($_SESSION['idCotPersonalizada'])) {
    $idCotPersonalizada = $_SESSION['idCotPersonalizada'];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Ingreso de Productos en la Cotización</title>
    <meta charset="utf-8">
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
    <link rel="stylesheet" href="../../../css/datatables.css">
    <script src="../../../js/jquery-3.3.1.min.js"></script>
    <script src="../../../js/datatables.js"></script>
    <script>
        function redireccion() {
            window.location.href = "../../../menu.php";
        }

        function eliminarSession() {
            let variable = 'idCotPersonalizada';
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
            let idCotPersonalizada = <?=$idCotPersonalizada?>;
            let ruta = "../ajax/listaDetCotPersonalizada.php?idCotPersonalizada=" + idCotPersonalizada;
            $('#example').DataTable({
                "columns": [
                    {
                        "data": function (row) {
                            let rep = '<form action="updateCotPers.php" method="post" name="elimina">' +
                                '          <input name="idCotPersonalizada" type="hidden" value="' + idCotPersonalizada + '">' +
                                '          <input name="codProducto" type="hidden" value="' + row.codProducto + '">' +
                                '          <input type="button" name="Submit" onclick="return Enviar(this.form)" class="formatoBoton"  value="Cambiar">' +
                                '      </form>'
                            return rep;
                        },
                        "className": 'dt-body-center',
                        width: '8%'
                    },
                    {
                        "data": "id",
                        "className": 'dt-body-center',
                        width: '5%'
                    },
                    {
                        "data": "codProducto",
                        "className": 'dt-body-center',
                        width: '5%'
                    },
                    {
                        "data": "producto",
                        "className": 'dt-body-center',
                        width: '38%'
                    },
                    {
                        "data": "canProducto",
                        "className": 'dt-body-center',
                        width: '5%'
                    },
                    {
                        "data": "precioProducto",
                        "className": 'dt-body-center',
                        width: '8%'
                    },
                    {
                        "data": "subtotal",
                        "className": 'dt-body-center',
                        width: '8%'
                    },
                    {
                        "data": function (row) {
                            let rep = '<form action="delprodCotPer.php" method="post" name="elimina">' +
                                '          <input name="idCotPersonalizada" type="hidden" value="' + idCotPersonalizada + '">' +
                                '          <input name="codProducto" type="hidden" value="' + row.codProducto + '">' +
                                '          <input type="button" name="Submit" onclick="return Enviar(this.form)" class="formatoBoton"  value="Eliminar">' +
                                '      </form>'
                            return rep;
                        },
                        "className": 'dt-body-center',
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

<?php
$cotizacionOperador = new CotizacionesPersonalizadasOperaciones();
$cotizacion = $cotizacionOperador->getCotizacionP($idCotPersonalizada);
if (!$cotizacion) {
    $ruta = "mod_cot_personalizada.php";
    $mensaje = "No existe una cotización personalizada con ese número.  Intente de nuevo.";
    $icon = "warning";
    mover_pag($ruta, $mensaje, $icon);
    exit;
}
$presentacionOperador = new PresentacionesOperaciones();
$distribucionOperador = new ProductosDistribucionOperaciones();
?>
<div id="contenedor" class="container-fluid">
    <div id="saludo1">
        <img src="../../../images/LogoNova.jpg" alt="novaquim" class="img-fluid mb-2"><h4>DETALLE DE LA COTIZACIÓN PERSONALIZADA</h4></div>
    <div class="mb-3 formatoDatos5 row">
        <div class="col-2">
            <strong>No. de Cotización</strong>
            <div class="bg-blue"><?= $idCotPersonalizada; ?></div>
        </div>
        <div class="col-2">
            <strong>Fecha Cotización</strong>
            <div class="bg-blue"><?= $cotizacion['fechaCotizacion'] ?></div>
        </div>
        <div class="col-4">
            <strong>Cliente</strong>
            <div class="bg-blue"><?= $cotizacion['nomCliente'] ?></div>
        </div>

    </div>
    <div class="mb-3 formatoDatos5 row">
        <div class="col-2">
            <strong>Contacto</strong>
            <div class="bg-blue"><?= $cotizacion['contactoCliente'] ?></div>
        </div>
        <div class="col-2">
            <strong>Cargo</strong>
            <div class="bg-blue"><?= $cotizacion['cargoContacto'] ?></div>
        </div>
        <div class="col-2">
            <strong>Vendedor</strong>
            <div class="bg-blue"><?= $cotizacion['nomPersonal'] ?></div>
        </div>
        <div class="col-2">
            <strong>Tipo de Precio</strong>
            <div class="bg-blue"><?= $cotizacion['tipPrecio'] ?></div>
        </div>
    </div>
    <div class="mb-3 titulo row text-center">
        <strong>Adicionar Detalle</strong>
    </div>
    <form method="post" class="formatoDatos5 mb-4" action="makeDetCotPersonalizada.php" name="form1">
        <input name="idCotPersonalizada" type="hidden" value="<?= $idCotPersonalizada; ?>">
        <input name="tipoPrecio" type="hidden" value="<?= $cotizacion['tipoPrecio']; ?>">
        <div class="row">
            <div class="col-4">
                <label class="form-label" for="codProducto"><strong>Productos Novaquim</strong></label>
                <select name="codProducto" id="codProducto" class="form-select">
                    <option selected disabled value="">Escoja un producto Novaquim</option>
                    <?php
                    $productos = $cotizacionOperador->getProdTerminadosByIdCotizacion($idCotPersonalizada);
                    $filas = count($productos);
                    for ($i = 0; $i < $filas; $i++) {
                        echo '<option value="' . $productos[$i]["codPresentacion"] . '">' . $productos[$i]['presentacion'] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="col-1">
                <label class="form-label" for="codProducto"><strong>Unidades</strong></label>
                <input type="text" class="form-control" name="cantProducto"
                       id="cantProducto" onkeydown="return aceptaNum(event)">
            </div>
            <div class="col-2 pt-2">
                <button class="button mt-3" type="button" onclick="return Enviar(this.form)"><span>Adicionar detalle</span>
                </button>
            </div>
        </div>
    </form>
    <form method="post" class="formatoDatos5" action="makeDetCotPersonalizada.php" name="form1">
        <input name="idCotPersonalizada" type="hidden" value="<?= $idCotPersonalizada; ?>">
        <input name="tipoPrecio" type="hidden" value="<?= $cotizacion['tipoPrecio']; ?>">
        <div class="row">
            <div class="col-4">
                <label class="form-label" for="codProducto"><strong>Productos Distribucion</strong></label>
                <select name="codProducto" id="codProducto" class="form-control">
                    <option selected disabled value="">Escoja un producto de distribución</option>
                    <?php
                    $productos = $cotizacionOperador->getProdDistribucionByIdCotizacion($idCotPersonalizada);
                    $filas = count($productos);
                    for ($i = 0; $i < $filas; $i++) {
                        echo '<option value="' . $productos[$i]["idDistribucion"] . '">' . $productos[$i]['producto'] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="col-1">
                <label class="form-label" for="cantProducto"><strong>Unidades</strong></label>
                <input type="text" class="form-control" name="cantProducto" id="cantProducto" onkeydown="return aceptaNum(event)">
            </div>
            <div class="col-2 pt-2">
                <button class="button mt-3" type="button" onclick="return Enviar(this.form)"><span>Adicionar detalle</span>
                </button>
            </div>
        </div>
    </form>
    <div class="mb-3 mt-4 titulo row text-center">
        <strong>Detalle de la cotización personalizada</strong>
    </div>
    <div class="tabla-70">
        <table id="example" class="formatoDatos5 table table-sm table-striped">
            <thead>
            <tr>
                <th></th>
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
    <div class="mb-3 row">
        <div class="col-2">
            <form method="post" action="Imp_Cot_Per.php" name="form3" target="_blank">
                <input name="idCotPersonalizada" type="hidden" value="<?= $idCotPersonalizada; ?>">
                <input name="iva" type="hidden" value="1">
                <button class="button" type="submit"><span>Imprimir cotización con iva</span></button>
            </form>
        </div>
        <div class="col-2">
            <form method="post" action="Imp_Cot_Per.php" name="form3" target="_blank">
                <input name="idCotPersonalizada" type="hidden" value="<?= $idCotPersonalizada; ?>">
                <input name="iva" type="hidden" value="0">
                <button class="button" type="submit"><span>Imprimir cotización sin iva</span></button>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-1">
            <button class="button" type="button" id="back" onClick="eliminarSession()"><span>Terminar</span>
            </button>
        </div>
    </div>

</div>
</body>
</html>
	   