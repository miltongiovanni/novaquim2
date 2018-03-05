<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Creaci&oacute;n de Orden de Pedido</title>
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
<div id="saludo"><strong>CREACI&Oacute;N DE ORDEN DE PEDIDO DE VENTA DIRECTA</strong></div>
<form method="post" action="pedido_vd2.php" name="form1">	
<table align="center">
    <tr><td colspan="2"><div align="center">&nbsp;</div></td></tr>
    <tr>
      	<td width="69" align="right"><strong>Cliente:</strong></td>
   	  <td width="379">
		<?php
			include "includes/conect.php";
			$link=conectarServidor();
			echo'<select name="cliente" id="combo">';
			$result=mysql_db_query("novaquim","select Nit_clien, Nom_clien from clientes where Estado='A' and Id_cat_clien=13 order by Nom_clien");
			$total=mysql_num_rows($result);
			echo '<option selected value="">-----------------------------------------------------------------------------------</option>';
			while($row=mysql_fetch_array($result)){
				echo '<option value='.$row['Nit_clien'].'>'.$row['Nom_clien'].'</option>';
			}
			echo'</select>';
			mysql_close($link);
		?>        </td>
    </tr>
     
    <tr>
      <td colspan="2"><div align="center">&nbsp;</div></td>
    </tr>    <input name="Crear" type="hidden" value="3">
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