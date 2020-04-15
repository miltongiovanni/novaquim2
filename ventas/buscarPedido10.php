<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css"><head>
<meta charset="utf-8">
<title>Seleccionar Pedido a Modificar</title>
<script  src="scripts/validar.js"></script>
<script  src="scripts/block.js"></script>
	<script >
	document.onkeypress = stopRKey; 
	</script>

</head>
<body>
<div id="contenedor">
<div id="saludo"><strong>BUSCAR ORDEN DE PEDIDO A MODIFICAR</strong></div>
<table border="0" align="center">
<form id="form1" name="form1" method="post" action="act_pedido1.php">	
    <tr> 
        <td width="133"><div align="right"><strong>Orden  de Pedido&nbsp;</strong></div></td><td>
        <?php
			include "includes/conect.php";
			$link=conectarServidor();
			echo'<select name="pedido" id="combo">';
			$result=mysql_db_query("novaquim","select Id_pedido from pedido, clientes where Nit_cliente=Nit_clien and pedido.Estado='P' order by Id_pedido;");
			$total=mysql_num_rows($result);
			echo '<option selected value="">----------</option>';
			while($row=mysql_fetch_array($result))
			{
				echo '<option value='.$row['Id_pedido'].'>'.$row['Id_pedido'].'</option>';
			}
			echo'</select>';
		?></td>
        <input type="hidden" name="Crear" value="5">
    </tr>
    <tr>
        <td colspan="2"><div align="center">&nbsp;</div></td>
    </tr>
    <tr> 
        <td align="right"><input type="reset" value="Restablecer"></td>
        <td align="left"><input type="button" value="    Continuar    " onclick="return Enviar(this.form);"></td>

    </tr>
</form>    
  	<tr>
        <td colspan="2"><div align="center">&nbsp;</div></td>
    </tr>
    <tr>
        <td colspan="2"><div align="center">&nbsp;</div></td>
    </tr>
    <tr> 
        <td colspan="2"><div align="center"><input type="button" class="resaltado" onClick="history.back()" value="  VOLVER  "></div></td></tr>
</table>
</div>
</body>
</html>
