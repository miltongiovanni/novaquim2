<?php
include "includes/valAcc.php";
include "includes/conect.php";

?>
<!DOCTYPE html>
<html>
<head>
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
<meta charset="utf-8">
<title>Actualizar datos del Proveedor</title>
<script type="text/javascript" src="scripts/validar.js"></script>
<script type="text/javascript" src="scripts/block.js"></script>
	<script type="text/javascript">
	document.onkeypress = stopRKey; 
	</script>
</head>
<body>
<div id="contenedor">
<div id="saludo1"><strong>ACTUALIZACI&Oacute;N DE PROVEEDORES</strong></div>

<?php
	  $link=conectarServidor();
	  $nit=$_POST['prov'];
	  $qry="select * from proveedores where NIT_provee='$nit'";
	  $result=mysqli_query($link,$qry);
	  $row=mysqli_fetch_array($result);
	  mysqli_free_result($result);
	  mysqli_close($link);
?>
<table border="0" align="center" width="43%">
<form id="form1" name="form1" method="post" action="updateProv.php">
    <tr align="center"> 
      <td width="18%"><strong>NIT</strong></td>
      <td width="53%"><strong>Proveedor</strong></td>
      <td width="14%"><strong>Tel&eacute;fono</strong></td>
      <td width="15%"><strong>Fax</strong></td>
    </tr>
    <tr> 
      <td><?php echo'<input name="nit" type="text" value="'.$row['NIT_provee'].'">';?></td>
      <td><?php echo'<input name="proveedor" type="text" value="'.$row['Nom_provee'].'" size="40">';?></td>
      <td><?php echo'<input name="tel1" type="text" size="10" value="'.$row['Tel_provee'].'">';?></td>
      <td><?php echo'<input name="fax" type="text" size="10" value="'.$row['Fax_provee'].'">';?></td>
    </tr>
    <tr align="center"> 
      <td><strong>Contacto</strong></td>
      <td><strong>Direcci&oacute;n</strong></td>
      <td colspan="2"><strong>Autoretenedor</strong></td>
      <td colspan="1"><strong>Régimen</strong></td>
    </tr>
    <tr> 
      <td><?php echo'<input name="contacto" type="text" value="'.$row['Nom_contac'].'">';?></td>
      <td><?php echo'<input name="direccion" type="text" value="'.$row['Dir_provee'].' " size="40">';?></td>
      <td colspan="2"><?php
	  		if ($row['ret_provee']==1)
			{
		  		echo'<select name="Auto_ret">';
		  		echo '<option selected value=1>Es Autorretenedor</option>';
            	echo '<option value=0>No es Autorretenedor</option>';
				echo'</select>';
          	}
			else
			{
		  		echo'<select name="Auto_ret">';
		  		echo '<option selected value=0>No es Autorretenedor</option>';
            	echo '<option value=1>Es Autorretenedor</option>';
				echo'</select>';
          	}
		  ?></td>
          <td colspan="1"><?php
	  		if ($row['regimen_provee']==1)
			{
		  		echo'<select name="regimen">';
		  		echo '<option selected value=1>Com&uacute;n</option>';
            	echo '<option value=0>Simplicado</option>';
				echo'</select>';
          	}
			else
			{
		  		echo'<select name="regimen">';
		  		echo '<option selected value=0>Simplicado</option>';
            	echo '<option value=1>Com&uacute;n</option>';
				echo'</select>';
          	}
		  ?></td>
    </tr>
    <tr align="center"> 
      <td><strong>Categor&iacute;a</strong></td>
      <td><strong>E-mail</strong></td>
      <td colspan="2"><strong>Tasa Reteica</strong></td>
    </tr>
    <tr> 
      <td><?php
		  $link=conectarServidor();
		  $qrya="select * from proveedores, cat_prov where proveedores.NIT_provee='$nit' and proveedores.Id_cat_prov=cat_prov.idCatProv";
		  $resulta=mysqli_query($link,$qrya);
		  $rowa=mysqli_fetch_array($resulta); 			
		  echo'<select name="Id_Cat">';
		  $resultp=mysqli_query($link,"select * from cat_prov");
		  echo '<option selected value='.$rowa['Id_cat_prov'].'>'.$rowa['Des_cat_prov'].'</option>';
          while($rowp=mysqli_fetch_array($resultp))
		  {
		  	if ($rowp['Des_cat_prov']!= $rowa['Des_cat_prov'])
            echo '<option value='.$rowp['Id_cat_prov'].'>'.$rowp['Des_cat_prov'].'</option>';
          }
          echo'</select>';	
		  mysqli_free_result($resulta);		
		  mysqli_close($link);
		  ?></td>
	  <td colspan="1"><?php echo'<input name="email" type="text" value="'.$row['Eml_provee'].'" onChange="TestMail(document.form1.email.value)" size="40">';?></td>
      <td colspan="2" align="center"><?php
		  $link=conectarServidor();
		  $qryica="select numtasa_rica, tasa_retica from proveedores, tasa_reteica where NIT_provee='$nit' and Id_tasa_retica=numtasa_rica";
		  $resultaica=mysqli_query($link,$qryica);
		  $rowica=mysqli_fetch_array($resultaica); 			
		  echo'<select name="Tasa_reteica">';
		  $resultca=mysqli_query($link,"select Id_tasa_retica,tasa_retica from tasa_reteica;");
		  echo '<option selected value='.$rowica['numtasa_rica'].'>'.$rowica['tasa_retica'].'</option>';
          while($rowca=mysqli_fetch_array($resultca))
		  {
		  	if ($rowca['Id_tasa_retica']!= $rowica['numtasa_rica'])
            echo '<option value='.$rowca['Id_tasa_retica'].'>'.$rowca['tasa_retica'].'</option>';
          }
          echo'</select>';	
		  mysqli_free_result($resultca);	
		  mysqli_free_result($resultaica);
		  mysqli_close($link);
		  ?></td>
    </tr>
    <tr> 
      <td colspan="1">&nbsp;</td><td colspan="1">&nbsp;</td><td colspan="1">&nbsp;</td><td colspan="1">&nbsp;</td>
    </tr>
    <tr> 
      <td colspan="5"><div align="center">
          <input type="submit" name="Submit" value="Actualizar Datos del Proveedor">
        </div></td>
    </tr>
    <tr> 
      <td colspan="3">&nbsp;</td>
    </tr>
  </form>
  </table>
  <table align="center" width="43%">
  <tr> 
      <td colspan="2"><div align="center">
	  <?php
		echo'<form action="detProveedor.php" method="post" name="formulario">';
		echo '<input name="NIT" type="hidden" value="'.$row['NIT_provee'].'"/>
		<input name="Crear" type="hidden" value="0"/>
		<input name="IdCat" type="hidden" value="'.$rowa['Id_cat_prov'].'"/>
		<input type="submit" name="Submit" value="Adicionar o Cambiar Productos" />';
		echo'</form>';        
		//mover_pag2("Proveedor Creado correctamente");
		function mover_pag2($Mensaje)
		{
			echo'<script >
			alert("'.$Mensaje.'");
			document.formulario.submit();
			</script>';
		}
	?>
        </div></td>
    </tr>
	<tr>
        <th width="78" align="center">C&oacute;digo</th>
      	<th width="386" align="center">Producto</th>
   </tr>
          <?php
			$link=conectarServidor();
			$NIT=$nit;
			$qry="
			select Codigo, Nom_mprima AS Producto from det_proveedores, mprimas 
			WHERE Codigo=Cod_mprima and det_proveedores.Id_cat_prov=1 and NIT_provee='$NIT' 
			union
			select Codigo, Nom_envase as Producto from det_proveedores, envase 
			WHERE Codigo=Cod_envase and det_proveedores.Id_cat_prov=2 and NIT_provee='$NIT' 
			union
			select Codigo, Nom_tapa as Producto from det_proveedores, tapas_val 
			WHERE Codigo=Cod_tapa and det_proveedores.Id_cat_prov=2 and NIT_provee='$NIT' 
			union
			select Codigo, Producto from det_proveedores, distribucion 
			WHERE Codigo=Id_distribucion and Activo=0 and det_proveedores.Id_cat_prov=5 and NIT_provee='$NIT' 
			union 
			select Codigo, Nom_etiq as Producto from det_proveedores, etiquetas 
			WHERE Codigo=Cod_etiq and det_proveedores.Id_cat_prov=3 and NIT_provee='$NIT' order by Producto;";
			$result=mysqli_query($link,$qry);
			while($rowp=mysqli_fetch_array($result))
			{
				$codigo=$rowp['Codigo'];
				$producto=$rowp['Producto'];
				echo'<tr>
				  <td><div align="center" class="formatoDatos">'.$codigo.'</div></td>
				  <td colspan="2"><div align="left" class="formatoDatos">'.$producto.'</div></td>
				</tr>';
			}
			mysqli_free_result($result);
			mysqli_close($link);
			?>
  </table>
<div align="center"><input type="button" class="resaltado" onClick="history.back()" value="  VOLVER  "></div>
</div>
</body>
</html>
