<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
	<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
	<title>Creación de Tipo de Cliente</title>
	<meta charset="utf-8">
	<script type="text/javascript" src="scripts/validar.js"></script>
	<script type="text/javascript" src="scripts/block.js"></script>	
		<script type="text/javascript">
	document.onkeypress = stopRKey; 
	</script>

</head>
<body>
<div id="contenedor">
<div id="saludo"><strong>CREACIÓN DE TIPO DE CLIENTE</strong></div>

<table  border="0" align="center" class="table2" cellspacing="0">
  <form name="form2" method="POST" action="makeCategoria_Cli.php">
    <tr> 
        <td width="93"><div align="right"><b>Descripción</b></div></td>
        <td colspan="2"><input type="text" name="categoria" size=34 ></td>
    </tr>
    <tr> 
        <td><div align="right"><strong>Código</strong></div></td>

        <td colspan="2"><?php
                include "includes/conect.php" ;
                $link=conectarServidor();
                $sql="select max(Id_cat_cli) as Codigo from cat_clien;";						
                $result = mysqli_query($link, $sql);
                $row= mysqli_fetch_row($result);
				$valor=$row[0];	
                echo'<input name="cod_cat_cli" type="text" size=34 readonly value='.($valor+1).'>';   	
                mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
            ?>    	</td>
    </tr>
    <tr>
        <td colspan="3"><div align="center">&nbsp;</div></td>
    </tr>
    <tr><td>&nbsp;</td>
        <td  width="120"><div align="center"><input type="button" value="Guardar" onClick="return Enviar(this.form);"></div></td>
        <td width="120"><div align="center"><input type="reset" value="Reiniciar"></div></td>
    </tr>
    </form>
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
</div>
</body>
</html>

