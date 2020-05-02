<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
<title>Lista de Cotizaciones Personalizadas</title>
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
<div id="saludo1"><strong>LISTA DE COTIZACIONES PERSONALIZADAS</strong></div>
<table align="center" width="100%" border="0">
  <tr> 
        <td><div align="right"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Men&uacute;">
        </div></td>
    </tr>
</table>
<table border="0" align="center" cellspacing="0" width="90%">
  <tr>
    <th width="2%" class="formatoEncabezados"></th>
    <th width="3%" class="formatoEncabezados">Id</th>
    <th width="29%" class="formatoEncabezados">Cliente</th>
    <th width="16%" class="formatoEncabezados">Categor&iacute;a Cliente</th>
    <th width="14%" class="formatoEncabezados">Vendedor</th>
    <th width="12%" class="formatoEncabezados">Fecha Cotizaci&oacute;n</th>
    <th width="10%" class="formatoEncabezados">Precio</th>
  </tr>   
<?php
	include "includes/utilTabla.php";
	include "includes/conect.php" ;
	$link=conectarServidor();
	$sql="select Id_Cotiz_p, Nom_clien, desCatClien, nom_personal, Fech_Cotizacion, tip_precio, destino 
	from cot_personalizada, clientes_cotiz, Personal, cat_clien 
	where Cliente_cot=Id_cliente and cod_vend=Id_personal and Id_cat_clien=idCatClien order by Id_Cotiz_p desc;";
	//llamar funcion de tabla
	$result=mysqli_query($link,$sql);
	$a=1;
	while($row=mysqli_fetch_array($result, MYSQLI_BOTH))
	{
	 $cot_per=$row['Id_Cotiz_p'];
	 echo'<tr';
	  if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
	  echo '>
	  <td class="formatoDatos"><div align="center"><a aiotitle="click to expand" href="javascript:togglecomments('."'".'UniqueName'.$a."'".')">+/-</a></div></td>
	  <td class="formatoDatos"><div align="center">'.$row['Id_Cotiz_p'].'</div></td>
	  <td class="formatoDatos"><div align="left">'.$row['Nom_clien'].'</div></td>
	  <td class="formatoDatos"><div align="center">'.$row['Des_cat_cli'].'</div></td>
	  <td class="formatoDatos"><div align="center">'.$row['nom_personal'].'</div></td>
	  <td class="formatoDatos"><div align="center">'.$row['Fech_Cotizacion'].'</div></td>';
	  if ($row['tip_precio']==1) $precio="Fábrica";
	  if ($row['tip_precio']==2) $precio="Distribuidor";
	  if ($row['tip_precio']==3) $precio="Detal";
	  if ($row['tip_precio']==4) $precio="Mayorista";
	  if ($row['tip_precio']==5) $precio="Super";
	  echo '<td class="formatoDatos"><div align="center">'.$precio.'</div></td>';
	  echo'</tr>';
	  $sqli="select Id_cot_per, Cod_producto, Nombre as Producto, Can_producto, Prec_producto from det_cot_personalizada, prodpre where Id_cot_per=$cot_per and Cod_producto <100000 AND Cod_producto=Cod_prese
	UNION
	select Id_cot_per, Cod_producto, Producto, Can_producto, Prec_producto from det_cot_personalizada, distribucion where Id_cot_per=$cot_per and Cod_producto >=100000 and Cod_producto=Id_distribucion;";
	$resulti=mysqli_query($link,$sqli);
	  echo '<tr><td colspan="9"><div class="commenthidden" id="UniqueName'.$a.'"><table width="100%" border="0" align="center" cellspacing="0" bordercolor="#CCCCCC">
	  <tr>
      <th width="6%" class="formatoEncabezados">C&oacute;digo</th>
	  <th width="50%" class="formatoEncabezados">Producto</th>
      <th width="5%" class="formatoEncabezados">Cantidad</th>
	  <th width="15%" class="formatoEncabezados">Precio Venta</th>
  	</tr>';
	while($rowi=mysqli_fetch_array($resulti, MYSQLI_BOTH))
	{
	echo '<tr>
	<td class="formatoDatos"><div align="center">'.$rowi['Cod_producto'].'</div></td>
	<td class="formatoDatos"><div align="left">'.$rowi['Producto'].'</div></td>
	<td class="formatoDatos"><div align="center"><script  > document.write(commaSplit('.$rowi['Can_producto'].'))</script></div></td>
	<td class="formatoDatos"><div align="center">$ <script  > document.write(commaSplit('.$rowi['Prec_producto'].'))</script></div></td>
	</tr>';
	}
	  echo '</table></div></td></tr>';
	  $a=$a+1;
	 }
	 mysqli_close($link);//Cerrar la conexion
?>
</table>
<div align="center"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Men&uacute;"></div>
</div>
</body>
</html>
