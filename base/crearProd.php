<?php
include "../includes/valAcc.php";
include "../includes/utilTabla.php";
function cargarClases($classname)
{
require '../clases/'.$classname.'.php';
}
spl_autoload_register('cargarClases');
?>
<!DOCTYPE html>
<html>

<head>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <title>Creación de Productos</title>
    <meta charset="utf-8">
    <script type="text/javascript" src="../js/validar.js"></script>
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
		fail: function () {
			alert("Vous avez un GROS problème");
		}
	});
    }
    </script>

</head>

<body>
    <div id="contenedor">
        <div id="saludo"><strong>CREACIÓN DE PRODUCTOS</strong></div>
        <form name="form2" method="POST" action="makeProd.php">
            <div class="form-group row">

                <label class="col-form-label col-1" for="idCatProd"><strong>Categoría</strong></label>
                <?php
                    $manager = new CategoriasProdOperaciones();
                    $categorias=$manager->getCatsProd();
                    $filas=count($categorias);
                    echo '<select name="idCatProd" id="idCatProd" class="form-control col-2" onchange="idProducto(this.value);">';
                    echo '<option selected value="">-----------------------------</option>';
                    for($i=0; $i<$filas; $i++)
                        {                            
                        echo '<option value="'.$categorias[$i]["idCatProd"].'">'.$categorias[$i]['catProd'].'</option>';
                        }
                        echo '</select>';
                ?>
                <label class="col-form-label col-1" style="text-align: right;" for="codProducto"><strong>Código</strong></label>
                <input type="text" class="form-control col-2" name="codProducto" id="codProducto" onKeyPress="return aceptaNum(event)" readOnly>
            </div>
            <div class="form-group row">
                <label class="col-form-label col-1" style="text-align: right;" for="nomProducto"><strong>Producto</strong></label>
                <input type="text" class="form-control col-2" name="nomProducto" id="nomProducto" onKeyPress="return aceptaLetra(event)" maxlength="50">
                <label class="col-form-label col-1" style="text-align: right;" for="apariencia"><strong>Apariencia</strong></label>
                <input type="text" class="form-control col-2" name="apariencia" id="apariencia" onKeyPress="return aceptaLetra(event)">
            </div>
            <div class="form-group row">
                <label class="col-form-label col-1" style="text-align: right;" for="densMin"><strong>Densidad Min</strong></label>
                <input type="text" class="form-control col-2" name="densMin" id="densMin" onKeyPress="return aceptaNum(event)">
                <label class="col-form-label col-1" style="text-align: right;" for="densMax"><strong>Densidad Max</strong></label>
                <input type="text" class="form-control col-2" name="densMax" id="densMax" onKeyPress="return aceptaNum(event)">
            </div>

            <div class="form-group row">
                <label class="col-form-label col-1" style="text-align: right;" for="pHmin"><strong>pH Min</strong></label>
                <input type="text" class="form-control col-2" name="pHmin" id="pHmin" onKeyPress="return aceptaNum(event)">
                <label class="col-form-label col-1" style="text-align: right;" for="pHmax"><strong>pH Max</strong></label>
                <input type="text" class="form-control col-2" name="pHmax" id="pHmax" onKeyPress="return aceptaNum(event)">
            </div>

            <div class="form-group row">
                <label class="col-form-label col-1" style="text-align: right;" for="fragancia"><strong>Fragancia</strong></label>
                <input type="text" class="form-control col-2" name="fragancia" id="fragancia" onKeyPress="return aceptaLetra(event)" maxlength="30">
                <label class="col-form-label col-1" style="text-align: right;" for="color"><strong>Color</strong></label>
                <input type="text" class="form-control col-2" name="color" id="color" onKeyPress="return aceptaLetra(event)" maxlength="30">
            </div>
            <div class="form-group row">
                <div class="col-1" style="text-align: center;">
                    <button class="button" style="vertical-align:middle"
                        onclick="return Enviar(this.form)"><span>Continuar</span></button>
                </div>
                <div class="col-1" style="text-align: center;">
                    <button class="button" style="vertical-align:middle" type="reset"><span>Reiniciar</span></button>
                </div>
            </div>
        </form>
        <div class="row">
            <div class="col-1"><button class="button1" id="back" style="vertical-align:middle" onClick="history.back()"><span>VOLVER</span></button></div>
        </div>
    </div>
</body>

</html>