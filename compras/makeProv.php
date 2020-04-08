<?php
include "includes/valAcc.php";
?><?php
include "includes/conect.php";
include "includes/nit_verif.php";

foreach ($_POST as $nombre_campo => $valor) 
{ 
	$asignacion = "\$".$nombre_campo."='".$valor."';"; 
	//echo $nombre_campo." = ".$valor."<br>";  
	eval($asignacion); 
}  
if ($tipo==1)
	$NIT_F=number_format($NIT, 0, '.', '.')."-".verifica($NIT);
if ($tipo==2)
	$NIT_F=number_format($NIT, 0, '.', '.');
echo $NIT_F;
$link=conectarServidor();
$sql="select * from proveedores where NIT_provee='$NIT_F';";
$result=mysqli_query($link,$sql);
$row=mysqli_fetch_array($result, MYSQLI_BOTH);
if ($row)
{
   echo'<script >
   alert("Proveedor o Nit ya existente")
   </script>';
	echo'<form action="updateProvForm.php" method="post" name="formulario">';
	echo '<input name="prov" type="hidden" value="'.$NIT_F.'"/><input type="submit" name="Submit" value="Cambiar" />';
	echo'</form>'; 
	echo' <script > 	document.formulario.submit(); 	</script>';
}
mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
echo'<form action="makeProvForm2.php" method="post" name="formulario">';
echo '<input name="nit" type="hidden" value="'.$NIT_F.'"/><input type="submit" name="Submit" value="Cambiar" />';
echo'</form>'; 
echo' <script > 	document.formulario.submit(); 	</script>';

function mover_pag($ruta,$Mensaje){
echo'<script >
   alert("'.$Mensaje.'")
   self.location="'.$ruta.'"
   </script>';
 }

?>
