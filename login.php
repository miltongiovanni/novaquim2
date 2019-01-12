<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
</head>

<body>
<?php

function chargerClasse($classname)
{
  require 'includes/'.$classname.'.php';
}

spl_autoload_register('chargerClasse');


//include "includes/conect.php";
include "includes/calcularDias.php";
//$con=conectarServidor();
$con=Conectar::conexion();
foreach ($_POST as $nombre_campo => $valor) 
{ 
	$asignacion = "\$".$nombre_campo."='".$valor."';"; 
	//echo $nombre_campo." = ".$valor."<br>";  
	eval($asignacion); 
}  
$nota="";
if($con)
{
	
	if((strlen($_POST['Nombre']))<=16)	//El nombre de usuario no debe superar la longitud de 16
	{
		$Nombre=strtoupper ($_POST['Nombre']);
		$Password=md5(strtoupper ($_POST['Password']));
	}
	else 
	{
		mover_pag("index.php","El nombre del usuario es muy grande");
	}
 	//Validacion de nombre y usuario
   	$QRY="select * from tblusuarios where usuario= '$Nombre' AND clave='$Password'";
   	$result = $con->query($QRY);
   	$row = $result->fetch(PDO::FETCH_ASSOC);
   	if(!$row)
   	{//si existen datos pero la clave esta errada
  		$QRY1="select * from tblusuarios where usuario= '$Nombre'";
		//verificacion de nombre en la Base de datos
		$result1 = $con->query($QRY1);
		$row1 = $result1->fetch(PDO::FETCH_ASSOC);	
		if($row1)
		{
			/********ERROR DE ACCESO*******
			$IdUser=$row['IdUsuario'];
			$hh=strftime("%H:").strftime("%M:").strftime("%S");	              
            $Fecha=date("Y")."-".date("m")."-".date("d")." ".$hh;
			$qryAcces="insert into logusuarios(IdUsuario, Fecha, Motivo) values($IdUser,'$Fecha','ERROR DE CLAVE')";
			//$ResutLog=con_query($link,$qryAcces);
			$ResutLog = $con->query($qryAcces);
			/*********FIN DEL LOG DE acceso*******/
			
			//si el usuario existe se le adiciona 1 intento a los 4 intentos se debe bloquear el usuario
			$intentos=$row['Intentos']+1;
			$QRY2="update tblusuarios set intentos=$intentos where usuario='$Nombre'";
		    $result2 = $con->query($QRY2);
			$ruta="index.php";
			$nota="Los Datos no son Correctos por favor verifique la informaci�n";
			$nota=utf8_encode($nota);
			mover_pag($ruta,$nota);	
		}
		else
		{
			$ruta="index.php";
			/********ERROR DE ACCESO*******
			$IdUser=$row['IdUsuario'];
			$hh=strftime("%H:").strftime("%M:").strftime("%S");	              
            $Fecha=date("Y")."-".date("m")."-".date("d")." ".$hh;
			$qryAcces="insert into logusuarios(IdUsuario, Fecha, Motivo) values($IdUser,'$Fecha','ERROR DE CLAVE')";
			//$ResutLog=con_query($link,$qryAcces);
			$ResutLog = $con->query($qryAcces);
			/*********FIN DEL LOG DE acceso*******/
			$nota="Los Datos no son Correctos por favor verifique la informaci�n";
			$nota=utf8_encode($nota);
			mover_pag($ruta,$nota);
		}
   	}	
   	else  	//si se superan los controles iniciales
	{
		$fechaFinal=$row['fecCambio'];
		$Fecha=Hoy();
		$dias=Calc_Dias($Fecha,$fechaFinal);//calculo de dias para validar la antiguedad del ultimo cambio
		$op=$row['estadoUsuario'];
		$perfil_admin=$row['idPerfil'];	
		$Id=$row['idUsuario'];
		$intentos=$row['intentos'];
		if($op==3)
		{//Si el usuario está bloqueado no se le deja continuar
			$ruta="index.php";
			$nota="Usuario bloqueado, consulte al administrador del sistema";
			mover_pag($ruta,$nota);
		}
    	if($op==2)
		{//Cuando el usuario es 2 esta activo de lo contrario se toma como nuevo
			if($intentos<=3)//Numero de intentos
			{
				if($dias<=90)//Numero de dias
				{
					 $QRY3="update tblusuarios set intentos=0 where usuario='$Nombre'";
					 $result3 = $con->query($QRY3);
					 session_start();
					 $_SESSION['Autorizado']=true;
					 $_SESSION['User']=$Nombre;
					 $_SESSION['IdUsuario']=$row['idUsuario'];
					 $_SESSION['Perfil']=MD5($perfil_admin);
					 $perfil =md5( $row['idPerfil']);
					 //echo $perfil.'<br>';
					 /******LOG DE ACCESO AL SISTEMA********
					 $IdUser=$row['IdUsuario'];
					 $hh=strftime("%H:").strftime("%M:").strftime("%S");	              
					 $Fecha=date("Y")."-".date("m")."-".date("d")." ".$hh;
					 $qryAcces="insert into logusuarios(IdUsuario, Fecha, Motivo) values($IdUser,'$Fecha','ACCESO')";
					 $ResutLog = $con->query($qryAcces);
					 //$ResutLog=con_query($link,$qryAcces);
					 
					 /*********FIN DEL LOG DE INGRESO*******/
					 $ruta="menu.php";
					 mover_pag($ruta,$row['nombre']." bienvenid@ al sistema de Inventarios de Industrias Novaquim S.A.S.");
				}
				else
				{
				  
					$ruta="cambio.php?nombre=$Nombre";
					$nota="Su �ltimo cambio fue hace mas de 90 d�as, por favor cambie su contrase�a";
					$nota=utf8_encode($nota);
					$QRY4="update tblusuarios set intentos=0 where usuario='$Nombre'";	
					$result4 = $con->query($QRY4);
					 session_start();
					 $_SESSION['Autorizado']=true;
					 $_SESSION['User']=$Nombre;
					 $_SESSION['IdUsuario']=$row['IdUsuario'];
					 $_SESSION['Perfil']=MD5($perfil_admin);				 
					 $perfil =md5( $row['IdPerfil']);
					/******LOG DE VENCIMIENTO DE CLAVE********
					 $IdUser=$row['IdUsuario'];
					 $hh=strftime("%H:").strftime("%M:").strftime("%S");	              
					 $Fecha=date("Y")."-".date("m")."-".date("d")." ".$hh;
					  $qryAcces="insert into logusuarios(IdUsuario, Fecha, Motivo) values($IdUser,'$Fecha','CLAVE VENCIDA')";
					 //$ResutLog=con_query($link,$qryAcces);
					 $ResutLog = $con->query($qryAcces);
					 
					 /*********FIN DEL LOG VENCIMIENTO DE CLAVE*****/
					mover_pag($ruta,$nota);
				}
			}
			else
			{
				$ruta="index.php";
				$nota="La clave se encuentra bloqueada por favor contacte al administrador";
				/******LOG CLAVE BLOQUEADA********
					 $IdUser=$row['IdUsuario'];
					 $hh=strftime("%H:").strftime("%M:").strftime("%S");	              
					 $Fecha=date("Y")."-".date("m")."-".date("d")." ".$hh;
					 $qryAcces="insert into logusuarios(IdUsuario, Fecha, Motivo) values($IdUser,'$Fecha','BLOQUEO')";
					 //$ResutLog=con_query($link,$qryAcces);
					 $ResutLog = $con->query($qryAcces);
					 
			  /*********FIN DEL LOG BLOQUEO*****/
				mover_pag($ruta,$nota);
			}
    	}
		else
		{
			$ruta="cambio.php";
			/******LOG PRIMER INGRESO********
			 $IdUser=$row['IdUsuario'];
			 $hh=strftime("%H:").strftime("%M:").strftime("%S");	              
			 $Fecha=date("Y")."-".date("m")."-".date("d")." ".$hh;
			 $qryAcces="insert into logusuarios(IdUsuario, Fecha, Motivo) values($IdUser,'$Fecha','PRIMER INGRESO')";
			 //$ResutLog=con_query($link,$qryAcces);
			 $ResutLog = $con->query($qryAcces);
					 
			/*********FIN PRIMER INGRESO*****/
			$nota="Primer Ingreso cambie su contraseña";
			$nota=utf8_encode($nota);
			session_start();
			$_SESSION['Autorizado']=true;
			$_SESSION['User']=$Nombre;
			$_SESSION['IdUsuario']=$row['IdUsuario'];
			$_SESSION['Perfil']=MD5($perfil_admin);
			mover_pag($ruta,$nota);
		}
   	}
	/* cerrar el resulset */
	$result->free();
	
	/* cerrar la conexi�n */
	$con->close();
}

function mover_pag($ruta,$nota)
{
	echo'<script>
   	alert("'.$nota.'")
   	self.location="'.$ruta.'"
   	</script>';
}
?>
</body>

</html>
