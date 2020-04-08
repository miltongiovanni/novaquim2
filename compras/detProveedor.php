<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>Productos por Proveedor</title>
<meta charset="utf-8">
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="scripts/validar.js"></script>
	<script type="text/javascript" src="scripts/block.js"></script>
        <link rel="stylesheet" type="text/css" media="all" href="css/calendar-blue2.css" title="blue">
    <script type="text/javascript" src="scripts/calendar.js"></script>
    <script type="text/javascript" src="scripts/calendar-sp.js"></script>
    <script type="text/javascript" src="scripts/calendario.js"></script>
    	<script type="text/javascript">
	document.onkeypress = stopRKey; 
	</script>
</head>
<body> 
<div id="contenedor">
<div id="saludo1"><strong>PRODUCTOS OFRECIDOS POR PROVEEDOR</strong></div>
<?php
include "includes/conect.php";
foreach ($_POST as $nombre_campo => $valor) 
{ 
	$asignacion = "\$".$nombre_campo."='".$valor."';"; 
	//echo $nombre_campo." = ".$valor."<br>";  
	eval($asignacion); 
}  
if($Crear==0)
{
		/*echo '<form method="post" action="detProveedor.php" name="form3">';
		echo '<input name="NIT" type="hidden" value="'.$NIT.'"/>
		<input name="IdCat" type="hidden" value="'.$IdCat.'"/>
		<input name="Crear" type="hidden" value="1"/>
		<input type="submit" name="Submit" value="Cambiar" />';
		echo'<script >
			document.form3.submit();
			</script>';	*/
} 

if($Crear==1)
{
	$link=conectarServidor();   
	$qryins="insert into det_proveedores (NIT_provee, Codigo, Id_cat_prov) values ('$NIT', $codigo, $IdCat)";
	$resultqryins=mysqli_query($link,$qryins);
	mysqli_close($link);
}
?>
<form method="post" action="detProveedor.php" name="form1">
  <table  align="center">
    <?php
	  	$link=conectarServidor();
		$qry="SELECT NIT_provee, Nom_provee, proveedores.Id_cat_prov as Categ, desCatProv from proveedores, cat_prov WHERE 						
		proveedores.Id_cat_prov=cat_prov.idCatProv and NIT_provee='$NIT';";
		$result=mysqli_query($link,$qry);
		$row=mysqli_fetch_array($result);
		mysqli_free_result($result);
		mysqli_close($link);
		$nit=$row['NIT_provee'];
	 ?>
     <tr><td>&nbsp;</td></tr>
    <tr>
      <td width="82" align="left"><strong>Proveedor: </strong></td>
      <td width="379" align="left"><?php echo  $row['Nom_provee']?></td>
      <td width="32"><strong>NIT:</strong></td>
      <td width="105"><?php echo  $row['NIT_provee']?></td>
    </tr>
    <tr>
      <td colspan="3"><div align="center"><strong>Producto</strong></div></td>
      <td></td>
    </tr>
    <tr>
      <td colspan="3"><div align="center">
        <?php
			foreach ($_POST as $nombre_campo => $valor) 
			{ 
				$asignacion = "\$".$nombre_campo."='".$valor."';"; 
				//echo $nombre_campo." = ".$valor."<br>";  
				eval($asignacion); 
			}  
			$link=conectarServidor();
			switch ($IdCat) 
			{
				case 1:
					$qry="SELECT Cod_mprima as Codigo, Nom_mprima as Producto FROM (SELECT Cod_mprima, Nom_mprima FROM mprimas as matprimas) as Tabla1 
left JOIN det_proveedores ON Codigo=Cod_mprima and NIT_provee='$nit' where Codigo IS NULL order by Producto";
					break;
				case 2:
					$qry="SELECT Cod_envase as Codigo, Nom_envase as Producto FROM (SELECT Cod_envase, Nom_envase FROM envase as envas) as Tabla1 
left JOIN det_proveedores ON Codigo=Cod_envase and NIT_provee='$nit' where Codigo IS NULL 
union
SELECT Cod_tapa as Codigo, Nom_tapa as Producto FROM (SELECT Cod_tapa, Nom_tapa FROM tapas_val as envas) as Tabla1 
left JOIN det_proveedores ON Codigo=Cod_tapa and NIT_provee='$nit' and Cod_tapa<>114 where Codigo IS NULL order by Producto";
					break;
				case 3:
					$qry="SELECT Cod_etiq as Codigo, Nom_etiq as Producto FROM (SELECT Cod_etiq, Nom_etiq FROM etiquetas as etiq) as Tabla1 
left JOIN det_proveedores ON Codigo=Cod_etiq and NIT_provee='$nit' where Codigo IS NULL order by Producto";
					break;
				case 4:
					$qry="select Cod_mprima as Codigo, Nom_mprima as Producto from mprimas";
					break;
				case 5:
					$qry="SELECT Id_distribucion as Codigo, Producto FROM (SELECT Id_distribucion, Producto FROM distribucion as distrib) as Tabla1 
left JOIN det_proveedores ON Codigo=Id_distribucion and NIT_provee='$nit' where Codigo IS NULL order by Producto";
					break;
				case 6:
					$qry="select Cod_etiq as Codigo, Nom_etiq as Producto from etiquetas order by Nom_etiq;";
					break;
			}

			echo'<select name="codigo">';
			$result=mysqli_query($link,$qry);
            while($row=mysqli_fetch_array($result))
			{
				echo '<option value='.$row['Codigo'].'>'.$row['Producto'].'</option>';
            }
            echo'</select>';
			mysqli_free_result($result);
		mysqli_close($link);
		?>      
      </div></td>
      <td width="105" align="left"><input name="submit" type="submit" onClick="return Enviar(this.form)"  value="Continuar">
          <?php 
		  echo '<input name="NIT" type="hidden" value="'.$NIT.'">
		<input name="IdCat" type="hidden" value="'.$IdCat.'">
		<input name="Crear" type="hidden" value="1">'; ?> </td>
    </tr>
    <tr>
    </tr>
    </table>
