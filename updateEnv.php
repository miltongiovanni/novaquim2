<?php
include "includes/valAcc.php";
//echo $_SESSION['Perfil'];
?>
<?php
include "includes/EnvObj.php";
include "includes/calcularDias.php";             
$cod_env=$_POST['Codigo'];
$nom_env=$_POST['nombre'];
$min_stock=$_POST['stock'];

$bd="novaquim";
$enva= new envas();
if($result=$enva->updateEnv($cod_env,$nom_env, $min_stock))
{
	$qryinv="update inv_envase set Nom_envase='$nom_env' where Cod_envase=$cod_env";
    $link=conectarServidor();
    $result=mysqli_query($link,$qryinv);
	$ruta="listarEnv.php";
    mover_pag($ruta,"Envase actualizado correctamente");
	mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
}
else
{
	$ruta="buscarEnv.php";
	mover_pag($ruta,"Error al actualizar el Envase");
}

function mover_pag($ruta,$Mensaje)
{
	echo'<script language="Javascript">
   	alert("'.$Mensaje.'")
   	self.location="'.$ruta.'"
   	</script>';
}
?>
