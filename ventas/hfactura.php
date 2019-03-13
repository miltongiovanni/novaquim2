<?php
include "includes/valAcc.php";
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
$sql="update pedido SET Estado='P' where Id_pedido=$pedido";	
$result=mysqli_query($link,$sql);
if($result)
{  
	$ruta="menu.php";
	mover_pag($ruta,"Pedido Habilitado para modificar correctamente");
}
else
{
	$ruta="menu.php";
	mover_pag($ruta,"Error al habilitar el Pedido");
}


function mover_pag($ruta,$Mensaje)
{
echo'<script language="Javascript">
   alert("'.$Mensaje.'")
   self.location="'.$ruta.'"
   </script>';
}
mysqli_close($link);//Cerrar la conexion
?>




