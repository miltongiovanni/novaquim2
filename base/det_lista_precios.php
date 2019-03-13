<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>Lista de Precios</title>
<meta charset="utf-8">
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="scripts/validar.js"></script>
	<script type="text/javascript" src="scripts/block.js"></script>
        <link rel="stylesheet" type="text/css" media="all" href="css/calendar-blue2.css" title="blue">
    <script type="text/javascript" src="scripts/calendar.js"></script>
    <script type="text/javascript" src="scripts/calendar-sp.js"></script>
    <script type="text/javascript" src="scripts/calendario.js"></script>
    	<script type="text/javascript">
	document.onkeypress = stopRKey; 
	</script>
</head>
<body> 
<div id="contenedor">
<div id="saludo1"><strong>DETALLE LISTA DE PRECIOS</strong></div>
<?php
include "includes/conect.php";
$link=conectarServidor();
$Presentaciones=$_POST['Presentaciones'];
/*foreach ($_POST as $nombre_campo => $valor) 
{ 
	$asignacion = "\$".$nombre_campo."='".$valor."';"; 
	echo $nombre_campo." = ".$valor."<br>";  
	eval($asignacion); 
}*/
if($_POST['seleccion1'])
{
  $opciones_prod = implode(",", $_POST['seleccion1']);
  $i=0;
  $qry="select codigo_ant, producto, cant_medida, Cod_produc, ";
  //SE DETERMINA A QUE PRECIO SE VA A COTIZAR
  $c=count($_POST['seleccion1']);
  $precios1=  array();
  for ($k=0; $k < $c; $k++) 
  {
	if ($_POST['seleccion1'][$k]==1) { $precios1[]=" Fábrica"; 			$precios[]=" fabrica";}
	if ($_POST['seleccion1'][$k]==2) { $precios1[]=" Distrib  "; 	$precios[]=" distribuidor";}
	if ($_POST['seleccion1'][$k]==3) { $precios1[]=" Detal  "; 			$precios[]=" detal";}
	if ($_POST['seleccion1'][$k]==4) { $precios1[]=" Mayor "; 		$precios[]=" mayor";}
	if ($_POST['seleccion1'][$k]==5) { $precios1[]=" Super "; 		$precios[]=" super";}
  }
  $opciones_prec1 = implode(",", $precios1);
  $opciones_prec = implode(",", $precios);
  $qry=$qry.$opciones_prec;
  $qry=$qry." from precios, (select DISTINCTROW Cod_ant, cant_medida, Cod_produc from prodpre, precios, medida where Cod_ant=codigo_ant and Cod_umedid=Id_medida and pres_activa=0 and pres_lista=0 group by Cod_ant) as tabla  where pres_activa=0 and codigo_ant=Cod_ant";		
			
			
	  
  //SELECCIONA EL TIPO DE PRESENTACIONES 1 PARA TODAS, 2 PARA PEQUEÑAS Y 3 PARA GRANDES
  if ($Presentaciones==1)
  {
	  $wh=" and cant_medida<=20000";
	  $presen="Todas";
  }
  if ($Presentaciones==2)
  {
	  $wh=" and cant_medida<=4000";
	  $presen="Pequeñas";
  }
  if ($Presentaciones==3)
  {
	  $wh=" and cant_medida>=3500";
	  $presen="Grandes";
  }
  $qry=$qry.$wh." order by Cod_produc,  cant_medida";
  //echo $qry."<br>";
}
else
{
	//echo "no escogió productos de novaquim <br>";
	echo' <script language="Javascript">
	alert("Debe escoger algún tipo de precio");
	history.back();
	</script>';
}
?>
<table align="center" width="34%">
	<tr>
        <td colspan="3">&nbsp;</td>
    </tr>
	<tr>
      	<td width="23%" align="right"><strong>Presentaci&oacute;n:</strong></td>
      	<td colspan="2"><?php echo  $presen;  ?></td>
    </tr>
    <tr>
      	<td align="right"><strong>Precio:</strong></td>
      	<td colspan="2"><?php echo  $opciones_prec1;  ?></td>
    </tr>    
    <tr>
    	<td></td>
   	 	 <td width="33%" colspan="1"><div align="center"><input name="button" type="button" onClick="history.back()" value="Volver"></div></td>
         <td width="44%">
        <form method="post" action="Imp_Precios.php" name="form3" target="_blank">
		<input name="query" type="hidden" value="<?php echo $qry; ?>">
		<input name="opciones_prec1" type="hidden" value="<?php echo $opciones_prec1; ?>">
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
	   