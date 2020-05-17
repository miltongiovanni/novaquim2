<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
<title>Consulta de Venta de Productos por Referencia</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
	<script  src="../js/validar.js"></script>
</head>
<body>
<div id="contenedor">
<div id="saludo1"><strong>CONSULTA DE VENTA DE PRODUCTOS POR REMISION</strong></div> 

<?php
foreach ($_POST as $nombre_campo => $valor) 
{ 
	$asignacion = "\$".$nombre_campo."='".$valor."';"; 
	//echo $nombre_campo." = ".$valor."<br>";  
	eval($asignacion); 
}  

?>
<table width="50%" align="center" border="0">
  <tr> 
      <form action="ProductosXRemision_Xls.php" method="post" target="_blank"><td width="85%" align="right"><input name="Submit" type="submit" class="resaltado" value="Exportar a Excel"></td><input name="FchIni" type="hidden" value="<?php echo $FchIni ?>"><input name="FchFin" type="hidden" value="<?php echo $FchFin ?>"></form>
      <td width="15%"><div align="right"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Men�"></div></td>
  </tr>
</table>
<table border="0" align="center" cellspacing="0" width="50%">
	<tr>
      <th width="13%" class="formatoEncabezados">Remisi�n</th>
      <th width="54%" class="formatoEncabezados">Cliente</th>
      <th width="14%" class="formatoEncabezados">Fecha</th>
      <th width="19%" class="formatoEncabezados">Subtotal</th>
  </tr>   
<?php
include "includes/utilTabla.php";
include "includes/conect.php" ;
$link=conectarServidor();
$sql="select Id_remision, cliente, Fech_remision, Valor from remision1 where Fech_remision>='$FchIni' and Fech_remision<='$FchFin';";
$result=mysqli_query($link,$sql);
$a=1;
while($row=mysqli_fetch_array($result, MYSQLI_BOTH))
{
	$Tot=number_format($row['Valor'], 0, '.', ',');
	echo'<tr';
	  if (($a++ % 2)==0) echo ' bgcolor="#B4CBEF" ';
	  echo '>
 	<td class="formatoDatos"><div align="center">'.$row['Id_remision'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$row['cliente'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$row['Fech_remision'].'</div></td>
	<td class="formatoDatos"><div align="center">$ '.$Tot.'</div></td>
	</tr>';
}
mysqli_free_result($result);
/* cerrar la conexi�n */
mysqli_close($link);
?>

</table>
<div align="center"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Men�"></div>
</div>
</body>
</html>