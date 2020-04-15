<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>Lista de &Oacute;rdenes de Producci&oacute;n</title>
<meta charset="utf-8">
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
	<script  src="scripts/validar.js"></script>
</head>
<body>
<div id="contenedor">
<div id="saludo1"><strong>LISTA DE &Oacute;RDENES DE PRODUCCI&Oacute;N</strong></div>

<table width="100%" border="0" class="formatoDatos" summary="encabezado">
  <tr> 
      <td><div align="right"><input type="button" class="formatoBoton" onClick="window.location='menu.php'" value="Ir al Men&uacute;"></div></td>
  </tr>
</table>
<table border="0" align="center" cellspacing="0" summary="cuerpo" width="87%">
	<tr>
      <th width="2%" class="formatoEncabezados"></th>
      <th width="6%" class="formatoEncabezados">Lote</th>
      <th width="25%" class="formatoEncabezados">Producto</th>
      <th width="25%" class="formatoEncabezados">F&oacute;rmula</th>
      <th width="13%" class="formatoEncabezados">Fecha Producci&oacute;n</th>
      <th width="13%" class="formatoEncabezados">Responsable</th>
      <th width="7%" class="formatoEncabezados">Cantidad</th>
      <th width="9%" class="formatoEncabezados">Estado</th>
  </tr>   
<?php
include "includes/utilTabla.php";
include "includes/conect.php" ;



//Limito la busqueda 
$TAMANO_PAGINA = 19; 

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
$sql="SELECT Lote, Fch_prod as 'Fecha de Producción', Nom_produc as 'Nombre de Producto', Nom_form as 'Formulación', Cant_kg as 'Cantidad (Kg)', nom_personal as Responsable, Estado FROM ord_prod, formula, productos, personal
WHERE ord_prod.Id_form=formula.Id_form AND formula.Cod_prod=productos.Cod_produc and Cod_persona=Id_personal order by Lote desc;";
$result=mysqli_query($link,$sql);
$num_total_registros = mysqli_num_rows($result); 
//calculo el total de páginas 
$total_paginas = ceil($num_total_registros / $TAMANO_PAGINA); 
echo '<div id="paginas" align="center">';
//muestro los distintos índices de las páginas, si es que hay varias páginas 
if ($total_paginas > 1){ 
   	for ($i=1;$i<=$total_paginas;$i++){ 
      	 if ($pagina == $i) 
         	 //si muestro el índice de la página actual, no coloco enlace 
         	 echo $pagina . " "; 
      	 else 
         	 //si el índice no corresponde con la página mostrada actualmente, coloco el enlace para ir a esa página 
         	 echo "<a href='listarOrProd.php?pagina=" . $i . "'>" . $i . "</a>&nbsp;"; 
   	} 
}
echo '</div>';


















//construyo la sentencia SQL 
$ssql = "SELECT Lote, Fch_prod as 'Fecha de Producción', Nom_produc as 'Nombre de Producto', Nom_form as 'Formulación', Cant_kg as 'Cantidad (Kg)', nom_personal as Responsable, Estado FROM ord_prod, formula, productos, personal
WHERE ord_prod.Id_form=formula.Id_form AND formula.Cod_prod=productos.Cod_produc and Cod_persona=Id_personal order by Lote desc limit " . $inicio . "," . $TAMANO_PAGINA; 
$rs = mysqli_query($link,$ssql);


$a=1;
while($row=mysqli_fetch_array($rs, MYSQLI_BOTH))
{
	$lote=$row['Lote'];
	$est=$row['Estado'];
	if ($est=='P')
		$estado="En Producción";
	if ($est=='C')
		$estado="En Calidad";
	if ($est=='E')
		$estado="Envasado";
	if ($est=='F')
		$estado="Parcial";
	if ($est=='A')
		$estado="Anulado";
	echo'<tr';
	  if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
	  echo '>
	<td class="formatoDatos"><div align="center"><a href="javascript:togglecomments('."'".'UniqueName'.$a."'".')">+/-</a></div></td>
	<td class="formatoDatos"><div align="center">'.$row['Lote'].'</div></td>
	<td class="formatoDatos"><div align="left">'.$row['Nombre de Producto'].'</div></td>
	<td class="formatoDatos"><div align="left">'.$row['Formulación'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$row['Fecha de Producción'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$row['Responsable'].'</div></td>
	<td class="formatoDatos"><div align="center"><script  > document.write(commaSplit('.$row['Cantidad (Kg)'].')+" Kg")</script></div></td>
	<td class="formatoDatos"><div align="center">'.$estado.'</div></td>
	';
	
	echo'</tr>';
	$sqli="SELECT det_ord_prod.Cod_mprima as Código, Nom_mprima, Can_mprima as Cantidad, Lote_MP
	from det_ord_prod, mprimas
	where det_ord_prod.Cod_mprima=mprimas.Cod_mprima and Lote = $lote 
	order by Orden;";
	$resulti=mysqli_query($link,$sqli);
	echo '<tr><td colspan="7"><div class="commenthidden" id="UniqueName'.$a.'"><table width="60%" border="0" align="center" cellspacing="0" summary="detalle">
	<tr>
      <th width="6%" class="formatoEncabezados">C&oacute;digo</th>
	  <th width="20%" class="formatoEncabezados">Materia Prima</th>
  	  <th width="10%" class="formatoEncabezados">Lote MP</th>
      <th width="5%" class="formatoEncabezados">Cantidad</th>
  	</tr>';
	while($rowi=mysqli_fetch_array($resulti, MYSQLI_BOTH))
	{
	echo '<tr>
	<td class="formatoDatos"><div align="center">'.$rowi['Código'].'</div></td>
	<td class="formatoDatos"><div align="left">'.$rowi['Nom_mprima'].'</div></td>
	<td class="formatoDatos"><div align="left">'.$rowi['Lote_MP'].'</div></td>
	<td class="formatoDatos"><div align="center"><script  > document.write(commaSplit('.$rowi['Cantidad'].'))</script></div></td>

	</tr>';
	}
	echo '</table></div></td></tr>';
	$a=$a+1;
}
mysqli_free_result($result);
mysqli_free_result($rs);
mysqli_free_result($resulti);
/* cerrar la conexión */
mysqli_close($link);
?>
</table>
<div align="center"><input type="button" class="formatoBoton" onClick="window.location='menu.php'" value="Ir al Men&uacute;"></div>
</div>
</body>
</html>