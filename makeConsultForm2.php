<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
	<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
	<title>Creaci&oacute;n de Clientes</title>
	<meta charset="utf-8">
	<script type="text/javascript" src="scripts/validar.js"></script>
	<script type="text/javascript" src="scripts/block.js"></script>	
	<script type="text/javascript">
	document.onkeypress = stopRKey; 
	</script>

</head>
<?php
foreach ($_POST as $nombre_campo => $valor) 
{ 
	$asignacion = "\$".$nombre_campo."='".$valor."';"; 
	echo $nombre_campo." = ".$valor."<br>";  
	eval($asignacion); 
}  
include "includes/conect.php";
$link=conectarServidor();
$bd="novaquim";
$qry="select Id_ciudad, ciudad from ciudades where Id_ciudad=$ciudad_cli";
$result=mysql_db_query($bd,$qry);
$row=mysql_fetch_array($result);
$ciudad=$row['ciudad'];

?>
<body>
<div id="contenedor">
<div id="saludo"><strong>CREACI&Oacute;N DE DISTRIBUIDORAS </strong></div>
<form name="form2" method="POST" action="makeConsult2.php">
<table align="center">
 <tr>
        <td colspan="9"><div align="center">&nbsp;</div></td>
    </tr>
  <tr> 
    <td><div align="right"><strong>Distribuidora:</strong></div></td>
    <td colspan="1"><input type="text" name="Cliente" size=60 id="Cliente" maxlength="60"></td>
        <td ><div align="right"><b>C&eacute;dula:</b></div></td>
    <td ><input type="text" name="NIT" size=15 id="NIT" readonly value="<?php echo $nit ?>"></td>
    <td><div align="right"><strong>Tel&eacute;fono:</strong></div></td>
        <td><input type="text" name="Tel1" maxlength="7" size=15 onKeyPress="return aceptaNum(event)" id="Tel1" ></td>
        <td><div align="right"><strong>Fax:</strong></div></td>
        <td><input type="text" name="Fax" maxlength="7" size=15 onKeyPress="return aceptaNum(event)" id="Fax"   value=""></td>
  </tr>
  <tr> 
    <td><div align="right"><b>Direcci&oacute;n:</b></div></td>
        <td colspan="1"><input type="text"  maxlength="50" name="Direccion" size=60 id="Direccion" ></td>
        <td ><div align="right"><b>Ciudad:</b></div></td>
    <td ><input type="text" name="cod_ciudad" size=15 id="NIT" readonly value="<?php echo $ciudad ?>"></td>
    <td><div align="right"><b>Localidad:</b></div></td>
        <td colspan="3"> <?php
				//include "conect.php";
				$link=conectarServidor();
				echo'<select name="localidad">';
				$result=mysql_db_query("novaquim","select Id_localidad, localidad from localidad where Id_city=$ciudad_cli;");
				$total=mysql_num_rows($result);
				echo '<option selected value="">------------------------------------</option>';
				while($row=mysql_fetch_array($result)){
					echo '<option value='.$row['Id_localidad'].'>'.$row['localidad'].'</option>';
				}
				echo'</select>';
				mysql_close($link);
	   ?>	  </td>
    </tr>
  <tr> 
    <td><div align="right"><b>Contacto:</b></div></td>
        <td colspan="1"><input type="text"  maxlength="34" name="Contacto" size=60 id="Contacto" ></td>
        <td colspan="2" align="right"><div align="right"><strong>Directora de Zona:</strong></div></td>
     <td colspan="4"><?php
				//include "conect.php";
				$link=conectarServidor();
				echo'<select name="vendedor">';
				$result=mysql_db_query("novaquim","select Id_personal , nom_personal FROM personal where Activo=1 and cargo_personal=9");
				$total=mysql_num_rows($result);
				echo '<option selected value="">------------------------------------</option>';
				while($row=mysql_fetch_array($result)){
					echo '<option value='.$row['Id_personal'].'>'.$row['nom_personal'].'</option>';
				}
				echo'</select>';
				mysql_close($link);
	   ?>	  </td> 
    </tr>
   <tr> 
    
       
    </tr>
  
  <tr><td><input name="Estado" type="hidden" value="A">
    <input type="hidden" name="Rete_fte" value="0">
    <input type="hidden" name="Rete_iva" value="0">
    <input type="hidden" name="Rete_ica" value="0">
    <input type="hidden"  name="Cargo" value="Distribuidora">
    <input type="hidden" name="IdCat" value="13"></td><td><input name="ciudad_cli" type="hidden" value="<?php echo $ciudad_cli; ?>"></td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
    <tr> 
        <td colspan="9" align="center">
            <input type="button" value="      Crear      " onClick="return Enviar(this.form);" >&nbsp;&nbsp;
            <input type="reset" value="Restablecer">            </td>
    </tr>
    <tr>
        <td colspan="9"><div align="center">&nbsp;</div></td>
    </tr>
    <tr> 
        <td colspan="9">
        <div align="center"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="VOLVER"></div></td>
    </tr>
</table>
</form>
</div>
</body>
</html>

