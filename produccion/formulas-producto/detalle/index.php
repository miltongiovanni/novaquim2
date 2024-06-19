<?php
include "../../../includes/valAcc.php";

if (isset($_POST['idFormula'])) {
    $idFormula = $_POST['idFormula'];
} else {
    if (isset($_SESSION['idFormula'])) {
        $idFormula = $_SESSION['idFormula'];
    }
}

function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');

$formulaOperador = new FormulasOperaciones();
$nomFormula = $formulaOperador->getNomFormula($idFormula);
$DetFormulaOperador = new DetFormulaOperaciones();
$porcentajeTotal = $DetFormulaOperador->getPorcentajeTotal($idFormula);

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
            let idFormula = <?=$idFormula?>;
            let ruta = "../ajax/listaDetFormulas.php?idFormula=" + idFormula;
            $('#example').DataTable({
                "columns": [
                    {
                        "data": function (row) {
                            let rep = '<form action="updateDetFormulaForm.php" method="post" name="cambiar">' +
                                '          <input name="idFormula" type="hidden" value="' + idFormula + '">' +
                                '          <input name="codMPrima" type="hidden" value="' + row.codMPrima + '">' +
                                '          <input type="button" name="Submit" onclick="return Enviar(this.form)" class="formatoBoton"  value="Cambiar">' +
                                '      </form>'
                            return rep;
                        },
                        "className": 'dt-body-center',
                        width : '15%'
                    },
                    {
                        "data": "orden",
                        "className": 'dt-body-center',
                        width : '15%'
                    },
                    {
                        "data": "nomMPrima",
                        "className": 'dt-body-left',
                        width : '40%'
                    },
                    {
                        "data": "porcentaje",
                        "className": 'dt-body-right',
                        width : '15%'
                    },
                    {
                        "data": function (row) {
                            let rep = '<form action="delDetFormula.php" method="post" name="elimina">' +
                                '          <input name="idFormula" type="hidden" value="' + idFormula + '">' +
                                '          <input name="codMPrima" type="hidden" value="' + row.codMPrima + '">' +
                                '          <input type="button" name="Submit" onclick="return Enviar(this.form)" class="formatoBoton"  value="Eliminar">' +
                                '      </form>'
                            return rep;
                        },
                        "className": 'dt-body-center',
                        width : '15%'
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
        <img src="../../../images/LogoNova.jpg" alt="novaquim" class="img-fluid mb-2"><h4>DETALLE DE FÓRMULA DE <?= strtoupper($nomFormula); ?>
        </h4></div>
    <form class="formatoDatos5" method="post" action="makeDetFormula.php" name="form1">
        <input name="idFormula" type="hidden" value="<?= $idFormula; ?>">
        <div class="row">
            <div class="col-3">
                <label class="form-label" for="codMPrima"><strong>MateriaPrima</strong></label>
                <select name="codMPrima" id="codMPrima" class="form-select col-3" style="margin: 0 5px 0 0;" required>
                    <option disabled selected value="">-----------------------------</option>
                    <?php
                    $mprimas = $DetFormulaOperador->getMPrimasFormula($idFormula);
                    for ($i = 0; $i < count($mprimas); $i++) {
                        echo '<option value="' . $mprimas[$i]["codMPrima"] . '">' . $mprimas[$i]['nomMPrima'] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="col-1">
                <label class="form-label" for="porcentaje"><strong>% en fórmula</strong></label>
                <input type="text" class="form-control" name="porcentaje" id="porcentaje" onkeydown="return aceptaNum(event)">
            </div>
            <div class="col-1">
                <label class="form-label col-1 text-center" for="orden"><strong>Orden</strong></label>
                <input type="text" class="form-control" name="orden" id="orden" onkeydown="return aceptaNum(event)">
            </div>
            <div class="col-2 pt-3">
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
                <th class="text-center">Orden</th>
                <th class="text-center">Materia Prima</th>
                <th class="text-center">Porcentaje</th>
                <th></th>
            </tr>
            </thead>
        </table>
    </div>
    <div class="tabla-50">
        <div class="row">
            <div class="col-9 text-end">
                <span class="text-bold">Total</span>
            </div>
            <div class="col-3">
                <span class="text-end text-bold"><?= $porcentajeTotal ?></span>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-1">
            <button class="button" id="back" onclick="window.location='../../../menu.php'"><span>Terminar</span>
            </button>
        </div>
    </div>

</div>
</body>
</html>