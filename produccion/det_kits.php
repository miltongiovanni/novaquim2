<?php
include "../includes/valAcc.php";
if (isset($_POST['idKit'])) {
    $idKit = $_POST['idKit'];
} else {
    if (isset($_SESSION['idKit'])) {
        $idKit = $_SESSION['idKit'];
    }
}
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
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
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../css/datatables.css">
    <script src="../js/validar.js"></script>
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/datatables.js"></script>
    <script src="../js/jszip.js"></script>
    <script src="../js/pdfmake.js"></script>
    <script src="../js/vfs_fonts.js"></script>
    <script>
        function eliminarSession() {
            let variables = 'idKit';
            $.ajax({
                url: '../includes/controladorProduccion.php',
                type: 'POST',
                data: {
                    "action": 'eliminarSession',
                    "variables": variables,
                },
                dataType: 'text',
                success: function (res) {
                    window.location = '../menu.php';
                },
                fail: function () {
                    alert("Vous avez un GROS problème");
                }
            });
        }

        $(document).ready(function () {
            let idKit = <?= $idKit; ?>;
            $('#example').DataTable({
                "columns": [
                    {
                        /*"className": 'details-control',*/
                        /*"orderable": false,*/
                        "data": "codProducto",
                        "className": 'dt-body-center'
                        /*"defaultContent": ''*/
                    },
                    {
                        "data": "producto",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": function (row) {
                            let rep = '<form action="delprodKit.php" method="post" name="elimina">' +
                                '                    <input name="idKit" type="hidden" value="' + idKit + '">' +
                                '                    <input name="codProducto" type="hidden" value="' + row.codProducto + '">' +
                                '                    <input type="submit" name="Submit" class="formatoBoton formatoDatos"  value="Eliminar">' +
                                '                </form>'
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
                "ajax": "ajax/listaDetKit.php?idKit=" + idKit
            });
        });
    </script>
</head>
<body>
<div id="contenedor">
    <div id="saludo1"><strong>DETALLE DE KIT</strong></div>

    <div class="form-group row">
        <div class="col-1 text-right"><strong>Código Kit</strong></div>
        <div class="col-1 bg-blue"><?= $idKit; ?></div>
        <div class="col-1 text-right"><strong>Kit</strong></div>
        <div class="col-3 bg-blue"><?= $kit['producto'] ?></div>
    </div>
    <div class="form-group titulo row">
        Agregar detalle
    </div>
    <form method="post" action="makeDetKit.php" name="form1">
        <input name="idKit" type="hidden" value="<?= $idKit; ?>">
        <div class="row">
            <div class="col-4 text-center" style="margin: 0 5px 0 0;"><strong>Producto Novaquim</strong></div>
            <div class="col-2 text-center">
            </div>
        </div>
        <div class="form-group row">
            <select name="codProducto" id="codProducto" class="form-control col-4"
                    style="margin: 0 5px 0 0;" onchange="findLotePresentacion(this.value);">
                <option selected disabled value="">------------------------------</option>
                <?php
                $presentaciones = $DetKitOperador->getProdNovaquim($idKit);
                for ($i = 0; $i < count($presentaciones); $i++) {
                    echo '<option value="' . $presentaciones[$i]['codigo'] . '">' . $presentaciones[$i]['producto'] . '</option>';
                }
                ?>
            </select>
            <div class="col-2 text-center" style="padding: 0 20px;">
                <button class="button" onclick="return Enviar(this.form)"><span>Continuar</span>
                </button>
            </div>
        </div>
    </form>
    <form method="post" action="makeDetKit.php" name="form1">
        <input name="idKit" type="hidden" value="<?= $idKit; ?>">
        <div class="row">
            <div class="col-4 text-center" style="margin: 0 5px 0 0;"><strong>Producto Distribución</strong></div>
            <div class="col-2 text-center">
            </div>
        </div>
        <div class="form-group row">
            <select name="codProducto" id="codProducto" class="form-control col-4"
                    style="margin: 0 5px 0 0;" onchange="findLotePresentacion(this.value);">
                <option selected disabled value="">------------------------------</option>
                <?php
                $prodsDistribucion = $DetKitOperador->getProdDistribucion($idKit);
                for ($i = 0; $i < count($prodsDistribucion); $i++) {
                    echo '<option value="' . $prodsDistribucion[$i]['codigo'] . '">' . $prodsDistribucion[$i]['producto'] . '</option>';
                }
                ?>
            </select>
            <div class="col-2 text-center" style="padding: 0 20px;">
                <button class="button" onclick="return Enviar(this.form)"><span>Continuar</span>
                </button>
            </div>
        </div>
    </form>
    <div class="form-group titulo row">
        Detalle
    </div>
    <div class="tabla-50">
        <table id="example" class="display compact formatoDatos">
            <thead>
            <tr>
                <th width="15%">Código</th>
                <th width="70%">Producto</th>
                <th width="15%"></th>
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
	   