<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
<head>
<meta charset="utf-8">
<title>Seleccionar proveedor a consultar pagos</title>
<script type="text/javascript" src="scripts/validar.js"></script>
<script type="text/javascript" src="scripts/block.js"></script>	
</head>
<body>
<div id="contenedor">
<div id="saludo"><strong>SELECCIONAR PROVEEDOR DE GASTOS A CONSULTAR ESTADO DE PAGOS</strong></div>

<table width="100%" border="0">
  	<tr>
    	<td>
		<form id="form1" name="form1" method="post" action="pagosXGastosProv.php">
      	<div align="center"><strong>Proveedor</strong>
		<?php
				include "includes/conect.php";
				$link=conectarServidor();
				echo'<select name="prov">';
				$result=mysqli_query($link,"select NIT_provee, Nom_provee from proveedores WHERE Id_cat_prov=6 order by Nom_provee;");
				echo '<option selected value="">---------------------------------------------------------------</option>';
				while($row=mysqli_fetch_array($result)){
					echo '<option value='.$row['NIT_provee'].'>'.$row['Nom_provee'].'</option>';
				}
				echo'</select>';
				mysqli_free_result($result);
/* cerrar la conexi�n */
mysqli_close($link);
		?>
        <input type="submit" name="Submit" value="Continuar" onClick="return Enviar2(this.form);">
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
