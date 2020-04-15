<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
<meta charset="utf-8">
<title>Seleccionar Cliente a Crear Nota</title>
<script  src="scripts/validar.js"></script>
<script  src="scripts/block.js"></script>
	<script >
	document.onkeypress = stopRKey; 
	</script>

</head>
<body>
<div id="contenedor">
<div id="saludo"><strong>SELECCIONAR CLIENTE AL QUE SE LE VA A CREAR NOTA</strong></div>
<table border="0" align="center" width="700" summary="cuerpo">
  	<tr>
    	<td colspan="2"><div align="center">&nbsp;</div></td>
    </tr>
    <tr>
    	<td>
		<form id="form1" name="form1" method="post" action="crearNotaC2.php">
      	<div align="center"><strong>Cliente:</strong>
<?php
				include "includes/conect.php";
				$link=conectarServidor();
				echo'<select name="cliente" id="combo">';
				$result=mysqli_query($link,"select Nit_clien, Nom_clien from clientes order by Nom_clien");
				echo '<option selected value="">-----------------------------------------------------------------------------------</option>';
				while($row=mysqli_fetch_array($result)){
					echo '<option value='.$row['Nit_clien'].'>'.$row['Nom_clien'].'</option>';
				}
				echo'</select>';
				mysqli_free_result($result);
				mysqli_close($link);
			?>
            <input name="Submit" type="submit" class="formatoBoton1" onClick="return Enviar2(this.form);" value="Continuar">
      	</div>
    	</form>    
        </td>
  	</tr>
    <tr>
    	<td colspan="2"><div align="center">&nbsp;</div></td>
    </tr>
    <tr> 
        <td colspan="2"><div align="center"><input type="button" class="formatoBoton1" onClick="history.back()" value="  VOLVER  "></div></td>
    </tr>
</table>
</div>
</body>
</html>

