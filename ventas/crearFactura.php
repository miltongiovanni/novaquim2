<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css"><head>
<meta charset="utf-8">
<title>Crear Factura a partir del Pedido</title>
<script  src="scripts/validar.js"></script>
<script  src="scripts/block.js"></script>
	<script >
	document.onkeypress = stopRKey; 
	</script>

</head>
<body>
<div id="contenedor">
<div id="saludo"><strong>CREAR FACTURA A PARTIR DEL PEDIDO</strong></div> 
<form id="form1" name="form1" method="post" action="factura.php">
<table border="0" align="center">
    <tr> 
        <td width="116"><div align="right"><strong>No. de Pedido&nbsp;</strong></div></td>
        <td width="118"><?php
			include "includes/conect.php";
			$link=conectarServidor();
			echo'<select name="pedido" id="combo">';
			$result=mysqli_query($link,"select Id_pedido from pedido, clientes where Nit_cliente=Nit_clien and pedido.Estado='L';");
			echo '<option selected value="">--------</option>';
			while($row=mysqli_fetch_array($result))
			{
				echo '<option value='.$row['Id_pedido'].'>'.$row['Id_pedido'].'</option>';
			}
			echo'</select>';
			mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
		?></td>
    </tr>
    <tr>
        <td colspan="2"><div align="center">&nbsp;</div></td>
    </tr>
    <tr> 
        <td ><div align="right"><input type="reset" value="Restablecer"></div></td>
        <td ><div align="left"><input type="button" value="    Continuar   " onclick="return Enviar(this.form);" ></div></td>
    </tr>
  
  	<tr>
        <td colspan="2"><div align="center">&nbsp;</div></td>
    </tr>
    <tr>
        <td colspan="2"><div align="center">&nbsp;</div></td>
    </tr>
    <tr> 
        <td colspan="2"><div align="center"><input type="button" class="resaltado" onClick="history.back()" value="  VOLVER  "></div></td></tr>
</table>
</form>  
</div>
</body>
</html>
