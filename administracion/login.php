<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
</head>

<body>
<?php

function chargerClasse($classname)
{
  require '../clases/'.$classname.'.php';
}

spl_autoload_register('chargerClasse');
function mover_pag($ruta, $mensaje)
{
    echo '<script >
   	alert("' . $mensaje . '")
   	self.location="' . $ruta . '"
   	</script>';
}

//include "includes/conect.php";
include "../includes/calcularDias.php";
//$con=conectarServidor();
$con=Conectar::conexion();
foreach ($_POST as $nombre_campo => $valor) {
    ${$nombre_campo} = $valor;
    if(is_array($valor)){
        //echo $nombre_campo.print_r($valor).'<br>';
    }else{
        //echo $nombre_campo. '=' .${$nombre_campo}.'<br>';
    }
}
$mensaje="";
if($con)
{
	
	if((strlen($_POST['nombre']))<=16)	//El nombre de usuario no debe superar la longitud de 16
	{
		$nombre=strtoupper ($_POST['nombre']);
		$password=md5(strtoupper ($_POST['password']));
	}
	else 
	{
		mover_pag("../index.php","El nombre del usuario es muy grande");
	}
 	//Validacion de nombre y usuario
   	$QRY="SELECT * FROM usuarios WHERE usuario= '$nombre' AND clave='$password'";
   	$result = $con->query($QRY);
   	$row = $result->fetch(PDO::FETCH_ASSOC);
   	if(!$row)
   	{//si existen datos pero la clave esta errada
  		$QRY1="select * from usuarios where usuario= '$nombre'";
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
			$QRY2="UPDATE usuarios SET intentos=$intentos WHERE usuario='$nombre'";
		    $result2 = $con->query($QRY2);
			$ruta="../index.php";
			$mensaje="Los Datos no son Correctos por favor verifique la información";
			mover_pag($ruta,$mensaje);	
		}
		else
		{
			$ruta="../index.php";
			/********ERROR DE ACCESO*******
			$IdUser=$row['IdUsuario'];
			$hh=strftime("%H:").strftime("%M:").strftime("%S");	              
            $Fecha=date("Y")."-".date("m")."-".date("d")." ".$hh;
			$qryAcces="insert into logusuarios(IdUsuario, Fecha, Motivo) values($IdUser,'$Fecha','ERROR DE CLAVE')";
			//$ResutLog=con_query($link,$qryAcces);
			$ResutLog = $con->query($qryAcces);
			/*********FIN DEL LOG DE acceso*******/
			$mensaje="Los Datos no son Correctos por favor verifique la información";
			mover_pag($ruta,$mensaje);
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
			$ruta="../index.php";
			$mensaje="Usuario bloqueado, consulte al administrador del sistema";
			mover_pag($ruta,$mensaje);
		}
    	if($op==2)
		{//Cuando el usuario es 2 esta activo de lo contrario se toma como nuevo
			if($intentos<=3)//Numero de intentos
			{
				if($dias<=90)//Numero de dias
				{
					 $QRY3="UPDATE usuarios SET intentos=0 WHERE usuario='$nombre'";
					 $result3 = $con->query($QRY3);
					 session_start();
					 $_SESSION['Autorizado']=true;
					 $_SESSION['User']=$nombre;
					 $_SESSION['IdUsuario']=$row['idUsuario'];
					 $_SESSION['Perfil']=$perfil_admin;
					 $perfil = $row['idPerfil'];
					 //echo $perfil.'<br>';
					 /******LOG DE ACCESO AL SISTEMA********
					 $IdUser=$row['IdUsuario'];
					 $hh=strftime("%H:").strftime("%M:").strftime("%S");	              
					 $Fecha=date("Y")."-".date("m")."-".date("d")." ".$hh;
					 $qryAcces="insert into logusuarios(IdUsuario, Fecha, Motivo) values($IdUser,'$Fecha','ACCESO')";
					 $ResutLog = $con->query($qryAcces);
					 //$ResutLog=con_query($link,$qryAcces);
					 
					 /*********FIN DEL LOG DE INGRESO*******/
					 $ruta="../menu.php";
					 mover_pag($ruta,$row['nombre']." bienvenid@ al Sistema de Inventarios de Industrias Novaquim S.A.S.");
				}
				else
				{
				  
					$ruta="cambio.php?nombre=$nombre";
					$mensaje="Su último cambio fue hace mas de 90 días, por favor cambie su contraseña";
					//$mensaje=utf8_encode($mensaje);
					$QRY4="update usuarios set intentos=0 where usuario='$nombre'";	
					$result4 = $con->query($QRY4);
					 session_start();
					 $_SESSION['Autorizado']=true;
					 $_SESSION['User']=$nombre;
					 $_SESSION['IdUsuario']=$row['idUsuario'];
					 $_SESSION['Perfil']=$perfil_admin;
					 $perfil =$row['idPerfil'];
					/******LOG DE VENCIMIENTO DE CLAVE********
					 $IdUser=$row['IdUsuario'];
					 $hh=strftime("%H:").strftime("%M:").strftime("%S");	              
					 $Fecha=date("Y")."-".date("m")."-".date("d")." ".$hh;
					  $qryAcces="insert into logusuarios(IdUsuario, Fecha, Motivo) values($IdUser,'$Fecha','CLAVE VENCIDA')";
					 //$ResutLog=con_query($link,$qryAcces);
					 $ResutLog = $con->query($qryAcces);
					 
					 /*********FIN DEL LOG VENCIMIENTO DE CLAVE*****/
					mover_pag($ruta,$mensaje);
				}
			}
			else
			{
				$ruta="../index.php";
				$mensaje="La clave se encuentra bloqueada por favor contacte al administrador";
				/******LOG CLAVE BLOQUEADA********
					 $IdUser=$row['IdUsuario'];
					 $hh=strftime("%H:").strftime("%M:").strftime("%S");	              
					 $Fecha=date("Y")."-".date("m")."-".date("d")." ".$hh;
					 $qryAcces="insert into logusuarios(IdUsuario, Fecha, Motivo) values($IdUser,'$Fecha','BLOQUEO')";
					 //$ResutLog=con_query($link,$qryAcces);
					 $ResutLog = $con->query($qryAcces);
					 
			  /*********FIN DEL LOG BLOQUEO*****/
				mover_pag($ruta,$mensaje);
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
			$mensaje="Primer Ingreso cambie su contraseña";
			$mensaje=utf8_encode($mensaje);
			session_start();
			$_SESSION['Autorizado']=true;
			$_SESSION['User']=$nombre;
			$_SESSION['IdUsuario']=$row['idUsuario'];
			$_SESSION['Perfil']=$perfil_admin;
			mover_pag($ruta,$mensaje);
		}
   	}
	/* cerrar el resulset */
	$result->free();
	
	/* cerrar la conexi�n */
	$con->close();
}


?>
</body>

</html>
