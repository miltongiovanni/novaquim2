<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Seleccionar Proveedor</title>
<script type="text/javascript" src="scripts/validar.js"></script>
<script type="text/javascript" src="scripts/block.js"></script>
	<script type="text/javascript">
	document.onkeypress = stopRKey; 
	</script>
	
</head>
<body>
<div id="contenedor">
<div id="saludo"><strong>CONSULTA DE COMPRA DE ETIQUETA POR PROVEEDOR</strong></div> 
<table width="100%" border="0">
  	<tr>
    	<td>
		<form id="form1" name="form1" method="post" action="listacompraetqProv.php">
      	<div align="center"><strong>Proveedor</strong>
<?php
				include "includes/conect.php";
				$link=conectarServidor();
				echo'<select name="prov">';
				$result=mysqli_query($link,"select * from proveedores  where Id_cat_prov=3 order by Nom_provee");
				echo '<option selected value="">---------------------------------------------------------------</option>';
				while($row=mysqli_fetch_array($result)){
					echo '<option value='.$row['NIT_provee'].'>'.$row['Nom_provee'].'</option>';
				}
				echo'</select>';
				mysqli_free_result($result);
				mysqli_close($link);
			?>
        <input type="submit" name="Submit" value="Continuar" onClick="return Enviar2(this.form);"/>
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

