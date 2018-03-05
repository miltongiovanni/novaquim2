<?php
include "includes/valAcc.php";
?>
<?php
include "includes/CatObj.php";
include "includes/calcularDias.php";
$categoria = $_POST['categoria'];
$cod_cat = $_POST['cod_cat'];
//$qryAcces="insert into cat_prod(Cod_clases, Nom_clases) values($cod_cat,'$categoria')";
$categ=new cate();
if($result=$categ->crearCat($cod_cat,$categoria))
{
	//$perfil1=$_SESSION['Perfil'];
	$ruta="listarcateg.php";
	/******LOG DE CREACION *********/
	//$IdUser=$_SESSION['IdUsuario'];
	//$hh=strftime("%H:").strftime("%M:").strftime("%S");	              
    //$Fecha=date("Y")."-".date("m")."-".date("d")." ".$hh;
	//$qryAcces="insert into logusuarios(IdUsuario, Fecha, Motivo) values($IdUser,'$Fecha','CREACION DE CATEGORIA')";
	//$ResutLog=mysql_db_query("users",$qryAcces);
	/*********FIN DEL LOG CREACION*****/
    mover_pag($ruta,"Categoria de producto creada correctamente");
}
else{
        $ruta="crearCategoria.php";
        mover_pag($ruta,"Error al crear la categoria");
     }


function mover_pag($ruta,$Mensaje){
echo'<script language="Javascript">
   alert("'.$Mensaje.'")
   self.location="'.$ruta.'"
   </script>';
}

?>
