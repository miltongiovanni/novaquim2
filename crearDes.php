<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>Relaci&oacute;n de Pacas de Productos de Distribuci&oacute;n</title>
<meta charset="utf-8">
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="scripts/validar.js"></script>
	<script type="text/javascript" src="scripts/block.js"></script>
    <link rel="stylesheet" type="text/css" media="all" href="css/calendar-blue2.css" title="blue">
    <script type="text/javascript" src="scripts/calendar.js"></script>
    <script type="text/javascript" src="scripts/calendar-sp.js"></script>
    <script type="text/javascript" src="scripts/calendario.js"></script>
    	<script type="text/javascript">
	document.onkeypress = stopRKey; 
	</script>
</head>
<body> 
<div id="contenedor">
<div id="saludo"><strong>RELACI&Oacute;N DE PACAS CON PRODUCTOS DE DISTRIBUCI&Oacute;N</strong></div>
<table width="452" border="0"  align="center">
<?php
include "includes/conect.php";
$link=conectarServidor();  
echo '<form method="post" action="crearDes2.php" name="form1">
<tr>
  <td colspan="1"><div align="center"><strong>Producto de Distribuci&oacute;n Empacado</strong></div></td>
  <td colspan="1"><div align="left"><strong></strong></div></td>
</tr>
<tr>
  <td colspan="1" ><div align="center">';
echo'<select name="cod_paca">';
$result=mysqli_query($link,"select Id_distribucion, Producto from distribucion where Activo=0 order by Producto;");
while($row=mysqli_fetch_array($result))
{
  echo '<option value='.$row['Id_distribucion'].'>'.$row['Producto'].'</option>';
}
echo '</select>';
echo '</div></td>';
echo '<td align="center"><input name="button" onclick="return Enviar(this.form)" type="submit"  value="Continuar" /></td>';
echo '<input name="Crear" type="hidden" value="0">'; 
echo '</tr></form>';
mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
?>
</table>
<table width="27%" border="0" align="center">
<tr> 
        <td><div align="center"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Men&uacute;">
        </div></td>
    </tr>
</table>
</div> 
</body>
</html>
	   