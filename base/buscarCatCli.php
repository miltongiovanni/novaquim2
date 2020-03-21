<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
<head>
<meta charset="utf-8">
<title>Seleccionar Tipo de Cliente</title>
<script type="text/javascript" src="scripts/validar.js"></script>
<script type="text/javascript" src="scripts/block.js"></script>	
	<script type="text/javascript">
	document.onkeypress = stopRKey; 
	</script>

</head>
<body>
<div id="contenedor">
<div id="saludo"><strong>SELECCIONAR TIPO DE CLIENTE A ACTUALIZAR</strong></div>
<table width="100%" border="0">
  	<tr>
    	<td>
		<form id="form1" name="form1" method="post" action="updateCatForm_Cli.php">
      	<div align="center"><strong>Tipo de Cliente</strong>
<?php
				include "includes/conect.php";
				$link=conectarServidor();
				echo'<select name="IdCat" id="combo">';
				$result=mysqli_query($link,"select * from cat_clien");
				echo '<option selected value="">---------------------------------------------------</option>';
				while($row=mysqli_fetch_array($result)){
					echo '<option value='.$row['Id_cat_cli'].'>'.$row['Des_cat_cli'].'</option>';
				}
				echo'</select>';
				mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
			?>
            <input type="button" value="Continuar" onClick="return Enviar(this.form);">
      	</div>
    	</form>    
        </td>
	</tr>
    <tr>
    	<td colspan="2"><div align="center">&nbsp;</div></td>
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
