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
//Ejecutamos la sentencia SQL
$usuario1=strtoupper ($Nombre);
$password1=md5(strtoupper ($Password));
$QRY="select * from tblusuarios where Usuario='$usuario1' and clave ='$password1'";
$result=mysqli_query($link,$QRY);
$row=mysqli_fetch_array($result);
if($row)
{
	$Nombre=$usuario1;
	$Id=$row['IdUsuario'];
	if(mysqli_num_rows($result) != 0)
	{
		$AntPass=strtoupper ($Password);
		$NewPass=strtoupper ($NewPass);
		$ConfNewPass= strtoupper ($ConfPass);
		$longPass=strlen($NewPass);
        if(($NewPass=='123456')||($NewPass==$AntPass)||($NewPass==$Nombre)||($NewPass!=$ConfNewPass)||($longPass<6))
        {
			echo'<script language="Javascript">
			alert("Password inadecuado, Recuerde utilizar una longitud mayor a 6 caracteres")
			self.location="cambio.php?Nombre='.$Nombre.'&Id='.$Id.'"
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
			if($result1)
			{
				/******LOG DE VENCIMIENTO DE CLAVE*********/
				$hh=strftime("%H:").strftime("%M:").strftime("%S");	              
				$Fecha=date("Y")."-".date("m")."-".date("d")." ".$hh;
				$qryAcces="insert into logusuarios(IdUsuario, Fecha, Motivo) values($Id,'$Fecha','CAMBIO DE CLAVE EXITOSO')";
				$ResutLog=mysqli_query($link,$qryAcces);
				/*********FIN DEL LOG VENCIMIENTO DE CLAVE*****/  
				echo'<script language="Javascript">
				alert("Cambio Exitoso")
				self.location="listarUsuarios.php"
				</script>';
			}
			else
			{
				$Nombre=$_POST['Nombre'];
				$Id=$row['IdUsuario'];
				echo'<script language="Javascript">
				alert("Password inadecuado")
				self.location="cambio.php?Nombre='.$Nombre.'&Id='.$Id.'"
				</script>';
			}
		}
	}
	else
	{
		$error="Error de usuario";
		echo $error;
		$_SESSION['auth']=false;
	}
}
else
{
	echo'<script language="Javascript">
	alert("Los datos no corresponden")
	self.location="index.php"
	</script>';
}
mysqli_free_result($result);
mysqli_close();
?>
