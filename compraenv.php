<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Ingreso de compra de Envase</title>
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
<div id="saludo"><strong>INGRESO DE COMPRA DE ENVASE</strong></div>
<form method="post" action="detCompraenv.php" name="form1">	
<table align="center" summary="tabla">
  <tr>
    <td align="right"><strong>Proveedor</strong></td>
    <td><?php
          include "includes/conect.php";
          $link=conectarServidor();
          echo'<select name="nit_prov">';
          $result=mysqli_query($link,"select * from proveedores where Id_cat_prov=2 order by Nom_provee");
          echo '<option value="">---------------------------------------------------------------</option>';
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
    <td align="right"><strong>N&uacute;mero de Factura</strong></td>
    <td><input type="text" name="num_fac" size=36 onKeyPress="return aceptaNum(event)"></td>
  </tr>
  <tr>
    <td align="right"><strong>Fecha de Compra</strong></td>
    <td><input type="text" name="FchFactura" id="sel2" readonly size=31><input type="reset" value=" ... "
      onclick="return showCalendar('sel2', '%Y-%m-%d', '12', true);"></td>
  </tr>
  <tr>
    <td align="right" ><strong>Fecha Vencimiento</strong></td>
      <td><input type="text" name="VenFactura" id="sel1"  readonly size=31><input type="reset" value=" ... "
      onclick="return showCalendar('sel1', '%Y-%m-%d', '12', true);"></td>
  </tr>
  <tr>
    <td colspan="2"><div align="center">&nbsp;</div></td>
  </tr>
  <tr>
    <td><input name="CrearFactura" type="hidden" value="0"></td>
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
      <div align="center"><input type="button" class="resaltado" onClick="history.back()" value="  VOLVER  "></div>
      </td>
  </tr>
</table>
</form> 
</div>
</body>
</html>