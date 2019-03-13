<?php
include "includes/valAcc.php";
include "includes/conect.php";
?>
<?php
foreach ($_POST as $nombre_campo => $valor) 
	{ 
		$asignacion = "\$".$nombre_campo."='".$valor."';"; 
		//echo $nombre_campo." = ".$valor."<br>";  
		eval($asignacion); 
	} 

$bd="novaquim";
$qry="update servicios set DesServicio='$servicio', Cod_iva=$cod_iva , Activo=$Activo where IdServicio=$Id_serv;";
$link=conectarServidor();
$result=mysqli_query($link,$qry);

if($result)
{
	$ruta="listarServ.php";
    mover_pag($ruta,"Servicio actualizado correctamente");
}
else
{
	$ruta="buscarServ.php";
	mover_pag($ruta,"Error al actualizar el Servicio");
}
mysqli_close($link);//Cerrar la conexion
function mover_pag($ruta,$Mensaje)
{
	echo'<script language="Javascript">
   	alert("'.$Mensaje.'")
   	self.location="'.$ruta.'"
   	</script>';
}
?>
