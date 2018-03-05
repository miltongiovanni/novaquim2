<?php
include "includes/valAcc.php";
?>
<?php
include "includes/cliObj.php";
include "includes/calcularDias.php";

foreach ($_POST as $nombre_campo => $valor) 
{ 
	$asignacion = "\$".$nombre_campo."='".$valor."';"; 
	//echo $nombre_campo." = ".$valor."<br>";  
	eval($asignacion); 
}  
$bd="novaquim";
$cliente=new Client();
$link=conectarServidor();   


if($result=$cliente->makeClient($bd, $NIT, $Cliente, $Direccion, $Contacto, $Cargo, $Tel1, $Fax, $IdCat, $Estado, $ciudad_cli, $Rete_iva, $Rete_ica, $Rete_fte, $localidad, $vendedor))
{
		echo '<form method="post" action="listarConsultor.php" name="form3">';
		echo'<input name="Estado" type="hidden" value="'.$Estado.'">';
		echo '</form>';
		echo'<script language="Javascript">
			document.form3.submit();
			alert("Cliente Creado correctamente");
			</script>';	
		$link=conectarServidor();
		$qrys="insert into clientes_sucursal (Nit_clien, Nom_sucursal, Dir_sucursal, Tel_sucursal, Ciudad_sucursal, Id_sucursal )
        values ('$NIT', '$Cliente','$Direccion', $Tel1, $ciudad_cli, 1 )";
		echo $qrys;
		$results=mysql_db_query($bd,$qrys);
		/******LOG DE CREACION *********
		$IdUser=$_SESSION['IdUsuario'];
		$hh=strftime("%H:").strftime("%M:").strftime("%S");	              
        $Fecha=date("Y")."-".date("m")."-".date("d")." ".$hh;
		$qryAcces="insert into logusuarios(IdUsuario, Fecha, Motivo) values($IdUser,'$Fecha','CREACION DE USUARIO')";
		$ResutLog=mysql_db_query("users",$qryAcces);
		/*********FIN DEL LOG CREACION*****/
		mysql_close($link);//Cerrar la conexion
}
else{
        $ruta="makeClienForm.php";
		mysql_close($link);//Cerrar la conexion        
		mover_pag($ruta,"Error al crear el Cliente");

     }


function mover_pag($ruta,$Mensaje){
echo'<script language="Javascript">
   alert("'.$Mensaje.'")
   self.location="'.$ruta.'"
   </script>';
}

?>
