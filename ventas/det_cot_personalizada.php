<?php
include "../includes/valAcc.php";
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
if (isset($_POST['idCotPersonalizada'])) {
    $idCotPersonalizada = $_POST['idCotPersonalizada'];
} elseif (isset($_SESSION['idCotPersonalizada'])) {
    $idCotPersonalizada = $_SESSION['idCotPersonalizada'];
}
$cotizacionOperador = new CotizacionesPersonalizadasOperaciones();
$cotizacion = $cotizacionOperador->getCotizacionP($idCotPersonalizada);
if (!$cotizacion) {
    $ruta = "mod_cot_personalizada.php";
    $mensaje = "No existe una cotización personalizada con ese número.  Intente de nuevo.";
    mover_pag($ruta, $mensaje);
    exit;
}
$presentacionOperador = new PresentacionesOperaciones();
$distribucionOperador = new ProductosDistribucionOperaciones();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Ingreso de Productos en la Cotización</title>
    <meta charset="utf-8">
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
<script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
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
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/datatables.js"></script>
    <script src="../js/dataTables.buttons.js"></script>
    <script src="../js/jszip.js"></script> <!--Para exportar Excel-->
    <!--<script src="../js/pdfmake.js"></script>-->  <!--Para exportar PDF-->
    <!--<script src="../js/vfs_fonts.js"></script>--> <!--Para exportar PDF-->
    <script src="../js/buttons.html5.js"></script>
    <script>
        function redireccion() {
            window.location.href = "../menu.php";
        }

        function eliminarSession() {
            let variable = 'idCotPersonalizada';
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
            let idCotPersonalizada = <?=$idCotPersonalizada?>;
            let ruta = "ajax/listaDetCotPersonalizada.php?idCotPersonalizada=" + idCotPersonalizada;
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
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "id",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "codProducto",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "producto",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "canProducto",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "precioProducto",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "subtotal",
                        "className": 'dt-body-center'
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
                        "className": 'dt-body-center'
                    }
                ],
                "columnDefs": [ {
                    "searchable": false,
                    "orderable": false,
                    "targets": 1
                } ],
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
<div id="contenedor">
    <div id="saludo1"><strong>DETALLE DE LA COTIZACIÓN PERSONALIZADA</strong></div>
    <div class="form-group row">
        <div class="col-2 text-right"><strong>No. de Cotización</strong></div>
        <div class="col-1 bg-blue"><?= $idCotPersonalizada; ?></div>
        <div class="col-2 text-right"><strong>Fecha Cotización</strong></div>
        <div class="col-1 bg-blue"><?= $cotizacion['fechaCotizacion'] ?></div>
        <div class="col-1 text-right"><strong>Cliente</strong></strong></div>
        <div class="col-4" style="background-color: #dfe2fd;"><?= $cotizacion['nomCliente'] ?></div>

    </div>
    <div class="form-group row">
        <div class="col-1 text-right"><strong>Contacto</strong></div>
        <div class="col-2 bg-blue"><?= $cotizacion['contactoCliente'] ?></div>
        <div class="col-1 text-right"><strong>Cargo</strong></div>
        <div class="col-2 bg-blue"><?= $cotizacion['cargoContacto'] ?></div>
        <div class="col-1 text-right"><strong>Vendedor</strong></div>
        <div class="col-2 bg-blue"><?= $cotizacion['nomPersonal'] ?></div>
        <div class="col-1 text-right"><strong>Tipo de Precio</strong></div>
        <div class="col-1 bg-blue"><?= $cotizacion['tipPrecio'] ?></div>
    </div>
    <div class="form-group titulo row">
        <strong>Adicionar Detalle</strong>
    </div>
    <form method="post" action="makeDetCotPersonalizada.php" name="form1">
        <input name="idCotPersonalizada" type="hidden" value="<?= $idCotPersonalizada; ?>">
        <input name="tipoPrecio" type="hidden" value="<?= $cotizacion['tipoPrecio']; ?>">
        <div class="row">
            <div class="col-4 text-center" style="margin: 0 5px;"><strong>Productos Novaquim</strong></div>
            <div class="col-1 text-center" style="margin: 0 5px;"><strong>Unidades</strong></div>
            <div class="col-2 text-center"></div>
        </div>
        <div class="form-group row">
            <select name="codProducto" id="codProducto" class="form-control col-4 mr-3">
                <option selected disabled value="">Escoja un producto Novaquim</option>
                <?php
                $productos = $cotizacionOperador->getProdTerminadosByIdCotizacion($idCotPersonalizada);
                $filas = count($productos);
                for ($i = 0; $i < $filas; $i++) {
                    echo '<option value="' . $productos[$i]["codPresentacion"] . '">' . $productos[$i]['presentacion'] . '</option>';
                }
                ?>
            </select>
            <input type="text" style="margin: 0 5px 0 0;" class="form-control col-1" name="cantProducto"
                   id="cantProducto" onKeyPress="return aceptaNum(event)">
            <div class="col-2 text-center" style="padding: 0 20px;">
                <button class="button" type="button" onclick="return Enviar(this.form)"><span>Adicionar detalle</span>
                </button>
            </div>
        </div>
    </form>
    <form method="post" action="makeDetCotPersonalizada.php" name="form1">
        <input name="idCotPersonalizada" type="hidden" value="<?= $idCotPersonalizada; ?>">
        <input name="tipoPrecio" type="hidden" value="<?= $cotizacion['tipoPrecio']; ?>">
        <div class="row">
            <div class="col-4 text-center" style="margin: 0 5px;"><strong>Productos Distribucion</strong></div>
            <div class="col-1 text-center" style="margin: 0 5px;"><strong>Unidades</strong></div>
            <div class="col-2 text-center"></div>
        </div>
        <div class="form-group row">
            <select name="codProducto" id="codProducto" class="form-control col-4 mr-3">
                <option selected disabled value="">Escoja un producto de distribución</option>
                <?php
                $productos = $cotizacionOperador->getProdDistribucionByIdCotizacion($idCotPersonalizada);
                $filas = count($productos);
                for ($i = 0; $i < $filas; $i++) {
                    echo '<option value="' . $productos[$i]["codDistribucion"] . '">' . $productos[$i]['producto'] . '</option>';
                }
                ?>
            </select>
            <input type="text" style="margin: 0 5px 0 0;" class="form-control col-1" name="cantProducto"
                   id="cantProducto" onKeyPress="return aceptaNum(event)">
            <div class="col-2 text-center" style="padding: 0 20px;">
                <button class="button" type="button" onclick="return Enviar(this.form)"><span>Adicionar detalle</span>
                </button>
            </div>
        </div>
    </form>
    <div class="form-group titulo row">
        <strong>Detalle de la cotización personalizada</strong>
    </div>
    <div class="tabla-70">
        <table id="example" class="display compact">
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
    <div class="form-group row">
        <div class="col-2">
            <form method="post" action="Imp_Cot_Per.php" name="form3" target="_blank">
                <input name="idCotPersonalizada" type="hidden" value="<?= $idCotPersonalizada; ?>">
                <button class="button" type="submit"><span>Imprimir cotización</span></button>
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
	   