<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>Inventario de Materia Prima</title>
<meta charset="utf-8">
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="scripts/validar.js"></script>
</head>
<body>
<div id="contenedor">
<?php
foreach ($_POST as $nombre_campo => $valor) 
	{ 
		$asignacion = "\$".$nombre_campo."='".$valor."';"; 
		//echo $nombre_campo." = ".$valor."<br>";  
		eval($asignacion); 
	}  
?>
<div id="saludo1"><strong>INVENTARIO DE MATERIA PRIMA A <?php echo $Fch; ?></strong></div>
<table width="713" border="0" align="center">
  <tr>
  	<form action="Inv_MP_fch_Xls.php" method="post" target="_blank"><td width="601" align="right">
    <input name="Submit" type="submit" class="resaltado" value="Exportar a Excel"></td><input name="Fch" type="hidden" value="<?php echo $Fch ?>"></form> 
      <td width="102"><div align="right"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Men&uacute;">
      </div></td>
  </tr>
</table>
<table border="0" align="center" cellspacing="0" width="70%">
<tr>
    <th class="formatoEncabezados">C&oacute;digo</th>
    <th class="formatoEncabezados">Materia Prima</th>
    <th class="formatoEncabezados">Cantidad (Kg)</th>
    <th class="formatoEncabezados">Entrada</th>
    <th class="formatoEncabezados">Salida</th>
    <th class="formatoEncabezados">Inventario</th>
  </tr>   
<?php
include "includes/utilTabla.php";
include "includes/conect.php" ;


//parametros iniciales que son los que cambiamos
//conectar con el servidor de BD
$link=conectarServidor();
//conectar con la tabla (ej. use datos;)
//sentencia SQL    tblusuarios.IdUsuario,
$sql="	SELECT inv_mprimas.Cod_mprima as Codigo, Nom_mprima as Nombre, sum(inv_mp) as inventario FROM inv_mprimas, mprimas
where inv_mprimas.Cod_mprima=mprimas.Cod_mprima group by Codigo order by Nombre;";
$result=mysqli_query($link,$sql);
$a=1;

while($row=mysqli_fetch_array($result, MYSQLI_BOTH))
{
	$salida=0;
	$salida1=0;
	$salida2=0;
	$prod=$row['Codigo'];
	$invt_ini=$row['inventario'];
	echo'<tr';
	if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
	echo '>
	<td class="formatoDatos"><div align="center">'.$row['Codigo'].'</div></td>
	<td class="formatoDatos"><div align="left">'.$row['Nombre'].'</div></td>
	<td class="formatoDatos"><div align="center"><script language="javascript"> document.write(commaSplit('.$invt_ini.'))</script></div></td>';
	//ENTRADA POR COMPRA DE MATERIA PRIMA
	$sqle="select Codigo, sum(Cantidad) as entrada from det_compras, compras where Codigo=$prod and det_compras.Id_compra=compras.Id_compra and compra=1 and Fech_comp>='$Fch' group by Codigo";
	$resulte=mysqli_query($link,$sqle);
	$rowe=mysqli_fetch_array($resulte, MYSQLI_BOTH);
	if($rowe['entrada']==NULL)
		$entrada=0;
	else
		$entrada=$rowe['entrada'];
	echo '<td class="formatoDatos"><div align="center"><script language="javascript"> document.write(commaSplit('.$entrada.'))</script></div></td>';
	//SALIDA POR ORDEN DE PRODUCCION	
	$sqls1="select Cod_mprima, sum(Can_mprima) as salida1 from det_ord_prod, ord_prod where Cod_mprima=$prod and det_ord_prod.Lote=ord_prod.Lote and Fch_prod>='$Fch' group by Cod_mprima;";
	$results1=mysqli_query($link,$sqls1);
	$rows1=mysqli_fetch_array($results1, MYSQLI_BOTH);
	if($rows1['salida1']==NULL)
		$salida1=0;
	else
		$salida1=$rows1['salida1'];
	//SALIDA POR ENVASADO DE PRODUCTOS DE DISTRIBUCION
	$sqls2="select Codigo_mp, sum(cant_medida*Cantidad*Densidad/1000) as salida2 from rel_dist_mp, env_dist, det_env_dist, medida where Codigo_mp=$prod and Cod_MP=env_dist.Id_env_dist  and Cod_umedid=Id_medida and rel_dist_mp.Cod_dist=det_env_dist.Cod_dist and Fch_env_dist>='$Fch';";	
	$results2=mysqli_query($link,$sqls2);
	$rows2=mysqli_fetch_array($results2, MYSQLI_BOTH);
	if($rows2['salida2']==NULL)
		$salida2=0;
	else
		$salida2=$rows2['salida2'];
	$salida=$salida1+$salida2;
	echo '<td class="formatoDatos"><div align="center"><script language="javascript"> document.write(commaSplit('.$salida.'))</script></div></td>';
	$inventario=$invt_ini-$entrada+$salida;
	echo '<td class="formatoDatos"><div align="center"><script language="javascript"> document.write(commaSplit('.$inventario.'))</script></div></td>';
	echo'</tr>';	
	$a=$a+1;
}
mysqli_free_result($result);
mysqli_free_result($resulte);
mysqli_free_result($results1);
mysqli_free_result($results2);
mysqli_close($link);//Cerrar la conexion
?>
</table>
<div align="center"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Men&uacute;"></div>
</div>
</body>
</html>