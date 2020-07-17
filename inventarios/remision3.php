<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Remisión de Productos</title>
    <meta charset="utf-8">
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script  src="../js/validar.js"></script>
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
<div id="saludo"><strong>REMISIÓN DE PRODUCTOS</strong></div>
<?php
	include "includes/conect.php";
	foreach ($_POST as $nombre_campo => $valor) 
	{ 
		$asignacion = "\$".$nombre_campo."='".$valor."';"; 
		//echo $nombre_campo." = ".$valor."<br>";  
		eval($asignacion); 
	} 
?>
<form method="post" action="det_remision.php" name="form1">	
<table align="center">
    <tr>
      	<td width="93" align="right"><strong>Sucursal</strong></td>
   	  <td width="380"><input name="cliente" type="hidden" value="<?php echo $cliente; ?> ">
		<?php
			$link=conectarServidor();
			echo'<select name="sucursal" id="combo">';
			$result=mysql_db_query("novaquim","SELECT Id_sucursal, Nom_sucursal from clientes_sucursal where Nit_clien='$cliente';");
			$total=mysql_num_rows($result);
			
			while($row=mysql_fetch_array($result))
			{	
				if($row['Id_sucursal']==1)
				echo '<option selected value="1">'.$row['Nom_sucursal'].'</option>';
				if($row['Id_sucursal']>1)
				echo '<option value='.$row['Id_sucursal'].'>'.$row['Nom_sucursal'].'</option>';
			}
			echo'</select>';
			mysql_close($link);
		?>        </td>
    </tr>
     <tr>
      <td align="right"><strong>Fecha </strong></td>
      <td><input type="text" name="FchPed" id="sel1" readonly size=20><input type="reset" value=" ... "
		onclick="return showCalendar('sel1', '%Y-%m-%d', '12', true);"></td>
    </tr>
    <tr>
      <td align="right"><strong>Valor </strong></td>
      <td><input type="text" name="valor" size=20 onKeyPress="return aceptaNum(event)"><input name="Crear" type="hidden" value="3"></td>
    </tr>
    
    <tr>
   	  <td>&nbsp;</td>
   	  <td><div align="right"><input name="button" type="button" onClick="return Enviar(this.form);" value="Continuar"></div></td>
    </tr>
    <tr>
        <td colspan="2"><div align="center">&nbsp;</div></td>
    </tr>
    <tr> 
        <td colspan="2">
        <div align="center"><input type="button" class="resaltado" onClick="history.back()" value="  VOLVER  "></div>        </td>
    </tr>
  </table>
</form> 
</div>
</body>
</html>