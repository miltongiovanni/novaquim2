<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Seleccionar Remisión a Anular</title>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
<script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
</head>
<body>
<div id="contenedor">
    <div id="saludo"><h4>INGRESAR REMISIÓN A ANULAR</h4></div>
    <form id="form1" name="form1" method="post" action="anulaRemision.php">
        <div class="form-group row">
            <label class="col-form-label col-1 text-right" for="idRemision"><strong>Remisión</strong></label>
            <input type="text" class="form-control col-1" onkeydown="return aceptaNum(event)" name="idRemision"
                   id="idRemision" required>
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
            <button class="button1" onclick="history.back()">
                <span>VOLVER</span></button>
        </div>
    </div>
    <!--<table border="0" align="center">

            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
                <td width="128">
                    <div align="right"><strong>No. de Factura&nbsp;</strong></div>
                </td>
                <td width="257"><input type="text" name="factura" size=10 onkeydown="return aceptaNum(event)"></td>
                <input type="hidden" name="Crear" value="5">
            </tr>
            <tr>
                <td align="right"><strong>Razón de Anulación</strong></td>
                <td><textarea name="observa" id="textarea" cols="40" rows="5"></textarea></td>
            </tr>
            <tr>
                <td colspan="2">
                    <div align="center">&nbsp;</div>
                </td>
            </tr>
            <tr>
                <td align="right"></td>
                <td align="left"><input type="reset" value="Restablecer">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                            type="button" value="   Anular   " onclick="return Enviar(this.form);"></td>
            </tr>
        </form>
        <tr>
            <td colspan="2">
                <div align="center">&nbsp;</div>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <div align="center"><input type="button" class="resaltado" onClick="history.back()" value="  VOLVER  ">
                </div>
            </td>
        </tr>
    </table>-->
</div>
</body>
</html>
