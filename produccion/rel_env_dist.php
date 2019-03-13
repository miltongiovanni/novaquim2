<?php
include "includes/valAcc.php";
include "includes/conect.php";
?>
<!DOCTYPE html>
<html>
<head>
	<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
	<title>Creaci&oacute;n de Relaci&oacute;n de Materia Prima con Producto de Distribuci&oacute;n</title>
	<meta charset="utf-8">
	<script type="text/javascript" src="scripts/validar.js"></script>
	<script type="text/javascript" src="scripts/block.js"></script>	
		<script type="text/javascript">
	document.onkeypress = stopRKey; 
	</script>
</head>
<body>
<div id="contenedor">
<div id="saludo"><strong>RELACI&Oacute;N MATERIA PRIMA CON PRODUCTO DE DISTRIBUCI&Oacute;N</strong></div>
<form name="form2" method="POST" action="make_env_dist.php">
<table border="0" align="center" cellspacing="2" cellpadding="0">
    <tr> 
        <td width="152"><div align="right"><strong>Materia Prima</strong></div></td>
        <td width="459"><select name="Cod_MP">
          <?php
                    $link=conectarServidor();
					$result=mysqli_query($link,"select * from env_dist");
					echo '<option selected value="">---------------------------------------</option>';
					while($row=mysqli_fetch_array($result)){
						echo '<option value='.$row['Id_env_dist'].'>'.$row['Producto'].'</option>';
					}
					echo'</select>';
					mysqli_close($link);
                ?>
        </select></td>          
    </tr>
    <tr> 
        <td><div align="right"><strong>Medida</strong></div></td>
        <td>
            <select name="IdMedida">
                <?php
                    $link=conectarServidor();
                    $qry="select * from medida";	
                    $result=mysqli_query($link,$qry);
                    echo '<option value="" selected></option>';
                    while($row=mysqli_fetch_array($result))
                    {
                          echo '<option value="'.$row['Id_medida'].'">'.$row['des_medida'].'</option>';
                    }
					mysqli_close($link);
                ?>
          </select>       </td>          
    </tr>
    <tr> 
        <td><div align="right"><strong>Envase</strong></div></td>
        <td>
            <select name="IdEnvase">
                <?php
                    $link=conectarServidor();
                    $qry="select * from envase";	
                    $result=mysqli_query($link,$qry);
                    echo '<option value="" selected></option>';
                    while($row=mysqli_fetch_array($result))
                    {
                          echo '<option value="'.$row['Cod_envase'].'">'.$row['Nom_envase'].'</option>';
                    }
					mysqli_close($link);
                ?>
          </select>    	</td>          
    </tr>
    <tr> 
        <td><div align="right"><strong>Tapa</strong></div></td>
        <td>
            <select name="IdTapa">
                <?php
                    $link=conectarServidor();
                    $qry="select * from tapas_val";	
                    $result=mysqli_query($link,$qry);
                    echo '<option value="" selected></option>';
                    while($row=mysqli_fetch_array($result))
                    {
                          echo '<option value="'.$row['Cod_tapa'].'">'.$row['Nom_tapa'].'</option>';
                    }
					mysqli_close($link);
                ?>
          	</select>    	</td>          
    </tr>
    <tr> 
        <td><div align="right"><strong>C&oacute;digo Distribuci&oacute;n</strong></div></td>
        <td>
            <select name="Cod_dist">
                <?php
                    $link=conectarServidor();
                    $qry="select * from distribucion order by Producto";	
                    $result=mysqli_query($link,$qry);
                    echo '<option value="" selected></option>';
                    while($row=mysqli_fetch_array($result))
                    {
                          echo '<option value="'.$row['Id_distribucion'].'">'.$row['Producto'].'</option>';
                    }
					mysqli_close($link);
                ?>
          </select>    	</td>          
    </tr>
    <tr><td></td> 
        <td>
            <div align="center"><input type="button" value="Guardar" onClick="return Enviar(this.form);">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" value="  Borrar  "></div>        </td>
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

