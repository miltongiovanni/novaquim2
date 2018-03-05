<?php
include "includes/valAcc.php";
include "includes/conect.php";
?>
<!DOCTYPE html>
<html>
<head>
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
<meta charset="utf-8">
<title>Actualizar datos del Cliente</title>
<script type="text/javascript" src="scripts/validar.js"></script>
<script type="text/javascript" src="scripts/block.js"></script>
	<script type="text/javascript">
	document.onkeypress = stopRKey; 
	</script>
</head>

<body>
<div id="contenedor">
<div id="saludo"><strong>ACTUALIZACI&Oacute;N DE CLIENTE DE COTIZACI&Oacute;N</strong></div>

<?php
	  $link=conectarServidor();
	  $cliente_cot=$_POST['cliente_cot'];
	  $qry="select Id_cliente, Nom_clien, Contacto, Cargo, Tel_clien, Fax_clien, Cel_clien, Dir_clien, Eml_clien, Id_cat_clien, Des_cat_cli, Ciudad_clien , ciudad, cod_vend, nom_personal from clientes_cotiz, ciudades, cat_clien, personal where Ciudad_clien=Id_ciudad and Id_cat_clien=Id_cat_cli and cod_vend=Id_personal and Id_cliente='$cliente_cot'";
	  $result=mysqli_query($link, $qry);
	  $row=mysqli_fetch_array($result);
	  $city=$row['Ciudad_clien'];
?>

<form id="form1" name="form1" method="post" action="updateClienCot.php">
<table align="center">
  <tr> 
    <td><div align="right"><strong>Cliente</strong></div></td>
    <td colspan="3"><input type="text" name="cliente" size=60 id="Cliente"
    <?php
    echo 'value="'.$row['Nom_clien'].'"';
    ?>
     maxlength="60"></td>
    <td><div align="right"><b>Ciudad</b></div></td>
    <td><?php
        $Idcity=$row['Ciudad_clien'];
        $city=$row['ciudad'];
        echo'<select name="ciudad_cli">';
        $qry1="select Id_ciudad, ciudad from ciudades where Id_ciudad<>$Idcity order by ciudad;";
        $result1=mysqli_query($link, $qry1);
        echo '<option selected value="'.$Idcity.'">'.$city.'</option>';
        while($row1=mysqli_fetch_array($result)){
            echo '<option value='.$row1['Id_ciudad'].'>'.$row1['ciudad'].'</option>';
        }
        echo'</select>';
        ?></td>
  </tr>
  <tr> 
    <td><div align="right"><b>Direcci&oacute;n</b></div></td>
    <td colspan="3"><input type="text"  maxlength="50" name="Direccion" size=60 id="Direccion"
    <?php 
    echo 'value="'.$row['Dir_clien'].'"';
    ?>
    ></td>
    <td><div align="right"><strong>Tel&eacute;fono</strong></div></td>
    <td><input type="text" name="Tel1" maxlength="7" size=15 onKeyPress="return aceptaNum(event)" id="Tel1"
    <?php
    echo 'value="'.$row['Tel_clien'].'"';
    ?>
    ></td>
  </tr>
  <tr> 
    <td><div align="right"><b>Contacto</b></div></td>
    <td colspan="3"><input type="text"  maxlength="34" name="Contacto" size=60 id="Contacto"
        <?php
    echo 'value="'.$row['Contacto'].'"';
    ?>
    ></td>
    <td><div align="right"><strong>Fax</strong></div></td>
    <td><input type="text" name="Fax" size=15 onKeyPress="return aceptaNum(event)" id="Fax" 
	<?php
    echo 'value="'.$row['Fax_clien'].'"';
    ?>></td>
  </tr>
  <tr> 
    <td><div align="right"><strong>Cargo</strong></div></td>
    <td colspan="3"><input type="text"  maxlength="34" name="Cargo" size=60
    <?php
    echo 'value="'.$row['Cargo'].'"';
    ?>
    ></td>
    <td><div align="right"><strong>Celular</strong></div></td>
    <td><input type="text" name="celular" size=15 onKeyPress="return aceptaNum(event)" id="Fax"   
     <?php
    echo 'value="'.$row['Cel_clien'].'"';
    ?>
    ></td>
  </tr>
  <tr>
    <td><div align="right"><strong>e-mail</strong></div></td>
    <td colspan="3"><input type="text" name="email" onChange="TestMail(document.form2.Email.value)" size=60
    <?php
    echo 'value="'.$row['Eml_clien'].'"';
    ?>
    ></td>
    <td><div align="right"><strong>Actividad</strong></div></td>
    <td colspan="2">
    <select name="IdCat" id="IdCat">
	<?php  
		$catcli=$row['Id_cat_clien'];
        $catclin=$row['Des_cat_cli'];
        $qry2="select Id_cat_cli, Des_cat_cli from cat_clien where Id_cat_cli<>$catcli order by Des_cat_cli";
        $result2=mysqli_query($link,$qry2);
        echo '<option selected value="'.$catcli.'">'.$catclin.'</option>';
        while($row2=mysqli_fetch_array($result2))
        {
                echo '<option value="'.$row2['Id_cat_cli'].'">'.$row2['Des_cat_cli'].'</option>';
        }
    ?>
    </select></td>													
  </tr>
  <tr> 
    <td><div align="right"><strong>Vendedor</strong></div></td>
    <td colspan="1">
	<?php
	  $vend=$row['cod_vend'];
      $vendn=$row['nom_personal'];
	  echo'<select name="vendedor">';
      $qry3="select Id_personal , nom_personal FROM personal where Activo=1 and Id_personal<>$vend order by nom_personal;";
	  $result3=mysqli_query($link,$qry3);
      echo '<option selected value="'.$vend.'">'.$vendn.'</option>';
	  while($row3=mysqli_fetch_array($result3)){
		  echo '<option value='.$row3['Id_personal'].'>'.$row3['nom_personal'].'</option>';
	  }
	  echo'</select>';
	  mysqli_close($link);
    ?>
    </td>
  </tr>
  <tr> 
    <td colspan="6" align="center"><input type="hidden" value="<?php echo $cliente_cot; ?>" name="cliente_cot" >  <input type="button" class="formatoBoton1" onClick="return Enviar(this.form);" value="     Actualizar     " >&nbsp;&nbsp;</td>
  </tr>
  <tr>
    <td colspan="6"><div align="center">&nbsp;</div></td>
  </tr>
</table>
</form>

<div align="center"><input type="button" class="resaltado" onClick="history.back()" value="  VOLVER  "></div>
</div>
</body>
</html>
