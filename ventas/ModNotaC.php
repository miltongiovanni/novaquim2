<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
	<title>Modificación Nota Crédito</title>
	<meta charset="utf-8">
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
<?php
foreach ($_POST as $nombre_campo => $valor)
{ 
	$asignacion = "\$".$nombre_campo."='".$valor."';"; 
	//echo $nombre_campo." = ".$valor."<br>";  
	eval($asignacion); 
}  	
?>

<div id="contenedor">
<div id="saludo"><strong> NOTA CRÉDITO PARA
<?php
	include "includes/conect.php";
	$link=conectarServidor();
	$qry="select nomCliente, Nit_cliente, Fecha, Fac_orig, Fac_dest, motivo from clientes, nota_c where Nota=$mensaje and Nit_cliente=nitCliente;";
	$result=mysqli_query($link,$qry);
	$row=mysqli_fetch_array($result);
	$cliente=$row['Nit_cliente'];
	$Fecha=$row['Fecha'];
	$Fac_orig=$row['Fac_orig'];
	$Fac_dest=$row['Fac_dest'];
	$motivo=$row['motivo'];
	echo mb_strtoupper($row['Nom_clien']);
?> 
</strong></div>
<form name="form2" method="POST" action="makeNota.php">
<table  align="center" border="0" summary="cuerpo">
    <tr> 
        
        <td width="170"><div align="right"><strong>Razón de la Nota</strong></div></td>
        <td colspan="2">
        <?php if ($motivo==0)
			echo '<select name="razon" size="1">
              <option value="0" selected>Devolución de Productos</option>
              <option value="1">Descuento no aplicado</option>
        		</select>';
			else
			echo '<select name="razon" size="1">
              <option value="1" selected>Descuento no aplicado</option>
              <option value="0">Devolución de Productos</option>
        		</select>'
		?>
		</td>
    </tr>
    <tr> 
        <td colspan="2"><div align="right"><strong>Factura por la cual se origina la Nota</strong></div></td>
        <td width="89"><?php 
				echo'<select name="fact_ori" id="fact_origen">';
				$result=mysqli_query($link,"select Factura from factura where Nit_cliente='$cliente' and Estado<>'A' order by Factura DESC");
				echo '<option selected value="'.$Fac_orig.'">'.$Fac_orig.'</option>';
				while($row=mysqli_fetch_array($result))
				{
					if($row['Factura']!=$Fac_orig)
					echo '<option value='.$row['Factura'].'>'.$row['Factura'].'</option>';
				}
				echo'</select>';
			?>
       </td>
    </tr>
    <tr> 
        <td colspan="2"><div align="right"><strong>Factura a la cual afecta la Nota</strong></div></td>
        <td><?php 
				echo'<select name="fact_des" id="fact_destino">';
				$result=mysqli_query($link,"select Factura from factura where Nit_cliente='$cliente' order by Factura DESC");
				echo '<option selected value="'.$Fac_dest.'">'.$Fac_dest.'</option>';
				while($row=mysqli_fetch_array($result))
				{
					if($row['Factura']!=$Fac_dest)
					echo '<option value='.$row['Factura'].'>'.$row['Factura'].'</option>';
				}
				echo'</select>';
				mysqli_free_result($result);
/* cerrar la conexi�n */
mysqli_close($link);
			?>
       </td>
    </tr>
    <tr>
      <td align="right"><strong>Fecha Nota Crédito</strong></td>
      <td colspan="2"><input type="text" name="Fecha" id="sel1" readonly size=17 value="<?php echo $Fecha; ?>"><input type="reset" value=" ... "
		onclick="return showCalendar('sel1', '%Y-%m-%d', '12', true);"></td>
    </tr>
    <tr>
        <td colspan="3"><div align="center">&nbsp;</div></td>
    </tr>
    <tr><td><input name="nota" type="hidden" value="<?php echo $mensaje; ?>"><input name="crear" type="hidden" value="6"></td>
        <td width="110" colspan="1"><div align="right">
          <input type="reset" value="   Reiniciar   ">
        </div></td>
        <td colspan="1" align="center"><input type="button" value="Continuar" onClick="return Enviar(this.form);"></td>
    </tr>
    <tr>
        <td colspan="3"><div align="center">&nbsp;</div></td>
    </tr>
    <tr>
        <td colspan="3"><div align="center">&nbsp;</div></td>
    </tr>
    <tr> 
        <td colspan="3"><div align="center"><input type="button" class="resaltado" onClick="history.back()" value="  VOLVER  "></div></td>
    </tr>
</table>
</form>
</div>
</body>
</html>

