<?php
include "../includes/valAcc.php";
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
$link=conectarServidor();
$qry="update clientes_sucursal set nomSucursal='$nom_sucursal', dirSucursal='$dir_sucursal', telSucursal=$tel_sucursal, ciudadSucursal=$ciudad_sucursal where Nit_clien='$NIT' and idSucursal=$Id_Sucursal";
$result=mysqli_query($link,$qry);
if($result)
{
	echo '<form method="post" action="detCliente.php" name="form3">';
	echo'<input name="NIT" type="hidden" value="'.$NIT.'">';
	echo'<input name="Crear" type="hidden" value="0">';
	echo '<input type="submit" name="Submit" value="">'; 
	echo '</form>';
	echo'<script >
		document.form3.submit();
		alert("Sucursal Actualizada Correctamente");
		</script>';	
}
else
{
	$ruta="buscarClien.php";
	mover_pag($ruta,"Error al Actualizar la sucursal");
}

?>
