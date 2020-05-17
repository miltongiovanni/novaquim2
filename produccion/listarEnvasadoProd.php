<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
<title>Lista de Envasado por Orden de Producción</title>
<meta charset="utf-8">
<link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
	<script  src="../js/validar.js"></script>
    <script >	function togglecomments (postid) {
		var whichpost = document.getElementById(postid);
		if (whichpost.className=="commentshown") { whichpost.className="commenthidden"; } else { whichpost.className="commentshown"; }
	}</script>
</head>
<body>

<div id="contenedor">
<?php
include "includes/conect.php" ;
foreach ($_POST as $nombre_campo => $valor) 
{ 
	$asignacion = "\$".$nombre_campo."='".$valor."';"; 
	//echo $nombre_campo." = ".$valor."<br>";  
	eval($asignacion); 
	$link=conectarServidor();  
	$qrybus="select Cod_produc, Nom_produc from productos where Cod_produc=$producto";
	$resultbus=mysqli_query($link,$qrybus);
	$rowbus=mysqli_fetch_array($resultbus);
} 
?>
<div id="saludo1"><strong>LISTADO DE ENVASADO DE<?php echo " ".strtoupper($rowbus['Nom_produc'])." ";  ?>
POR ORDEN DE PRODUCCIÓN</strong></div>
<table width="700" align="center" border="0" summary="title">
  <tr> 
      <td><div align="right"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Menú">
      </div></td>
  </tr>
</table>
<table border="0" align="center" cellspacing="0" summary="Cuerpo">
<tr>
      <th width="23" align="center" class="formatoEncabezados"></th>
      <th width="76" align="center" class="formatoEncabezados">Lote</th>
      <th width="338" align="center" class="formatoEncabezados">Producto</th>
    <th width="106" align="center" class="formatoEncabezados">Fecha Producción</th>
      <th width="171" align="center" class="formatoEncabezados">Responsable</th>
    <th width="92" align="center" class="formatoEncabezados">Cantidad</th>
  </tr>   
<?php
//sentencia SQL    tblusuarios.IdUsuario,
$sql="	SELECT ord_prod.Lote, Fch_prod as 'Fecha de Producción', Nom_produc as 'Nombre de Producto', 
Cant_kg as 'Cantidad (Kg)', nom_personal as Responsable
FROM ord_prod, productos, personal, envasado
WHERE  Cod_prod=Cod_produc and Cod_persona=Id_personal and ord_prod.Lote=envasado.Lote and Cod_produc=$producto
Group by Lote order by Lote DESC;";
$result=mysqli_query($link,$sql);
$a=1;
while($row=mysqli_fetch_array($result, MYSQLI_BOTH))
{
	$lote=$row['Lote'];
	echo'<tr';
	  if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
	  echo '>
	<td class="formatoDatos"><div align="center"><a href="javascript:togglecomments('."'".'UniqueName'.$a."'".')">+/-</a></div></td>
	<td class="formatoDatos"><div align="center">'.$row['Lote'].'</div></td>
	<td class="formatoDatos"><div align="left">'.$row['Nombre de Producto'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$row['Fecha de Producción'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$row['Responsable'].'</div></td>
	<td class="formatoDatos"><div align="center"><script  > document.write(commaSplit('.$row['Cantidad (Kg)'].'))</script></div></td>
	';
	
	echo'</tr>';
	$sqli="SELECT Con_prese as Codigo, Nombre as Producto, Can_prese as Cantidad FROM envasado, prodpre
	WHERE Con_prese=Cod_prese and Lote=$lote ;";
	$resulti=mysqli_query($link,$sqli);
	echo '<tr><td colspan="7"><div class="commenthidden" id="UniqueName'.$a.'"><table width="80%" border="0" align="center" cellspacing="0" summary="Cuerpo">
	<tr>
      <th width="6%" class="formatoEncabezados">Código</th>
	  <th width="50%" class="formatoEncabezados">Producto</th>
      <th width="5%" class="formatoEncabezados">Cantidad</th>
  	</tr>';
	while($rowi=mysqli_fetch_array($resulti, MYSQLI_BOTH))
	{
	echo '<tr>
	<td class="formatoDatos"><div align="center">'.$rowi['Codigo'].'</div></td>
	<td class="formatoDatos"><div align="left">'.$rowi['Producto'].'</div></td>
	<td class="formatoDatos"><div align="center"><script  > document.write(commaSplit('.$rowi['Cantidad'].'))</script></div></td>

	</tr>';
	}
	echo '</table></div></td></tr>';
	$a=$a+1;
}
mysqli_close($link);//Cerrar la conexion
?>

</table>
<div align="center"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Menú"></div>
</div>
</body>
</html>