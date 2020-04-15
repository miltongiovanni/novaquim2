<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Compra de Etiquetas</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script  src="scripts/validar.js"></script>
	<script  src="scripts/block.js"></script>	
    <link rel="stylesheet" type="text/css" media="all" href="css/calendar-blue2.css" title="blue" />
    <script  src="scripts/calendar.js"></script>
    <script  src="scripts/calendar-sp.js"></script>
    <script  src="scripts/calendario.js"></script>
    	<script >
	document.onkeypress = stopRKey; 
	</script>

</head>
<body> 
<div id="contenedor">
<div id="saludo"><strong>INGRESO DE COMPRA DE ETIQUETAS</strong></div> 
<?php
foreach ($_POST as $nombre_campo => $valor) 
{ 
	$asignacion = "\$".$nombre_campo."='".$valor."';"; 
	//echo $nombre_campo." = ".$valor."<br>";  
	eval($asignacion); 
}  
?>
<form method="post" action="detCompraetq.php" name="form1">	
  	<table width="36%" align="center">
    <tr>
      <td width="44%">&nbsp;</td>
      <td width="56%">&nbsp;</td>
    </tr>
    <tr>
      <td align="right"><strong>Id Compra</strong></td>
      <td><input type="text" name="Factura" size=41 readonly onKeyPress="return aceptaNum(event)" value="<?php echo $Factura; ?>"></td>
    </tr>
    <tr>
      <td align="right"><strong>Proveedor</strong></td>
      <td><?php
			include "includes/conect.php";
			$link=conectarServidor();
			echo'<select name="nit_prov">';
			$result=mysqli_query($link,"select * from proveedores where Id_cat_prov=3 order by Nom_provee");
			$result1=mysqli_query($link,"select nitProv, Nom_provee, Num_fact, Fech_comp, Fech_venc from proveedores, compras where Id_cat_prov=3 and Id_compra=$Factura and nitProv=nit_prov;");
			$row1=mysqli_fetch_array($result1);
			echo '<option value='.$row1['NIT_provee'].'>'.$row1['Nom_provee'].'</option>';
            while($row=mysqli_fetch_array($result))
			{
				if($row['NIT_provee']!=$row1['NIT_provee'])
				echo '<option value='.$row['NIT_provee'].'>'.$row['Nom_provee'].'</option>';
            }
            echo'</select>';
			mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
		?></td>
    </tr>
    <tr>
      <td align="right"><strong>N&uacute;mero de Factura</strong></td>
      <td><input type="text" name="num_fac" size=41 onKeyPress="return aceptaNum(event)" value="<?php echo $row1['Num_fact']; ?>"></td>
    </tr>
    <tr>
      <td align="right"><strong>Fecha de Compra</strong></td>
      <td><input type="text" name="FchFactura" id="sel2" readonly="true" size=20 value="<?php echo $row1['Fech_comp']; ?>"><input type="reset" value=" ... "
		onclick="return showCalendar('sel2', '%Y-%m-%d', '12', true);"></td>
    </tr>
    <tr>
   	  <td align="right" ><strong>Fecha Vencimiento</strong></td>
        <td><input type="text" name="VenFactura" id="sel1"  readonly="true" size=20 value="<?php echo $row1['Fech_venc']; ?>"><input type="reset" value=" ... "
		onclick="return showCalendar('sel1', '%Y-%m-%d', '12', true);"></td>
    </tr>
    <tr>
      <td colspan="2"><div align="center">&nbsp;</div></td>
    </tr>
    <tr>
   	  <td><input name="CrearFactura" type="hidden" value="2"></td>
    	<td><div align="center"><input name="button" type="button" onClick="return Enviar(this.form);" value="Continuar"></div></td>
    </tr>
    <tr>
      <td colspan="2"><div align="center">&nbsp;</div></td>
    </tr>
    <tr>
        <td colspan="2"><div align="center">&nbsp;</div></td>
    </tr>
    <tr> 
        <td colspan="2">
        <div align="center"><input type="button" class="resaltado" onClick="history.back()" value="  VOLVER  "></div>
        </td>
    </tr>
  </table>
</form> 
</div>
</body>
</html>