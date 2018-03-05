<?php
include "includes/valAcc.php";
?>
<?php
include "includes/ProdObj.php";
include "includes/calcularDias.php";

foreach ($_POST as $nombre_campo => $valor) 
{ 
	$asignacion = "\$".$nombre_campo."='".$valor."';"; 
	echo $nombre_campo." = ".$valor."<br>";  
	eval($asignacion); 
}  

//$qryAcces="insert into cat_prod(Cod_clases, Nom_clases) values($cod_cat,'$categoria')";
$prod=new produ();
$valida=0;
if($result=$prod->validarProd($codigo, $valida))
{
	$ruta="crearProd.php";
	if($valida==1)
	    mover_pag($ruta,"Código de Producto ya existente");
}
if($result=$prod->crearProd($codigo,$producto, $Cate, $cuenta, $den_min, $den_max, $ph_min, $ph_max, $fragancia, $color, $Apariencia ))
{
	//$perfil1=$_SESSION['Perfil'];
	$ruta="listarProd.php";
	/******LOG DE CREACION *********/
	//$IdUser=$_SESSION['IdUsuario'];
	//$hh=strftime("%H:").strftime("%M:").strftime("%S");	              
    //$Fecha=date("Y")."-".date("m")."-".date("d")." ".$hh;
	//$qryAcces="insert into logusuarios(IdUsuario, Fecha, Motivo) values($IdUser,'$Fecha','CREACION DE CATEGORIA')";
	//$ResutLog=mysql_db_query("users",$qryAcces);
	/*********FIN DEL LOG CREACION*****/
   mover_pag($ruta,"Producto creado correctamente");
}
else
{
	$ruta="crearProd.php";
	mover_pag($ruta,"Error al crear el Producto");
 }


function mover_pag($ruta,$Mensaje){
echo'<script language="Javascript">
   alert("'.$Mensaje.'")
   self.location="'.$ruta.'"
   </script>';
}

?>
