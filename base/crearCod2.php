<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
	<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
	<title>Creaci&oacute;n de C&oacute;digo Gen&eacute;rico</title>
	<meta charset="utf-8">
	<script type="text/javascript" src="scripts/validar.js"></script>
	<script type="text/javascript" src="scripts/block.js"></script>	
    <script type="text/javascript">
	document.onkeypress = stopRKey; 
	</script>
</head>
<body>
<div id="contenedor">
<div id="saludo"><strong>CREACI&Oacute;N DE C&Oacute;DIGO GEN&Eacute;RICO</strong></div>
<?php

foreach ($_POST as $nombre_campo => $valor) 
{ 
	include "includes/conect.php";
	$asignacion = "\$".$nombre_campo."='".$valor."';"; 
	//echo $nombre_campo." = ".$valor."<br>";  
	eval($asignacion); 
}  
	$link=conectarServidor();
	$qry1="select Cod_produc, Nom_produc, Id_cat_prod from productos where Cod_produc=$Prod;";	
	$result1=mysqli_query($link, $qry1);
	$row1=mysqli_fetch_array($result1);
?>
<form name="form2" method="POST" action="makeCod.php">
<table  align="center" border="0" class="table2" width="50%" cellspacing="0">
	<tr> 
        <td><div align="right"><b>Producto</b></div></td>
        <td width="57%"><?php echo'<input name="Producto" type="text" readonly="true" value="'.$row1['Nom_produc'].'" size="40"/>';?></td> 
        <?php 
			echo'<input name="CodCat" type="hidden" readonly="true" value="'.$row1['Id_cat_prod'].'" size="34"/>';
			echo'<input name="CodProd" type="hidden" readonly="true" value="'.$row1['Cod_produc'].'" size="34"/>';
		?>
    </tr>
    <tr> 
        <td><div align="right"><strong>Medida</strong></div></td>
        <td>
            <select name="IdMedida">
                <?php
                    $qry="select * from medida order by des_medida";	
                    $result=mysqli_query($link,$qry);
                    echo '<option value="" selected></option>';
                    while($row=mysqli_fetch_array($result))
                    {
                          echo '<option value="'.$row['Id_medida'].'">'.$row['des_medida'].'</option>';
                    }
					mysqli_free_result($result);
/* cerrar la conexi�n */
mysqli_close($link);
                ?>
          </select>    	
       </td>          
    </tr>
    <tr> 
        <td><div align="right"><b>Descripci&oacute;n</b></div></td>
        <td><input type="text" name="Generico" size=40 ></td>
    </tr>
    <tr> 
        <td><div align="right"><strong>Precio F&aacute;brica</strong></div></td>
        <td><input type="text" name="fabrica" size=10   onKeyPress="return aceptaNum(event)" maxlength="6"></td>
    </tr>
    <tr> 
        <td colspan="2">
            <div align="center">
              <input type="button" value="Guardar" onClick="return Enviar(this.form);">
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <input type="reset" value="Reiniciar">    
            </div></td>
    </tr>
    
    <tr>
        <td colspan="2"><div align="center">&nbsp;</div></td>
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

