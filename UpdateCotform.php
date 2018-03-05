<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Actualizar Cotizaci&oacute;n</title>
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
	</script></head>
<body>
<div id="contenedor">
<div id="saludo1"><strong>MODIFICAR COTIZACI&Oacute;N</strong></div>
<?php
foreach ($_POST as $nombre_campo => $valor) 
{ 
	$asignacion = "\$".$nombre_campo."='".$valor."';"; 
	//echo $nombre_campo." = ".$valor."<br>";  
	eval($asignacion); 
}  
include "includes/conect.php";
$link=conectarServidor();
$qrys="select Id_Cotizacion, cliente, Fech_Cotizacion, precio, presentaciones, distribucion, productos, Nom_clien from cotizaciones, clientes_cotiz where cliente=Id_cliente and Id_Cotizacion=$cotiza;";
$results=mysqli_query($link,$qrys);
$rows=mysqli_fetch_array($results); 
$id_cliente=$rows['cliente'];
$nom_cliente=$rows['Nom_clien'];
$presentaciones=$rows['presentaciones'];
$precio=$rows['precio'];
$seleccion = explode(",", $rows['distribucion']);
$seleccion1 = explode(",", $rows['productos']);
?>
<form method="post" action="update_cotiza.php" name="form1">	
  	<table align="center" width="55%">
    <tr>
      	<td width="22%" align="right"><strong>No. Cotizaci&oacute;n</strong></td>
   	  <td colspan="3"><input type="text" name="cotiza" id="sel1" value="<?php echo $cotiza; ?>" readonly size=20></td>
    </tr>
    <tr>
      	<td align="right"><strong>Cliente</strong></td>
   	  <td colspan="3">
	  <?php
			echo'<select name="cliente" id="combo">';
			$result=mysqli_query($link,"select Id_cliente, Nom_clien from clientes_cotiz order BY Nom_clien;");
			echo '<option selected value="'.$id_cliente.'">'.$nom_cliente.'</option>';
			while($row=mysqli_fetch_array($result))
			{
				if ($row['Id_cliente']<>$id_cliente)
					echo '<option value='.$row['Id_cliente'].'>'.$row['Nom_clien'].'</option>';
			}
			echo'</select>';
		?>
        </td>
    </tr>
     <tr>
      <td align="right"><strong>Fecha de Cotizaci&oacute;n</strong></td>
      <td colspan="3"><input type="text" name="FchCot" id="sel1" value="<?php echo $rows['Fech_Cotizacion']; ?>" readonly size=20><input type="reset" value=" ... "
		onclick="return showCalendar('sel1', '%Y-%m-%d', '12', true);"></td>
    </tr>
        <input name="Crear" type="hidden" value="3">
     <tr>
      	<td align="right"><strong>Destino</strong></td>
      	<td colspan="3">
        <input name="Destino" type="radio" id="Destino_0" value="1" checked> 
        Impresi&oacute;n
        <input type="radio" name="Destino" value="2" id="Destino_1"> 
        Correo electr&oacute;nico</td>
    </tr>
    <tr>
      	<td align="right"><strong>Presentaci&oacute;n</strong></td>
      	<td colspan="3">
        <?php
			if ($presentaciones==1)
			{
				echo '<input name="Presentaciones" type="radio" id="Presentaciones_0" value="1" checked> 
        		Todas
        		<input type="radio" name="Presentaciones" value="2" id="Presentaciones_1"> 
        		Peque&ntilde;as
        		<input type="radio" name="Presentaciones" value="3" id="Presentaciones_2"> 
        		Grandes		';
			}
			if ($presentaciones==2)
			{
				echo '<input name="Presentaciones" type="radio" id="Presentaciones_0" value="1"> 
        		Todas
        		<input type="radio" name="Presentaciones" value="2" id="Presentaciones_1" checked> 
        		Peque&ntilde;as
        		<input type="radio" name="Presentaciones" value="3" id="Presentaciones_2"> 
        		Grandes		';
			}
			if ($presentaciones==3)
			{
				echo '<input name="Presentaciones" type="radio" id="Presentaciones_0" value="1"> 
        		Todas
        		<input type="radio" name="Presentaciones" value="2" id="Presentaciones_1"> 
        		Peque&ntilde;as
        		<input type="radio" name="Presentaciones" value="3" id="Presentaciones_2" checked> 
        		Grandes		';
			}
		?>
        </td>
    </tr>
    <tr>
      	<td align="right"><strong>Precio</strong></td>
      	<td colspan="3">
        <?php
		if ($precio==1)
		{
			echo '<input type="radio" name="precio" value="1" id="precio_0"  checked> 
        	F&aacute;brica
        	<input name="precio" type="radio" value="2" id="precio_1"> 
        	Distribuidor
        	<input type="radio" name="precio" value="3" id="precio_2"> 
        	Detal
        	<input type="radio" name="precio" value="4" id="precio_3"> 
        	Mayorista		
        	<input type="radio" name="precio" value="5" id="precio_4"> 
        	Superetes';	
		}
		if ($precio==2)
		{
			echo '<input type="radio" name="precio" value="1" id="precio_0"> 
        	F&aacute;brica
        	<input name="precio" type="radio" value="2" id="precio_1"  checked> 
        	Distribuidor
        	<input type="radio" name="precio" value="3" id="precio_2"> 
        	Detal
        	<input type="radio" name="precio" value="4" id="precio_3"> 
        	Mayorista		
        	<input type="radio" name="precio" value="5" id="precio_4"> 
        	Superetes';	
		}
		if ($precio==3)
		{
			echo '<input type="radio" name="precio" value="1" id="precio_0"> 
        	F&aacute;brica
        	<input name="precio" type="radio" value="2" id="precio_1"> 
        	Distribuidor
        	<input type="radio" name="precio" value="3" id="precio_2"  checked> 
        	Detal
        	<input type="radio" name="precio" value="4" id="precio_3"> 
        	Mayorista		
        	<input type="radio" name="precio" value="5" id="precio_4"> 
        	Superetes';	
		}
		if ($precio==4)
		{
			echo '<input type="radio" name="precio" value="1" id="precio_0"> 
        	F&aacute;brica
        	<input name="precio" type="radio" value="2" id="precio_1"> 
        	Distribuidor
        	<input type="radio" name="precio" value="3" id="precio_2"> 
        	Detal
        	<input type="radio" name="precio" value="4" id="precio_3"  checked> 
        	Mayorista		
        	<input type="radio" name="precio" value="5" id="precio_4"> 
        	Superetes';	
		}
		if ($precio==5)
		{
			echo '<input type="radio" name="precio" value="1" id="precio_0"> 
        	F&aacute;brica
        	<input name="precio" type="radio" value="2" id="precio_1"> 
        	Distribuidor
        	<input type="radio" name="precio" value="3" id="precio_2"> 
        	Detal
        	<input type="radio" name="precio" value="4" id="precio_3"> 
        	Mayorista		
        	<input type="radio" name="precio" value="5" id="precio_4  checked"> 
        	Superetes';	
		}
		?>
        </td>
    </tr>    
    <tr>
    	<td align="right"><strong>Familia de Productos</strong></td>
  		<td width="31%"  align="left">
		<?php
				$resultnova=mysqli_query($link,"select Id_cat_prod, Des_cat_prod from cat_prod where Id_cat_prod<8;");
				while($rownova=mysqli_fetch_array($resultnova))
				{
					echo $rownova['Des_cat_prod'].'<input type="checkbox" name="seleccion1[]"  align="right" value="'.$rownova['Id_cat_prod'].'"';
					if (in_array ($rownova['Id_cat_prod'], $seleccion1))
						echo " checked ";
					echo '><br>';
				}
				
	   ?>       </td>
    	<td width="18%" align="right"><strong>Familia Distribuci&oacute;n</strong></td>
  		<td width="29%" colspan="2" align="left"><?php
				$resultdist=mysqli_query($link,"select Id_cat_dist, Des_cat_dist from cat_dist;");
				while($rowdist=mysqli_fetch_array($resultdist))
				{
					echo $rowdist['Des_cat_dist'].'<input type="checkbox" name="seleccion[]"  align="right" value="'.$rowdist['Id_cat_dist'].'"';
					if (in_array($rowdist['Id_cat_dist'], $seleccion))
						echo " checked ";
					echo '><br>';
				}
				mysqli_close($link);
	   ?></td>
    </tr>
    <tr>
   	  <td colspan="3" align="right"><input name="button" type="button" onClick="return Enviar(this.form);" value="Continuar"></td>
    </tr>
    <tr> 
        <td colspan="3">
        <div align="center"><input type="button" class="resaltado" onClick="history.back()" value="  VOLVER  "></div></td>
    </tr>
  </table>
</form> 
</div>
</body>
</html>
