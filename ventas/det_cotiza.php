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
$ba=0;
if ($Crear==3)
{  	  
  if($_POST['seleccion1']==NULL)
  {
	//echo "no escogió productos de novaquim <br>";
	echo' <script >
	alert("Debe escoger alguna Familia de los productos Nova");
	self.location="cotizacion.php";
	</script>';
  }
  else
  {
	$opciones_prod = implode(",", $_POST['seleccion1']);
	$i=0;
	//SE DETERMINA A QUE PRECIO SE VA A COTIZAR
	if($precio==1)
		$qry="select DISTINCT codigo_ant, Producto, prodpre.fabrica as precio from prodpre, productos, precios WHERE Cod_ant=codigo_ant and prodpre.Cod_produc=productos.Cod_produc and Cotiza=0 ";
	if($precio==2)
		$qry="select DISTINCT codigo_ant, Producto, prodpre.distribuidor as precio from prodpre, productos, precios WHERE Cod_ant=codigo_ant and prodpre.Cod_produc=productos.Cod_produc and Cotiza=0 ";
	if($precio==3)
		$qry="select DISTINCT codigo_ant, Producto, prodpre.detal as precio from prodpre, productos, precios WHERE Cod_ant=codigo_ant and prodpre.Cod_produc=productos.Cod_produc and Cotiza=0 ";
	if($precio==4)
		$qry="select DISTINCT codigo_ant, Producto, prodpre.mayor as precio from prodpre, productos, precios WHERE Cod_ant=codigo_ant and prodpre.Cod_produc=productos.Cod_produc and Cotiza=0 ";
	if($precio==5)
		$qry="select DISTINCT codigo_ant, Producto, prodpre.super as precio from prodpre, productos, precios WHERE Cod_ant=codigo_ant and prodpre.Cod_produc=productos.Cod_produc and Cotiza=0 ";	
	//SELECCIONA EL TIPO DE PRESENTACIONES 1 PARA TODAS, 2 PARA PEQUEÑAS Y 3 PARA GRANDES
	if ($Presentaciones==1)
		$wh="";
	if ($Presentaciones==2)
		$wh=" and Cod_umedid<=11 and Cotiza=0";
	if ($Presentaciones==3)
		$wh=" and Cod_umedid>=10 and Cotiza=0";
	$qry=$qry.$wh."";
	$b=count($_POST['seleccion1']);
	$qryp=" and (";
	for ($k = 0; $k < $b; $k++) 
	{
		$qryp=$qryp." Id_cat_prod=".($_POST['seleccion1'][$k]);
		if ($k<=($b-2))
			$qryp=$qryp." or ";	
	} 
	$qryp=$qryp.")";	
	$qry=$qry.$qryp;
	echo $qry."<br>";
	$qryd="select Id_distribucion, Producto, precio_vta from distribucion where Cotiza=0";
	if($_POST['seleccion'])
	{
		$qryd=$qryd." and (";	
		$opciones_dist = implode(",", $_POST['seleccion']);
		//echo $separado_por_comas."<br>";
		//print_r(explode(',', $separado_por_comas));
		//echo "<br>";	
	
		$a=count($_POST['seleccion']);
		for ($j = 0; $j < $a; $j++) 
		{
			$qryd=$qryd."(Id_distribucion >= ".($_POST['seleccion'][$j]*100000+1)." and Id_distribucion <= ".(($_POST['seleccion'][$j]+1)*100000-1).")";
			
			if ($j<=($a-2))
				$qryd=$qryd." or ";	
		} 
		$qryd=$qryd.")";
		$ba=1;
		//echo $qryd."<br>";	
		//echo "<br>";
	}
	else
	{
		//echo "no escogió productos de distribución <br>";
		$No_dist=1;
	}
	$link=conectarServidor();   
	/*validacion del valor a pagar"*/
	if($ba==1)
	{
	  $qryIns="insert into cotizaciones (cliente, Fech_Cotizacion, precio, presentaciones, distribucion, productos)
	  values  ($cliente, '$FchCot', $precio, $Presentaciones, '$opciones_dist', '$opciones_prod')"; 
	  if($resultIns=mysqli_query($link,$qryIns))
	  {
		  $qrys="select max(Id_Cotizacion) as num_cotiza from cotizaciones";
		  $results=mysqli_query($link,$qrys);
		  $rows=mysqli_fetch_array($results);
		  $num_cotiza=$rows['num_cotiza'];	
		  $No_dist=0;
		  mysqli_close($link);
		  echo '<form method="post" action="det_cotiza.php" name="form5" target="_blank">';
		  echo'<input name="Crear" type="hidden" value="5">';
		  echo'<input name="Destino" type="hidden" value="'.$Destino.'">';
		  echo'<input name="num_cotiza" type="hidden" value="'.$num_cotiza.'">';
		  echo '<input type="submit" name="Submit" value="Analizar" >'; 
		  echo '</form>';
		  echo'<script >
			  document.form5.submit();
			  </script>';
	  }
	  else
	  {
		  mysqli_close($link);
		  mover_pag("cotizacion.php","Error al ingresar la Cotización");
	  }
	}
  }
}

