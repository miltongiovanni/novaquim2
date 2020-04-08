<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>Lista de Cotizaciones</title>
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
<div id="saludo1"><strong>LISTA DE COTIZACIONES</strong></div>
<table align="center" width="100%" border="0">
  <tr> 
        <td width="1177" align="right"> <form action="Cotiza_Xls.php" method="post" target="_blank"><input name="Submit" type="submit" class="resaltado" value="Exportar a Excel"></form></td><td width="93"><div align="right"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Men&uacute;">
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
    <th width="14%" class="formatoEncabezados">Presentaciones </th>
  </tr>   
<?php
	include "includes/utilTabla.php";
	include "includes/conect.php" ;
	$link=conectarServidor();
	$sql="select Id_Cotizacion, Nom_clien, desCatClien, nom_personal, Fech_Cotizacion, precio, presentaciones, distribucion, productos 
	from cotizaciones, clientes_cotiz, Personal, cat_clien 
	where cliente=Id_cliente and cod_vend=Id_personal and Id_cat_clien=idCatClien order by Id_Cotizacion desc;";
	//llamar funcion de tabla
	$result=mysqli_query($link,$sql);
	$a=1;
	while($row=mysqli_fetch_array($result, MYSQLI_BOTH))
	{
	 echo'<tr';
	  if (($a++ % 2)==0) echo ' bgcolor="#B4CBEF" ';
	  echo '>
	  <td class="formatoDatos"><div align="center"><a aiotitle="click to expand" href="javascript:togglecomments('."'".'UniqueName'.$a."'".')">+/-</a></div></td>
	  <td class="formatoDatos"><div align="center">'.$row['Id_Cotizacion'].'</div></td>
	  <td class="formatoDatos"><div align="left">'.$row['Nom_clien'].'</div></td>
	  <td class="formatoDatos"><div align="center">'.$row['Des_cat_cli'].'</div></td>
	  <td class="formatoDatos"><div align="center">'.$row['nom_personal'].'</div></td>
	  <td class="formatoDatos"><div align="center">'.$row['Fech_Cotizacion'].'</div></td>';
	  if ($row['precio']==1) $precio="Fábrica";
	  if ($row['precio']==2) $precio="Distribuidor";
	  if ($row['precio']==3) $precio="Detal";
	  if ($row['precio']==4) $precio="Mayorista";
	  if ($row['precio']==5) $precio="Super";
	  echo '<td class="formatoDatos"><div align="center">'.$precio.'</div></td>';
	  if ($row['presentaciones']==1) $presentacion="Todas";
	  if ($row['presentaciones']==2) $presentacion="Pequeñas";
	  if ($row['presentaciones']==3) $presentacion="Grandes";
	  echo '<td class="formatoDatos"><div align="center">'.$presentacion.'</div></td>';
	  
	  $seleccion1 = explode(",", $row['productos']);
	  $c=count($seleccion1);
	  $prodnova="";
	  if (in_array(1, $seleccion1)) $prodnova[]=" Limpieza Equipos";
	  if (in_array(2, $seleccion1)) $prodnova[]=" Limpieza General  ";
	  if (in_array(3, $seleccion1)) $prodnova[]=" Mantenimiento de pisos ";
	  if (in_array(4, $seleccion1)) $prodnova[]=" Productos para Lavandería ";
	  if (in_array(5, $seleccion1)) $prodnova[]=" Aseo Doméstico y Oficina ";
	  if (in_array(6, $seleccion1)) $prodnova[]=" Higiene Cocina ";
	  if (in_array(7, $seleccion1)) $prodnova[]=" Línea Automotriz ";

	  $opciones_prod = implode(",", $prodnova);
	  if ($row['distribucion'])
	  {
		$seleccion = explode(",", $row['distribucion']);
		$b=count($seleccion);
		$distrib="";
		if (in_array(1, $seleccion)) $distrib[]=" Implementos de Aseo";
		if (in_array(2, $seleccion)) $distrib[]=" Desechables ";
		if (in_array(3, $seleccion)) $distrib[]=" Cafetería ";
		if (in_array(4, $seleccion)) $distrib[]=" Abarrotes ";
		if (in_array(5, $seleccion)) $distrib[]=" Distribución Aseo ";
		if (in_array(6, $seleccion)) $distrib[]=" Aseo Personal ";
		if (in_array(7, $seleccion)) $distrib[]=" Hogar ";
		if (in_array(8, $seleccion)) $distrib[]=" Papelería ";
		if (in_array(9, $seleccion)) $distrib[]=" Otros ";
		$opciones_dist = implode(",", $distrib);
	  }
	  else
	  {
		  $opciones_dist = 'No eligió Productos de Distribución';
	  }
	  echo'</tr>';
	  echo '<tr><td colspan="9"><div class="commenthidden" id="UniqueName'.$a.'"><table width="100%" border="0" align="center" cellspacing="0" bordercolor="#CCCCCC">
	  <tr>
		<th width="45%" class="formatoEncabezados">Productos Novaquim</th>
		<th width="10%" class="formatoEncabezados"></th>
		<th width="45%" class="formatoEncabezados">Productos de Distribuci&oacute;n</th>
	  </tr>';
	  echo '<tr>
	  <td class="formatoDatos"><div align="center">'.$opciones_prod.'</div></td>
	  <td class="formatoDatos"><div align="center">'.'</div></td>
	  <td class="formatoDatos"><div align="left">'.$opciones_dist.'</div></td>
	  </tr>';
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
