<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>Lista de Envasado por Orden de Producci&oacute;n</title>
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
<div id="saludo1"><strong>LISTADO DE ENVASADO POR ORDEN DE PRODUCCI&Oacute;N</strong></div>
<table width="700" align="center" border="0">
  <tr> 
      <td><div align="right"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Men&uacute;">
      </div></td>
  </tr>
</table>
<table border="0" align="center" cellspacing="0">
<tr>
      <th width="23" align="center" class="formatoEncabezados"></th>
      <th width="76" align="center" class="formatoEncabezados">Lote</th>
      <th width="338" align="center" class="formatoEncabezados">Producto</th>
    <th width="106" align="center" class="formatoEncabezados">Fecha Producci&oacute;n</th>
      <th width="171" align="center" class="formatoEncabezados">Responsable</th>
    <th width="92" align="center" class="formatoEncabezados">Cantidad</th>
  </tr>   
<?php
include "includes/utilTabla.php";
include "includes/conect.php" ;



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
$sql="	SELECT ord_prod.Lote, Fch_prod as 'Fecha de Producción', Nom_produc as 'Nombre de Producto', 
Cant_kg as 'Cantidad (Kg)', nom_personal as Responsable
FROM ord_prod, productos, personal, envasado
WHERE  Cod_prod=Cod_produc and Cod_persona=Id_personal and ord_prod.Lote=envasado.Lote
Group by Lote order by Lote DESC;";
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
         	 echo "<a href='listarEnvasado.php?pagina=" . $i . "'>" . $i . "</a>&nbsp;"; 
   	} 
}
echo '</div>';


//construyo la sentencia SQL 
$ssql = "SELECT ord_prod.Lote, Fch_prod as 'Fecha de Producción', Nom_produc as 'Nombre de Producto', 
Cant_kg as 'Cantidad (Kg)', nom_personal as Responsable
FROM ord_prod, productos, personal, envasado
WHERE  Cod_prod=Cod_produc and Cod_persona=Id_personal and ord_prod.Lote=envasado.Lote
Group by Lote order by Lote DESC limit " . $inicio . "," . $TAMANO_PAGINA; 
$rs = mysqli_query($link,$ssql);

$a=1;
while($row=mysqli_fetch_array($rs, MYSQLI_BOTH))
{
	$lote=$row['Lote'];
	echo'<tr';
	  if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
	  echo '>
	<td class="formatoDatos"><div align="center"><a aiotitle="click to expand" href="javascript:togglecomments('."'".'UniqueName'.$a."'".')">+/-</a></div></td>
	<td class="formatoDatos"><div align="center">'.$row['Lote'].'</div></td>
	<td class="formatoDatos"><div align="left">'.$row['Nombre de Producto'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$row['Fecha de Producción'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$row['Responsable'].'</div></td>
	<td class="formatoDatos"><div align="center"><script > document.write(commaSplit('.$row['Cantidad (Kg)'].'))</script></div></td>
	';
	
	echo'</tr>';
	$sqli="SELECT Con_prese as Codigo, Nombre as Producto, Can_prese as Cantidad FROM envasado, prodpre
	WHERE Con_prese=Cod_prese and Lote=$lote ;";
	$resulti=mysqli_query($link,$sqli);
	echo '<tr><td colspan="7"><div class="commenthidden" id="UniqueName'.$a.'"><table width="80%" border="0" align="center" cellspacing="0">
	<tr>
      <th width="6%" class="formatoEncabezados">C&oacute;digo</th>
	  <th width="50%" class="formatoEncabezados">Producto</th>
      <th width="5%" class="formatoEncabezados">Cantidad</th>
  	</tr>';
	while($rowi=mysqli_fetch_array($resulti, MYSQLI_BOTH))
	{
	echo '<tr>
	<td class="formatoDatos"><div align="center">'.$rowi['Codigo'].'</div></td>
	<td class="formatoDatos"><div align="left">'.$rowi['Producto'].'</div></td>
	<td class="formatoDatos"><div align="center"><script > document.write(commaSplit('.$rowi['Cantidad'].'))</script></div></td>

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
<div align="center"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Men&uacute;"></div>
</div>
</body>
</html>