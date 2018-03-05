<?php
include "includes/valAcc.php";
?>
<?php
include "includes/conect.php";

$link=conectarServidor();
foreach ($_POST as $nombre_campo => $valor) 
{ 
	$asignacion = "\$".$nombre_campo."='".$valor."';"; 
	//echo $nombre_campo." = ".$valor."<br>";  
	eval($asignacion); 
}  
//Convertimos en mayusculas el usuario y md5 a password
$usuario1=strtoupper ($Nombre);
$NewPass=strtoupper ($NewPass);
$ConfNewPass= strtoupper ($ConfPass);
$longPass=strlen($NewPass);
if(($NewPass=='123456')||($NewPass==$Nombre)||($NewPass!=$ConfNewPass)||($longPass<6))
{
	echo'<script language="Javascript">
	alert("Password inadecuado, Recuerde utilizar una longitud mayor a 6 caracteres")
	self.location="buscarUsuario2.php"
	</script>';
}
else
{
	//Creamos la sentencia SQL y la ejecutamos
	$year=date("Y");
	$mes=date("m");
	$dia=date("d");
	$fec=$year."-".$mes."-".$dia;
	$sSQL="Update tblusuarios Set clave=md5('$NewPass'), FecCambio='$fec', Intentos=0,
	estadousuario=2 Where usuario='$Nombre'";
	$result1=mysqli_query($link,$sSQL);
	echo'<script language="Javascript">
				alert("Asignacion Exitosa")
				self.location="listarUsuarios.php"
				</script>';
}
mysqli_close($link);
?>
