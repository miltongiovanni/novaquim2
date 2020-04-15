<?php
include "includes/valAcc.php";
foreach ($_POST as $nombre_campo => $valor) 
{ 
  $asignacion = "\$".$nombre_campo."='".$valor."';"; 
  echo $nombre_campo." = ".$valor."<br>";  
  eval($asignacion); 
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Crear Cotizaci&oacute;n</title>
    <meta charset="utf-8">
    <link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script  src="scripts/validar.js"></script>
	<script  src="scripts/block.js"></script>
    <link rel="stylesheet" type="text/css" media="all" href="css/calendar-blue2.css" title="blue">
    <script  src="scripts/calendar.js"></script>
    <script  src="scripts/calendar-sp.js"></script>
    <script  src="scripts/calendario.js"></script>
    	<script >
	document.onkeypress = stopRKey; 
	</script></head>
<body>
<div id="contenedor">
<div id="saludo1"><strong>CREAR COTIZACI&Oacute;N</strong></div>
<form method="post" action="det_cotiza.php" name="form1">	
  	<table align="center" width="56%">
    <tr>
      	<td width="18%" align="right"><strong>Cliente</strong></td>
   	  <td colspan="3">
	  <?php
			include "includes/conect.php";
			$link=conectarServidor();
			echo'<select name="cliente" id="combo">';
			$qry="select Id_cliente, Nom_clien from clientes_cotiz order BY Nom_clien;";
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
      <td align="right"><strong>Fecha de Cotizaci&oacute;n</strong></td>
      <td colspan="3"><input type="text" name="FchCot" id="sel1" readonly size=20><input type="reset" value=" ... "
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
        <input name="Presentaciones" type="radio" id="Presentaciones_0" value="1" checked> 
        Todas
        <input type="radio" name="Presentaciones" value="2" id="Presentaciones_1"> 
        Peque&ntilde;as
        <input type="radio" name="Presentaciones" value="3" id="Presentaciones_2"> 
        Grandes		</td>
    </tr>
    <tr>
      	<td align="right"><strong>Precio</strong></td>
      	<td colspan="3">
        <input type="radio" name="precio" value="1" id="precio_0"> 
        F&aacute;brica
        <input name="precio" type="radio" value="2" id="precio_1"  checked> 
        Distribuidor
        <input type="radio" name="precio" value="3" id="precio_2"> 
        Detal
        <input type="radio" name="precio" value="4" id="precio_3"> 
        Mayorista		
        <input type="radio" name="precio" value="5" id="precio_4"> 
        Superetes	</td>
    </tr>    
    <tr>
    	<td align="center"><strong>Familia de Productos</strong></td>
  		<td width="30%"  align="left">
		<?php
				$resultnova=mysqli_query($link,"select Id_cat_prod, Des_cat_prod from cat_prod where Id_cat_prod<8;");
				while($rownova=mysqli_fetch_array($resultnova))
				{
					echo $rownova['Des_cat_prod'].'<input type="checkbox" name="seleccion1[]"  align="right" value="'.$rownova['Id_cat_prod'].'">'."<br>";
				}
				
	   ?>       </td>
    	<td width="12%" align="center"><strong>Familia Distribuci&oacute;n</strong></td>
  		<td width="40%" colspan="2" align="left">
		<?php
				$resultdist=mysqli_query($link,"select Id_cat_dist, Des_cat_dist from cat_dist;");
				while($rowdist=mysqli_fetch_array($resultdist))
				{
					echo $rowdist['Des_cat_dist'].'<input type="checkbox" name="seleccion[]"  align="right" value="'.$rowdist['Id_cat_dist'].'">'."<br>";
				}
				mysqli_close($link);
	   ?>       </td>
    </tr>
    <tr>
   	  <td colspan="4"><div align="center"><input name="button" type="button" onClick="return Enviar(this.form);" value="Continuar"></div></td>
    </tr>    
    <tr>
        <td colspan="3">&nbsp;</td>
    </tr>

    <tr> 
        <td colspan="4">
        <div align="center"><input type="button" class="resaltado" onClick="history.back()" value="  VOLVER  "></div>        </td>
    </tr>
  </table>
</form> 
</div>
</body>
</html>