function mover_pag($ruta,$mensaje)
{	
//Funcion que permite el redireccionamiento de los usuarios a otra pagina 
echo' <script >
alert("'.$mensaje.'")
self.location="'.$ruta.'"
</script>';
}	
$link=conectarServidor();
$qryb="select Id_Cotizacion, Nom_clien, Fech_Cotizacion, precio, presentaciones, distribucion, productos, nom_personal from cotizaciones, clientes_cotiz, personal where Id_Cotizacion=$num_cotiza and cliente=Id_cliente and Id_personal=cod_vend;";
$resultb=mysqli_query($link,$qryb);		
$rowb=mysqli_fetch_array($resultb);
if ($Destino==1)
$dest="Impresión";
if ($Destino==2)
$dest="Correo Electrónico";
if($rowb['presentaciones']==1)
$presen="Todas";
if($rowb['presentaciones']==2)
$presen="Pequeñas";
if($rowb['presentaciones']==3)
$presen="Grandes";
if($rowb['precio']==1)
$precio_c="Fábrica";
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
if (in_array(4, $seleccion1)) $prodnova[]=" Productos para Lavandería ";
if (in_array(5, $seleccion1)) $prodnova[]=" Aseo Doméstico y Oficina ";
if (in_array(6, $seleccion1)) $prodnova[]=" Higiene Cocina ";
if (in_array(7, $seleccion1)) $prodnova[]=" Línea Automotriz ";
/*

for ($k = 0; $k <= $c; $k++) 
{
if ($seleccion1[$k]==1) $prodnova[]=" Limpieza Equipos";
if ($seleccion1[$k]==2) $prodnova[]=" Limpieza General  ";
if ($seleccion1[$k]==3) $prodnova[]=" Mantenimiento de pisos  ";
if ($seleccion1[$k]==4) $prodnova[]=" Productos para Lavandería  ";
if ($seleccion1[$k]==5) $prodnova[]=" Aseo Doméstico y Oficina  ";
if ($seleccion1[$k]==6) $prodnova[]=" Higiene Cocina  ";
if ($seleccion1[$k]==7) $prodnova[]=" Línea Automotriz  ";
}*/
$opciones_prod = implode(",", $prodnova);
if ($rowb['distribucion'])
{
$seleccion = explode(",", $rowb['distribucion']);
$b=count($seleccion);
$distrib= array();
if (in_array(1, $seleccion)) $distrib[]=" Implementos de Aseo";
if (in_array(2, $seleccion)) $distrib[]=" Desechables ";
if (in_array(3, $seleccion)) $distrib[]=" Cafetería ";
if (in_array(4, $seleccion)) $distrib[]=" Abarrotes ";
if (in_array(5, $seleccion)) $distrib[]=" Distribución Aseo ";
if (in_array(6, $seleccion)) $distrib[]=" Aseo Personal ";
if (in_array(7, $seleccion)) $distrib[]=" Hogar ";
if (in_array(8, $seleccion)) $distrib[]=" Papelería ";
if (in_array(9, $seleccion)) $distrib[]=" Otros ";


/*for ($j = 0; $j <= $b; $j++) 
{
  if ($seleccion[$j]==1) $distrib[]=" Implementos de Aseo";
  if ($seleccion[$j]==2) $distrib[]=" Desechables  ";
  if ($seleccion[$j]==3) $distrib[]=" Cafetería  ";
  if ($seleccion[$j]==4) $distrib[]=" Abarrotes  ";
  if ($seleccion[$j]==5) $distrib[]=" Distribución Aseo  ";
  if ($seleccion[$j]==6) $distrib[]=" Aseo Personal  ";
  if ($seleccion[$j]==7) $distrib[]=" Hogar  ";
  if ($seleccion[$j]==8) $distrib[]=" Papelería  ";
  if ($seleccion[$j]==9) $distrib[]=" Otros  ";
}*/
$opciones_dist = implode(",", $distrib);
}
else
{
$opciones_dist = 'No eligió Productos de Distribución';
}
?>
<table align="center" width="68%">
	<tr>
        <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
    	<td width="23%" align="right"><strong>No. Cotizaci&oacute;n:</strong></td>
   	  	<td colspan="2"><?php echo  $num_cotiza;  ?></td>
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
   	 	 <td width="47%" colspan="1"><div align="center"><form id="form1" name="form1" method="post" action="UpdateCotform.php"><input name="cotiza" type="hidden" value="<?php echo $num_cotiza; ?>"><input name="button" type="submit" onClick="return Enviar(this.form);" value="Modificar"></form></div></td>
         <td width="30%">
        <form method="post" action="Imp_Cotizacion.php" name="form3" target="_blank">
		<input name="Destino" type="hidden" value="<?php echo $Destino; ?>">
		<input name="Cotizacion" type="hidden" value="<?php echo $num_cotiza; ?>">
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
	   