<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
<head>
<meta charset="utf-8">
<title>Ajuste de Inventario de Producto Terminado</title>
<script  src="../js/validar.js"></script>
<script  src="scripts/block.js"></script>
</head>
<body>
<div id="contenedor">
  <div id="saludo"><strong>SELECCIÓN DE PRODUCTO A AJUSTAR INVENTARIO</strong></div>
<form id="form1" name="form1" method="post" action="a_inv_prod2.php">  
<table width="700" border="0" align="center">
 <tr>
      <td>
        <div align="center"><strong>Producto</strong>
		<?php
		  include "includes/conect.php";
		  $link=conectarServidor();
		  echo'<select name="IdProd">';
		  $result=mysqli_query($link,"select Cod_prese, Nombre from prodpre  where pres_activo=0 order by Nombre;");
		  echo '<option selected value="">---------------------------------------------------------------------------------</option>';
		  while($row=mysqli_fetch_array($result))
		  {
			  echo '<option value='.$row['Cod_prese'].'>'.$row['Nombre'].'</option>';
		  }
		  echo'</select>';
		  mysqli_close($link);
		?>
        <input type="button" value="Continuar" onClick="return Enviar0(this.form);">
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
      <td colspan="2"><div align="center">
        <input type="button" class="resaltado" onClick="history.back()" value="  VOLVER  ">
      </div></td>
    </tr>
</table>
</form>
</div>
</body>
</html>
