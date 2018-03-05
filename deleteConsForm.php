<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Eliminar Cliente</title>
<script type="text/javascript" src="scripts/validar.js"></script>
<script type="text/javascript" src="scripts/block.js"></script>	
	<script type="text/javascript">
	document.onkeypress = stopRKey; 
	</script>

</head>


<body>
<div id="contenedor">
<div id="saludo"><strong>SELECCIONAR DISTRIBUIDORA A ELIMINAR</strong></div>

<table width="700" border="0" align="center">
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td colspan="2">
			<form method="post" action="deleteConsult.php">
			<div align="center"><strong>Distribuidora:</strong>
			  <?php
			include "includes/conect.php";
			$link=conectarServidor();
			echo'<select name="Cliente" id="combo">';
			$result=mysql_db_query("novaquim","select Nit_clien, Nom_clien from clientes  where id_cat_clien=13 order by Nom_clien;");
			$total=mysql_num_rows($result);
			echo '<option value="">---------------------------------------------------------------------</option>';
			while($row=mysql_fetch_array($result))
			{
				echo '<option value='.$row['Nit_clien'].'>'.$row['Nom_clien'].'</option>';
			}
			echo'</select>';
			mysql_close($link);
			?>
			  <input name="button" type="submit" value="Eliminar" onClick="return Enviar2(this.form);"></div>
			<div align="center"></div>
			<div align="right"></div>
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
        <td colspan="2">
        <div align="center"><input type="button" class="resaltado" onClick="history.back()" value="  VOLVER  "></div>
        </td>
    </tr>
</table>
</div>
</body>
</html>
