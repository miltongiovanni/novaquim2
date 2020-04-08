<?php include "includes/valAcc.php";
?>
<?php
include "includes/calcularDias.php";
include "includes/conect.php";
foreach ($_POST as $nombre_campo => $valor) 
{ 
	$asignacion = "\$".$nombre_campo."='".$valor."';"; 
	//echo $nombre_campo." = ".$valor."<br>";  
	eval($asignacion); 
}  
$bd="novaquim";
$link=conectarServidor();
$qry="insert into clientes_cotiz (Nom_clien, Contacto, Cargo, Tel_clien, Fax_clien, Cel_clien, Dir_clien, Eml_clien, Id_cat_clien, Ciudad_clien, cod_vend)
	  values ('$Cliente', '$Contacto', '$Cargo', $Tel1, $Fax, $celular, '$Direccion', '$email', $IdCat, $ciudad_cli, $vendedor)"; 
$result=mysqli_query($link,$qry);
if($result)
{			
		$ruta="listarClientCot.php";
		mysqli_close($link);//Cerrar la conexion        
		mover_pag($ruta,"Cliente Creado Correctamente");
		/******LOG DE CREACION *********
		$IdUser=$_SESSION['IdUsuario'];
		$hh=strftime("%H:").strftime("%M:").strftime("%S");	              
        $Fecha=date("Y")."-".date("m")."-".date("d")." ".$hh;
		$qryAcces="insert into logusuarios(IdUsuario, Fecha, Motivo) values($IdUser,'$Fecha','CREACION DE USUARIO')";
		$ResutLog=mysql_db_query("users",$qryAcces);
		/*********FIN DEL LOG CREACION*****/
}
else
{
	$ruta="makeClienCotForm.php";
	mysqli_close($link);//Cerrar la conexion        
	mover_pag($ruta,"Error al crear el Cliente");

 }


function mover_pag($ruta,$Mensaje){
echo'<script >
   alert("'.$Mensaje.'")
   self.location="'.$ruta.'"
   </script>';
}

?>
