<?php
include "includes/conect.php";
include "includes/calcularDias.php";
$link=conectarServidor();


if($link)
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
   	$result=mysql_db_query("novaquim",$QRY);
   	$row=mysql_fetch_array($result);
   	if(!$row)
   	{//si existen datos pero la clave esta errada
  		$QRY="select * from tblusuarios where usuario= '$Nombre'";
		//verificacion de nombre en la Base de datos
		$result=mysql_db_query("novaquim",$QRY);
		$row=mysql_fetch_array($result);		
		if($row)
		{
			/********ERROR DE ACCESO********/
			$IdUser=$row['IdUsuario'];
			$hh=strftime("%H:").strftime("%M:").strftime("%S");	              
            $Fecha=date("Y")."-".date("m")."-".date("d")." ".$hh;
			$qryAcces="insert into logusuarios(IdUsuario, Fecha, Motivo) values($IdUser,'$Fecha','ERROR DE CLAVE')";
			$ResutLog=mysql_db_query("novaquim",$qryAcces);
			/*********FIN DEL LOG DE acceso*******/
			
			//si el usuario existe se le adiciona 1 intento a los 4 intentos se debe bloquear el usuario
			$intentos=$row['Intentos']+1;
			$QRY="update tblusuarios set Intentos=$intentos where usuario='$Nombre'";
		    $result=mysql_db_query("novaquim",$QRY);
			$ruta="index1.php";
			$nota="Los Datos no son Correctos por favor verifique la información";
			mover_pag($ruta,$nota);	
		}
		else
		{
			$ruta="index1.php";
			/********ERROR DE ACCESO********/
			$IdUser=$row['IdUsuario'];
			$hh=strftime("%H:").strftime("%M:").strftime("%S");	              
            $Fecha=date("Y")."-".date("m")."-".date("d")." ".$hh;
			echo $qryAcces="insert into logusuarios(IdUsuario, Fecha, Motivo) values($IdUser,'$Fecha','ERROR DE CLAVE')";
			$ResutLog=mysql_db_query("novaquim",$qryAcces);
			/*********FIN DEL LOG DE acceso*******/
			$nota="Los Datos no son Correctos por favor verifique la información";
			mover_pag($ruta,$nota);
		}
   	}	
   	$total=mysql_num_rows($result);
   	//si se superan los controles iniciales
   	if($total==1)
	{
		$fechaFinal=$row['FecCambio']." ".$hh=strftime("%H:").strftime("%M:").strftime("%S");
		$Fecha=Hoy()." ".$hh=strftime("%H:").strftime("%M:").strftime("%S");
		$dias=Calc_Dias($Fecha,$fechaFinal);//calculo de dias para validar la antiguedad del ultimo cambio
		$op=$row['EstadoUsuario'];
		$perfil_admin=$row['IdPerfil'];	
		$Id=$row['IdUsuario'];
		$intentos=$row['Intentos'];
		if($op==3)
		{//Si el usuario está bloqueado no se le deja continuar
			$ruta="index1.php";
			$nota="Usuario bloqueado, consulte al administrador del sistema";
			mover_pag($ruta,$nota);
		}
    	if($op==2)
		{//Cuando el usuario es 2 esta activo de lo contrario se toma como nuevo
			if($intentos<=3)//Numero de intentos
			{
				if($dias<=90)//Numero de dias
				{
					 $QRY="update tblusuarios set Intentos=0 where usuario='$Nombre'";
					 $result=mysql_db_query("users",$QRY);
					 session_start();
					 $_SESSION['Autorizado']=true;
					 $_SESSION['User']=$Nombre;
					 $_SESSION['IdUsuario']=$row['IdUsuario'];
					 $_SESSION['Perfil']=MD5($perfil_admin);
					 $perfil =md5( $row['IdPerfil']);
					 //echo $perfil.'<br>';
					 /******LOG DE ACCESO AL SISTEMA*********/
					 $IdUser=$row['IdUsuario'];
					 $hh=strftime("%H:").strftime("%M:").strftime("%S");	              
					 $Fecha=date("Y")."-".date("m")."-".date("d")." ".$hh;
					 $qryAcces="insert into logusuarios(IdUsuario, Fecha, Motivo) values($IdUser,'$Fecha','ACCESO')";
					 $ResutLog=mysql_db_query("novaquim",$qryAcces);
					 
					 /*********FIN DEL LOG DE INGRESO*******/
	 
					 echo '<script language=javascript> 
					 
					 var nom_ventana="ventana1";
					 var ventana1=window.open("menu.php",nom_ventana,"toolbar=no,location=no,scrollbars=no,resizable=no,width=1280,height=575");
					   //ventana1.focus();
					   	//alert (ventana1.name);
						//if (ventana1.closed!=
						//alert (ventana1.closed);
					</script> ';
					 
					 
					 
					 //$ruta="menu2.php";
					 //mover_pag($ruta,$row['Nombre']." bienvenido al sistema de Inventarios de Industrias Novaquim S.A.S.");
				}
				else
				{
				  
					$ruta="cambio.php?nombre=$Nombre";
					$nota="Su ultimo cambio fue hace mas de 90 dias, por favor cambie su contraseña";
					$QRY="update tblusuarios set intentos=0 where usuario='$Nombre'";	
					 $result=mysql_db_query("novaquim",$QRY);
					 session_start();
					 $_SESSION['Autorizado']=true;
					 $_SESSION['User']=$Nombre;
					 $_SESSION['IdUsuario']=$row['IdUsuario'];
					 $_SESSION['Perfil']=MD5($perfil_admin);				 
					 $perfil =md5( $row['IdPerfil']);
					/******LOG DE VENCIMIENTO DE CLAVE*********/
					 $IdUser=$row['IdUsuario'];
					 $hh=strftime("%H:").strftime("%M:").strftime("%S");	              
					 $Fecha=date("Y")."-".date("m")."-".date("d")." ".$hh;
					  $qryAcces="insert into logusuarios(IdUsuario, Fecha, Motivo) values($IdUser,'$Fecha','CLAVE VENCIDA')";
					 $ResutLog=mysql_db_query("novaquim",$qryAcces);
					 
					 /*********FIN DEL LOG VENCIMIENTO DE CLAVE*****/
					mover_pag($ruta,$nota);
				}
			}
			else
			{
				$ruta="index1.php";
				$nota="La clave se encuentra bloqueada por favor contacte al administrador";
				/******LOG CLAVE BLOQUEADA*********/
					 $IdUser=$row['IdUsuario'];
					 $hh=strftime("%H:").strftime("%M:").strftime("%S");	              
					 $Fecha=date("Y")."-".date("m")."-".date("d")." ".$hh;
					 echo $qryAcces="insert into logusuarios(IdUsuario, Fecha, Motivo) values($IdUser,'$Fecha','BLOQUEO')";
					 $ResutLog=mysql_db_query("novaquim",$qryAcces);
					 
			  /*********FIN DEL LOG BLOQUEO*****/
				mover_pag($ruta,$nota);
			}
    	}
		else
		{
			$ruta="cambio.php";
			/******LOG PRIMER INGRESO*********/
			 $IdUser=$row['IdUsuario'];
			 $hh=strftime("%H:").strftime("%M:").strftime("%S");	              
			 $Fecha=date("Y")."-".date("m")."-".date("d")." ".$hh;
			 $qryAcces="insert into logusuarios(IdUsuario, Fecha, Motivo) values($IdUser,'$Fecha','PRIMER INGRESO')";
			 $ResutLog=mysql_db_query("novaquim",$qryAcces);
					 
			/*********FIN PRIMER INGRESO*****/
			$nota="Primer Ingreso cambie su contraseña";
			session_start();
			$_SESSION['Autorizado']=true;
			$_SESSION['User']=$Nombre;
			$_SESSION['IdUsuario']=$row['IdUsuario'];
			$_SESSION['Perfil']=MD5($perfil_admin);
			mover_pag($ruta,$nota);
		}
   	}
	mysql_close($link);//Cerrar la conexion
}

function mover_pag($ruta,$nota)
{
	//Funcion que permite el redireccionamiento de los usuarios a otra pagina 
	echo'<script language="Javascript">
	alert("'.$nota.'")
	self.location="'.$ruta.'"
	</script>';
}
?>