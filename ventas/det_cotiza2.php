<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
<title>Detalle de la Cotizaci&oacute;n</title>
<meta charset="utf-8">
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
	<script  src="scripts/validar.js"></script>
	<script  src="scripts/block.js"></script>
        <link rel="stylesheet" type="text/css" media="all" href="css/calendar-blue2.css" title="blue">
    <script  src="scripts/calendar.js"></script>
    <script  src="scripts/calendar-sp.js"></script>
    <script  src="scripts/calendario.js"></script>
    	<script >
	document.onkeypress = stopRKey; 
	</script>
</head>
<body> 
<div id="contenedor">
<div id="saludo1"><strong>DETALLE DE LA COTIZACI&Oacute;N</strong></div>
<?php
	include "includes/conect.php";
	$link=conectarServidor();
	foreach ($_POST as $nombre_campo => $valor) 
	{ 
		$asignacion = "\$".$nombre_campo."='".$valor."';"; 
		//echo $nombre_campo." = ".$valor."<br>";  
		eval($asignacion); 
	}  	
	$qryb="select Id_Cotizacion, Nom_clien, Fech_Cotizacion, precio, presentaciones, distribucion, productos, nom_personal from cotizaciones, clientes_cotiz, personal where Id_Cotizacion=$Cotizacion and cliente=Id_cliente and Id_personal=cod_vend;";
  $resultb=mysqli_query($link,$qryb);		
  $rowb=mysqli_fetch_array($resultb);
  if ($Destino==1)
	$dest="Impresi�n";
  if ($Destino==2)
	$dest="Correo Electr�nico";
  if($rowb['presentaciones']==1)
	$presen="Todas";
  if($rowb['presentaciones']==2)
	$presen="Peque�as";
  if($rowb['presentaciones']==3)
	$presen="Grandes";
  if($rowb['precio']==1)
	$precio_c="F�brica";
  if($rowb['precio']==2)
	$precio_c="Distribuidor";
  if($rowb['precio']==3)
	$precio_c="Detal";
  if($rowb['precio']==4)
	$precio_c="Mayorista";
  if($rowb['precio']==5)
	$precio_c="Superetes";
  $seleccion1 = explode(",", $rowb['productos']);
  $c=count($seleccion1);
  $prodnova= array();

if (in_array(1, $seleccion1)) $prodnova[]=" Limpieza Equipos";
if (in_array(2, $seleccion1)) $prodnova[]=" Limpieza General  ";
if (in_array(3, $seleccion1)) $prodnova[]=" Mantenimiento de pisos ";
if (in_array(4, $seleccion1)) $prodnova[]=" Productos para Lavander�a ";
if (in_array(5, $seleccion1)) $prodnova[]=" Aseo Dom�stico y Oficina ";
if (in_array(6, $seleccion1)) $prodnova[]=" Higiene Cocina ";
if (in_array(7, $seleccion1)) $prodnova[]=" L�nea Automotriz ";

