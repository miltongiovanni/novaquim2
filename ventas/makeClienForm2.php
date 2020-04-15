<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
	<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
	<title>Creaci&oacute;n de Clientes</title>
	<meta charset="utf-8">
	<script  src="scripts/validar.js"></script>
	<script  src="scripts/block.js"></script>	
	<script >
	document.onkeypress = stopRKey; 
	</script>

</head>
<body>
<div id="contenedor">
<div id="saludo"><strong>CREACI&Oacute;N DE CLIENTES</strong></div>
<?php
foreach ($_POST as $nombre_campo => $valor) 
{ 
	$asignacion = "\$".$nombre_campo."='".$valor."';"; 
	//echo $nombre_campo." = ".$valor."<br>";  
	eval($asignacion); 
}  
include "includes/conect.php";
$link=conectarServidor();
$qry="select Id_ciudad, ciudad from ciudades where Id_ciudad=$ciudad_cli";
$result=mysqli_query($link,$qry);
$row=mysqli_fetch_array($result);
$ciudad=$row['ciudad'];

?>

<form name="form2" method="POST" action="makeClien2.php">
<table align="center" border="0">
  <tr> 
    <td width="81"><div align="right"><strong>Cliente</strong></div></td>
    <td colspan="4"><input type="text" name="Cliente" size=60 id="Cliente" maxlength="60"></td>
    <td width="118" ><div align="right"><b>NIT o C&eacute;dula</b></div></td>
    <td width="94" ><input type="text" name="NIT" size=15 id="NIT" readonly value="<?php echo $nit ?>"></td>
    <td width="118"><div align="right"><strong>Actividad</strong></div></td>
    <td width="94" colspan="3"><select name="IdCat" id="IdCat">
      <?php
            
            $link=conectarServidor();
            $qry="select * from cat_clien";	
            $result=mysqli_query($link,$qry);
            echo '<option value="1" selected>Conjunto Residencial</option>';
            while($row=mysqli_fetch_array($result))
            {
                if ($row['Id_cat_cli']!=1)
                    echo '<option value="'.$row['Id_cat_cli'].'">'.$row['Des_cat_cli'].'</option>';
            }
            mysqli_close($link);
        ?>
    </select></td>
  </tr>
  <tr> 
    <td><div align="right"><b>Direcci&oacute;n</b></div></td>
    <td colspan="4"><input type="text"  maxlength="50" name="Direccion" size=60 id="Direccion" ></td>
    <td ><div align="right"><b>Ciudad</b></div></td>
    <td ><input type="text" name="cod_ciudad" size=15 id="NIT" readonly value="<?php echo $ciudad ?>"></td>
    <td><div align="right"><b>Celular</b></div></td>
    <td> <input type="text" name="celular" maxlength="10" size=15 onKeyPress="return aceptaNum(event)" id="celular"   value=""></td>
    </tr>
  <tr> 
    <td><div align="right"><b>Contacto</b></div></td>
    <td colspan="4"><input type="text"  maxlength="34" name="Contacto" size=60 id="Contacto" ></td>
    <td><div align="right"><strong>Tel&eacute;fono</strong></div></td>
    <td><input type="text" name="Tel1" maxlength="7" size=15 onKeyPress="return aceptaNum(event)" id="Tel1" ></td>
    <td><div align="right"><strong>Fax</strong></div></td>
    <td><input type="text" name="Fax" maxlength="7" size=15 onKeyPress="return aceptaNum(event)" id="Fax"   value=""></td>
  </tr>
  <tr> 
    <td><div align="right"><strong>Cargo</strong></div></td>
    <td colspan="4"><input type="text"  maxlength="34" name="Cargo" size=60></td>
    <td colspan="1" align="right"><div align="right"><strong>Vendedor</strong></div></td>
    <td colspan="3"><?php
            $link=conectarServidor();
            echo'<select name="vendedor">';
            $result=mysqli_query($link,"select Id_personal , nom_personal FROM personal where Activo=1;");
            echo '<option selected value="">------------------------------------</option>';
            while($row=mysqli_fetch_array($result)){
                echo '<option value='.$row['Id_personal'].'>'.$row['nom_personal'].'</option>';
            }
            echo'</select>';
            mysqli_close($link);
    ?>	  </td>
  </tr>
  <tr> 
    <td colspan="2"><div align="right"><strong>Aplica Retefuente</strong></div></td>
    <td width="77"><select name="Rete_fte" >
    <?php
        if ($tip_cli==1)
         echo '<option value="0" >No</option>
                <option value="1" selected>Si</option>';
        else
        echo '<option value="0" selected>No</option>
                <option value="1">Si</option>';
    ?>
    </select></td>  
    <td colspan="2"><div align="right"><strong>Autoretenedor IVA</strong></div></td>
    <td><select name="Rete_iva" >
    <option value="0" selected>No</option>
    <option value="1">Si</option>
  	</select></td>
    <td  colspan="2"><div align="right"><strong>Autoretenedor ICA</strong></div></td>               
  <td>
<select name="Rete_ica" >
            <option value="0" selected>No</option>
            <option value="1">Si</option>               
    </select>        </td>                       
  </tr>
  <tr><td><input name="Estado" type="hidden" value="A"></td><td width="90"><input name="ciudad_cli" type="hidden" value="<?php echo $ciudad_cli; ?>"></td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
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
        <div align="center"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="VOLVER"></div>                    </td>
    </tr>
</table>
</form>
</div>
</body>
</html>

