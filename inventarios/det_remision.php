<?php
include "../../../includes/valAcc.php";
if (isset($_SESSION['idRemision'])) {//Si idRemision existe
    $idRemision = $_SESSION['idRemision'];
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

$remisionOperador = new RemisionesOperaciones();
$remisionOperador->updateTotalRemision($idRemision);
$remision = $remisionOperador->getRemisionById($idRemision);
//
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Ingreso de Productos a la Remisión</title>
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
            width: 10%;
        }

        .width2 {
            width: 15%;
        }

        .width3 {
            width: 50%;
        }

        .width4 {
            width: 15%;
        }

        .width5 {
            width: 10%;
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
            let variable = 'idRemision';
            $.ajax({
                url: '../includes/controladorInventarios.php',
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
            let idRemision = <?=$idRemision?>;
            let ruta = "../ajax/listaDetRemision.php?idRemision=" + idRemision;
            $('#example').DataTable({
                "columns": [
                    {
                        "data": function (row) {
                            let rep = '<form action="updateDetRemisionForm.php" method="post" name="elimina">' +
                                '          <input name="idRemision" type="hidden" value="' + idRemision + '">' +
                                '          <input name="codProducto" type="hidden" value="' + row.codProducto + '">' +
                                '          <input type="button" name="Submit" onclick="return Enviar(this.form)" class="formatoBoton"  value="Cambiar">' +
                                '      </form>'
                            return rep;
                        },
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "codProducto",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "producto",
                        "className": 'dt-body-left'
                    },
                    {
                        "data": "cantProducto",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "precioProducto",
                        "className": 'dt-body-left'
                    },
                    {
                        "data": function (row) {
                            let rep = '<form action="delDetRemision.php" method="post" name="elimina">' +
                                '          <input name="idRemision" type="hidden" value="' + idRemision + '">' +
                                '          <input name="codProducto" type="hidden" value="' + row.codProducto + '">' +
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
<div id="contenedor" class="container-fluid">
    <div id="saludo1">
        <img src="../images/LogoNova.jpg" alt="novaquim" class="img-fluid mb-2"><h4>DETALLE DE LA REMISIÓN</h4></div>
    <div class="mb-3 row">
        <div class="col-2"><strong>No. de Remisión</strong></div>
        <div class="col-1 bg-blue"><?= $idRemision; ?></div>
        <div class="col-1"><strong>Cliente</strong></strong></div>
        <div class="col-3" style="background-color: #dfe2fd;"><?= $remision['cliente'] ?></div>
        <div class="col-1"><strong>Fecha</strong></div>
        <div class="col-1 bg-blue"><?= $remision['fechaRemision'] ?></div>
        <div class="col-1"><strong>Valor</strong></div>
        <div class="col-1 bg-blue">$ <?= number_format($remision['valor']) ?></div>
    </div>
    <div class="mb-3 titulo row text-center">
        <strong>Adicionar Detalle</strong>
    </div>
    <form method="post" action="makeDetRemision.php" name="form1">
        <input name="idRemision" type="hidden" value="<?= $idRemision; ?>">
        <div class="row">
            <div class="col-4 text-center mx-3" ><strong>Productos Novaquim</strong></div>
            <div class="col-1 text-center mx-3" ><strong>Unidades</strong></div>
            <div class="col-1 text-center mx-3" ><strong>Precio</strong></div>
            <div class="col-2 text-center mx-3"></div>
        </div>
        <div class="mb-3 row">
            <select name="codProducto" id="codProducto" class="form-select col-4 mx-3">
                <option selected disabled value="">Escoja un producto Novaquim</option>
                <?php
                $productos = $remisionOperador->getProdTerminadosByIdRemision($idRemision);
                $filas = count($productos);
                for ($i = 0; $i < $filas; $i++) {
                    echo '<option value="' . $productos[$i]["codPresentacion"] . '">' . $productos[$i]['presentacion'] . '</option>';
                }
                ?>
            </select>
            <input type="text" class="form-control col-1 mx-3" name="cantProducto"
                   id="cantProducto" onkeydown="return aceptaNum(event)">
            <input type="text" class="form-control col-1 mx-3" name="precioProducto"
                   id="precioProducto" onkeydown="return aceptaNum(event)">
            <div class="col-2 text-center mx-3" >
                <button class="button" type="button" onclick="return Enviar(this.form)"><span>Adicionar detalle</span>
                </button>
            </div>
        </div>
    </form>
    <form method="post" action="makeDetRemision.php" name="form1">
        <input name="idRemision" type="hidden" value="<?= $idRemision; ?>">
        <div class="row">
            <div class="col-4 text-center mx-3" ><strong>Productos Distribucion</strong></div>
            <div class="col-1 text-center mx-3" ><strong>Unidades</strong></div>
            <div class="col-1 text-center mx-3" ><strong>Precio</strong></div>
            <div class="col-2 text-center mx-3"></div>
        </div>
        <div class="mb-3 row">
            <select name="codProducto" id="codProducto" class="form-select col-4 mx-3">
                <option selected disabled value="">Escoja un producto de distribución</option>
                <?php
                $productos = $remisionOperador->getProdDistribucionByIdRemision($idRemision);
                $filas = count($productos);
                for ($i = 0; $i < $filas; $i++) {
                    echo '<option value="' . $productos[$i]["codDistribucion"] . '">' . $productos[$i]['producto'] . '</option>';
                }
                ?>
            </select>
            <input type="text" class="form-control col-1 mx-3" name="cantProducto"
                   id="cantProducto" onkeydown="return aceptaNum(event)">
            <input type="text" class="form-control col-1 mx-3" name="precioProducto"
                   id="precioProducto" onkeydown="return aceptaNum(event)">
            <div class="col-2 text-center mx-3">
                <button class="button" type="button" onclick="return Enviar(this.form)"><span>Adicionar detalle</span>
                </button>
            </div>
        </div>
    </form>
    <div class="mb-3 titulo row text-center">
        <strong>Detalle de la remisión</strong>
    </div>
    <div class="tabla-50">
        <table id="example" class="formatoDatos table table-sm table-striped formatoDatos">
            <thead>
            <tr>
                <th class="width1"></th>
                <th class="width2">Código</th>
                <th class="width3">Producto</th>
                <th class="width4">Cantidad</th>
                <th class="width5">Precio</th>
                <th class="width6"></th>
            </tr>
            </thead>
        </table>
    </div>

    <div class="mb-3 row">
        <div class="col-2">
            <form action="Imp_Remision1.php" method="post" target="_blank">
                <input name="idRemision" type="hidden" value="<?php echo $idRemision ?>">
                <button name="Submit" type="submit" class="button"><span>Imprimir Remisión</span></button>
            </form>
        </div>
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
	   