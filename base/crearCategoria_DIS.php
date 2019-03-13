<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
	<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
	<title>Creaci&oacute;n de Categor&iacute;as de Productos de Distribuci&oacute;n</title>
	<meta charset="utf-8">
	<script type="text/javascript" src="scripts/validar.js"></script>
	<script type="text/javascript" src="scripts/block.js"></script>	
		<script type="text/javascript">
	document.onkeypress = stopRKey; 
	</script>

</head>
<body>
<div id="contenedor">
<div id="saludo"><strong>CREACI&Oacute;N DE CATEGOR&Iacute;AS DE DISTRIBUCI&Oacute;N</strong></div>
<form name="form2" method="POST" action="makeCategoria_DIS.php">
<table  border="0" align="center" class="table2" cellspacing="0">
    <tr> 
        <td><div align="right"><b>Descripci&oacute;n</b></div></td>
        <td  colspan="2"><input type="text" name="categoria" size=34 ></td>
    </tr>
    <tr> 
        <td><div align="right"><strong>C&oacute;digo</strong></div></td>

        <td colspan="2"><?php
                include "includes/conect.php" ;
                //parametros iniciales que son los que cambiamos
                $link=conectarServidor();
                //sentencia SQL    tblusuarios.IdUsuario,
                $sql="select max(Id_cat_dist) as Código from cat_dist";						
                $result = mysqli_query($link, $sql);
                //$filas=mysql_num_rows($result);
                $row= mysqli_fetch_row($result);
                 $valor=$row[0];	
                echo'<input name="cod_cat_mp" type="text"  size= 34 readonly value='.($valor+1).'>';   	
                mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
            ?>    	</td>
    </tr>
    <tr> <td></td> 
        <td><div align="center"><input type="button" value="  Crear  " onClick="return Enviar(this.form);"></div></td>
        <td><div align="center"><input type="reset" value="Borrar"></div></td>
    </tr>
    <tr>
        <td colspan="3"><div align="center">&nbsp;</div></td>
    </tr>
    <tr>
        <td colspan="3"><div align="center">&nbsp;</div></td>
    </tr>
    <tr> 
        <td colspan="3">
        <div align="center"><input type="button" class="resaltado" onClick="history.back()" value="  VOLVER  "></div>        </td>
    </tr>
</table> 
</form>
</div>
</body>
</html>

