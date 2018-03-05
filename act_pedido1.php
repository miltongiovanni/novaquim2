<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Actualizaci&oacute;n de Orden de Pedido</title>
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
<div id="saludo"><strong>ACTUALIZACI&Oacute;N DE ORDEN DE PEDIDO</strong></div>
<?php
	include "includes/conect.php";
	foreach ($_POST as $nombre_campo => $valor) 
	{ 
		$asignacion = "\$".$nombre_campo."='".$valor."';"; 
		//echo $nombre_campo." = ".$valor."<br>";  
		eval($asignacion); 
	} 
?>
<form method="post" action="act_pedido2.php" name="form1">	
  	<table align="center" summary="detalle pedido">
    <tr>
      	<td width="170" align="right"><strong>No. Pedido:</strong></td>
   	  <td width="379">
		<input type="text" name="pedido" readonly value="<?php echo $pedido; ?>" size=50></td>
    </tr>
    <tr>
      	<td width="170" align="right"><strong>Cliente:</strong></td>
   	  <td width="379">
		<?php
			$link=conectarServidor();
			echo'<select name="Nit_cliente" id="combo">';
			$result=mysqli_query($link, "select Nit_cliente, Nom_clien from pedido, clientes WHERE Nit_cliente=Nit_clien and Id_pedido=$pedido;");
			$row=mysqli_fetch_array($result);
			echo '<option selected value="'.$row['Nit_cliente'].'">'.$row['Nom_clien'].'</option>';
			$result1=mysqli_query($link, "select Nit_clien, Nom_clien from clientes order by Nom_clien;");
			while($row1=mysqli_fetch_array($result1))
			{	
				if($row['Nit_cliente']!=$row1['Nit_clien'])
				echo '<option value='.$row1['Nit_clien'].'>'.$row1['Nom_clien'].'</option>';
			}
			echo'</select>';
			mysqli_free_result($result);
			mysqli_free_result($result1);
			/* cerrar la conexión */
			mysqli_close($link);
		?>        </td>
    </tr>
     
    <tr>
      <td colspan="2"><div align="center">&nbsp;</div><input name="pedido" type="hidden" value="<?php echo $pedido; ?>"></td>
    </tr>    
    <tr>
   	  <td>&nbsp;</td>
   	  <td><div align="right"><input name="button" type="button" class="formatoBoton1" onClick="return Enviar(this.form);" value="Continuar"></div></td>
    </tr>
    <tr>
      <td colspan="2"><div align="center">&nbsp;</div></td>
    </tr>
    <tr>
        <td colspan="2"><div align="center">&nbsp;</div></td>
    </tr>
    <tr> 
        <td colspan="2">
        <div align="center"><input type="button" class="formatoBoton1" onClick="history.back()" value="  VOLVER  "></div>        </td>
    </tr>

  </table>
</form> 
</div>
</body>
</html>