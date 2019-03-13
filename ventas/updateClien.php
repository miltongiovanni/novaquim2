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
if($result=$cliente->updateClient($nit, $nom_cliente, $direccion, $Contacto, $Cargo, $celular, $tel1, $fax, $email, $Id_Cat, $Estado, $Id_Ciudad, $Ret_iva, $Ret_ica, $Ret_fte, $Id_vendor))
{
	echo '<form method="post" action="listarClien2.php" name="form3">';
	echo'<input name="Estado" type="hidden" value="'.$Estado.'">';
	//echo '<input type="submit" name="Submit" value="">'; 
	echo '</form>';
	echo'<script language="Javascript">
		alert("Cliente Actualizado Correctamente");
		document.form3.submit();
		</script>';	
}
else
{
	$ruta="buscarClien.php";
	mover_pag($ruta,"Error al Actualizar el Cliente");
}
function mover_pag($ruta,$Mensaje)
{
	echo'<script language="Javascript">
   	alert("'.$Mensaje.'")
   	self.location="'.$ruta.'"
   	</script>';
}
?>
