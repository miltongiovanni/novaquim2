<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
	<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
	<title>Creaci&oacute;n de Productos</title>
	<meta charset="utf-8">
	<script type="text/javascript" src="scripts/validar.js"></script>
	<script type="text/javascript" src="scripts/block.js"></script>	
    	<script type="text/javascript">
	document.onkeypress = stopRKey; 
	</script>

</head>
<body>
<div id="contenedor">
<div id="saludo"><strong>CREACI&Oacute;N DE PRODUCTOS</strong></div>
<form name="form2" method="POST" action="crearProd2.php">
<table width="368" border="0"  align="center" cellspacing="0" >
	<tr> 
        <td width="101"><div align="right"><b>Categor&iacute;a</b></div></td>
        <td colspan="2"><select name="Cate" id="combo">
          <?php
            include "includes/conect.php";
            $link=conectarServidor();
            $qry="select * from cat_prod";	
            $result=mysqli_query($link, $qry);
            echo '<option selected value="">---------------------------------------------------</option>';
            while($row=mysqli_fetch_array($result))
            {
                  echo '<option value="'.$row['Id_cat_prod'].'">'.$row['Des_cat_prod'].'</option>';  
                  //echo= $row['Id_cat_prod'];
            }
			mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
        ?>
        </select ></td> 
    </tr>
     <tr> 
    <td>&nbsp; </td>
    </tr>
    <tr> <td></td>
        <td width="130"><div align="center"><input type="button" value="  Crear  " onClick="return Enviar(this.form);"></div></td>
        <td width="131"><div align="center"><input type="reset" value="  Borrar  "></div></td>
    </tr>
    <tr> 
    <td>&nbsp; </td>
    </tr>

    <tr>
        <td colspan="3"><div align="center">&nbsp;</div></td>
    </tr>
    <tr> 
        <td colspan="3"><div align="center"><input type="button" class="resaltado" onClick="history.back()" value="  VOLVER  "></div></td>
    </tr>
</table>    
</form>
</div>
</body>
</html>

