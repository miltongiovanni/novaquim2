<?php
include "includes/valAcc.php";
include "includes/conect.php";
?>
<!DOCTYPE html>
<html>
<head>
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
<title>Creaci&oacute;n de Clientes para Cotizaci&oacute;n</title>
<meta charset="utf-8">
<script type="text/javascript" src="scripts/validar.js"></script>
<script type="text/javascript" src="scripts/block.js"></script>	
<script type="text/javascript">
document.onkeypress = stopRKey; 
</script>
</head>

<body>
<div id="contenedor">
<?php
foreach ($_POST as $nombre_campo => $valor) 
{ 
  $asignacion = "\$".$nombre_campo."='".$valor."';"; 
  echo $nombre_campo." = ".$valor."<br>";  
  eval($asignacion); 
}    
$link=conectarServidor();
if (($crear==2)&&($CliExis == 1))
{ 

  $qryb="select Nom_clien, Contacto, Cargo, Tel_clien, Fax_clien, Cel_clien, Dir_clien, Eml_clien, Id_cat_clien, Ciudad_clien, cod_vend, desCatClien, ciudad, nom_personal from clientes, cat_clien, ciudades, personal where Nit_clien='$cliente' and Id_cat_clien=idCatClien and Ciudad_clien=Id_ciudad and cod_vend=Id_personal;";
  $resultb=mysqli_query($link,$qryb);
  $rowb=mysqli_fetch_array($resultb);
		
		/* echo '<form method="post" action="det_cotiza.php" name="form5" target="_blank">';
		  echo'<input name="Crear" type="hidden" value="5">';
		  echo'<input name="Destino" type="hidden" value="'.$Destino.'">';
		  echo'<input name="num_cotiza" type="hidden" value="'.$num_cotiza.'">';
		  echo '<input type="submit" name="Submit" value="Analizar" >'; 
		  echo '</form>';
		  echo'<script >
			  document.form5.submit();
			  </script>';  */

}
?>   
<div id="saludo"><strong>CREACI&Oacute;N DE CLIENTES PARA COTIZACI&Oacute;N</strong></div>
<?php
if (($crear==1)&&($CliExis==1))
{
?>
<form method="post" action="makeClienCotForm.php" name="form1">	
<table align="center" width="36%">
<tr>
  <td width="18%" align="right"><strong>Cliente</strong></td>
  <td colspan="3">
  <?php
  $link=conectarServidor();
  echo'<select name="cliente" id="combo">';
  if ($CliExis==0)
	$qry="select Id_cliente, Nom_clien from clientes_cotiz order BY Nom_clien;";
  else
	$qry="select Nit_clien as Id_cliente, Nom_clien from clientes where Nit_clien<>'0-0' and Estado='A' order by Nom_clien;";
  
  $result=mysqli_query($link, $qry);
  echo '<option selected value="">-----------------------------------------------------------------------------------</option>';
  while($row=mysqli_fetch_array($result))
  {
	  echo '<option value='.$row['Id_cliente'].'>'.$row['Nom_clien'].'</option>';
  }
  echo'</select>';
  ?>
  </td>
</tr>
<tr> 
<td colspan="2" align="right"><input name="crear" value="2"  type="hidden" ><input name="CliExis" value="1"  type="hidden" >
<input type="button" class="formatoBoton1" value=" Continuar " onClick="return Enviar(this.form);" ></td>
</tr>
</table>
</form>
<?php
}
?>
<?php
if ((($crear==1)&&($CliExis == 0))||($crear!=1))
{
	echo "estoy adentro";
?>

<form name="form2" method="POST" action="makeClienCot.php">
<table align="center">
  <tr> 
    <td><div align="right"><strong>Cliente</strong></div></td>
    <td colspan="3"><input type="text"  name="Cliente" size=60 id="Cliente"
    <?php
    if($CliExis==1)
    echo 'value="'.$rowb['Nom_clien'].'"';
    ?>
     maxlength="60"></td>
    <td><div align="right"><b>Ciudad</b></div></td>
    <td><?php
        
        echo'<select name="ciudad_cli">';
        if($CliExis == 1)
		{
			$city=$rowb['Ciudad_clien'];
        	$cityn=$rowb['ciudad'];
          	$qry1="select Id_ciudad, ciudad from ciudades where Id_ciudad<>$city order by ciudad;";
		 }
        else
          $qry1="select Id_ciudad, ciudad from ciudades order by ciudad;";
        $result=mysqli_query($link, $qry1);
        if($CliExis == 1)
          echo '<option selected value="'.$city.'">'.$cityn.'</option>';
        else
          echo '<option selected value="">------------------------------------</option>';
        while($row=mysqli_fetch_array($result)){
            echo '<option value='.$row['Id_ciudad'].'>'.$row['ciudad'].'</option>';
        }
        echo'</select>';
        ?></td>
  </tr>
  <tr> 
    <td><div align="right"><b>Direcci&oacute;n</b></div></td>
    <td colspan="3"><input type="text"  maxlength="60" name="Direccion" size=60 id="Direccion"
    <?php 
    if($CliExis == 1)
    echo 'value="'.$rowb['Dir_clien'].'"';
    ?>
    ></td>
    <td><div align="right"><strong>Tel&eacute;fono</strong></div></td>
    <td><input type="text" name="Tel1" maxlength="7" size=15 onKeyPress="return aceptaNum(event)" id="Tel1"
    <?php
    if($CliExis == 1)
    echo 'value="'.$rowb['Tel_clien'].'"';
    ?>
    ></td>
  </tr>
  <tr> 
    <td><div align="right"><b>Contacto</b></div></td>
    <td colspan="3"><input type="text"  maxlength="40" name="Contacto" size=60 id="Contacto"
        <?php
    if($CliExis == 1)
    echo 'value="'.$rowb['Contacto'].'"';
    ?>
    ></td>
    <td><div align="right"><strong>Fax</strong></div></td>
    <td><input type="text" name="Fax" size=15 onKeyPress="return aceptaNum(event)" id="Fax" 
	<?php
    if($CliExis == 1)
    echo 'value="'.$rowb['Fax_clien'].'"';
    ?>></td>
  </tr>
  <tr> 
    <td><div align="right"><strong>Cargo</strong></div></td>
    <td colspan="3"><input type="text"  maxlength="30" name="Cargo" size=60
    <?php
    if($CliExis == 1)
    echo 'value="'.$rowb['Cargo'].'"';
    ?>
    ></td>
    <td><div align="right"><strong>Celular</strong></div></td>
    <td><input type="text" name="celular" maxlength="11" size=15 onKeyPress="return aceptaNum(event)" id="Fax"   
     <?php
    if($CliExis == 1)
    echo 'value="'.$rowb['Cel_clien'].'"';
    ?>
    ></td>
  </tr>
  <tr>
    <td><div align="right"><strong>e-mail</strong></div></td>
    <td colspan="3"><input type="text" name="email" maxlength="30" onChange="TestMail(document.form2.Email.value)" size=60
    <?php
    if($CliExis == 1)
    echo 'value="'.$rowb['Eml_clien'].'"';
    ?>
    ></td>
    <td><div align="right"><strong>Actividad</strong></div></td>
    <td colspan="2">
    <select name="IdCat" id="IdCat">
	<?php  
		
		if($CliExis == 1){
		$catcli=$rowb['Id_cat_clien'];
        $catclin=$rowb['Des_cat_cli'];
          $qry2="select idCatClien, desCatClien from cat_clien where idCatClien<>$catcli order by desCatClien";}
        else
          $qry2="select idCatClien, desCatClien from cat_clien order by desCatClien";
        $result=mysqli_query($link,$qry2);
		if($CliExis == 1)
          echo '<option selected value="'.$catcli.'">'.$catclin.'</option>';
        else
		  echo '<option value="" selected>-----------------------</option>';
        while($row=mysqli_fetch_array($result))
        {
                echo '<option value="'.$row['Id_cat_cli'].'">'.$row['Des_cat_cli'].'</option>';
        }
    ?>
    </select></td>													
  </tr>
  <tr> 
    <td><div align="right"><strong>Vendedor</strong></div></td>
    <td colspan="1">
	<?php
	  
	  echo'<select name="vendedor">';
	  if($CliExis == 1){
		$vend=$rowb['cod_vend'];
		$vendn=$rowb['nom_personal'];
		$qry3="select Id_personal , nom_personal FROM personal where Activo=1 and Id_personal<>$vend order by nom_personal;";}
        else
	  	  $qry3="select Id_personal , nom_personal FROM personal where Activo=1 order by nom_personal;";
	  $result=mysqli_query($link,$qry3);
	  if($CliExis == 1)
        echo '<option selected value="'.$vend.'">'.$vendn.'</option>';
      else
	    echo '<option selected value="">------------------------------------</option>';
	  while($row=mysqli_fetch_array($result)){
		  echo '<option value='.$row['Id_personal'].'>'.$row['nom_personal'].'</option>';
	  }
	  echo'</select>';
	  mysqli_close($link);
    ?>
    </td>
  </tr>
  <tr> 
    <td colspan="6" align="center"><input type="button" class="formatoBoton1" onClick="return Enviar(this.form);" value="     Crear     " >&nbsp;&nbsp;<input type="reset" class="formatoBoton1" value="Restablecer"></td>
  </tr>
  <tr>
    <td colspan="6"><div align="center">&nbsp;</div></td>
  </tr>
<?php
  }
  ?>
  <tr> 
     <td colspan="6"><div align="center"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="VOLVER"></div></td>
  </tr>
</table>
</form>
</div>
</body>
</html>

