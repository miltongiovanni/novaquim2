<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
	<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
	<title>Organizaci&oacute;n de Kits de Productos de Distribuci&oacute;n</title>
	<meta charset="utf-8">
	<script type="text/javascript" src="scripts/validar.js"></script>
	<script type="text/javascript" src="scripts/block.js"></script>	
		<script type="text/javascript">
	document.onkeypress = stopRKey; 
	</script>

</head>
<body>
<div id="contenedor">
<div id="saludo"><strong>ORGANIZACI&Oacute;N DE KITS DE PRODUCTOS</strong></div>
<table  border="0" align="center" class="table2" cellspacing="0">
  <form name="form2" method="POST" action="det_kits.php">
    <tr>
    	<td><div align="right"><strong>Kit</strong></div></td>
      <td width="351">
      	<div align="left"> <?php
				include "includes/conect.php";
				$link=conectarServidor();
				echo'<select name="Cod_kit">';
				$result=mysqli_query($link,"SELECT Id_kit as Id, Codigo as C�digo, Nombre as Producto, Nom_envase as Envase from kit, prodpre, envase where Codigo=Cod_prese AND Cod_env=envase.Cod_envase
		union
		SELECT Id_kit as Id, Codigo as C�digo, Producto, Nom_envase as Envase from kit, distribucion, envase where Codigo=Id_distribucion AND Cod_env=envase.Cod_envase;");
				echo '<option selected value="">-----------------------------------------------------------------------------</option>';
				while($row=mysqli_fetch_array($result)){
					echo '<option value='.$row['Id'].'>'.$row['Producto'].'</option>';
				}
				echo'</select>';
				mysqli_close($link);
			?>
      	</div>
        </td>
  	</tr>
     <tr>
    	<td>&nbsp;</td>
    </tr>
    <tr> <td></td>
        <td>
            <div align="center"><input name="Crear" type="hidden" value="3">
              <input type="button" value="Continuar" onClick="return Enviar(this.form);">
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <input type="reset" value="  Reiniciar  ">    	
          </div></td>
    </tr>
    </form>
    <tr>
        <td colspan="2"><div align="center">&nbsp;</div></td>
    </tr>
    <tr>
        <td colspan="2"><div align="center">&nbsp;</div></td>
    </tr>
    <tr> 
        <td colspan="2">
        <div align="center"><input type="button" class="resaltado" onClick="history.back()" value="  VOLVER  "></div>        </td>
    </tr>
</table>
</div>
</body>
</html>

