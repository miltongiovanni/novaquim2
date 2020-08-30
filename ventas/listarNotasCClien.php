<?php
include "../includes/valAcc.php";
include "includes/utilTabla.php";
include "includes/conect.php" ;
foreach ($_POST as $nombre_campo => $valor) 
{ 
	$asignacion = "\$".$nombre_campo."='".$valor."';"; 
	echo $nombre_campo." = ".$valor."<br>";  
	eval($asignacion); 
}  
$link=conectarServidor();  
$qrybus="select nomCliente from clientes where nitCliente='$cliente'";
$resultbus=mysqli_query($link,$qrybus);
$rowbus=mysqli_fetch_array($resultbus);
?>
<!DOCTYPE html>
<html lang="es">
<head>
<title>Lista de Notas Crédito</title>
<meta charset="utf-8">
<link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
	<script  src="../js/validar.js"></script>
</head>
<body>
<div id="contenedor">
<div id="saludo1"><strong>LISTA DE NOTAS CRÉDITO <?php echo strtoupper($rowbus['Nom_clien']); ?></strong></div>
<table  align="center" width="700" border="0" summary="encabezado">
  <tr> 
      <td><div align="right"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Menú"></div></td>
  </tr>
</table>
<table border="0" align="center" cellspacing="0" cellpadding="0" summary="Cuerpo">
	<tr>
      <th width="8" class="formatoEncabezados"></th>
      <th width="95" class="formatoEncabezados">Nota Crédito</th>
      <th width="379" class="formatoEncabezados">Cliente</th>
      <th width="113" class="formatoEncabezados">Fecha</th>
      <th width="110" class="formatoEncabezados">Factura Origen</th>
      <th width="110" class="formatoEncabezados">Factura Afecta</th>
      <th width="160" class="formatoEncabezados">Motivo</th>
      <th width="160" class="formatoEncabezados">Valor</th>
  </tr>   
<?php


//Limito la busqueda 
$TAMANO_PAGINA = 20; 

//examino la página a mostrar y el inicio del registro a mostrar 
if(isset($_GET['pagina'])) 
{
    $pagina = $_GET['pagina']; 
}
else
	$pagina=NULL;
	
if (!$pagina) 
{ 
   	 $inicio = 0; 
   	 $pagina=1; 
} 
else 
{ 
   	$inicio = ($pagina - 1) * $TAMANO_PAGINA; 
}
$link=conectarServidor();
$sql="	select Nota, nomCliente, Fecha, Fac_orig, Fac_dest, Motivo, Total from nota_c, clientes where Nit_cliente=nitCliente and Nit_cliente='$cliente' order by Nota DESC;";
$result=mysqli_query($link,$sql);

$num_total_registros = mysqli_num_rows($result); 
//calculo el total de páginas 
$total_paginas = ceil($num_total_registros / $TAMANO_PAGINA); 

//muestro los distintos índices de las páginas, si es que hay varias páginas 
echo '<div id="paginas" align="center">';
if ($total_paginas > 1){ 
   	for ($i=1;$i<=$total_paginas;$i++){ 
      	 if ($pagina == $i) 
         	 //si muestro el índice de la página actual, no coloco enlace 
         	 echo $pagina . " "; 
      	 else 
         	 //si el índice no corresponde con la página mostrada actualmente, coloco el enlace para ir a esa página 
         	 echo "<a href='listarNotasC.php?pagina=" . $i ."'>" . $i . "</a>&nbsp;"; 
   	} 
}
echo '</div>';

$ssql="	select Nota, nomCliente, Fecha, Fac_orig, Fac_dest, Motivo, Total from nota_c, clientes where Nit_cliente=nitCliente and Nit_cliente='$cliente' order by Nota DESC  limit " . $inicio . "," . $TAMANO_PAGINA;
$rs = mysqli_query($link,$ssql);


$a=1;
while($row=mysqli_fetch_array($rs, MYSQLI_BOTH))
{
	$mensaje=$row['Nota'];
	if ($row['Motivo']==0)
		$motivo="Devolución";
	else
		$motivo="Descuento no aplicado";
	$Tot=number_format($row['Total'], 0, '.', ',');
	echo'<tr';
	  if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
	  echo '>
	<td class="formatoDatos"><div align="center"><a aiotitle="click to expand" href="javascript:togglecomments('."'".'UniqueName'.$a."'".')">+/-</a></div></td>
	<td class="formatoDatos"><div align="center">'.$row['Nota'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$row['Nom_clien'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$row['Fecha'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$row['Fac_orig'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$row['Fac_dest'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$motivo.'</div></td>
	<td class="formatoDatos"><div align="center">$ <script > document.write(commaSplit('.round($row['Total'],0).'))</script></div></td>';
	
	echo'</tr>';
	$sqli="select det_nota_c.Cod_producto as codigo, Nombre as producto, det_nota_c.Can_producto as cantidad 
	FROM det_nota_c, nota_c, det_factura, prodpre
	where Id_Nota=Nota and Id_Nota=$mensaje and det_nota_c.Cod_producto<100000 and det_nota_c.Cod_producto>0  AND det_nota_c.Cod_producto=Cod_prese 
	union
	select det_nota_c.Cod_producto as codigo, Producto as producto,det_nota_c.Can_producto as cantidad
	from det_nota_c, nota_c, det_factura, distribucion
	where Id_Nota=Nota and Id_Nota=$mensaje and det_nota_c.Cod_producto>100000 AND det_nota_c.Cod_producto=Id_distribucion
	union
	select Cod_producto as codigo, CONCAT ('Descuento de ', Can_producto, '% no aplicado en la factura')  as producto, Can_producto AS cantidad from det_nota_c where Id_Nota=$mensaje AND Cod_producto=0";
	$resulti=mysqli_query($link,$sqli);
	echo '<tr><td colspan="7"><div class="commenthidden" id="UniqueName'.$a.'"><table width="750" border="0" align="center" cellspacing="0" summary="Detalle">
	<tr>
      <th width="40" class="formatoEncabezados">Código</th>
	  <th width="250" class="formatoEncabezados">Producto</th>
      <th width="40" class="formatoEncabezados">Cantidad</th>
  	</tr>';
	while($rowi=mysqli_fetch_array($resulti, MYSQLI_BOTH))
	{
	echo '<tr>
	<td class="formatoDatos"><div align="center">'.$rowi['codigo'].'</div></td>
	<td class="formatoDatos"><div align="left">'.$rowi['producto'].'</div></td>
	<td class="formatoDatos"><div align="center"><script  > document.write(commaSplit('.$rowi['cantidad'].'))</script></div></td>

	</tr>';
	}
	echo '</table></div></td></tr>';
	$a=$a+1;
}
mysqli_free_result($result);
mysqli_free_result($resulti);
mysqli_close($link);//Cerrar la conexion
?>

</table>
<div align="center"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Menú"></div>
</div>
 </body>
</html>