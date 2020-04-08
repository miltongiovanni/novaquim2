<?php
include "includes/valAcc.php";
include "includes/conect.php";
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
</head>
<?php
foreach ($_POST as $nombre_campo => $valor) 
	{ 
		$asignacion = "\$".$nombre_campo."='".$valor."';"; 
		//echo $nombre_campo." = ".$valor."<br>";  
		eval($asignacion); 
	}  
$qry="update clientes_cotiz set 
	  Nom_clien='$cliente', 
	  Dir_clien='$Direccion', 
	  Contacto='$Contacto',
	  Cargo='$Cargo', 
	  Tel_clien=$Tel1, 
	  Fax_clien=$Fax,
	  Eml_clien='$email', 
	  Cel_clien=$celular,
	  Id_cat_clien=$IdCat,
	  Ciudad_clien=$ciudad_cli,
	  cod_vend=$vendedor
	  where Id_cliente=$cliente_cot";
	  
	 
$link=conectarServidor();
$result=mysqli_query($link,$qry);
mysqli_close($link);

echo '<form method="post" action="listarClientCot.php" name="form3">';
//echo '<input type="submit" name="Submit" value="">'; 
echo '</form>';
echo'<script >
	alert("Cliente de Cotización Actualizado Correctamente");
	document.form3.submit();
	</script>';	


function mover_pag($ruta,$Mensaje)
{
	echo'<script >
   	alert("'.$Mensaje.'")
   	self.location="'.$ruta.'"
   	</script>';
}
?>
