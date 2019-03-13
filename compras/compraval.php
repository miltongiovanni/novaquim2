<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Compra de Tapas y V&aacute;lvulas</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="scripts/validar.js"></script>
	<script type="text/javascript" src="scripts/block.js"></script>	
    <link rel="stylesheet" type="text/css" media="all" href="css/calendar-blue2.css" title="blue" />
    <script type="text/javascript" src="scripts/calendar.js"></script>
    <script type="text/javascript" src="scripts/calendar-sp.js"></script>
    <script type="text/javascript" src="scripts/calendario.js"></script>
    	<script type="text/javascript">
	document.onkeypress = stopRKey; 
	</script>

</head>
<body> 
<form method="post" action="detCompraval.php" name="form1">	
	<div align="center"><img src="images/LogoNova1.JPG"/></div>
  	<table width="36%" align="center">
<tr>
        <td colspan="2"><div align="center">&nbsp;</div></td>
    </tr>
    <tr>
   	  <td colspan="2"><div align="center" class="titulo"><strong>INGRESO DE COMPRA DE V&Aacute;LVULAS Y TAPAS</strong></div></td>
    </tr>
    <tr>
      <td width="44%">&nbsp;</td>
      <td width="56%">&nbsp;</td>
    </tr>
    <tr>
      <td><strong>Proveedor</strong></td>
      <td><?php
			include "includes/conect.php";
			$link=conectarServidor();
			echo'<select name="nit_prov">';
			$result=mysql_db_query("general","select * from proveedores where Id_cat_prov=2 order by Nom_provee");
			$total=mysql_num_rows($result);
			echo '<option value="">---------------------------------------------------------------</option>';
            while($row=mysql_fetch_array($result))
			{
				echo '<option value='.$row['NIT_provee'].'>'.$row['Nom_provee'].'</option>';
            }
            echo'</select>';
			mysql_close($link);
		?></td>
    </tr>
    <tr>
      <td><strong>N&uacute;mero de Factura</strong></td>
      <td><input type="text" name="num_fac" size=41 onKeyPress="return aceptaNum(event)"></td>
    </tr>
    <tr>
      <td><strong>Fecha de Compra</strong></td>
      <td><input type="text" name="FchFactura" id="sel2" readonly="true" size=20><input type="reset" value=" ... "
		onclick="return showCalendar('sel2', '%Y-%m-%d', '12', true);"></td>
    </tr>
    <tr>
   	  <td ><strong>Fecha Vencimiento</strong></td>
        <td><input type="text" name="VenFactura" id="sel1"  readonly="true" size=20><input type="reset" value=" ... "
		onclick="return showCalendar('sel1', '%Y-%m-%d', '12', true);"></td>
    </tr>
    <tr>
      <td colspan="2"><div align="center">&nbsp;</div></td>
    </tr>
    <tr>
   	  <td><input name="CrearFactura" type="hidden" value="0"></td>
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
        <div align="center"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="  VOLVER  "></div>
        </td>
    </tr>
  </table>
</form> 
</body>
</html>