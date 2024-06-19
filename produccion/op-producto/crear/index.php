<?php
include "../../../includes/valAcc.php";
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Orden de Producción</title>
    <meta charset="utf-8">
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
    <script src="../../../js/jquery-3.3.1.min.js"></script>
    <script>
        function findFormula(codProducto) {
            $.ajax({
                url: '../../../includes/controladorProduccion.php',
                type: 'POST',
                data: {
                    "action": 'findFormulaByProd',
                    "codProducto": codProducto
                },
                dataType: 'html',
                success: function (formulasList) {
                    $("#myDiv").html(formulasList);
                },
                error: function () {
                    alert("Vous avez un GROS problème");
                }
            });
        }
    </script>

</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo">
        <img src="../../../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2 w-25"><h4>ORDEN DE PRODUCCIÓN</h4></div>
    <form method="post" action="makeO_Prod.php" name="form1">
        <div class="mb-3 row">
            <div class="col-3">
                <label class="form-label" for="codProducto"><strong>Producto</strong></label>
                <?php
                $ProductoOperador = new ProductosOperaciones();
                $productos = $ProductoOperador->getProductos(true);
                $filas = count($productos);
                echo '<select name="codProducto" id="codProducto" class="form-select" onchange="findFormula(this.value);" required>';
                echo '<option selected disabled value="">-----------------------------</option>';
                for ($i = 0; $i < $filas; $i++) {
                    echo '<option value="' . $productos[$i]["codProducto"] . '">' . $productos[$i]['nomProducto'] . '</option>';
                }
                echo '</select>';
                ?>
            </div>
            <div class="col-3">
                <label class="form-label" for="codProducto"><strong>Fórmula</strong></label>
                <div id="myDiv" class=" px-0">
                </div>
            </div>
        </div>
        <div class="mb-3 row">
            <div class="col-2">
                <label class="form-label" for="fechProd"><strong>Fecha de Producción</strong></label>
                <input type="date" class="form-control" name="fechProd" id="fechProd" required>
            </div>
            <div class="col-2">
                <label class="form-label " for="codResponsable"><strong>Responsable</strong></label>
                <?php
                $PersonalOperador = new PersonalOperaciones();
                $personal = $PersonalOperador->getPersonalProd();
                echo '<select name="codResponsable" id="codResponsable" class="form-select col-2" required>';
                echo '<option selected disabled value="">-----------------------------</option>';
                for ($i = 0; $i < count($personal); $i++) {
                    echo '<option value="' . $personal[$i]["idPersonal"] . '">' . $personal[$i]['nomPersonal'] . '</option>';
                }
                echo '</select>';
                ?>
            </div>
            <div class="col-2">
                <label class="form-label" for="cantidadKg"><strong>Cantidad a Producir (Kg)</strong></label>
                <input type="text" class="form-control" name="cantidadKg" id="cantidadKg" onkeydown="return aceptaNum(event)" required>
            </div>
        </div>
        <div class="mb-3 row">
            <div class="col-1 text-center">
                <button class="button" type="reset"><span>Reiniciar</span></button>
            </div>
            <div class="col-1 text-center">
                <button class="button" type="button" onclick="return Enviar(this.form)"><span>Continuar</span></button>
            </div>
        </div>
    </form>
    <div class="row">
        <div class="col-1">
            <button class="button1" id="back" onClick="window.location='../../../menu.php'"><span>VOLVER</span></button>
        </div>
    </div>
</div>
</body>
</html>