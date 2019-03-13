<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Ingreso de Gastos de Novaquim</title>
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
<div id="saludo"><strong>INGRESO DE GASTOS DE INDUSTRIAS NOVAQUIM</strong></div>
<?php
foreach ($_POST as $nombre_campo => $valor) 
{ 
	$asignacion = "\$".$nombre_campo."='".$valor."';"; 
	//echo $nombre_campo." = ".$valor."<br>";  
	eval($asignacion); 
}  
?>
<form method="post" action="detGasto.php" name="form1">	
<table align="center">
<tr>
      <td align="right"><strong>Id Compra</strong></td>
      <td><input type="text" name="Factura" size=41 readonly onKeyPress="return aceptaNum(event)" value="<?php echo $Factura; ?>"></td>
    </tr>
    <tr>
      <td width="156"><div align="right"><strong>Proveedor</strong></div></td>
      <td width="291"><?php
			include "includes/conect.php";
			$link=conectarServidor();
			echo'<select name="nit_prov">';
			$result=mysqli_query($link,"select * from proveedores order by Nom_provee");
			$result1=mysqli_query($link,"select NIT_provee, Nom_provee, Num_fact, Fech_comp, Fech_venc from proveedores, gastos where Id_gasto=$Factura and NIT_provee=nit_prov;");
			$row1=mysqli_fetch_array($result1);
			echo '<option value='.$row1['NIT_provee'].'>'.$row1['Nom_provee'].'</option>';
            while($row=mysqli_fetch_array($result))
			{
				echo '<option value='.$row['NIT_provee'].'>'.$row['Nom_provee'].'</option>';
            }
            echo'</select>';
			mysqli_free_result($result);
			mysqli_close($link);
		?></td>
    </tr>
    <tr>
      <td><div align="right"><strong>N&uacute;mero de Factura</strong></div></td>
      <td><input type="text" name="num_fac" size=41 onKeyPress="return aceptaNum(event)" value="<?php echo $row1['Num_fact']; ?>"></td>
    </tr>
    <tr>
      <td><div align="right"><strong>Fecha de Compra</strong></div></td>
      <td><input type="text" name="FchFactura" id="sel2" readonly size=20 value="<?php echo $row1['Fech_comp']; ?>"><input type="reset" value=" ... "
		onclick="return showCalendar('sel2', '%Y-%m-%d', '12', true);"></td>
    </tr>
    <tr>
   	  <td ><div align="right"><strong>Fecha Vencimiento</strong></div></td>
        <td><input type="text" name="VenFactura" id="sel1"  readonly size=20 value="<?php echo $row1['Fech_venc']; ?>"><input type="reset" value=" ... "
		onclick="return showCalendar('sel1', '%Y-%m-%d', '12', true);"></td>
    </tr>
    <tr>
      <td colspan="2"><div align="center">&nbsp;</div></td>
    </tr>
    <tr>
   	  <td><input name="CrearFactura" type="hidden" value="2"></td>
    	<td><div align="right"><input name="button" type="button" onClick="return Enviar(this.form);" value="Continuar"></div></td>
    </tr>
    <tr>
      <td colspan="2"><div align="center">&nbsp;</div></td>
    </tr>
    <tr>
        <td colspan="2"><div align="center">&nbsp;</div></td>
    </tr>
    <tr> 
        <td colspan="2">
        <div align="center"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="  VOLVER  "></div>        </td>
    </tr>
  </table>
</form> 
</div>
</body>
</html>