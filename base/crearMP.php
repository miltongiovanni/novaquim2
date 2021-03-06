<?php
include "../includes/valAcc.php";
include "../includes/utilTabla.php";
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
    <title>Creación de Materias Primas</title>
    <meta charset="utf-8">
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script>


        function codigoMP(idCatMPrima) {
            $.ajax({
                url: '../includes/controladorBase.php',
                type: 'POST',
                data: {
                    "action": 'ultimaMPxCat',
                    "idCatMPrima": idCatMPrima
                },
                dataType: 'json',
                success: function (lastCodMP) {
                    $("#codMPrima").val(lastCodMP.codigo);
                    $("#aliasMPrima").val(lastCodMP.alias);
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
        <img src="../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2 w-25"><h4>CREACIÓN DE MATERIAS PRIMAS</h4></div>
    <form name="form2" method="POST" action="makeMP.php">
        <div class="form-group row">

            <label class="col-form-label col-1" for="idCatMPrima"><strong>Categoría MP</strong></label>
            <?php
            $manager = new CategoriasMPOperaciones();
            $categorias = $manager->getCatsMP();
            $filas = count($categorias);
            echo '<select name="idCatMPrima" id="idCatMPrima" class="form-control col-2" onchange="codigoMP(this.value)"  required>';
            echo '<option selected disabled value="">-----------------------------</option>';
            for ($i = 0; $i < $filas; $i++) {
                echo '<option value="' . $categorias[$i]["idCatMP"] . '">' . $categorias[$i]['catMP'] . '</option>';
            }
            echo '</select>';
            ?>
            <label class="col-form-label col-1 text-end" for="codMPrima"><strong>Código</strong></label>
            <input type="text" class="form-control col-2" name="codMPrima" id="codMPrima" readOnly>
            <label class="col-form-label col-1 text-end"
                   for="aliasMPrima"><strong>Alias M Prima</strong></label>
            <input type="text" class="form-control col-2" name="aliasMPrima" id="aliasMPrima" readOnly>

        </div>
        <div class="form-group row">
            <label class="col-form-label col-1 text-end"
                   for="nomMPrima"><strong>Materia Prima</strong></label>
            <input type="text" class="form-control col-2" name="nomMPrima" id="nomMPrima" required>
            <label class="col-form-label col-1 text-end" for="aparienciaMPrima"><strong>Apariencia</strong></label>
            <input type="text" class="form-control col-2" name="aparienciaMPrima" id="aparienciaMPrima"
                   onkeydown="return aceptaLetra(event)" required>

        </div>
        <div class="form-group row">

            <label class="col-form-label col-1" for="codIva"><strong>Iva</strong></label>
            <?php
            $manager = new TasaIvaOperaciones();
            $tasas = $manager->getTasasIva();
            $filas = count($tasas);
            echo '<select name="codIva" id="codIva" class="form-control col-2"  required>';
            echo '<option selected disabled value="">-----------------------------</option>';
            for ($i = 0; $i < $filas; $i++) {
                echo '<option value="' . $tasas[$i]["idTasaIva"] . '">' . $tasas[$i]['iva'] . '</option>';
            }
            echo '</select>';
            ?>
            <label class="col-form-label col-1 text-end" for="minStockMprima"><strong>Stock Min</strong></label>
            <input type="text" class="form-control col-2" name="minStockMprima" id="minStockMprima"
                   onkeydown="return aceptaNum(event)" required>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-1 text-end" for="pHmPrima"><strong>pH</strong></label>
            <input type="text" class="form-control col-2" name="pHmPrima" id="pHmPrima"
                   placeholder="Si no tiene escribir N.A." required>
            <label class="col-form-label col-1 text-end" for="densidadMPrima"><strong>Densidad</strong></label>
            <input type="text" class="form-control col-2" name="densidadMPrima" id="densidadMPrima"
                   placeholder="Si no tiene escribir N.A." required>
        </div>

        <div class="form-group row">
            <label class="col-form-label col-1 text-end" for="colorMPrima"><strong>Color</strong></label>
            <input type="text" class="form-control col-2" name="colorMPrima" id="colorMPrima"
                   onkeydown="return aceptaLetra(event)" maxlength="30" required>
            <label class="col-form-label col-1 text-end" for="olorMPrima"><strong>Olor</strong></label>
            <input type="text" class="form-control col-2" name="olorMPrima" id="olorMPrima"
                   onkeydown="return aceptaLetra(event)" maxlength="30" required>
        </div>

        <div class="form-group row">
            <div class="col-1 text-center">
                <button class="button" type="reset"><span>Reiniciar</span></button>
            </div>
            <div class="col-1 text-center">
                <button class="button" type="button"
                        onclick="return Enviar(this.form)"><span>Continuar</span></button>
            </div>
        </div>

    </form>
    <div class="row">
        <div class="col-1">
            <button class="button1" id="back" type="button" onClick="history.back()"><span>VOLVER</span></button>
        </div>
    </div>

</div>
</body>

</html>