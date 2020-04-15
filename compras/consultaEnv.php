<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
<head>
<meta charset="utf-8">
<title>Seleccionar Proveedor</title>
<script  src="scripts/validar.js"></script>
<script  src="scripts/block.js"></script>
	<script >
	document.onkeypress = stopRKey; 
	</script>

</head>
<body>
<div id="contenedor">
<div id="saludo"><strong>SELECCIONAR PROVEEDOR DE ENVASE, TAPAS O V&Aacute;LVULAS</strong></div>
<form id="form1" name="form1" method="post" action="listacompraenvProv.php">
<table width="100%" border="0">
  	<tr>
    	<td>

      	<div align="center"><strong>Proveedor</strong>
<?php
				include "includes/conect.php";
				$link=conectarServidor();
				echo'<select name="prov">';
				$result=mysqli_query($link, "select * from proveedores  where Id_cat_prov=2 order by Nom_provee");
				echo '<option selected value="">---------------------------------------------------------------</option>';
				while($row=mysqli_fetch_array($result)){
					echo '<option value='.$row['NIT_provee'].'>'.$row['Nom_provee'].'</option>';
				}
				echo'</select>';
				mysqli_free_result($result);
				mysqli_close($link);
			?>
        <input type="submit" name="Submit" value="Continuar" onClick="return Enviar2(this.form);">
      	</div>
    	   
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
</form> 
</div>
</body>
</html>

