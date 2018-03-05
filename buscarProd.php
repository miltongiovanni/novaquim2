<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
<head>
<meta charset="utf-8">
<title>Seleccionar Producto a Actualizar</title>
<script type="text/javascript" src="scripts/validar.js"></script>
<script type="text/javascript" src="scripts/block.js"></script>	
</head>
<body>
<div id="contenedor">
<div id="saludo"><strong>SELECCIONAR PRODUCTO A MODIFICAR</strong></div>
<form id="form1" name="form1" method="post" action="updateProdForm.php">
<table width="664" border="0" align="center">
  	<tr>
    	<td>
		
      	<div align="center"><strong>Producto</strong>
<?php
				include "includes/conect.php";
				$link=conectarServidor();
				echo'<select name="IdProd" id="combo">';
				$result=mysqli_query($link, "select * from productos where prod_activo=0 order by Nom_produc;");
				echo '<option selected value="">--------------------------------------------------------------------------</option>';
				while($row=mysqli_fetch_array($result)){
					echo '<option value='.$row['Cod_produc'].'>'.$row['Nom_produc'].'</option>';
				}
				echo'</select>';
				mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
			?>
            <input type="submit" name="Submit" value="Continuar" onClick="return Enviar(this.form);">
      	</div>
    	    
        </td>
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
