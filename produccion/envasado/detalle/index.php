<?php
include "../../../includes/valAcc.php";

if (isset($_POST['lote'])) {
    $lote = $_POST['lote'];
} else {
    if (isset($_SESSION['lote'])) {
        $lote = $_SESSION['lote'];
    }
}

function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$OProdOperador = new OProdOperaciones();
$ordenProd = $OProdOperador->getOProd($lote);
$EnvasadoOperador = new EnvasadoOperaciones();
$cantidadPendiente = $EnvasadoOperador->getCantidadPorEnvasar($lote);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Envasado de productos por lote</title>
    <meta charset="utf-8">
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../../../css/datatables.css">
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
    <script src="../../../js/jquery-3.3.1.min.js"></script>
    <script src="../../../js/datatables.js"></script>

    <script>
        function terminarEnvasado(lote) {
            //alert(idCatProd);
            $.ajax({
                url: '../../../includes/controladorProduccion.php',
                type: 'POST',
                data: {
                    "action": 'updateEstadoOProd',
                    "estado": 4,
                    "lote": lote
                },
                dataType: 'text',
                success: function (message) {
                    alerta('Envasado finalizado correctamente', 'success', '../../../menu.php', '');
                },
                error: function () {
                    alert("Vous avez un GROS problème");
                }
            });
        }

        $(document).ready(function () {
            let lote = <?=$lote?>;
            let cantidadPendiente = <?=$cantidadPendiente?>;
            let ruta = "../ajax/listaDetEnvasado.php?lote=" + lote;
            $('#example').DataTable({
                "columns": [
                    {
                        "data": function (row) {
                            let rep = '<form action="updateEnvasadoForm.php" method="post" name="actualiza">' +
                                '          <input name="lote" type="hidden" value="' + lote + '">' +
                                '          <input name="cantidadPendiente" type="hidden" value="' + cantidadPendiente + '">' +
                                '          <input name="codPresentacion" type="hidden" value="' + row.codPresentacion + '">' +
                                '          <input type="button" name="Submit" onclick="return Enviar(this.form)" class="formatoBoton"  value="Cambiar">' +
                                '      </form>'
                            return rep;
                        },
                        "className": 'dt-body-center',
                        width: '15%'
                    },
                    {
                        "data": "codPresentacion",
                        "className": 'dt-body-center',
                        width: '15%'
                    },
                    {
                        "data": "presentacion",
                        "className": 'dt-body-center',
                        width: '55%'
                    },
                    {
                        "data": "cantPresentacion",
                        "className": 'dt-body-center',
                        width: '15%'
                    },
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
        <img src="../../../images/LogoNova.jpg" alt="novaquim" class="img-fluid mb-2"><h4>PRODUCTOS ENVASADOS POR LOTE</h4></div>
    <div class="mb-3 row formatoDatos5">
        <div class="col-3">
            <strong>Producto</strong>
            <div class="bg-blue"><?= $ordenProd['nomProducto'] ?></div>
        </div>
        <div class="col-1">
            <strong>Lote</strong>
            <div class="bg-blue"><?= $lote; ?></div>
        </div>
        <div class="col-1">
            <strong>Cantidad</strong>
            <div class="bg-blue"><?= $ordenProd['cantidadKg'] ?> Kg</div>
        </div>
        <div class="col-1">
            <strong>Fecha producción</strong>
            <div class="bg-blue"><?= $ordenProd['fechProd'] ?></div>
        </div>
        <div class="col-2">
            <strong>Responsable</strong>
            <div class="bg-blue"><?= $ordenProd['nomPersonal'] ?></div>
        </div>
    </div>
    <div class="mb-3 titulo row text-center">
        Adicionar Envasado
    </div>
    <form method="post" class="formatoDatos5" action="makeEnvasado.php" name="form1">
        <input name="lote" type="hidden" value="<?= $lote; ?>">
        <input name="cantidadPendiente" type="hidden" value="<?= $cantidadPendiente; ?>">
        <div class="row">
            <div class="col-3">
                <label class="form-label" for="codPresentacion"><strong>Presentación de Productos</strong></label>
                <select name="codPresentacion" id="codPresentacion" class="form-select" required>
                    <option selected disabled value="">Seleccione una opción-</option>
                    <?php
                    $presentaciones = $EnvasadoOperador->getPresentacionesPorEnvasar($lote);
                    for ($i = 0; $i < count($presentaciones); $i++) {
                        echo '<option value="' . $presentaciones[$i]['codPresentacion'] . '">' . $presentaciones[$i]['presentacion'] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="col-1">
                <label class="form-label" for="cantPresentacion"><strong>Unidades</strong></label>
                <input type="text" class="form-control" name="cantPresentacion" id="cantPresentacion" onkeydown="return aceptaNum(event)" required>
            </div>
            <div class="col-2 pt-3">
                <button class="button mt-2" type="button" onclick="return Enviar(this.form)"><span>Adicionar envasado</span></button>
            </div>
        </div>
    </form>
    <div class="mb-3 row titulo">Detalle envasado :</div>
    <div class="tabla-50">
        <table id="example" class="formatoDatos5 table table-sm table-striped">
            <thead>
            <tr>
                <th class="width1"></th>
                <th class="width2">Código</th>
                <th class="width3">Producto por presentación</th>
                <th class="width4">Cantidad</th>
            </tr>
            </thead>
        </table>
    </div>
    <div class="tabla-50">
        <table width="100% formatoDatos">
            <tr>
                <td width="85%" class="text-end text-bold formatoDatos">Cantidad pendiente en litros</td>
                <td width="15%" class="text-center text-bold formatoDatos"><?= $cantidadPendiente ?></td>
            </tr>
        </table>
    </div>
    <div class="row mb-3">
        <div class="col-2">
            <button class="button" onclick="terminarEnvasado(<?= $lote; ?>)">
                <span><STRONG>Terminar envasado</STRONG></span>
            </button>
        </div>
    </div>
    <div class="row">
        <div class="col-1">
            <button class="button" onclick="window.location='../../../menu.php'">
                <span><STRONG>Ir al menú</STRONG></span>
            </button>
        </div>
    </div>
</div>
</body>
</html>