</form>
	<table width="496" border="0" align="center" cellpadding="0" cellspacing="0" >
  	<tr>
        <th width="71" align="center">C&oacute;digo</th>
        <th width="351" align="center">Producto</th>
        <th width="60">&nbsp;</th>
   </tr>
          <?php
			$link=conectarServidor();
			//$Fact=$Factura;
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
			WHERE Codigo=Id_distribucion and det_proveedores.Id_cat_prov=5 and Activo=0 and NIT_provee='$NIT' 
			union 
			select Codigo, Nom_etiq as Producto from det_proveedores, etiquetas 
			WHERE Codigo=Cod_etiq and det_proveedores.Id_cat_prov=3 and NIT_provee='$NIT' order by Producto;";
			$result=mysqli_query($link,$qry);
			$a=1;
			while($row=mysqli_fetch_array($result))
			{
				$codigo=$row['Codigo'];
				$producto=$row['Producto'];
				echo'<tr>
				<td';
				if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
				echo '><div align="center" class="formatoDatos">'.$codigo.'</div></td>
				<td';
				if (($a++ % 2)==0) echo ' bgcolor="#B4CBEF" ';
				echo '><div align="left" class="formatoDatos">'.$producto.'</div></td>
			<form action="delDetProv.php" method="post" name="elimina">
				<input name="NIT" type="hidden" value="'.$NIT.'">
				<input name="Codigo" type="hidden" value="'.$codigo.'">
				<input name="IdCat" type="hidden" value="'.$IdCat.'">
				<td align="center" valign="middle"> <input type="submit" name="Submit" class="formatoBoton"  value="Eliminar"></td>
			</form>
				</tr>';
			}
			mysqli_free_result($result);
		mysqli_close($link);
			?>
</table>
<table width="27%" border="0" align="center">
<tr> 
        <td><div align="center"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Terminar"></div></td>
    </tr>
</table> 
</div>
</body>
</html>