<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
<title>Hist&oacute;rico de Cobros Facturas</title>
<meta charset="utf-8">
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="contenedor">
<div id="saludo1"><strong>HIST&Oacute;RICO DE PAGOS DE FACTURAS GENERAL</strong></div>
<table width="711" border="0" align="center" summary="encabezado">
  <tr> <td width="611" align="right"><form action="fech_histo_cobros_Xls.php" method="post"><input name="Submit" type="submit" class="formatoBoton" value="Exportar a Excel">
    </form></td>
      <td width="90"><div align="right"><input type="button" class="formatoBoton" onClick="window.location='menu.php'" value="Ir al Men&uacute;">
      </div></td>
  </tr>
</table>

<table border="0" align="center" cellspacing="0" cellpadding="0" width="67%">
	<tr>
      <th width="5%" class="formatoEncabezados">Id</th>
      <th width="7%" class="formatoEncabezados">Factura</th>
      <th width="46%" class="formatoEncabezados">Cliente</th>
      <th width="9%" class="formatoEncabezados">Pago</th>
      <th width="8%" class="formatoEncabezados">Fecha</th>
      <th width="15%" class="formatoEncabezados">Forma de Pago</th>
      <th width="10%" class="formatoEncabezados">&nbsp;</th>
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
$sql="	select Id_caja as 'Id', Fact as Factura, Nom_clien as Cliente, CONCAT('$ ', FORMAT(cobro,0)) as Pagos, Fecha, formaPago as 'Forma de Pago' 
from r_caja, factura, clientes, form_pago where Fact=Factura and Nit_cliente=Nit_clien and form_pago=idFormaPago order by Id DESC";
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
         	 echo "<a href='hist_cobros.php?pagina=" . $i . "'>" .$i. "</a>&nbsp;"; 
   	} 
}
echo '</div>';

//construyo la sentencia SQL 
$ssql = "select Id_caja as 'Id', Fact as Factura, Nom_clien as Cliente, CONCAT('$ ', FORMAT(cobro,0)) as Pagos, Fecha, formaPago  
from r_caja, factura, clientes, form_pago where Fact=Factura and Nit_cliente=Nit_clien and form_pago=idFormaPago order by Id DESC limit " . $inicio . "," . $TAMANO_PAGINA;
$rs = mysqli_query($link,$ssql);
$a=1;
while($row=mysqli_fetch_array($rs, MYSQLI_BOTH))
{
	$Recibo=$row['Id'];
	echo'<tr';
	  if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
	  echo '>
	<td class="formatoDatos"><div align="center">'.$row['Id'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$row['Factura'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$row['Cliente'].'</div></td>
	<td class="formatoDatos"><div align="left">'.$row['Pagos'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$row['Fecha'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$row['forma_pago'].'</div></td>
	<td class="formatoDatos"><div align="center"><form action="Imp_Recibo_Caja.php" method="post" target="_blank" name="imprime'.$a.'"><input name="Recibo" type="hidden" value="'.$Recibo.'"><input name="Submit" type="submit" value="Imprimir" class="formatoBoton"></form></div></td>
	';
	
	echo'</tr>';
	$a=$a+1;
}

mysqli_free_result($result);
mysqli_close($link);//Cerrar la conexion





?>
</table>

<div align="center"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Men&uacute;"></div>
</div>
</body>
</html>