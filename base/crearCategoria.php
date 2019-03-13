<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
	<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
	<title>Creaci&oacute;n de Categor&iacute;as de Productos</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<script type="text/javascript" src="scripts/validar.js"></script>
	<script type="text/javascript" src="scripts/block.js"></script>	
</head>
<body>
<div id="contenedor">

<div id="saludo"><strong>CREACI&Oacute;N DE CATEGOR&Iacute;AS&nbsp;</strong></div> 
<form name="form2" method="POST" action="makeCategoria.php">
<table width="235" align="center" cellspacing="0" class="table2">
	<tr> 
        <td width="89"><div align="right"><b>Descripci&oacute;n</b></div></td>
        <td colspan="2"><input type="text" name="categoria" size=23 ></td>
    </tr>
    <tr> 
        <td><div align="right"><strong>C&oacute;digo</strong></div></td>
        <td colspan="2"><?php
                include "includes/conect.php" ;
                //parametros iniciales que son los que cambiamos
                //conectar con el servidor de BD
                $mysqli=conectarServidor();
                //conectar con la tabla (ej. use datos;)
                //sentencia SQL    tblusuarios.IdUsuario,
                $sql="	select max(Id_cat_prod) as valor from cat_prod;";						
                $result = $mysqli->query($sql);
                //$filas=mysql_num_rows($result);
				$row= $result->fetch_row();
                $valor=$row[0];	
                echo'<input name="cod_cat" type="text" size=23 readonly value='.($valor+1).'>';   	
                $result->free();
/* cerrar la conexión */
$mysqli->close();//Cerrar la conexion
            ?>    	</td>
    </tr>
    <tr> 
        <td></td>
        <td width="66"><div align="center">
          <button class="button" style="vertical-align:middle" onclick="return Enviar(this.form)"><span>Guardar</span></button>
        </div></td>
        <td width="72"><div align="center">
          <button class="button" style="vertical-align:middle" type="reset"><span>Borrar</span></button>
        </div></td>
    </tr>
    <tr>
        <td colspan="3"><div align="center">&nbsp;</div></td>
    </tr>
    <tr>
        <td colspan="3"><div align="center">&nbsp;</div></td>
    </tr>
    <tr> 
        <td colspan="3">
        <div align="center"><button class="button1" id="back" style="vertical-align:middle" onClick="history.back()"> <span>VOLVER</span></button></div>        </td>
    </tr>
</table>
</form>
</div>
</body>
</html>

