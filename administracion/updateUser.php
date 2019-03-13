<?php
include "includes/valAcc.php";
?>
<?php
include "includes/userObj.php";
include "includes/calcularDias.php";


foreach ($_POST as $nombre_campo => $valor) 
{ 
	$asignacion = "\$".$nombre_campo."='".$valor."';"; 
	//echo $nombre_campo." = ".$valor."<br>";  
	eval($asignacion); 
}  

$Nombre=$_POST['Nombre'];
$Apellido=$_POST['Apellido'];
$usuario=$_POST['Usuario'];
$estadousuario=1;
$Intentos=0;
$perfli1=$_SESSION['Perfil'];
$user=new user();
if($result=$user->updateUser($Nombre,$Apellido, $Usuario, $IdEstado, $FecCrea, $FecCambio,$IdEstado2, $Intentos))
{
	$perfil1=$_SESSION['Perfil'];
	$ruta="listarUsuarios.php";
    mover_pag($ruta,"Usuario Actualizado correctamente");
}
else
{
	$ruta="buscarUsuario.php";
	mover_pag($ruta,"Error al Actualizar el usuario");
}
function mover_pag($ruta,$Mensaje)
{
	echo'<script language="Javascript">
   	alert("'.$Mensaje.'")
   	self.location="'.$ruta.'"
   	</script>';
}
?>
