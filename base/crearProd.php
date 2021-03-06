<?php
include "../includes/valAcc.php";
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <title>Creación de Productos</title>
    <meta charset="utf-8">
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script>

        //var idCatProd = $('idCatProd').value;

        function idProducto(idCatProd) {
            //alert(idCatProd);
            $.ajax({
                url: '../includes/controladorBase.php',
                type: 'POST',
                data: {
                    "action": 'ultimoProdxCat',
                    "idCatProd": idCatProd
                },
                dataType: 'text',
                success: function (lastCodProd) {
                    $("#codProducto").val(lastCodProd);
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
        <img src="../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2 w-25"><h4>CREACIÓN DE PRODUCTOS</h4></div>
    <form name="form2" method="POST" action="makeProd.php">
        <div class="form-group row">

            <label class="col-form-label col-1" for="idCatProd"><strong>Categoría</strong></label>
            <?php
            $manager = new CategoriasProdOperaciones();
            $categorias = $manager->getCatsProd();
            $filas = count($categorias);
            echo '<select name="idCatProd" id="idCatProd" class="form-control col-2" onchange="idProducto(this.value);" required>';
            echo '<option disabled selected value="">-----------------------------</option>';
            for ($i = 0; $i < $filas; $i++) {
                echo '<option value="' . $categorias[$i]["idCatProd"] . '">' . $categorias[$i]['catProd'] . '</option>';
            }
            echo '</select>';
            ?>
            <label class="col-form-label col-1 text-end" for="codProducto"><strong>Código</strong></label>
            <input type="text" class="form-control col-2" name="codProducto" id="codProducto"
                   onkeydown="return aceptaNum(event)" readOnly>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-1 text-end" for="nomProducto"><strong>Producto</strong></label>
            <input type="text" class="form-control col-2" name="nomProducto" id="nomProducto"
                   onkeydown="return aceptaLetra(event)" maxlength="50" required>
            <label class="col-form-label col-1 text-end" for="apariencia"><strong>Apariencia</strong></label>
            <input type="text" class="form-control col-2" name="apariencia" id="apariencia"
                   onkeydown="return aceptaLetra(event)" required>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-1 text-end" for="densMin"><strong>Densidad Min</strong></label>
            <input type="text" class="form-control col-2" name="densMin" id="densMin"
                   onkeydown="return aceptaNum(event)" required>
            <label class="col-form-label col-1 text-end" for="densMax"><strong>Densidad Max</strong></label>
            <input type="text" class="form-control col-2" name="densMax" id="densMax"
                   onkeydown="return aceptaNum(event)" required>
        </div>

        <div class="form-group row">
            <label class="col-form-label col-1 text-end" for="pHmin"><strong>pH Min</strong></label>
            <input type="text" class="form-control col-2" name="pHmin" id="pHmin" onkeydown="return aceptaNum(event)"
                   required>
            <label class="col-form-label col-1 text-end" for="pHmax"><strong>pH Max</strong></label>
            <input type="text" class="form-control col-2" name="pHmax" id="pHmax" onkeydown="return aceptaNum(event)"
                   required>
        </div>

        <div class="form-group row">
            <label class="col-form-label col-1 text-end" for="fragancia"><strong>Fragancia</strong></label>
            <input type="text" class="form-control col-2" name="fragancia" id="fragancia"
                   onkeydown="return aceptaLetra(event)" maxlength="30" required>
            <label class="col-form-label col-1 text-end" for="color"><strong>Color</strong></label>
            <input type="text" class="form-control col-2" name="color" id="color" onkeydown="return aceptaLetra(event)"
                   maxlength="30" required>
        </div>
        <div class="form-group row">
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
            <button class="button1" type="button" id="back" onClick="history.back()"><span>VOLVER</span></button>
        </div>
    </div>
</div>
</body>

</html>