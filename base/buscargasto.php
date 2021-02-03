<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Seleccionar Gasto a Modificar</title>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
<script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
</head>
<body>
<div id="contenedor">
    <div id="saludo"><strong>SELECCIONAR GASTO A MODIFICAR</strong></div>
    <form id="form1" name="form1" method="post" action="gasto2.php">
        <table border="0" align="center">
            <tr>
                <td>
                    <div align="right"><strong>No. de Gasto&nbsp;</strong></div>
                </td>
                <td><input type="text" name="Factura" size=15 onKeyPress="return aceptaNum(event)"></td>
                <input type="hidden" name="CrearFactura" value="5">
            </tr>
            <tr>
                <td colspan="2">
                    <div align="center">&nbsp;</div>
                </td>
            </tr>
            <tr>
                <td align="right"><input type="reset" value="Restablecer"></td>
                <td align="left"><input type="button" value="    Continuar   " onclick="return Enviar(this.form);"/>
                </td>
            </tr>

            <tr>
                <td colspan="2">
                    <div align="center">&nbsp;</div>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <div align="center"><input type="button" class="resaltado" onClick="history.back()"
                                               value="  VOLVER  "></div>
                </td>
            </tr>
        </table>
    </form>
</div>
</body>
</html>
