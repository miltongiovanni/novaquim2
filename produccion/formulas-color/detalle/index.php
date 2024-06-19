<?php
include "../../../includes/valAcc.php";

if (isset($_POST['idFormulaColor'])) {
    $idFormulaColor = $_POST['idFormulaColor'];
} else {
    if (isset($_SESSION['idFormulaColor'])) {
        $idFormulaColor = $_SESSION['idFormulaColor'];
    }
}

function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');

$formulaColorOperador = new FormulasColorOperaciones();
$nomFormula = $formulaColorOperador->getNomFormulaColor($idFormulaColor);
$DetFormulaColorOperador = new DetFormulaColorOperaciones();
$porcentajeTotal = $DetFormulaColorOperador->getPorcentajeTotal($idFormulaColor);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Porcentaje de Materias Primas en la Fórmula</title>
    <meta charset="utf-8">
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../../../css/datatables.css">
    <style>
        table.dataTable.compact thead th, table.dataTable.compact thead td {
            padding: 4px 4px 4px 4px;
        }
    </style>
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
    <script src="../../../js/jquery-3.3.1.min.js"></script>
    <script src="../../../js/datatables.js"></script>
    
    <script>
        $(document).ready(function () {
            let idFormulaColor = <?=$idFormulaColor?>;
            let ruta = "../ajax/listaDetFormulasColor.php?idFormulaColor=" + idFormulaColor;
            $('#example').DataTable({
                "columns": [
                    {
                        "data": function (row) {
                            let rep = '<form action="updateDetFormulaColorForm.php" method="post" name="cambiar">' +
                                '          <input name="idFormulaColor" type="hidden" value="' + idFormulaColor + '">' +
                                '          <input name="codMPrima" type="hidden" value="' + row.codMPrima + '">' +
                                '          <input type="button" name="Submit" onclick="return Enviar(this.form)" class="formatoBoton"  value="Cambiar">' +
                                '      </form>'
                            return rep;
                        },
                        "className": 'dt-body-center',
                        width: '20%'
                    },
                    {
                        "data": "nomMPrima",
                        "className": 'dt-body-left',
                        width: '40%'
                    },
                    {
                        "data": "porcentaje",
                        "className": 'dt-body-right',
                        width: '20%'
                    },
                    {
                        "data": function (row) {
                            let rep = '<form action="delDetFormulaColor.php" method="post" name="elimina">' +
                                '          <input name="idFormulaColor" type="hidden" value="' + idFormulaColor + '">' +
                                '          <input name="codMPrima" type="hidden" value="' + row.codMPrima + '">' +
                                '          <input type="button" name="Submit" onclick="return Enviar(this.form)" class="formatoBoton"  value="Eliminar">' +
                                '      </form>'
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
                "ajax": ruta
            });
        });
    </script>
</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo1">
        <img src="../../../images/LogoNova.jpg" alt="novaquim" class="img-fluid mb-2"><h4>INGRESO DEL DETALLE DE FÓRMULA DE <?= $nomFormula; ?></h4></div>
    <form class="formatoDatos5" method="post" action="makeDetFormulaColor.php" name="form1">
        <input name="idFormulaColor" type="hidden" value="<?= $idFormulaColor; ?>">
        <div class="row">
            <div class="col-3">
                <label class="form-label  text-center" for="codMPrima" ><strong>Materia Prima</strong></label>
                <select name="codMPrima" id="codMPrima" class="form-select">
                    <option disabled selected value="">-----------------------------</option>
                    <?php
                    $mprimas = $DetFormulaColorOperador->getMPrimasFormula($idFormulaColor);
                    for ($i = 0; $i < count($mprimas); $i++) {
                        echo '<option value="' . $mprimas[$i]["codMPrima"] . '">' . $mprimas[$i]['nomMPrima'] . '</option>';
                    }
                    echo '';
                    ?>
                </select>
            </div>
            <div class="col-1">
                <label class="form-label" for="porcentaje"><strong>% en fórmula</strong></label>
                <input type="text" class="form-control" name="porcentaje"
                       id="porcentaje" onkeydown="return aceptaNum(event)">
            </div>
            <div class="col-2 text-center pt-3">
                <button class="button mt-3" type="button" onclick="return Enviar(this.form)">
                    <span>Adicionar detalle</span>
                </button>
            </div>
        </div>
    </form>
    <div class="mb-3 titulo row text-center">
        <strong>Detalle de la fórmula</strong>
    </div>
    <div class="tabla-50">
        <table id="example" class="formatoDatos5 table table-sm table-striped">
            <thead>
            <tr>
                <th class="text-center"></th>
                <th class="text-center">Materia Prima</th>
                <th class="text-center">Porcentaje</th>
                <th class="text-center"></th>
            </tr>
            </thead>
        </table>
    </div>
    <div class="tabla-50">
        <div class="row mb-3">
            <div class="col-8 text-end">
                <span class="text-bold">Total</span>
            </div>
            <div class="col-4">
                <span class="text-end text-bold"><?= $porcentajeTotal ?></span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-1">
            <button class="button" type="button" id="back" onclick="window.location='../../../menu.php'"><span>Terminar</span>
            </button>
        </div>
    </div>

</body>
</html>