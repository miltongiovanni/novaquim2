<?php
include "includes/valAcc.php";
?>
<?php
include "includes/personObj.php";
include "includes/calcularDias.php";


foreach ($_POST as $nombre_campo => $valor) 
{ 
	$asignacion = "\$".$nombre_campo."='".$valor."';"; 
	//echo $nombre_campo." = ".$valor."<br>";  
	eval($asignacion); 
}  
$persona=new person();
if($result=$persona->updatePerson($IdPersonal, $Nombre,$Estado, $Area, $Celular, $Email, $Cargo))
{
	$perfil1=$_SESSION['Perfil'];
	$ruta="listarPersonal.php";
    mover_pag($ruta,"Personal Actualizado correctamente");
}
else
{
	$ruta="buscarPersonal.php";
	mover_pag($ruta,"Error al Actualizar el Personal");
}
function mover_pag($ruta,$Mensaje)
{
	echo'<script language="Javascript">
   	alert("'.$Mensaje.'")
   	self.location="'.$ruta.'"
   	</script>';
}
?>
