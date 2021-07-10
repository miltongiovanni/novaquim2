<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Creación cotización personalizada</title>
    <meta charset="utf-8">
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/findCliente.js"></script>
</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo">
        <img src="../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2 w-25"><h4>CREACIÓN DE COTIZACIÓN PERSONALIZADA</h4></div>
    <form method="post" action="makeCotizacionPersonalizada.php" name="form1">
        <div class="form-group row">
            <label class="col-form-label col-2" for="busClien"><strong>Cliente</strong></label>
            <input type="text" class="form-control col-1" id="busClien" name="busClien"
                   onkeyup="findClienteCotizacion()"
                   required/>
            <div class="col-4" id="myDiv"></div>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-2 text-end" for="fechaCotizacion"><strong>Fecha de
                    Cotización</strong></label>
            <input type="date" class="form-control col-5" name="fechaCotizacion" id="fechaCotizacion" required>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-2"><strong>Destino</strong></label>
            <div class="col-form-label col-5 ">
                <input name="destino" type="radio" id="Destino_0" value="1" checked>
                <label for="Destino_0">Impresión</label>
                <input type="radio" name="destino" value="2" id="Destino_1">
                <label for="Destino_1">Correo electrónico</label>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-2"><strong>Precio</strong></label>
            <div class="col-form-label col-5 ">
                <input name="tipPrecio" type="radio" id="precio_0" value="1" checked>
                <label for="precio_0">Fábrica</label>
                <input type="radio" name="tipPrecio" value="2" id="precio_1">
                <label for="precio_1">Distribuidor</label>
                <input type="radio" name="tipPrecio" value="3" id="precio_2">
                <label for="precio_2">Detal</label>
                <input type="radio" name="tipPrecio" value="4" id="precio_3">
                <label for="precio_3">Mayorista</label>
                <input type="radio" name="tipPrecio" value="5" id="precio_4">
                <label for="precio_4">Superetes</label>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-1">
                <button class="button" type="button" onclick="return Enviar(this.form)">
                    <span>Continuar</span></button>
            </div>
        </div>
    </form>
    <div class="row form-group">
        <div class="col-1">
            <button class="button1" onclick="window.location='../menu.php">
                <span>VOLVER</span></button>
        </div>
    </div>
</div>
</body>
</html>