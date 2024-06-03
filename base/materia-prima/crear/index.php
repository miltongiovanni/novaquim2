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
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <title>Creación de Materias Primas</title>
    <meta charset="utf-8">
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
    <script src="../../../js/jquery-3.3.1.min.js"></script>
    <script>


        function codigoMP(idCatMPrima) {
            $.ajax({
                url: '../../../includes/controladorBase.php',
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
        <img src="../../../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2 w-25"><h4>CREACIÓN DE MATERIAS PRIMAS</h4></div>
    <form name="form2" method="POST" action="makeMP.php">
        <div class="mb-3 row">
            <div class="col-3">
                <label class="form-label " for="idCatMPrima"><strong>Categoría MP</strong></label>


                <?php
                $manager = new CategoriasMPOperaciones();
                $categorias = $manager->getCatsMP();
                $filas = count($categorias);
                echo '<select name="idCatMPrima" id="idCatMPrima" class="form-control " onchange="codigoMP(this.value)"  required>';
                echo '<option selected disabled value="">-----------------------------</option>';
                for ($i = 0; $i < $filas; $i++) {
                    echo '<option value="' . $categorias[$i]["idCatMP"] . '">' . $categorias[$i]['catMP'] . '</option>';
                }
                echo '</select></div>';
                ?>
                <div class="col-1">
                    <label class="form-label " for="codMPrima"><strong>Código</strong></label>
                    <input type="text" class="form-control " name="codMPrima" id="codMPrima" readOnly>
                </div>
                <div class="col-2">
                    <label class="form-label " for="aliasMPrima"><strong>Alias M Prima</strong></label>
                    <input type="text" class="form-control " name="aliasMPrima" id="aliasMPrima" readOnly>
                </div>
            </div>
            <div class="mb-3 row">
                <div class="col-3">
                    <label class="form-label " for="nomMPrima"><strong>Materia Prima</strong></label>
                    <input type="text" class="form-control " name="nomMPrima" id="nomMPrima" required>
                </div>
                <div class="col-3">
                    <label class="form-label " for="aparienciaMPrima"><strong>Apariencia</strong></label>
                    <input type="text" class="form-control " name="aparienciaMPrima" id="aparienciaMPrima"
                           onkeydown="return aceptaLetra(event)" required>
                </div>
            </div>
            <div class="mb-3 row">
                <div class="col-1">
                    <label class="form-label " for="codIva"><strong>Iva</strong></label>
                    <?php
                    $manager = new TasaIvaOperaciones();
                    $tasas = $manager->getTasasIva();
                    $filas = count($tasas);
                    echo '<select name="codIva" id="codIva" class="form-control "  required>';
                    echo '<option selected disabled value="">---------</option>';
                    for ($i = 0; $i < $filas; $i++) {
                        echo '<option value="' . $tasas[$i]["idTasaIva"] . '">' . $tasas[$i]['iva'] . '</option>';
                    }
                    echo '</select></div>';
                    ?>
                    <div class="col-1">
                        <label class="form-label " for="minStockMprima"><strong>Stock Min</strong></label>
                        <input type="text" class="form-control " name="minStockMprima" id="minStockMprima"
                               onkeydown="return aceptaNum(event)" required>
                    </div>
                    <div class="col-2">
                        <label class="form-label " for="pHmPrima"><strong>pH</strong></label>
                        <input type="text" class="form-control " name="pHmPrima" id="pHmPrima"
                               placeholder="Si no tiene escribir N.A." required>
                    </div>
                    <div class="col-2">
                        <label class="form-label " for="densidadMPrima"><strong>Densidad</strong></label>
                        <input type="text" class="form-control " name="densidadMPrima" id="densidadMPrima"
                               placeholder="Si no tiene escribir N.A." required>
                    </div>
                </div>
                <div class="mb-3 row">
                    <div class="col-3">
                        <label class="form-label " for="colorMPrima"><strong>Color</strong></label>
                        <input type="text" class="form-control " name="colorMPrima" id="colorMPrima"
                               onkeydown="return aceptaLetra(event)" maxlength="30" required>
                    </div>
                    <div class="col-3">
                        <label class="form-label " for="olorMPrima"><strong>Olor</strong></label>
                        <input type="text" class="form-control " name="olorMPrima" id="olorMPrima"
                               onkeydown="return aceptaLetra(event)" maxlength="30" required>
                    </div>
                </div>

                <div class="mb-3 row">
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