<?php
include "includes/valAcc.php";
include "includes/conect.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Actualizar datos de Presentaci&oacute;n de Producto</title>
<script type="text/javascript" src="scripts/validar.js"></script>
<script type="text/javascript" src="scripts/block.js"></script>
	<script type="text/javascript">
	document.onkeypress = stopRKey; 
	</script>
</head>
<body>
<div id="contenedor">
<div id="saludo"><strong>ACTUALIZACI&Oacute;N DE PRESENTACIONES DE PRODUCTO</strong></div>
<?php
	  $link=conectarServidor();
	  $Idpres=$_POST['IdProdPre'];
	  $qry="SELECT * FROM prodpre where Cod_prese=$Idpres";
	  $result=mysqli_query($link,$qry);
	  $row=mysqli_fetch_array($result);
	  mysqli_free_result($result);
	  mysqli_close($link);
?>
<form id="form1" name="form1" method="post" action="updateMed.php">
	<table width="693" border="0" align="center">
    <tr> 
        <td width="217"><div align="right"><strong>C&oacute;digo</strong></div></td>
		<td width="466"><?php echo'<input size=10 name="Cod_Present" type="text" readonly value="'.$row['Cod_prese'].'"/>';?></td>
    </tr>
    <tr> 
        <td><div align="right"><strong>Presentaci&oacute;n</strong></div></td>
		<td><?php echo'<input size=55 name="Present" type="text" value="'.$row['Nombre'].'"/>';?></td>
    </tr>
    <tr> 
    	<td><div align="right"><strong>Producto</strong></div></td>
        <td>
        <?php
		  $link=conectarServidor();
		  $qry1="select * from prodpre, productos where prodpre.Cod_prese=$Idpres and prodpre.Cod_produc=productos.Cod_produc ";
		  $result1=mysqli_query($link,$qry1);
		  $row1=mysqli_fetch_array($result1); 
		  echo'<select name="IdProducto">';
		  $result2=mysqli_query($link,"select * from productos order by Nom_produc");
		  echo '<option selected value='.$row1['Cod_produc'].'>'.$row1['Nom_produc'].'</option>';
          while ($row2=mysqli_fetch_array($result2))
		  {
			if ($row2['Nom_produc']!= $row1['Nom_produc'])
	        	echo '<option value='.$row2['Cod_produc'].'>'.$row2['Nom_produc'].'</option>';
          }
          echo'</select>';
		  mysqli_free_result($result1);
		  mysqli_free_result($result2);
	  mysqli_close($link);
		?>        </td>  
        </tr>
    <tr> 
        <td><div align="right"><strong>Medida</strong></div></td>
        <td>
        <?php
          $link=conectarServidor();
		  $qry3="select *from prodpre, medida where prodpre.Cod_prese=$Idpres and prodpre.Cod_umedid=medida.Id_medida";
		  $result3=mysqli_query($link,$qry3);
		  $row3=mysqli_fetch_array($result3); 
		  echo'<select name="IdMedida">';
		  $result4=mysqli_query($link,"select * from medida order by des_medida");
		  echo '<option selected value='.$row3['Id_medida'].'>'.$row3['des_medida'].'</option>';
          while ($row4=mysqli_fetch_array($result4))
		  {
			if ($row4['des_medida']!= $row3['des_medida'])
	        	echo '<option value='.$row4['Id_medida'].'>'.$row4['des_medida'].'</option>';
          }
          echo'</select>';
		  mysqli_free_result($result3);
		  mysqli_free_result($result4);
	  mysqli_close($link);
		?>        </td>
    </tr>
    <tr> 
        <td><div align="right"><strong>Envase</strong></div></td>
        <td>
        <?php
		  $link=conectarServidor();
		  $qry5="select *from prodpre, envase where prodpre.Cod_prese=$Idpres and prodpre.Cod_envase=envase.Cod_envase";
		  $result5=mysqli_query($link,$qry5);
		  $row5=mysqli_fetch_array($result5); 
		  echo'<select name="IdEnvase">';
		  $result6=mysqli_query($link,"select * from envase order by Nom_envase");
		  echo '<option selected value='.$row5['Cod_envase'].'>'.$row5['Nom_envase'].'</option>';
          while ($row6=mysqli_fetch_array($result6))
		  {
			if ($row6['Nom_envase']!= $row5['Nom_envase'])
	        	echo '<option value='.$row6['Cod_envase'].'>'.$row6['Nom_envase'].'</option>';
          }
          echo'</select>';
		  mysqli_free_result($result5);
		  mysqli_free_result($result6);
	  mysqli_close($link);
		?>        </td>
    </tr>
    <tr> 
        <td><div align="right"><strong>Tapa</strong></div></td>
        <td>
        <?php
		$link=conectarServidor();
		  $qry7="select *from prodpre, tapas_val where prodpre.Cod_prese=$Idpres and prodpre.Cod_tapa=tapas_val.Cod_tapa";
		  $result7=mysqli_query($link,$qry7);
		  $row7=mysqli_fetch_array($result7); 
		  echo'<select name="IdTapa">';
		  $result8=mysqli_query($link,"select * from tapas_val order by Nom_tapa");
		  echo '<option selected value='.$row7['Cod_tapa'].'>'.$row7['Nom_tapa'].'</option>';
          while ($row8=mysqli_fetch_array($result8))
		  {
			if ($row8['Nom_tapa']!= $row7['Nom_tapa'])
	        	echo '<option value='.$row8['Cod_tapa'].'>'.$row8['Nom_tapa'].'</option>';
          }
          echo'</select>';
		  mysqli_free_result($result7);
		  mysqli_free_result($result8);
	  	   mysqli_close($link);
		?>        </td>
    </tr>
    <tr> 
        <td><div align="right"><strong>Etiqueta</strong></div></td>
        <td>
        <?php
		$link=conectarServidor();
		  $qry9="select * from prodpre, etiquetas WHERE prodpre.Cod_etiq=etiquetas.Cod_etiq AND Cod_prese=$Idpres;";
		  $result9=mysqli_query($link,$qry9);
		  $row9=mysqli_fetch_array($result9); 
		  echo'<select name="IdEtiq">';
		  $result10=mysqli_query($link,"select * from etiquetas order by Nom_etiq");
		  		  echo '<option selected value='.$row9['Cod_etiq'].'>'.$row9['Nom_etiq'].'</option>';
          while ($row10=mysqli_fetch_array($result10))
		  {
			if ($row10['Nom_etiq']!= $row9['Nom_etiq'])
	        	echo '<option value='.$row10['Cod_etiq'].'>'.$row10['Nom_etiq'].'</option>';
          }
          echo'</select>';
		  mysqli_free_result($result9);
		  mysqli_free_result($result10);
	  mysqli_close($link);
		?>        </td>
    </tr>
    <tr> 
        <td><div align="right"><strong>C&oacute;digo anterior</strong></div></td>
        <td>
        <?php
		$link=conectarServidor();
		  $qry9="select * from prodpre, precios where prodpre.Cod_prese=$Idpres and prodpre.Cod_ant=precios.codigo_ant";
		  $result9=mysqli_query($link,$qry9);
		  $row9=mysqli_fetch_array($result9); 
		  echo'<select name="IdCodAnt">';
		  $result10=mysqli_query($link,"select * from precios where pres_activa=0 order by producto");
		  echo '<option selected value='.$row9['codigo_ant'].'>'.$row9['producto'].'</option>';
          while ($row10=mysqli_fetch_array($result10))
		  {
			if ($row10['producto']!= $row9['producto'])
	        	echo '<option value='.$row10['codigo_ant'].'>'.$row10['producto'].'</option>';
          }
          echo'</select>';
		  mysqli_free_result($result9);
		  mysqli_free_result($result10);
	  mysqli_close($link);
		?>        </td>
    </tr>
    <tr> 
      <td><div align="right"><strong>Stock M&iacute;nimo</strong></div></td>
      <td><?php echo'<input name="stock" type="text" size="10" value="'.$row['stock_prese'].'"/>';?></td>
    </tr>
    <tr> 
      <td><div align="right"><strong>Tasa Iva</strong></div></td>
      <td><?php 
	  $link=conectarServidor();
	  $qry1="select * from prodpre, tasa_iva where Cod_iva=Id_tasa and Cod_prese=$Idpres;";
		  $result1=mysqli_query($link,$qry1);
		  $row1=mysqli_fetch_array($result1); 
		  echo'<select name="IdIva">';
		  $result2=mysqli_query($link,"select * from tasa_iva");
		  echo '<option selected value='.$row1['Id_tasa'].'>'.$row1['tasa'].'</option>';
          while ($row2=mysqli_fetch_array($result2))
		  {
			if ($row2['tasa']!= $row1['tasa'])
	        	echo '<option value='.$row2['Id_tasa'].'>'.$row2['tasa'].'</option>';
          }
          echo'</select>'; 
		  mysqli_free_result($result1);
		  mysqli_free_result($result2);
	  mysqli_close($link);
		  ?>      </td>
    </tr>
    <tr><td><div align="right"><strong>Cotizar</strong></div></td>
            <td><?php
        $link=conectarServidor();
        $Cotiza=$row['Cotiza'];
        if ($Cotiza==1)
        {
        echo '<select name="Cotiza" >
            <option value="1" selected>No</option>
            <option value="0">Si</option>
            </select>';
        }
        else
		{
		echo '<select name="Cotiza" >
            <option value="0" selected>Si</option>
            <option value="1">No</option>
            </select>';	
		}    
        ?></td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td><div align="center">
          <input type="submit" name="Submit" value="Actualizar">
        </div></td>
    </tr>
  </table>
</form>
</div>
</body>
</html>
