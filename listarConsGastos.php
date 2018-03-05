<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>Listado de Compras por Fecha</title>
<meta charset="utf-8">
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="scripts/validar.js"></script>
    <script type="text/Javascript">	function togglecomments (postid) {
		var whichpost = document.getElementById(postid);
		if (whichpost.className=="commentshown") { whichpost.className="commenthidden"; } else { whichpost.className="commentshown"; }
	}</script>
</head>
<body>
<div id="contenedor">
<div id="saludo1"><strong>LISTADO DE GASTOS POR FECHA</strong></div>

<?php
foreach ($_POST as $nombre_campo => $valor) 
{ 
	$asignacion = "\$".$nombre_campo."='".$valor."';"; 
	//echo $nombre_campo." = ".$valor."<br>";  
	eval($asignacion); 
}  

?>
<table width="100%" border="0">
  <tr>
  	<form action="Gastos_Xls.php" method="post" target="_blank"><td width="85%" align="right">
    <input name="Submit" type="submit" class="resaltado" value="Exportar a Excel"></td><input name="FchIni" type="hidden" value="<?php echo $FchIni ?>"><input name="FchFin" type="hidden" value="<?php echo $FchFin ?>"></form> 
      <td width="15%"><div align="right"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Men&uacute;">
      </div></td>
  </tr>
</table>
<table border="0" align="center" cellspacing="0">
	<tr>
      <th width="16" class="formatoEncabezados"></th>
      <th width="52" class="formatoEncabezados">Id Gasto</th>
      <th width="100" class="formatoEncabezados">NIT</th>
      <th width="324" class="formatoEncabezados">Proveedor</th>
      <th width="78" class="formatoEncabezados">Factura</th>
      <th width="113" class="formatoEncabezados">Fecha Compra</th>
      <th width="113" class="formatoEncabezados">Fecha Vencimiento</th>
      <th width="69" class="formatoEncabezados">Estado</th>
      <th width="84" class="formatoEncabezados">Valor Factura </th>
  </tr>   
<?php
include "includes/utilTabla.php";
include "includes/conect.php" ;
$link=conectarServidor();
$sql="SELECT Id_gasto, nit_prov, Num_fact, Fech_comp, Fech_venc, Des_estado as Estado, total_fact, Nom_provee 
from gastos, proveedores, estados WHERE nit_prov=NIT_provee and Fech_comp>='$FchIni' and Fech_comp<='$FchFin' and estado=Id_estado
order BY Fech_comp desc, Num_fact;";
$result=mysqli_query($link,$sql);
$a=1;
while($row=mysqli_fetch_array($result, MYSQLI_BOTH))
{
	$id_com=$row['Id_gasto'];
	echo'<tr';
	if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
	echo '>
	<td class="formatoDatos"><div align="center"><a aiotitle="click to expand" href="javascript:togglecomments('."'".'UniqueName'.$a."'".')">+/-</a></div></td>
	<td class="formatoDatos"><div align="center">'.$row['Id_gasto'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$row['nit_prov'].'</div></td>
	<td class="formatoDatos"><div align="left">'.$row['Nom_provee'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$row['Num_fact'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$row['Fech_comp'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$row['Fech_venc'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$row['Estado'].'</div></td>
	<td class="formatoDatos"><div align="right">$ <script language="javascript"> document.write(commaSplit('.$row['total_fact'].'))</script></div></td>
	';
	
	echo'</tr>';
	$sqli="select Producto, Cant_gasto, Precio_gasto, tasa from det_gastos, tasa_iva 
where det_gastos.Id_tasa=tasa_iva.Id_Tasa and Id_gasto=$id_com;";
	$resulti=mysqli_query($link,$sqli);
	echo '<tr><td colspan="7"><div class="commenthidden" id="UniqueName'.$a.'"><table width="65%" border="0" align="center" cellspacing="0" bordercolor="#CCCCCC">
	<tr>
	  <th width="49%" class="formatoEncabezados">Descripción</th>
      <th width="10%" class="formatoEncabezados">Cantidad</th>
	  <th width="20%" class="formatoEncabezados">Precio</th> 
	  <th width="10%" class="formatoEncabezados">Iva</th>
  	</tr>';
	while($rowi=mysqli_fetch_array($resulti, MYSQLI_BOTH))
	{
	echo '<tr>
	<td class="formatoDatos"><div align="center">'.$rowi['Producto'].'</div></td>
	<td class="formatoDatos"><div align="center"><script language="javascript"> document.write(commaSplit('.$rowi['Cant_gasto'].'))</script></div></td>
	<td class="formatoDatos"><div align="center">$ <script language="javascript"> document.write(commaSplit('.$rowi['Precio_gasto'].'))</script></div></td>
	<td class="formatoDatos"><div align="center"><script language="javascript"> document.write(commaSplit('.(100*$rowi['tasa']).'))</script> %</div></td>
	</tr>';
	}
	echo '</table></div></td></tr>';
	$a=$a+1;
}
mysqli_close($link);//Cerrar la conexion
?>

</table>
<table width="27%" border="0" align="center">
  <tr>
        <td class="formatoDatos">&nbsp;</td>
  </tr>
    <tr> 
      <td><div align="center"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Men&uacute;">
      </div></td>
    </tr>
</table>
</div>
</body>
</html>