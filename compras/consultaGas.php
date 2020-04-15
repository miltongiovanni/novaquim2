<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Seleccionar Proveedor</title>
<script  src="scripts/validar.js"></script>
<script  src="scripts/block.js"></script>
	<script >
	document.onkeypress = stopRKey; 
	</script>

</head>
<body>
<div id="contenedor">
<div id="saludo"><strong>CONSULTA DE GASTOS POR PROVEEDOR</strong></div> 
<table width="100%" border="0">
  	<tr>
    	<td >&nbsp;</td>
  	</tr>
  	<tr>
    	<td>
		<form id="form1" name="form1" method="post" action="listagastosProv.php">
      	<div align="center"><strong>Proveedor</strong>
<?php
				include "includes/conect.php";
				$link=conectarServidor();
				echo'<select name="prov">';
				$result=mysqli_query($link,"select nitProv, Nom_provee from proveedores, gastos  where nit_prov=nitProv group by Nom_provee order by Nom_provee");
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

