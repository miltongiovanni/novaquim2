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
<?php
foreach ($_POST as $nombre_campo => $valor) 
{ 
	include "includes/conect.php";
	$asignacion = "\$".$nombre_campo."='".$valor."';"; 
	//echo $nombre_campo." = ".$valor."<br>";  
	eval($asignacion); 
}  
	$link=conectarServidor();
	$qry="select * from cat_prod where Id_cat_prod=$Cate";	
	$result=mysqli_query($link,$qry);
	$row=mysqli_fetch_array($result);
	$qry1="SELECT MAX(Cod_produc) as Cod from productos where Id_cat_prod=$Cate;";	
	$result1=mysqli_query($link,$qry1);
	$row1=mysqli_fetch_array($result1);
	$Codigo=$row1['Cod']+1;
	mysqli_free_result($result);
	mysqli_free_result($result1);
/* cerrar la conexión */
mysqli_close($link);
?> 
<form name="form2" method="POST" action="makeProd.php">
<table  align="center" border="0" cellspacing="0" width="52%">
 <tr>
        <td colspan="4"><div align="center">&nbsp;</div></td>
    </tr>
    <tr> 
        <td width="9%"><div align="right"><strong>C&oacute;digo</strong></div></td>
        <td colspan="2"><input type="text" name="codigo" size=20  ReadOnly  onKeyPress="return aceptaNum(event)" value="<?php echo $Codigo; ?>"></td>
        <td colspan="3"><div align="right"><b>Categor&iacute;a</b></div></td>
        <td colspan="2"><?php echo'<input name="Categoria" type="text" readonly="true" value="'.$row['Des_cat_prod'].'" size="29">';?></td> 
        <?php echo'<input name="Cate" type="hidden" readonly="true" value="'.$row['Id_cat_prod'].'" size="34"/>';?>    
    </tr>
    <tr> 
        <td><div align="right"><b>Descripci&oacute;n</b></div></td>
        <td colspan="7"><input type="text" name="producto" size=93 value=""></td>
    </tr>
    <tr> 
        <td><div align="right"><strong>Tipo</strong></div></td>
            <td colspan="7"><select name="cuenta" id="cuenta">
              <option value="" selected>-------------------------------------------------------------------------------------------------------------------------------------------</option>
              <option value="412046">Detergente, Suavizante, Ambientador, Jabón, Shampoo, Lavaloza, Desengrasante, Multiusos</option>
              <option value="412047">Ceras, Removedor, Limpiadores, Blanqueador, Limpiavidrios, Lustramuebles, Creolina</option>
            </select></td>
    </tr>
    <tr>
    	<td colspan="1"><div align="center"><strong>&nbsp;</strong></div></td>
        <td width="9%" colspan="1"><div align="center"><strong>Densidad M&iacute;nima</strong></div></td>
        <td width="15%" colspan="1"><div align="center"><strong>Densidad M&aacute;xima</strong></div></td>
        <td width="8%" colspan="1"><div align="center"><strong>pH M&iacute;nimo</strong></div></td>
        <td width="6%" colspan="1"><div align="center"><strong>pH M&aacute;ximo</strong></div></td>
        <td width="17%" colspan="1"><div align="center"><strong>Fragancia</strong></div></td>
        <td width="16%" colspan="1"><div align="center"><strong>Color</strong></div></td>
        <td width="20%" colspan="1"><div align="center"><strong>Apariencia</strong></div></td>
        
    </tr>
    <tr>
    	<td colspan="1"><div align="center"><strong>&nbsp;</strong></div></td>
        <td width="9%" colspan="1"><div align="center"><strong><input type="text" name="den_min" size=5 onKeyPress="return aceptaNum(event)"></strong></div></td>
        <td width="15%" colspan="1"><div align="center"><strong><input type="text" name="den_max" size=5 onKeyPress="return aceptaNum(event)"></strong></div></td>
        <td width="8%" colspan="1"><div align="center"><strong><input type="text" name="ph_min" size=5 onKeyPress="return aceptaNum(event)"></strong></div></td>
        <td width="6%" colspan="1"><div align="center"><strong><input type="text" name="ph_max" size=5 onKeyPress="return aceptaNum(event)"></strong></div></td>
        <td width="17%" colspan="1"><div align="center"><strong><input type="text" name="fragancia" size=12></strong></div></td>
        <td width="16%" colspan="1"><div align="center"><strong><input type="text" name="color" size=12></strong></div></td>
        <td width="20%" colspan="1"><div align="center"><strong><input type="text" name="Apariencia" size=12></strong></div></td>
      <tr>
        <td colspan="4"><div align="center">&nbsp;</div></td>
    </tr>  
    </tr>
    <tr><td></td>
        <td colspan="4"><div align="center"><input type="button" value="  Crear  " onClick="return Enviar(this.form);"></div></td>
        <td colspan="3" align="center"><input type="reset" value="Borrar"></td>
    </tr>
    
    <tr>
        <td colspan="4"><div align="center">&nbsp;</div></td>
    </tr>

</table>
</form>
<div align="center"><input type="button" class="resaltado" onClick="history.back()" value="  VOLVER  "></div>
</div>
</body>
</html>

