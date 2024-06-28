<?php
include "../../../includes/valAcc.php";
if (isset($_POST['idKit'])) {
    $idKit = $_POST['idKit'];
} else {
    if (isset($_SESSION['idKit'])) {
        $idKit = $_SESSION['idKit'];
    }
}
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$KitOperador = new KitsOperaciones();
$DetKitOperador = new DetKitsOperaciones();
$kit = $KitOperador->getKit($idKit);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Detalle de Kit</title>
    <meta charset="utf-8">
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../../../css/datatables.css">
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
    <script src="../../../js/jquery-3.3.1.min.js"></script>
    <script src="../../../js/datatables.js"></script>

    <script>
        function eliminarSession() {
            let variables = 'idKit';
            $.ajax({
                url: '../../../includes/controladorProduccion.php',
                type: 'POST',
                data: {
                    "action": 'eliminarSession',
                    "variables": variables,
                },
                dataType: 'text',
                success: function (res) {
                    window.location = '../../../menu.php';
                },
                error: function () {
                    alert("Vous avez un GROS problème");
                }
            });
        }

        $(document).ready(function () {
            let idKit = <?= $idKit; ?>;
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
                        "data": function (row) {
                            let rep = '<form action="delprodKit.php" method="post" name="elimina">' +
                                '                    <input name="idKit" type="hidden" value="' + idKit + '">' +
                                '                    <input name="codProducto" type="hidden" value="' + row.codProducto + '">' +
                                '                    <input type="submit" name="Submit" class="formatoBoton"  value="Eliminar">' +
                                '                </form>'
                            return rep;
                        },
                        "className": 'dt-body-center',
                        width: '20%'
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
                "ajax": "../ajax/listaDetKit.php?idKit=" + idKit
            });
        });
    </script>
</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo1">
        <img src="../../../images/LogoNova.jpg" alt="novaquim" class="img-fluid mb-2"><h4>DETALLE DE KIT</h4></div>

    <div class="mb-3 row formatoDatos5">
        <div class="col-1">
            <label class="mb-1"><strong>Código Kit</strong></label>
            <div class="bg-blue"><?= $idKit; ?></div>
        </div>
        <div class="col-3">
            <label class="mb-1"><strong class="mb-1">Kit</strong></label>
            <div class="bg-blue"><?= $kit['producto'] ?></div>
        </div>
    </div>
    <div class="mb-3 titulo row text-center">
        Agregar detalle
    </div>
    <form method="post" class="formatoDatos5 mb-4" action="makeDetKit.php" name="form1">
        <input name="idKit" type="hidden" value="<?= $idKit; ?>">
        <div class="row">
            <div class="col-4 text-center">
                <strong>Producto Novaquim</strong>
                <select name="codProducto" id="codProducto" class="form-select" onchange="findLotePresentacion(this.value);" required>
                    <option selected disabled value="">Seleccione una opción-</option>
                    <?php
                    $presentaciones = $DetKitOperador->getProdNovaquim($idKit);
                    for ($i = 0; $i < count($presentaciones); $i++) {
                        echo '<option value="' . $presentaciones[$i]['codigo'] . '">' . $presentaciones[$i]['producto'] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="col-2 pt-2">
                <button class="button mt-2" type="button" onclick="return Enviar(this.form)"><span>Continuar</span>
                </button>
            </div>
        </div>
    </form>
    <form method="post" class="formatoDatos5" action="makeDetKit.php" name="form1">
        <input name="idKit" type="hidden" value="<?= $idKit; ?>">
        <div class="row">
            <div class="col-4 text-center">
                <strong>Producto Distribución</strong>
                <select name="codProducto" id="codProducto" class="form-select" onchange="findLotePresentacion(this.value);" required>
                    <option selected disabled value="">Seleccione una opción</option>
                    <?php
                    $prodsDistribucion = $DetKitOperador->getProdDistribucion($idKit);
                    for ($i = 0; $i < count($prodsDistribucion); $i++) {
                        echo '<option value="' . $prodsDistribucion[$i]['codigo'] . '">' . $prodsDistribucion[$i]['producto'] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="col-2 pt-2">
                <button class="button mt-2" type="button" onclick="return Enviar(this.form)"><span>Continuar</span>
                </button>
            </div>
        </div>
    </form>
    <div class="mb-3 titulo row text-center">
        Detalle
    </div>
    <div class="tabla-50">
        <table id="example" class="formatoDatos5 table table-sm table-striped">
            <thead>
            <tr>
                <th class="text-center">Código</th>
                <th class="text-center">Producto</th>
                <th class="text-center"></th>
            </tr>
            </thead>
        </table>
    </div>
    <div class="row">
        <div class="col-1">
            <button class="button" onclick="eliminarSession(); ">
                <span><STRONG>Terminar</STRONG></span>
            </button>
        </div>
    </div>
</div>
</body>
</html>
	   