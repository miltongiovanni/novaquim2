<?php
include "../includes/valAcc.php";
?>
<?php
include "includes/conect.php";
foreach ($_POST as $nombre_campo => $valor) 
	{ 
		$asignacion = "\$".$nombre_campo."='".$valor."';"; 
		//echo $nombre_campo." = ".$valor."<br>";  
		eval($asignacion); 
	}  
$link=conectarServidor();
$sql="update pedido SET Estado='L' where idPedido=$pedido";
$result=mysqli_query($link,$sql);
if($result)
{  
	$ruta="menu.php";
	mover_pag($ruta,"Pedido Habilitado para facturar correctamente");
}
else
{
	$ruta="menu.php";
	mover_pag($ruta,"Error al habilitar el Pedido");
}



mysqli_close($link);//Cerrar la conexion
?>




