<?php
include "../includes/valAcc.php";
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');

foreach ($_POST as $nombre_campo => $valor) {
    ${$nombre_campo} = $valor;
    if(is_array($valor)){
        //echo $nombre_campo.print_r($valor).'<br>';
    }else{
        //echo $nombre_campo. '=' .${$nombre_campo}.'<br>';
    }
}
$datos = array($idCatMP, $catMP);
$catsMPOperador = new CategoriasMPOperaciones();

try {
	$lastCatMP=$catsMPOperador->makeCatMP($datos);
	$ruta = "listarCatMP.php";
	$mensaje =  "Categoría de materia prima creada correctamente";
	
} catch (Exception $e) {
	$ruta = "crearCategoriaMP.php";
	$mensaje = "Error al crear la categoría de materia prima";
} finally {
	unset($conexion);
	unset($stmt);
	mover_pag($ruta, $mensaje);
}


include "includes/calcularDias.php";
include "includes/conect.php";
foreach ($_POST as $nombre_campo => $valor) 
{ 
	$asignacion = "\$".$nombre_campo."='".$valor."';"; 
//	echo $nombre_campo." = ".$valor."<br>";  
	eval($asignacion); 
}  
$link=conectarServidor();  
$bd="novaquim";
$qry="insert into cat_mp (Id_cat_mp, Des_cat_mp) values ($cod_cat_mp,'$categoria')";
$result=mysqli_query($link, $qry);
if($result)
{
	//$perfil1=$_SESSION['Perfil'];
	$ruta="listarcateg_MP.php";
	/******LOG DE CREACION *********/
	//$IdUser=$_SESSION['IdUsuario'];
	//$hh=strftime("%H:").strftime("%M:").strftime("%S");	              
    //$Fecha=date("Y")."-".date("m")."-".date("d")." ".$hh;
	//$qryAcces="insert into logusuarios(IdUsuario, Fecha, Motivo) values($IdUser,'$Fecha','CREACION DE CATEGORIA')";
	//$ResutLog=mysql_db_query("users",$qryAcces);
	/*********FIN DEL LOG CREACION*****/
    mover_pag($ruta,"Categoria de Materia Prima creada correctamente");
}
else{
        $ruta="crearCategoria_MP.php";
        mover_pag($ruta,"Error al crear la Categor�a de Materia Prima");
     }
mysqli_free_result($result);
/* cerrar la conexi�n */
mysqli_close($link);



?>
