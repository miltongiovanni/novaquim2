<?php
include "../includes/valAcc.php";
?>
<?php

function cargarClases($classname)
{
  require '../clases/'.$classname.'.php';
}

spl_autoload_register('cargarClases');

foreach ($_POST as $nombre_campo => $valor) 
{ 
	$asignacion = "\$".$nombre_campo."='".$valor."';"; 
	//echo $nombre_campo." = ".$valor."<br>";  
	eval($asignacion); 
}  
$manager = new UsersManager();

//Ejecutamos la sentencia SQL
$usuario1=strtoupper ($nombre);
$password1=md5(strtoupper ($password));
$row=$manager->getUserPassword($usuario1, $password1);
if($row)
{
	$nombre=$usuario1;
	$id=$row['idUsuario'];

		$antPass=strtoupper ($password);
		$newPass=strtoupper ($newPass);
		$confnewPass= strtoupper ($confPass);
		$longPass=strlen($newPass);
        if(($newPass=='123456')||($newPass==$antPass)||($newPass==$nombre)||($newPass!=$confnewPass)||($longPass<6))
        {
			echo'<script language="Javascript">
			alert("Password inadecuado, Recuerde utilizar una longitud mayor a 6 caracteres")
			self.location="cambio.php?Nombre='.$Nombre.'&Id='.$Id.'"
			</script>';
		}
		else
		{
			//Creamos la sentencia SQL y la ejecutamos
			$fec=Fecha::Hoy();
			$result1=$manager->changeClave($newPass, $fec, $nombre);
			if($result1)
			{
				echo'<script language="Javascript">
				alert("Cambio Exitoso")
				self.location="listarUsuarios.php"
				</script>';
			}
			else
			{
				$nombre=$_POST['nombre'];
				$id=$row['idUsuario'];
				echo'<script language="Javascript">
				alert("Password inadecuado");
				self.location="cambio.php";
				</script>';
			}
		}
}
else
{
	echo'<script language="Javascript">
	alert("Los datos no corresponden")
	self.location="../index.php"
	</script>';
}
?>
