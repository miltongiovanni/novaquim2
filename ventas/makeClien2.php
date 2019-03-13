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
$cliente=new Client();
$link=conectarServidor();   

$Fecha=date("Y")."-".date("m")."-".date("d");

if($result=$cliente->makeClient($NIT, $Cliente, $Direccion, $Contacto, $Cargo, $Tel1, $Fax, $IdCat, $Estado, $ciudad_cli, $Rete_iva, $Rete_ica, $Rete_fte, $celular, $vendedor, $Fecha))
{
		echo '<form method="post" action="listarClien.php" name="form3">';
		echo'<input name="Estado" type="hidden" value="'.$Estado.'">';
		echo '</form>';
		echo'<script language="Javascript">
		    alert("Cliente Creado correctamente");
			document.form3.submit();
			</script>';	
		$link=conectarServidor();
		$qrys="insert into clientes_sucursal (Nit_clien, Nom_sucursal, Dir_sucursal, Tel_sucursal, Ciudad_sucursal, Id_sucursal )
        values ('$NIT', '$Cliente','$Direccion', $Tel1, $ciudad_cli, 1 )";
		$results=mysqli_query($link,$qrys);
		/******LOG DE CREACION *********
		$IdUser=$_SESSION['IdUsuario'];
		$hh=strftime("%H:").strftime("%M:").strftime("%S");	              
        $Fecha=date("Y")."-".date("m")."-".date("d")." ".$hh;
		$qryAcces="insert into logusuarios(IdUsuario, Fecha, Motivo) values($IdUser,'$Fecha','CREACION DE USUARIO')";
		$ResutLog=mysql_db_query("users",$qryAcces);
		/*********FIN DEL LOG CREACION*****/
		mysqli_close($link);//Cerrar la conexion
}
else{
        $ruta="makeClienForm.php";
		mysqli_close($link);//Cerrar la conexion        
		mover_pag($ruta,"Error al crear el Cliente");

     }


function mover_pag($ruta,$Mensaje){
echo'<script language="Javascript">
   alert("'.$Mensaje.'")
   self.location="'.$ruta.'"
   </script>';
}

?>
