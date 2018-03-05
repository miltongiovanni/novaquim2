<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
<head>
<meta charset="utf-8">
<title>Seleccionar Cliente a Modificar</title>
<script type="text/javascript" src="scripts/validar.js"></script>
<script type="text/javascript" src="scripts/block.js"></script>	
	<script type="text/javascript">
	document.onkeypress = stopRKey; 
	</script>

</head>
<body>
<div id="contenedor">
<div id="saludo"><strong>SELECCIONAR DISTRIBUIDORA A MODIFICAR</strong></div>
<table border="0" align="center" width="700">
  	<tr>
    	<td colspan="2"><div align="center">&nbsp;</div></td>
    </tr>
    <tr>
    	<td>
		<form id="form1" name="form1" method="post" action="updateConsultForm.php">
      	<div align="center"><strong>Distribuidora:</strong>
<?php
				include "includes/conect.php";
				$link=conectarServidor();
				echo'<select name="cliente" id="combo">';
				$result=mysql_db_query("novaquim","select Nit_clien, Nom_clien from clientes where id_cat_clien=13 order by Nom_clien");
				$total=mysql_num_rows($result);
				echo '<option selected value="">-----------------------------------------------------------------------------------</option>';
				while($row=mysql_fetch_array($result)){
					echo '<option value='.$row['Nit_clien'].'>'.$row['Nom_clien'].'</option>';
				}
				echo'</select>';
				mysql_close($link);
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

