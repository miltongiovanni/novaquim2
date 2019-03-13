<?php
include "includes/valAcc.php";
?>
<?php
include "includes/CatObj.php";
include "includes/calcularDias.php";
$cod_cat=$_POST['Cod_cat'];
$categoria=$_POST['Categoria'];
$categ=new cate();
if($result=$categ->updateCat($cod_cat,$categoria))
{
	$perfil1=$_SESSION['Perfil'];
	$ruta="listarcateg.php";
    mover_pag($ruta,"Categoria Actualizada correctamente");
}
else
{
	$ruta="buscarCat.php";
	mover_pag($ruta,"Error al Actualizar la Categoria");
}
function mover_pag($ruta,$Mensaje)
{
	echo'<script language="Javascript">
   	alert("'.$Mensaje.'")
   	self.location="'.$ruta.'"
   	</script>';
}
?>
