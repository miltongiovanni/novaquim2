<?php
include "includes/valAcc.php";
?><?php
include "includes/conect.php";
include "includes/calcularDias.php";
include "includes/nit_verif.php";

foreach ($_POST as $nombre_campo => $valor) 
{ 
	$asignacion = "\$".$nombre_campo."='".$valor."';"; 
	echo $nombre_campo." = ".$valor."<br>";  
	eval($asignacion); 
}  
if ($tipo==1)
	$NIT_F=number_format($NIT, 0, '.', '.')."-".verifica($NIT);
if ($tipo==0)
	$NIT_F=number_format($NIT, 0, '.', '.');
$bd="novaquim";
$link=conectarServidor();   
echo $NIT_F;
$sql="select * from clientes where Nit_clien='$NIT_F';";
$result=mysql_db_query($bd,$sql);
$row=mysql_fetch_array($result, MYSQLI_BOTH);
if ($row)
{
   echo'<script language="Javascript">
   alert("Cliente o Nit ya existente")
   </script>';
	echo'<form action="updateConsultForm.php" method="post" name="formulario">';
	echo '<input name="cliente" type="hidden" value="'.$NIT_F.'"><input type="submit" name="Submit" value="Cambiar" />';
	echo'</form>'; 
	echo' <script language="Javascript"> 	document.formulario.submit(); 	</script>';
	mysql_close($link);//Cerrar la conexion
}
echo'<form action="makeConsultForm2.php" method="post" name="formulario">';
echo '<input name="nit" type="hidden" value="'.$NIT_F.'"><input name="ciudad_cli" type="hidden" value="'.$ciudad_cli.'"><input type="submit" name="Submit" value="Cambiar" />';
echo'</form>'; 
echo' <script language="Javascript"> 	document.formulario.submit(); 	</script>';

function mover_pag($ruta,$Mensaje){
echo'<script language="Javascript">
   alert("'.$Mensaje.'")
   self.location="'.$ruta.'"
   </script>';
 }

?>
