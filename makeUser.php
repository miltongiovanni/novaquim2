<?php
include "includes/valAcc.php";
?><?php
include "includes/userObj.php";
include "includes/calcularDias.php";

foreach ($_POST as $nombre_campo => $valor) 
{ 
	$asignacion = "\$".$nombre_campo."='".$valor."';"; 
	//echo $nombre_campo." = ".$valor."<br>";  
	eval($asignacion); 
}  
$Usuario=strtoupper ($_POST['Usuario']);
$estadousuario=1;
$fecCambio=Hoy();
$fecCrea=Hoy();
$Intentos=0;
$clave=md5($Usuario);
$user=new user();
if($result=$user->makeUser($Nombre,$Apellido, $clave, $Usuario, $estadousuario, $fecCrea, $fecCambio, $IdPerfil, $Intentos, $Email)){
        $perfil1=$_SESSION['Perfil'];
		$ruta="listarUsuarios.php";
		/******LOG DE CREACION ********
		$IdUser=$_SESSION['IdUsuario'];
		$hh=strftime("%H:").strftime("%M:").strftime("%S");	              
        $Fecha=date("Y")."-".date("m")."-".date("d")." ".$hh;
		$link=conectarServidor();
		$qryAcces="insert into logusuarios(IdUsuario, Fecha, Motivo) values($IdUser,'$Fecha','CREACION DE USUARIO')";
		$result=mysqli_query($link,$qryAcces);
//mysqli_free_result($result);
/* cerrar la conexión 
mysqli_close($link);		********FIN DEL LOG CREACION*****/
        mover_pag($ruta,"Usuario Creado correctamente");
        }
else{
        $ruta="makeUserForm.php";
        mover_pag($ruta,"Error al crear el usuario");
     }

function mover_pag($ruta,$Mensaje){
echo'<script language="Javascript">
   alert("'.$Mensaje.'")
   self.location="'.$ruta.'"
   </script>';
}

?>
