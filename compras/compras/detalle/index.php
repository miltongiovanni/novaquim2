<?php
include "../../../includes/valAcc.php";

if (isset($_SESSION['idCompra'])) {//Si la factura existe
    $idCompra = $_SESSION['idCompra'];
    $tipoCompra = $_SESSION['tipoCompra'];
}
foreach ($_POST as $nombre_campo => $valor) {
    ${$nombre_campo} = $valor;
    if (is_array($valor)) {
        //echo $nombre_campo.print_r($valor).'<br>';
    } else {
        //echo $nombre_campo. '=' .${$nombre_campo}.'<br>';
    }
}

function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');


switch ($tipoCompra) {
    case 1:
        $titulo = ' materias primas';
        $rutaError = '../../materia-prima/crear';
        break;
    case 2:
        $titulo = ' envases y/o tapas';
        $rutaError = '../../envase/crear';
        break;
    case 3:
        $titulo = ' etiquetas';
        $rutaError = '../../etiqueta/crear';
        break;
    case 5:
        $titulo = ' productos de distribución';
        $rutaError = '../../distribucion/crear';
        break;
}
$CompraOperador = new ComprasOperaciones();
$DetComprasOperador = new DetComprasOperaciones();
$compra = $CompraOperador->getCompra($idCompra, $tipoCompra);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Detalle compra de<?= $titulo ?></title>
    <meta charset="utf-8">
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../../../css/datatables.css">
    <style>
        table.dataTable.compact thead th, table.dataTable.compact thead td {
            padding: 4px 4px 4px 4px;
        }

        .width1 {
            width: 8%;
        }

        .width2 {
            width: 8%;
        }

        .width3 {
            width: 36%;
        }

        .width4 {
            width: 5%;
        }

        .width5 {
            width: 10%;
        }

        .width6 {
            width: 10%;
        }

        .width7 {
            width: 15%;
        }

        .width8 {
            width: 8%;
        }

        .width34 {
            width: 41%;
        }
        .width56 {
            width: 20%;
        }
    </style>
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
    <script src="../../../js/jquery-3.3.1.min.js"></script>
    <script src="../../../js/datatables.js"></script>
    <script src="../../../js/jszip.js"></script>
    <script src="../../../js/pdfmake.js"></script>
    <script src="../../../js/vfs_fonts.js"></script>
    <script>
        function redireccion() {
            window.location.href = "../../../menu.php";
        }

        function eliminarSession() {
            let variable = 'idCompra';
            $.ajax({
                url: '../../../includes/controladorCompras.php',
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

        function updateEstadoCompra(idCompra) {
            let estadoActualCompra = <?=$compra['estadoCompra']?>;
            if (estadoActualCompra != 2) {
                eliminarSession();
            } else {
                $.ajax({
                    url: '../../../includes/controladorCompras.php',
                    type: 'POST',
                    data: {
                        "action": 'updateEstadoCompra',
                        "idCompra": idCompra,
                        "estadoCompra": 3,
                    },
                    dataType: 'json',
                    success: function (respuesta) {
                        if (respuesta.msg == 'OK') {
                            eliminarSession();
                        }
                    },
                    error: function () {
                        alert("Vous avez un GROS problème");
                    }
                });
            }
        }

        $(document).ready(function () {
            let tipoCompra = <?=$tipoCompra?>;
            let idCompra = <?=$idCompra?>;
            let ruta = "../ajax/listaDetCompra.php?idCompra=" + idCompra + "&tipoCompra=" + tipoCompra;
            $('#example').DataTable({
                "columns": [
                    {
                        "data": function (row) {
                            let rep = '<form action="updateDetCompraForm.php" method="post" name="elimina">' +
                                '          <input name="tipoCompra" type="hidden" value="' + tipoCompra + '">' +
                                '          <input name="idCompra" type="hidden" value="' + idCompra + '">' +
                                '          <input name="codigo" type="hidden" value="' + row.codigo + '">' +
                                '          <input type="button" name="Submit" onclick="return Enviar(this.form)" class="formatoBoton"  value="Cambiar">' +
                                '       </form>'
                            return rep;
                        },
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "codigo",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "Producto",
                        "className": 'dt-body-left'
                    },
                    {
                        "data": "iva",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "cantidad",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "precio",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "lote",
                        "className": 'dt-body-center',
                        "visible": tipoCompra == 1 ? true : false
                    },
                    {
                        "data": function (row) {
                            let rep = '<form action="delDetCompra.php" method="post" name="elimina">' +
                                '          <input name="tipoCompra" type="hidden" value="' + tipoCompra + '">' +
                                '          <input name="idCompra" type="hidden" value="' + idCompra + '">' +
                                '          <input name="codigo" type="hidden" value="' + row.codigo + '">' +
                                '          <input type="button" name="Submit" onclick="return Enviar(this.form)" class="formatoBoton"  value="Eliminar">' +
                                '      </form>'
                            return rep;
                        },
                        "className": 'dt-body-center'
                    }
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
        <img src="../../../images/LogoNova.jpg" alt="novaquim" class="img-fluid mb-2"><h4>DETALLE DE COMPRA DE<?= $titulo ?></h4></div>
    <div class="mb-3 row formatoDatos5">
        <div class="col-2">
            <strong>No. de Compra</strong>
            <div class="bg-blue"><?= $idCompra; ?></div>
        </div>
        <div class="col-3">
            <strong>Proveedor</strong>
            <div class="bg-blue"><?= $compra['nomProv'] ?></div>
        </div>
        <div class="col-2">
            <strong>NIT</strong>
            <div class="bg-blue"><?= $compra['nitProv'] ?></div>
        </div>
        <div class="col-2">
            <strong>No. de Factura</strong>
            <div class="bg-blue"><?= $compra['numFact'] ?></div>
        </div>
        <div class="col-1">
            <strong>Estado</strong>
            <div class="bg-blue"><?= $compra['descEstado'] ?></div>
        </div>
    </div>
    <div class="mb-3 row formatoDatos5">
        <div class="col-2">
            <strong>Fecha de compra</strong>
            <div class="bg-blue"><?= $compra['fechComp']; ?></div>
        </div>
        <div class="col-2">
            <strong>Fecha Vencimiento </strong>
            <div class="bg-blue"><?= $compra['fechVenc'] ?></div>
        </div>
        <div class="col-1">
            <strong>Subtotal</strong>
            <div class="bg-blue"><?= $compra['subtotalCompra'] ?></div>
        </div>
        <div class="col-1">
            <strong>Iva </strong>
            <div class="bg-blue"><?= $compra['ivaCompra'] ?></div>
        </div>
        <div class="col-1">
            <strong>Reteiva </strong>
            <div class="bg-blue"><?= $compra['reteivaCompra'] ?></div>
        </div>
        <div class="col-1">
            <strong>Rete Ica</strong>
            <div class="bg-blue"><?= $compra['reteicaCompra'] ?></div>
        </div>
        <div class="col-1">
            <strong>Retención</strong>
            <div class="bg-blue"><?= $compra['retefuenteCompra'] ?></div>
        </div>
        <div class="col-1">
            <strong>Valor a Pagar</strong>
            <div class="bg-blue"><?= $compra['vreal'] ?></div>
        </div>
    </div>


    <?php
    if ($compra['estadoCompra'] != 7) {
        ?>
        <div class="titulo row text-center">
            <strong>Adicionar Productos</strong>
        </div>
        <?php
        if ($tipoCompra == 1) {
            ?>
            <form method="post" action="makeDetCompra.php" name="form1">
                <input name="tipoCompra" type="hidden" value="<?= $tipoCompra; ?>">
                <input name="idCompra" type="hidden" value="<?= $idCompra; ?>">
                <div class="mb-3 row">
                    <div class="col-2">
                        <label class="form-label formatoDatos5 " for="codigo"><strong>Materia Prima</strong></label>
                        <?php
                        $productos = $DetComprasOperador->getProdPorProveedorCompra($compra['idProv'], $tipoCompra, $idCompra);
                        $filas = count($productos);
                        echo '<select name="codigo" id="codigo" class="form-control" required>';
                        echo '<option disabled selected value="">-----------------------------</option>';
                        for ($i = 0; $i < $filas; $i++) {
                            echo '<option value="' . $productos[$i]["Codigo"] . '">' . $productos[$i]['Producto'] . '</option>';
                        }
                        echo '</select>';
                        ?>
                    </div>
                    <div class="col-1">
                        <label class="form-label formatoDatos5 " for="cantidad"><strong>Cantidad kg</strong></label>
                        <input type="text" class="form-control col-1" name="cantidad" id="cantidad" onkeydown="return aceptaNum(event)">
                    </div>
                    <div class="col-1">
                        <label class="form-label formatoDatos5 " for="precio"><strong>Precio kg (Sin IVA)</strong></label>
                        <input type="text" class="form-control col-1" name="precio" id="precio"
                               onkeydown="return aceptaNum(event)">
                    </div>
                    <div class="col-1" >
                        <label class="form-label formatoDatos5 " for="lote"><strong>Lote M Prima</strong></label>
                        <input type="text" class="form-control " maxlength="15" name="lote" id="lote">
                    </div>
                    <div class="col-2">
                        <label class="form-label formatoDatos5 " for="fechLote"><strong>Fecha Lote</strong></label>
                        <input type="date" class="form-control"
                               name="fechLote" id="fechLote">
                    </div>
                    <div class="col-2 pt-3">
                        <button class="button mt-3" type="button" onclick="return Enviar(this.form)"><span>Adicionar producto</span>
                        </button>
                    </div>
                </div>
            </form>
            <?php
        }
        if ($tipoCompra == 2) {
            ?>
            <form method="post" action="makeDetCompra.php" name="form1">
                <input name="tipoCompra" type="hidden" value="<?= $tipoCompra; ?>">
                <input name="idCompra" type="hidden" value="<?= $idCompra; ?>">
                <div class="mb-3 row">
                    <div class="col-2">
                        <label class="form-label formatoDatos5 " for="fechLote"><strong>Envase o tapa </strong></label>
                        <?php
                        $manager = new DetProveedoresOperaciones();
                        $productos = $DetComprasOperador->getProdPorProveedorCompra($compra['idProv'], $tipoCompra, $idCompra);
                        $filas = count($productos);
                        echo '<select name="codigo" id="codigo" class="form-control col-2" required>';
                        echo '<option disabled selected value="">-----------------------------</option>';
                        for ($i = 0; $i < $filas; $i++) {
                            echo '<option value="' . $productos[$i]["Codigo"] . '">' . $productos[$i]['Producto'] . '</option>';
                        }
                        echo '</select>';
                        ?>

                    </div>
                    <div class="col-1">
                        <label class="form-label formatoDatos5 " for="fechLote"><strong>Cantidad</strong></label>
                        <input type="text" class="form-control col-1" name="cantidad"
                               id="cantidad"
                               onkeydown="return aceptaNum(event)">

                    </div>
                    <div class="col-2">
                        <label class="form-label formatoDatos5 " for="fechLote"><strong>Precio por Un (Sin IVA)</strong></label>
                        <input type="text" class="form-control col-1" name="precio" id="precio" onkeydown="return aceptaNum(event)">
                    </div>
                    <div class="col-2 pt-3">
                        <button class="button mt-3" type="button" onclick="return Enviar(this.form)"><span>Adicionar producto</span>
                        </button>
                    </div>
                </div>
            </form>
            <?php
        }
        if ($tipoCompra == 3) {
            ?>
            <form method="post" action="makeDetCompra.php" name="form1">
                <input name="tipoCompra" type="hidden" value="<?= $tipoCompra; ?>">
                <input name="idCompra" type="hidden" value="<?= $idCompra; ?>">
                <div class="row mb-3">
                    <div class="col-2" >
                        <label class="form-label formatoDatos5 " for="fechLote"><strong>Etiqueta</strong></label>
                        <?php
                        $manager = new DetProveedoresOperaciones();
                        $productos = $DetComprasOperador->getProdPorProveedorCompra($compra['idProv'], $tipoCompra, $idCompra);
                        $filas = count($productos);
                        echo '<select name="codigo" id="codigo" class="form-control" required>';
                        echo '<option disabled selected value="">-----------------------------</option>';
                        for ($i = 0; $i < $filas; $i++) {
                            echo '<option value="' . $productos[$i]["Codigo"] . '">' . $productos[$i]['Producto'] . '</option>';
                        }
                        echo '</select>';
                        ?>
                    </div>
                    <div class="col-1" >
                        <label class="form-label formatoDatos5 " for="fechLote"><strong>Cantidad</strong></label>
                        <input type="text" class="form-control col-1" name="cantidad" id="cantidad" onkeydown="return aceptaNum(event)">
                    </div>
                    <div class="col-2" >
                        <label class="form-label formatoDatos5 " for="fechLote"><strong>Precio por Un (Sin IVA)</strong></label>
                        <input type="text" class="form-control" name="precio" id="precio" onkeydown="return aceptaNum(event)">
                    </div>
                    <div class="col-2 pt-3">
                        <button class="button mt-3" type="button" onclick="return Enviar(this.form)"><span>Adicionar producto</span>
                        </button>
                    </div>
                </div>
                <div class="mb-3 row">
                    <div class="col-2" >
                    </div>
                </div>
            </form>
            <?php
        }
        if ($tipoCompra == 5) {
            ?>
            <form method="post" action="makeDetCompra.php" name="form1">
                <input name="tipoCompra" type="hidden" value="<?= $tipoCompra; ?>">
                <input name="idCompra" type="hidden" value="<?= $idCompra; ?>">
                <div class="row">
                    <div class="col-3">
                        <label class="form-label formatoDatos5 " for="fechLote"><strong>Producto de distribución</strong></label>
                        <?php
                        $manager = new DetProveedoresOperaciones();
                        $productos = $DetComprasOperador->getProdPorProveedorCompra($compra['idProv'], $tipoCompra, $idCompra);
                        $filas = count($productos);
                        echo '<select name="codigo" id="codigo" class="form-control" required>';
                        echo '<option disabled selected value="">-----------------------------</option>';
                        for ($i = 0; $i < $filas; $i++) {
                            echo '<option value="' . $productos[$i]["Codigo"] . '">' . $productos[$i]['Producto'] . '</option>';
                        }
                        echo '</select>';
                        ?>
                    </div>
                    <div class="col-1" >
                        <label class="form-label formatoDatos5 " for="fechLote"><strong>Cantidad</strong></label>
                        <input type="text" class="form-control col-1" name="cantidad" id="cantidad" onkeydown="return aceptaNum(event)">
                    </div>
                    <div class="col-2" >
                        <label class="form-label formatoDatos5 " for="fechLote"><strong>Precio por Un (Sin IVA)</strong></label>
                        <input type="text" class="form-control col-1" name="precio" id="precio" onkeydown="return aceptaNum(event)">
                    </div>
                    <div class="col-2 pt-3">
                        <button class="button mt-3" type="button" onclick="return Enviar(this.form)"><span>Adicionar producto</span>
                        </button>
                    </div>
                </div>
                <div class="mb-3 row">

                    <div class="col-2" >
                    </div>
                </div>
            </form>
            <?php
        }
        ?>
        <?php
    }
    ?>
    <div class="titulo row text-center">
        <strong>Detalle de la compra</strong>
    </div>
    <div class="tabla-80">
    <table id="example" class="formatoDatos5 table table-sm table-striped formatoDatos5" >
        <thead>
        <tr>
            <th class="width1"></th>
            <th class="text-center width2">Código</th>
            <?php
            if ($tipoCompra == 1) {
                ?>
                <th class="text-center width3">Materia Prima</th>
                <th class="text-center width4">Iva</th>
                <th class="text-center width5">Cantidad(Kg)</th>
                <th class="text-center width6">Precio/Kg</th>
                <th class="text-center width7">Lote M. Prima</th>
                <?php
            }
            ?>
            <?php
            if ($tipoCompra == 2) {
                ?>
                <th class="text-center width34">Envase o tapa</th>
                <th class="text-center width4">Iva</th>
                <th class="text-center width5">Cantidad</th>
                <th class="text-center width56">Precio unitario(Sin Iva)</th>
                <th class="d-none">Lote</th>
                <?php
            }
            ?>
            <?php
            if ($tipoCompra == 3) {
                ?>
                <th class="text-center width34">Etiqueta</th>
                <th class="text-center width4">Iva</th>
                <th class="text-center width5">Cantidad</th>
                <th class="text-center width56">Precio unitario(Sin Iva)</th>
                <th class="d-none">Lote</th>
                <?php
            }
            ?>
            <?php
            if ($tipoCompra == 5) {
                ?>
                <th class="text-center width34">Producto</th>
                <th class="text-center width4"">Iva</th>
                <th class="text-center width5">Cantidad</th>
                <th class="text-center width56">Precio unitario(Sin Iva)</th>
                <th class="d-none">Lote</th>
                <?php
            }
            ?>
            <th class="width8"></th>
        </tr>
        </thead>
    </table>
    </div>
    <div class="row">
        <div class="col-1">
            <button class="button" id="back" onClick="updateEstadoCompra(<?= $idCompra ?>)"><span>Terminar</span>
            </button>
        </div>
    </div>
</div>
</body>
</html>