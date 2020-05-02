<?php
include "../includes/valAcc.php";

if (isset($_SESSION['idCompra'])) {//Si la factura existe
    $idCompra = $_SESSION['idCompra'];
    $tipoCompra = $_SESSION['tipoCompra'];
}
foreach ($_POST as $nombre_campo => $valor) {
    $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
    //echo $nombre_campo . " = " . $valor . "<br>";
    eval($asignacion);
}

function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');

function mover_pag($ruta, $nota)//Funcion que permite el redireccionamiento a otra pagina
{
    echo ' <script >
            alert("' . $nota . '")
            self.location="' . $ruta . '"
            </script>';
}

switch ($tipoCompra) {
    case 1:
        $titulo = ' materias primas';
        $rutaError = 'compramp.php';
        break;
    case 2:
        $titulo = ' envases y/o tapas';
        $rutaError = 'compraenv.php';
        break;
    case 3:
        $titulo = ' etiquetas';
        $rutaError = 'compraetq.php';
        break;
    case 5:
        $titulo = ' productos de distribución';
        $rutaError = 'compradist.php';
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
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../css/datatables.css">
    <style>
        table.dataTable.compact thead th, table.dataTable.compact thead td {
            padding: 4px 4px 4px 4px;
        }
    </style>
    <script src="../js/validar.js"></script>
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/datatables.js"></script>
    <script src="../js/jszip.js"></script>
    <script src="../js/pdfmake.js"></script>
    <script src="../js/vfs_fonts.js"></script>
    <script>
        function redireccion() {
            eliminarSession();
            window.location.href = "../menu.php";
        }

        function eliminarSession() {
            let variable = 'idCompra';
            $.ajax({
                url: '../includes/controladorCompras.php',
                type: 'POST',
                data: {
                    "action": 'eliminarSession',
                    "variable": variable,
                },
                dataType: 'text',
                success: function (res) {
                },
                fail: function () {
                    alert("Vous avez un GROS problème");
                }
            });
        }
        function updateEstadoCompra(idCompra) {
            let estadoActualCompra = <?=$compra['estadoCompra']?>;
            if (estadoActualCompra != 2) {
                redireccion();
            }
            else{
                $.ajax({
                    url: '../includes/controladorCompras.php',
                    type: 'POST',
                    data: {
                        "action": 'updateEstadoCompra',
                        "idCompra": idCompra,
                        "estadoCompra": 3,
                    },
                    dataType: 'json',
                    success: function (respuesta) {
                        if (respuesta.msg == 'OK') {
                            redireccion();
                        }
                    },
                    fail: function () {
                        alert("Vous avez un GROS problème");
                    }
                });
            }
        }

        $(document).ready(function () {
            let tipoCompra = <?=$tipoCompra?>;
            let idCompra = <?=$idCompra?>;
            let ruta = "ajax/listaDetCompra.php?idCompra=" + idCompra + "&tipoCompra=" + tipoCompra;
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
                        "className": 'dt-body-center'
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
    <div id="saludo1"><strong>DETALLE DE COMPRA DE<?= $titulo ?></strong></div>
    <div class="form-group row">
        <div class="col-1 text-right"><strong>No. de Compra</strong></div>
        <div class="col-1" style="background-color: #dfe2fd;"><?= $idCompra; ?></div>
        <div class="col-1 text-right"><strong>Proveedor</strong></strong></div>
        <div class="col-3" style="background-color: #dfe2fd;"><?= $compra['nomProv'] ?></div>
        <div class="col-1 text-right"><strong>NIT</strong></div>
        <div class="col-1" style="background-color: #dfe2fd;"><?= $compra['nitProv'] ?></div>
    </div>
    <div class="form-group row">
        <div class="col-1 text-right"><strong>No. de Factura</strong></div>
        <div class="col-1" style="background-color: #dfe2fd;"><?= $compra['numFact'] ?></div>
        <div class="col-2 text-right"><strong>Fecha de compra</strong></div>
        <div class="col-1" style="background-color: #dfe2fd;"><?= $compra['fechComp']; ?></div>
        <div class="col-2 text-right"><strong>Fecha Vencimiento </strong></strong></div>
        <div class="col-1" style="background-color: #dfe2fd;"><?= $compra['fechVenc'] ?></div>
        <div class="col-1 text-right"><strong>Estado</strong></div>
        <div class="col-1" style="background-color: #dfe2fd;"><?= $compra['descEstado'] ?></div>
    </div>
    <div class="form-group row">
        <div class="col-1 text-right"><strong>Valor Factura</strong></div>
        <div class="col-1" style="background-color: #dfe2fd;"><?= $compra['totalCompra'] ?></div>
        <div class="col-1 text-right"><strong>Rete Ica</strong></strong></div>
        <div class="col-1" style="background-color: #dfe2fd;"><?= $compra['reteicaCompra'] ?></div>
        <div class="col-1 text-right"><strong>Retención</strong></div>
        <div class="col-1" style="background-color: #dfe2fd;"><?= $compra['retefuenteCompra'] ?></div>
        <div class="col-1 text-right"><strong>Valor a Pagar</strong></div>
        <div class="col-1" style="background-color: #dfe2fd;"><?= $compra['vreal'] ?></div>
    </div>


    <?php
    if ($compra['estadoCompra'] != 7) {
        ?>
        <div class="form-group titulo row">
            <strong>Adicionar Productos</strong>
        </div>
        <?php
        if ($tipoCompra == 1) {
            ?>
            <form method="post" action="makeDetCompra.php" name="form1">
                <input name="tipoCompra" type="hidden" value="<?= $tipoCompra; ?>">
                <input name="idCompra" type="hidden" value="<?= $idCompra; ?>">
                <div class="row">
                    <div class="col-2 text-center" style="margin: 0 5px 0 0;"><strong>Materia Prima</strong></div>
                    <div class="col-1 text-center" style="margin: 0 5px;"><strong>Cantidad en Kg</strong></div>
                    <div class="col-1 text-center" style="margin: 0 5px;"><strong>Precio por Kg (Sin IVA)</strong></div>
                    <div class="col-1 text-center" style="margin: 0 5px;"><strong>Lote Materia Prima</strong></div>
                    <div class="text-center" style="margin: 0 0 0 5px; flex: 0 0 10%; max-width: 10%;"><strong>Fecha
                            Lote</strong></div>
                    <div class="col-2 text-center">
                    </div>
                </div>
                <div class="form-group row">
                    <?php
                    $manager = new DetProveedoresOperaciones();
                    $productos = $manager->getProdPorProveedor($compra['idProv'], $tipoCompra);
                    $filas = count($productos);
                    echo '<select name="codigo" id="codigo" class="form-control col-2" style="margin: 0 5px;">';
                    echo '<option disabled selected value="">-----------------------------</option>';
                    for ($i = 0; $i < $filas; $i++) {
                        echo '<option value="' . $productos[$i]["Codigo"] . '">' . $productos[$i]['Producto'] . '</option>';
                    }
                    echo '</select>';
                    ?>
                    <input type="text" style="margin: 0 5px 0 0;" class="form-control col-1" name="cantidad"
                           id="cantidad"
                           onKeyPress="return aceptaNum(event)">
                    <input type="text" style="margin: 0 5px;" class="form-control col-1" name="precio" id="precio"
                           onKeyPress="return aceptaNum(event)">
                    <input type="text" style="margin: 0 5px;" class="form-control col-1" name="lote" id="lote">
                    <input type="date" style="margin: 0 0 0 5px; flex: 0 0 10%; max-width: 10%;" class="form-control"
                           name="fechLote" id="fechLote">
                    <div class="col-2 text-center" style="padding: 0 20px;">
                        <button class="button" onclick="return Enviar(this.form)"><span>Adicionar producto</span>
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
                <div class="row">
                    <div class="col-2 text-center" style="margin: 0 5px 0 0;"><strong>Envase</strong></div>
                    <div class="col-1 text-center" style="margin: 0 5px;"><strong>Cantidad</strong></div>
                    <div class="col-1 text-center" style="margin: 0 5px;"><strong>Precio por Un (Sin IVA)</strong></div>
                    <div class="col-2 text-center"></div>
                </div>
                <div class="form-group row">
                    <?php
                    $manager = new DetProveedoresOperaciones();
                    $productos = $manager->getProdPorProveedor($compra['idProv'], $tipoCompra);
                    $filas = count($productos);
                    echo '<select name="codigo" id="codigo" class="form-control col-2" style="margin: 0 5px;">';
                    echo '<option disabled selected value="">-----------------------------</option>';
                    for ($i = 0; $i < $filas; $i++) {
                        echo '<option value="' . $productos[$i]["Codigo"] . '">' . $productos[$i]['Producto'] . '</option>';
                    }
                    echo '</select>';
                    ?>
                    <input type="text" style="margin: 0 5px 0 0;" class="form-control col-1" name="cantidad"
                           id="cantidad"
                           onKeyPress="return aceptaNum(event)">
                    <input type="text" style="margin: 0 5px;" class="form-control col-1" name="precio" id="precio"
                           onKeyPress="return aceptaNum(event)">
                    <div class="col-2 text-center" style="padding: 0 20px;">
                        <button class="button" onclick="return Enviar(this.form)"><span>Adicionar producto</span>
                        </button>
                    </div>
                </div>
            </form>
            <form method="post" action="makeDetCompra.php" name="form1">
                <input name="tipoCompra" type="hidden" value="<?= $tipoCompra; ?>">
                <input name="idCompra" type="hidden" value="<?= $idCompra; ?>">
                <div class="row">
                    <div class="col-2 text-center" style="margin: 0 5px 0 0;"><strong>Tapa o válvula</strong></div>
                    <div class="col-1 text-center" style="margin: 0 5px;"><strong>Cantidad</strong></div>
                    <div class="col-1 text-center" style="margin: 0 5px;"><strong>Precio por Un (Sin IVA)</strong></div>
                    <div class="col-2 text-center"></div>
                </div>
                <div class="form-group row">
                    <?php
                    $manager = new DetProveedoresOperaciones();
                    $productos = $manager->getProdPorProveedor($compra['idProv'], $tipoCompra);
                    $filas = count($productos);
                    echo '<select name="codigo" id="codigo" class="form-control col-2" style="margin: 0 5px;">';
                    echo '<option disabled selected value="">-----------------------------</option>';
                    for ($i = 0; $i < $filas; $i++) {
                        echo '<option value="' . $productos[$i]["Codigo"] . '">' . $productos[$i]['Producto'] . '</option>';
                    }
                    echo '</select>';
                    ?>
                    <input type="text" style="margin: 0 5px 0 0;" class="form-control col-1" name="cantidad"
                           id="cantidad"
                           onKeyPress="return aceptaNum(event)">
                    <input type="text" style="margin: 0 5px;" class="form-control col-1" name="precio" id="precio"
                           onKeyPress="return aceptaNum(event)">
                    <div class="col-2 text-center" style="padding: 0 20px;">
                        <button class="button" onclick="return Enviar(this.form)"><span>Adicionar producto</span>
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
                <div class="row">
                    <div class="col-2 text-center" style="margin: 0 5px 0 0;"><strong>Etiqueta</strong></div>
                    <div class="col-1 text-center" style="margin: 0 5px;"><strong>Cantidad</strong></div>
                    <div class="col-1 text-center" style="margin: 0 5px;"><strong>Precio por Un (Sin IVA)</strong></div>
                    <div class="col-2 text-center">
                    </div>
                </div>
                <div class="form-group row">
                    <?php
                    $manager = new DetProveedoresOperaciones();
                    $productos = $manager->getProdPorProveedor($compra['idProv'], $tipoCompra);
                    $filas = count($productos);
                    echo '<select name="codigo" id="codigo" class="form-control col-2" style="margin: 0 5px;">';
                    echo '<option disabled selected value="">-----------------------------</option>';
                    for ($i = 0; $i < $filas; $i++) {
                        echo '<option value="' . $productos[$i]["Codigo"] . '">' . $productos[$i]['Producto'] . '</option>';
                    }
                    echo '</select>';
                    ?>
                    <input type="text" style="margin: 0 5px 0 0;" class="form-control col-1" name="cantidad"
                           id="cantidad"
                           onKeyPress="return aceptaNum(event)">
                    <input type="text" style="margin: 0 5px;" class="form-control col-1" name="precio" id="precio"
                           onKeyPress="return aceptaNum(event)">
                    <div class="col-2 text-center" style="padding: 0 20px;">
                        <button class="button" onclick="return Enviar(this.form)"><span>Adicionar producto</span>
                        </button>
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
                    <div class="col-2 text-center" style="margin: 0 5px 0 0;"><strong>Producto de distribución</strong>
                    </div>
                    <div class="col-1 text-center" style="margin: 0 5px;"><strong>Cantidad</strong></div>
                    <div class="col-1 text-center" style="margin: 0 5px;"><strong>Precio por Un (Sin IVA)</strong></div>
                    <div class="col-2 text-center">
                    </div>
                </div>
                <div class="form-group row">
                    <?php
                    $manager = new DetProveedoresOperaciones();
                    $productos = $manager->getProdPorProveedor($compra['idProv'], $tipoCompra);
                    $filas = count($productos);
                    echo '<select name="codigo" id="codigo" class="form-control col-2" style="margin: 0 5px;">';
                    echo '<option disabled selected value="">-----------------------------</option>';
                    for ($i = 0; $i < $filas; $i++) {
                        echo '<option value="' . $productos[$i]["Codigo"] . '">' . $productos[$i]['Producto'] . '</option>';
                    }
                    echo '</select>';
                    ?>
                    <input type="text" style="margin: 0 5px 0 0;" class="form-control col-1" name="cantidad"
                           id="cantidad"
                           onKeyPress="return aceptaNum(event)">
                    <input type="text" style="margin: 0 5px;" class="form-control col-1" name="precio" id="precio"
                           onKeyPress="return aceptaNum(event)">
                    <div class="col-2 text-center" style="padding: 0 20px;">
                        <button class="button" onclick="return Enviar(this.form)"><span>Adicionar producto</span>
                        </button>
                    </div>
                </div>
            </form>
            <?php
        }
        ?>
        <?php
    }
    ?>
    <div class="form-group titulo row">
        <strong>Detalle de la compra</strong>
    </div>
    <table id="example" class="display compact" style="width:80%; margin-bottom: 20px;">
        <thead>
        <tr>
            <th width="8%"></th>
            <th width="8%">Código</th>
            <?php
            if($tipoCompra==1){
                ?>
                <th width="36%">Materia Prima</th>
                <th width="5%">Iva</th>
                <th width="10%">Cantidad(Kg)</th>
                <th width="10%">Precio/Kg</th>
                <th width="15%">Lote M. Prima</th>
            <?php
            }
            ?>
            <?php
            if($tipoCompra==2){
                ?>
                <th width="41%">Envase o tapa</th>
                <th width="5%">Iva</th>
                <th width="10%">Cantidad</th>
                <th width="20%">Precio unitario(Sin Iva)</th>
                <th style="display: none">Lote</th>
                <?php
            }
            ?>
            <?php
            if($tipoCompra==3){
                ?>
                <th width="41%">Etiqueta</th>
                <th width="5%">Iva</th>
                <th width="10%">Cantidad</th>
                <th width="20%">Precio unitario(Sin Iva)</th>
                <th style="display: none">Lote</th>
                <?php
            }
            ?>
            <?php
            if($tipoCompra==5){
                ?>
                <th width="41%">Producto</th>
                <th width="5%">Iva</th>
                <th width="10%">Cantidad</th>
                <th width="20%">Precio unitario(Sin Iva)</th>
                <th style="display: none">Lote</th>
                <?php
            }
            ?>
            <th width="8%"></th>
        </tr>
        </thead>
    </table>
    <div class="row">
        <div class="col-1">
            <button class="button" id="back" onClick="updateEstadoCompra(<?= $idCompra ?>)"><span>Terminar</span>
            </button>
        </div>
    </div>
</div>
</body>
</html>