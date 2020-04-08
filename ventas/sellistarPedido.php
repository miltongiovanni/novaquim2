<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>Lista de &Oacute;rdenes de Pedido Pendientes por Facturar</title>
<meta charset="utf-8">
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="scripts/validar.js"></script>
    <script >
	function seleccionar1(form, checkbox_name)
	{ 
		//document.writeln (document.forms[0].seleccionar.value);
		//document.writeln (document.forms[0].seleccion1[].length);
		var checkboxes = form[checkbox_name];
		//document.writeln (checkboxes.length)
		for (i=0;i<checkboxes.length;i++) 
			if(form.seleccion1[i].type == "checkbox") 
				if(form.seleccionar.checked == true)
					form.seleccion1[i].checked=true 
				else if(form.seleccionar.checked == false)
					form.seleccion1[i].checked=false 
	}
	</script>
</head>
<body>
<div id="contenedor">
<div id="saludo1"><strong>LISTA DE &Oacute;RDENES DE PEDIDO PENDIENTES PARA REVISI&Oacute;N</strong></div> 
<form name="revision_pedidos"  method="post" action="lista_necesidades.php">
<table width="100%" border="0" summary="encabezado">
  <tr> <td width="16%"><div align="right"><input type="checkbox"  id="seleccionar" name="seleccionar" onclick='seleccionar1(this.form, "seleccion1[]")'>Seleccionar Todos/Ninguno</div></td>
      <td width="84%"><div align="right"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Men&uacute;"></div></td>
  </tr>
</table>

<table border="0" align="center" cellspacing="0" cellpadding="0" summary="cuerpo" width="100%">
<tr>
    <th width="2%" class="formatoEncabezados"></th>
    <th width="4%" class="formatoEncabezados">Pedido</th>
    <th width="23%" class="formatoEncabezados">Cliente</th>
    <th width="9%" class="formatoEncabezados">Fecha Pedido</th>
    <th width="9%" class="formatoEncabezados">Fecha Entrega</th>
    <th width="23%" class="formatoEncabezados">Lugar Entrega</th>
    <th width="18%" class="formatoEncabezados">Direcci&oacute;n Entrega</th>
    <th width="5%" class="formatoEncabezados">Precio</th>
    <th width="7%" class="formatoEncabezados">Estado</th>
  </tr>   
<?php
include "includes/utilTabla.php";
include "includes/conect.php" ;
$link=conectarServidor();
$sql="	select Id_pedido, Fech_pedido, Fech_entrega, tipo_precio, Nom_clien, pedido.Estado, Nom_sucursal, Dir_sucursal from pedido, tip_precio, clientes, clientes_sucursal where Nit_cliente=clientes.Nit_clien and clientes_sucursal.Nit_clien=clientes.Nit_clien and tip_precio=Id_precio and Id_sucurs=Id_sucursal AND pedido.Estado='P'  and Id_cat_clien<>13 order by Id_pedido";
$result=mysqli_query($link,$sql);
$a=1;
while($row=mysqli_fetch_array($result, MYSQLI_BOTH))
{
	$pedido=$row['Id_pedido'];
	if ($row['Estado']=='A')
	  	$estado='Anulado';
		if ($row['Estado']=='F')
	  	$estado='Facturado';
		if ($row['Estado']=='P')
	  	$estado='Pendiente';
		if ($row['Estado']=='L')
	  	$estado='Por Facturar';
	echo'<tr';
	  if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
	  echo '>
	<td class="formatoDatos"><div align="center"><input type="checkbox" id="seleccion1" class=”check” name="seleccion1[]"  align="left" value="'.$pedido.'"></div></td>
	<td class="formatoDatos"><div align="center">'.$row['Id_pedido'].'</div></td>
	<td class="formatoDatos"><div align="left">'.$row['Nom_clien'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$row['Fech_pedido'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$row['Fech_entrega'].'</div></td>
	<td class="formatoDatos"><div align="left">'.$row['Nom_sucursal'].'</div></td>
	<td class="formatoDatos"><div align="left">'.$row['Dir_sucursal'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$row['tipo_precio'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$estado.'</div></td>
	';
	echo'</tr>';
	$a=$a+1;
}
mysqli_close($link);//Cerrar la conexion
?>
</table>
<div align="center"><input type="submit" value="Enviar"></div>
</form>
</div>
</body>
</html>