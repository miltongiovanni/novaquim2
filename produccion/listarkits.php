<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>Lista de Kits</title>
<meta charset="utf-8">
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
	<script  src="scripts/validar.js"></script>
    <script >	function togglecomments (postid) {
		var whichpost = document.getElementById(postid);
		if (whichpost.className=="commentshown") { whichpost.className="commenthidden"; } else { whichpost.className="commentshown"; }
	}</script>
</head>
<body>
<div id="contenedor">
<div id="saludo1"><strong>LISTADO DE KITS</strong></div>
<table width="100%" border="0" summary="encabezado">
  <tr> 
      <td><div align="right"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Men&uacute;">
      </div></td>
  </tr>
</table>
<table border="0" align="center" cellspacing="0" summary="cuerpo">
	<tr>
      <th width="32" class="formatoEncabezados"></th>
      <th width="48" class="formatoEncabezados">Id</th>
      <th width="66" class="formatoEncabezados">C&oacute;digo</th>
      <th width="381" class="formatoEncabezados">Producto</th>
      <th width="97" class="formatoEncabezados">Envase</th>
  </tr>   
<?php
include "includes/utilTabla.php";
include "includes/conect.php" ;
$link=conectarServidor();
$sql="	SELECT Id_kit as Id, Codigo as Código, Nombre as Producto, Nom_envase as Envase from kit, prodpre, envase where Codigo=Cod_prese AND Cod_env=envase.Cod_envase
		union
		SELECT Id_kit as Id, Codigo as Código, Producto, Nom_envase as Envase from kit, distribucion, envase where Codigo=Id_distribucion AND Cod_env=envase.Cod_envase";
$result=mysqli_query($link,$sql);
$a=1;
while($row=mysqli_fetch_array($result, MYSQLI_BOTH))
{
	$id=$row['Id'];
	echo'<tr';
	  if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
	  echo '>
	<td class="formatoDatos"><div align="center"><a href="javascript:togglecomments('."'".'UniqueName'.$a."'".')">+/-</a></div></td>
	<td class="formatoDatos"><div align="center">'.$row['Id'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$row['Código'].'</div></td>
	<td class="formatoDatos"><div align="left">'.$row['Producto'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$row['Envase'].'</div></td>';
	
	echo'</tr>';
	$sqli="select Cod_producto, Nombre as Producto from det_kit, prodpre where Id_kit=$id and Cod_producto=Cod_prese
	union
	select Cod_producto, Producto from det_kit, distribucion where Id_kit=$id AND Cod_producto=Id_distribucion;";
	$resulti=mysqli_query($link,$sqli);
	echo '<tr><td colspan="9"><div class="commenthidden" id="UniqueName'.$a.'"><table width="500" border="0" align="center" cellspacing="0" summary="detalle">
	<tr>
      <th width="100" class="formatoEncabezados">C&oacute;digo</th>
	  <th width="400" class="formatoEncabezados">Producto</th>
  	</tr>';
	while($rowi=mysqli_fetch_array($resulti, MYSQLI_BOTH))
	{
	echo '<tr>
	<td class="formatoDatos"><div align="center">'.$rowi['Cod_producto'].'</div></td>
	<td class="formatoDatos"><div align="left">'.$rowi['Producto'].'</div></td>';
	}
	echo '</table></div></td></tr>';
	$a=$a+1;
}
mysqli_free_result($result);
mysqli_free_result($resulti);
mysqli_close($link);//Cerrar la conexion
?>

</table>
<div align="center"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Men&uacute;"></div>
</div>
</body>
</html>