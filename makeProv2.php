<?php
include "includes/valAcc.php";
?><?php
include "includes/provObj.php";

foreach ($_POST as $nombre_campo => $valor) 
{ 
	$asignacion = "\$".$nombre_campo."='".$valor."';"; 
	//echo $nombre_campo." = ".$valor."<br>";  
	eval($asignacion); 
}  
$prov=new prover();
if($result=$prov->makeProv($NIT, $Proveedor, $Direccion, $Contacto, $Tel1, $Fax, $Email, $IdCat, $autoret, $Tasa_reteica, $regimen))
{
		$ruta="listarProv.php";
		/******LOG DE CREACION *********
		$IdUser=$_SESSION['IdUsuario'];
		$hh=strftime("%H:").strftime("%M:").strftime("%S");	              
        $Fecha=date("Y")."-".date("m")."-".date("d")." ".$hh;
		$qryAcces="insert into logusuarios(IdUsuario, Fecha, Motivo) values($IdUser,'$Fecha','CREACION DE USUARIO')";
		$ResutLog=mysql_db_query("users",$qryAcces);
		/*********FIN DEL LOG CREACION*****/
		echo'<form action="detProveedor.php" method="post" name="formulario">';
		echo '<input name="NIT" type="hidden" value="'.$NIT.'"/>
		<input name="IdCat" type="hidden" value="'.$IdCat.'"/>
		<input name="Crear" type="hidden" value="0"/>
		<input type="submit" name="Submit" value="Cambiar" />';
		echo'</form>';        
		mover_pag2("Proveedor Creado correctamente");
		//Cerrar la conexion
}
else{
        $ruta="makeProvForm.php";
        mover_pag($ruta,"Error al crear el Proveedor");
		//Cerrar la conexion
     }
function mover_pag($ruta,$Mensaje){
echo'<script language="Javascript">
   alert("'.$Mensaje.'")
   self.location="'.$ruta.'"
   </script>';
}

function mover_pag2($Mensaje)
	{
	echo'<script language="Javascript">
	alert("'.$Mensaje.'");
	document.formulario.submit();
	</script>';
	}
?>
