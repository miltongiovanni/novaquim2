<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
<head>
<meta charset="utf-8">
<title>Seleccionar Cliente de Cotizaci&oacute;n a Modificar</title>
<script type="text/javascript" src="scripts/validar.js"></script>
<script type="text/javascript" src="scripts/block.js"></script>	
	<script type="text/javascript">
	document.onkeypress = stopRKey; 
	</script>

</head>
<body>
<div id="contenedor">
<div id="saludo"><strong>SELECCIONAR CLIENTE DE COTIZACI&Oacute;N A MODIFICAR</strong></div>
<table border="0" align="center" width="700">
  	<tr>
    	<td colspan="2"><div align="center">&nbsp;</div></td>
    </tr>
    <tr>
    	<td>
		<form id="form1" name="form1" method="post" action="updateCliCotForm.php">
      	<div align="center"><strong>Cliente:</strong>
<?php
				include "includes/conect.php";
				$link=conectarServidor();
				echo'<select name="cliente_cot" id="combo">';
				$result=mysqli_query($link,"select Id_cliente, Nom_clien from clientes_cotiz order by Nom_clien;");
				echo '<option selected value="">-----------------------------------------------------------------------------------</option>';
				while($row=mysqli_fetch_array($result)){
					echo '<option value='.$row['Id_cliente'].'>'.$row['Nom_clien'].'</option>';
				}
				echo'</select>';
				mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link)
			?>
            <input type="button" value="Continuar" onClick="return Enviar2(this.form);">
      	</div>
    	</form>    
        </td>
  	</tr>
    <tr>
    	<td colspan="2"><div align="center">&nbsp;</div></td>
    </tr>
    <tr> 
        <td colspan="2"><div align="center"><input type="button" class="resaltado" onClick="history.back()" value="  VOLVER  "></div></td>
    </tr>
</table>
</div>
</body>
</html>

