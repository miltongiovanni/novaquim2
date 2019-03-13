<?php
include "includes/valAcc.php";
include "includes/conect.php";
?>
<!DOCTYPE html>
<html>
<head>
	<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
	<title>Creaci&oacute;n de Presentaci&oacute;n de Productos</title>
	<meta charset="utf-8">
	<script type="text/javascript" src="scripts/validar.js"></script>
	<script type="text/javascript" src="scripts/block.js"></script>	
		<script type="text/javascript">
	document.onkeypress = stopRKey; 
	</script>
</head>
<body>
<div id="contenedor">
<div id="saludo"><strong>CREACI&Oacute;N DE PRESENTACI&Oacute;N DE PRODUCTO</strong></div>
<form name="form2" method="POST" action="makeMedida.php">
<table border="0" align="center" cellspacing="2" cellpadding="0">
    <tr> 
        <td><div align="right"><strong>Presentaci&oacute;n</strong></div></td>
		<td><input type="text" name="ProdPresen" size=70 ></td>
    </tr>
    <tr> 
        <td><div align="right"><strong>Producto</strong></div></td>
        <td>
            <select name="IdProducto">
                <?php
                    $link=conectarServidor();
                    $qry="select * from productos order by Nom_produc";	
                    $result=mysqli_query($link,$qry);
                    echo '<option value="" selected > </option>';
                    while($row=mysqli_fetch_array($result))
                    {
                          echo '<option value="'.$row['Cod_produc'].'">'.$row['Nom_produc'].'</option>';
                    }
					mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
                ?>
          </select>          </td>          
    </tr>
    <tr> 
        <td><div align="right"><strong>Medida</strong></div></td>
        <td>
            <select name="IdMedida">
                <?php
                    $link=conectarServidor();
                    $qry="select * from medida order by des_medida";	
                    $result=mysqli_query($link,$qry);
                    echo '<option value="" selected></option>';
                    while($row=mysqli_fetch_array($result))
                    {
                          echo '<option value="'.$row['Id_medida'].'">'.$row['des_medida'].'</option>';
                    }
					mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
                ?>
          </select>    	
       </td>          
    </tr>
    <tr> 
        <td><div align="right"><strong>Envase</strong></div></td>
        <td>
            <select name="IdEnvase">
                <?php
                    $link=conectarServidor();
                    $qry="select * from envase order by Nom_envase";	
                    $result=mysqli_query($link, $qry);
                    echo '<option value="" selected></option>';
                    while($row=mysqli_fetch_array($result))
                    {
                          echo '<option value="'.$row['Cod_envase'].'">'.$row['Nom_envase'].'</option>';
                    }
					mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
                ?>
          </select>    	
    	</td>          
    </tr>
    <tr> 
        <td><div align="right"><strong>Tapa</strong></div></td>
        <td>
            <select name="IdTapa">
                <?php
                    $link=conectarServidor();
                    $qry="select * from tapas_val order by Nom_tapa";	
                    $result=mysqli_query($link, $qry);
                    echo '<option value="" selected></option>';
                    while($row=mysqli_fetch_array($result))
                    {
                          echo '<option value="'.$row['Cod_tapa'].'">'.$row['Nom_tapa'].'</option>';
                    }
					mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
                ?>
          	</select>    	
    	</td>          
    </tr>
    <tr> 
        <td><div align="right"><strong>Etiqueta</strong></div></td>
        <td>
            <select name="Etiq">
                <?php
                    $link=conectarServidor();
                    $qry="select Cod_etiq, Nom_etiq from etiquetas order by Nom_etiq;";	
                    $result=mysqli_query($link,$qry);
                    echo '<option value="" selected></option>';
                    while($row=mysqli_fetch_array($result))
                    {
                          echo '<option value="'.$row['Cod_etiq'].'">'.$row['Nom_etiq'].'</option>';
                    }
					mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
                ?>
          	</select>    	
    	</td>          
    </tr>
    <tr> 
        <td><div align="right"><strong>C&oacute;digo General</strong></div></td>
        <td>
            <select name="IdCodAnt">
                <?php
                    $link=conectarServidor();
                    $qry="select * from precios order by producto";	
                    $result=mysqli_query($link,$qry);
                    echo '<option value="" selected></option>';
                    while($row=mysqli_fetch_array($result))
                    {
                          echo '<option value="'.$row['codigo_ant'].'">'.$row['producto'].'</option>';
                    }
					mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
                ?>
          </select>    	</td>          
    </tr>
    <tr> 
        <td><div align="right"><strong>Stock M&iacute;nimo</strong></div></td>
		<td><input type="text" name="Stock" onKeyPress="return aceptaNum(event)" size=20 ></td>
    </tr>
    <tr><td><div align="right"><strong>Cotizar</strong></div></td>
            <td><select name="Cotiza" >
        <option value="1" selected>No</option>
        <option value="0">Si</option>
      </select></td>
    </tr>
    <tr> 
        <td colspan="2">
            <div align="center"><input type="button" value="  Crear  " onClick="return Enviar(this.form);">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" value=" Borrar "></div>
        </td>
    </tr>
    <tr> 
        <td colspan="2">&nbsp;</td>
    </tr>
    <tr> 
        <td colspan="2"><div align="center"><input type="button" class="resaltado" onClick="history.back()" value="  VOLVER  "></div></td>
    </tr>

</table> 
</form>       
</div>
</body>
</html>

