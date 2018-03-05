<?php
include "includes/valAcc.php";
?><?php
include "includes/personObj.php";
include "includes/calcularDias.php";

foreach ($_POST as $nombre_campo => $valor) 
{ 
	$asignacion = "\$".$nombre_campo."='".$valor."';"; 
	//echo $nombre_campo." = ".$valor."<br>";  
	eval($asignacion); 
}  
$persona=new person();
if($result=$persona->makePerson($nombre, $estado, $area, $celular, $email, $cargo))
{
		$ruta="listarPersonal.php";
		/******LOG DE CREACION ********
		$IdUser=$_SESSION['IdUsuario'];
		$hh=strftime("%H:").strftime("%M:").strftime("%S");	              
        $Fecha=date("Y")."-".date("m")."-".date("d")." ".$hh;
		$link=conectarServidor();
		$qryAcces="insert into logusuarios(IdUsuario, Fecha, Motivo) values($IdUser,'$Fecha','CREACION DE USUARIO')";
		$ResutLog=mysql_db_query("users",$qryAcces);
		mysql_close($link);
		/*********FIN DEL LOG CREACION*****/
        mover_pag($ruta,"Personal Creado correctamente");
        }
else{
        $ruta="makePersonalForm.php";
        mover_pag($ruta,"Error al crear el Personal");
     }

function mover_pag($ruta,$Mensaje){
echo'<script language="Javascript">
   alert("'.$Mensaje.'")
   self.location="'.$ruta.'"
   </script>';
}

?>
