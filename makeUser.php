<?php
include "includes/valAcc.php";
?><?php
//include "includes/conect.php";
//include "includes/calcularDias.php";
// On enregistre notre autoload.
function chargerClasse($classname)
{
  require 'includes/'.$classname.'.php';
}

spl_autoload_register('chargerClasse');

//include "includes/userObj.php";


foreach ($_POST as $nombre_campo => $valor) 
{ 
	$asignacion = "\$".$nombre_campo."='".$valor."';"; 
	//echo $nombre_campo." = ".$valor."<br>";  
	eval($asignacion); 
}  
$usuario=strtoupper ($_POST['usuario']);
$estadoUsuario=1;
$fecCambio=Hoy();
$fecCrea=Hoy();
$intentos=0;
$clave=md5($usuario);

$datos=[
	'nombre' => $nombre,
	'apellido' => $apellido,
	'usuario' => $usuario,
	'clave' => $clave,
	'estadoUsuario' => $estadoUsuario,
	'fecCrea' => $fecCrea,
	'fecCambio' => $fecCambio,
	'idPerfil' => $idPerfil,
	'intentos' => $intentos
];
$user = new user($datos);
//$mysqli = conectarServidor();
$manager = new UsersManager();

if($result = $manager->makeUser($user))
{
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
