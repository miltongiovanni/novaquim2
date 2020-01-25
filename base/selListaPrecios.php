<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html>

<head>
    <title>Seleccionar precio o precios</title>
    <meta charset="utf-8">
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="../js/validar.js"></script>
</head>

<body>
    <div id="contenedor">
        <div id="saludo1"><strong>SELECCIONAR PRECIO O PRECIOS PARA LA LISTA</strong></div>
        <form name="form1" method="POST" action="detListaPrecios.php">
            <div class="form-group row">
                <label class="col-1" style="text-align: right;"><br>Presentación</label>
                <div class="col-2 form-control">
                    <div class="form-check">
                        <input name="Presentaciones" class="form-check-input" type="radio" id="Presentaciones_0"
                            value="1" checked>
                        <label class="form-check-label" for="Presentaciones_0"> Todas</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" name="Presentaciones" class="form-check-input" value="2"
                            id="Presentaciones_1">
                        <label class="form-check-label" for="Presentaciones_0">Pequeñas</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" name="Presentaciones" class="form-check-input" value="3"
                            id="Presentaciones_2">
                        <label class="form-check-label" for="Presentaciones_0">Grandes</label>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-form-label col-1" style="text-align: right;"
                    for="apellido"><strong><br><br>Precio</strong></label>
                <div class="col-2 form-control">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="seleccion1[]" value="1" id="defaultCheck1">
                        <label class="form-check-label" for="defaultCheck1">
                            Fábrica
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="seleccion1[]" value="2" id="defaultCheck2">
                        <label class="form-check-label" for="defaultCheck2">
                            Distribuidor
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="seleccion1[]" value="3" id="defaultCheck3">
                        <label class="form-check-label" for="defaultCheck3">
                            Detal
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="seleccion1[]" value="4" id="defaultCheck4">
                        <label class="form-check-label" for="defaultCheck4">
                            Mayorista
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="seleccion1[]" value="5" id="defaultCheck5">
                        <label class="form-check-label" for="defaultCheck5">
                            Superetes
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-1" style="text-align: center;">
                    <button class="button" 
                        onclick="return Enviar(this.form)"><span>Continuar</span></button>
                </div>
                <div class="col-1" style="text-align: center;">
                    <button class="button" 
                        type="reset"><span>Reiniciar</span></button>
                </div>
            </div>
        </form>
        <div class="row">
            <div class="col-1"><button class="button1" id="back"  onClick="history.back()">
                    <span>VOLVER</span></button></div>
        </div>
       
    </div>
</body>

</html>