/*
for ($k = 0; $k <= $c; $k++) 
{
	if ($seleccion1[$k]==1) $prodnova[]=" Limpieza Equipos";
	if ($seleccion1[$k]==2) $prodnova[]=" Limpieza General  ";
	if ($seleccion1[$k]==3) $prodnova[]=" Mantenimiento de pisos  ";
	if ($seleccion1[$k]==4) $prodnova[]=" Productos para Lavander�a  ";
	if ($seleccion1[$k]==5) $prodnova[]=" Aseo Dom�stico y Oficina  ";
	if ($seleccion1[$k]==6) $prodnova[]=" Higiene Cocina  ";
	if ($seleccion1[$k]==7) $prodnova[]=" L�nea Automotriz  ";
}*/
$opciones_prod = implode(",", $prodnova);
if ($rowb['distribucion'])
{
  $seleccion = explode(",", $rowb['distribucion']);
  $b=count($seleccion);
  $distrib= array();
  
  
  if (in_array(1, $seleccion)) $distrib[]=" Implementos de Aseo";
  if (in_array(2, $seleccion)) $distrib[]=" Desechables ";
  if (in_array(3, $seleccion)) $distrib[]=" Cafeter�a ";
  if (in_array(4, $seleccion)) $distrib[]=" Abarrotes ";
  if (in_array(5, $seleccion)) $distrib[]=" Distribuci�n Aseo ";
  if (in_array(6, $seleccion)) $distrib[]=" Aseo Personal ";
  if (in_array(7, $seleccion)) $distrib[]=" Hogar ";
  if (in_array(8, $seleccion)) $distrib[]=" Papeler�a ";
  if (in_array(9, $seleccion)) $distrib[]=" Otros ";
  
  /*
  
  for ($j = 0; $j <= $b; $j++) 
  {
	  if ($seleccion[$j]==1) $distrib[]=" Implementos de Aseo";
	  if ($seleccion[$j]==2) $distrib[]=" Desechables  ";
	  if ($seleccion[$j]==3) $distrib[]=" Cafeter�a  ";
	  if ($seleccion[$j]==4) $distrib[]=" Abarrotes  ";
	  if ($seleccion[$j]==5) $distrib[]=" Distribuci�n Aseo  ";
	  if ($seleccion[$j]==6) $distrib[]=" Aseo Personal  ";
	  if ($seleccion[$j]==7) $distrib[]=" Hogar  ";
	  if ($seleccion[$j]==8) $distrib[]=" Papeler�a  ";
	  if ($seleccion[$j]==9) $distrib[]=" Otros  ";
  }*/
  $opciones_dist = implode(",", $distrib);
}
else
{
	$opciones_dist = 'No eligi� Productos de Distribuci�n';
}
?>
<table align="center" width="68%">
	<tr>
        <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
    	<td width="23%" align="right"><strong>No. Cotizaci&oacute;n:</strong></td>
   	  	<td colspan="2"><?php echo  $Cotizacion;  ?></td>
    </tr>
	<tr>
    	<td width="23%" align="right"><strong>Cliente:</strong></td>
   	  	<td colspan="2"><?php echo  $rowb['Nom_clien'];  ?></td>
    </tr>
    <tr>
      	<td align="right"><strong>Fecha de Cotizaci&oacute;n:</strong></td>
      	<td colspan="2"><?php echo  $rowb['Fech_Cotizacion'];  ?></td>
    </tr>
    <tr>
      	<td align="right"><strong>Destino:</strong></td>
      	<td colspan="2"><?php echo  $dest;  ?></td>
    </tr>
    <tr>
      	<td align="right"><strong>Presentaci&oacute;n:</strong></td>
      	<td colspan="2"><?php echo  $presen;  ?></td>
    </tr>
    <tr>
      	<td align="right"><strong>Precio:</strong></td>
      	<td colspan="2"><?php echo  $precio_c;  ?></td>
    </tr>    
    <tr>
    	<td align="right"><strong>Productos Novaquim:</strong></td>
  		<td colspan="2"><?php echo  $opciones_prod;  ?></td>
    </tr>    
    <tr>
    	<td align="right"><strong>Productos de Distribuci&oacute;n</strong></td>
  		<td colspan="2"><?php echo  $opciones_dist;  ?></td>
    </tr>
    <tr>
    	<td></td>
   	 	 <td width="47%" colspan="1"><div align="center"><form id="form1" name="form1" method="post" action="UpdateCotform.php"><input name="cotiza" type="hidden" value="<?php echo $Cotizacion; ?>"><input name="button" type="submit" onClick="return Enviar(this.form);" value="Modificar"></form></div></td>
         <td width="30%">
        <form method="post" action="Imp_Cotizacion.php" name="form3" target="_blank">
		<input name="Destino" type="hidden" value="<?php echo $Destino; ?>">
		<input name="Cotizacion" type="hidden" value="<?php echo $Cotizacion; ?>">
		<input name="No_dist" type="hidden" value="<?php echo $No_dist; ?>">
		<input type="submit" name="Submit" value="Imprimir">
		</form>
        </td>
    </tr>    
    <tr>
        <td colspan="3">&nbsp;</td>
    </tr>
  </table>
<div align="center"><input name="" type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir a Men&uacute;"></div>
</div>
</body>
</html>
	   