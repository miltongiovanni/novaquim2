<?php
include "includes/valAcc.php";
include "includes/conect.php";
include "includes/calcularDias.php";
foreach ($_POST as $nombre_campo => $valor) 
{ 
	$asignacion = "\$".$nombre_campo."='".$valor."';"; 
	echo $nombre_campo." = ".$valor."<br>";  
	eval($asignacion); 
} 
$fecha_actual=date("Y")."-".date("m")."-".date("d"); 
$link=conectarServidor();  
$bd="novaquim"; 
$qrye="select apariencia_mp, olor_mp, color_mp, pH_mp, densidad_mp from mprimas where Cod_mprima=$IdMP";
$resulte=mysql_db_query($bd,$qrye);
$rowe=mysql_fetch_array($resulte);
$e_apariencia_mp=$rowe['apariencia_mp'];
$e_olor_mp=$rowe['olor_mp'];
$e_color_mp=$rowe['color_mp'];
$e_pH_mp=$rowe['pH_mp'];
$e_densidad_mp=$rowe['densidad_mp'];
$e_apariencia=$rowe['apariencia_mp'];

$control_mp=0;

if ($apar_mp<>1)
	$control_mp++;
if ($olor_mp<>1)
	$control_mp++;
if ($color_mp<>1)
	$control_mp++;
if ($pH_comp<>'N.A.')
{
	if (abs($pH_comp-$e_pH_mp)>0.5)
			$control_mp++;
}
if ($dens_comp<>'N.A.')
{
	if (abs($dens_mp-$e_densidad_mp)>0.05)
			$control_mp++;
}

if ($control_mp==0)
{
	echo "La Materia Prima pasó el Control de Calidad";
	$qry="insert into cal_mprimas (Cod_mprima, Lote_mp, Fech_analisis, apariencia_mp, olor_mp, color_mp, pH_mp, densidad_mp, est_mprima) values ($IdMP, '$Lote_MP', '$fecha_actual', $apar_mp, $olor_mp, $color_mp, '$pH_comp', '$dens_mp', 0 )";
	$result=mysql_db_query($bd,$qry);
	$qry_up="update inv_mprimas set Estado_MP='L' where codMP=$IdMP and loteMP='$Lote_MP'";
	$result_up=mysql_db_query($bd,$qry_up);
}
else
{
	echo "La Materia Prima no pasó el Control de Caldiad".$control_mp;
	$qry="insert into cal_mprimas (Cod_mprima, Lote_mp, Fech_analisis, apariencia_mp, olor_mp, color_mp, pH_mp, densidad_mp, est_mprima) values ($IdMP, $Lote_MP, '$fecha_actual', $apar_mp, $olor_mp, $color_mp, '$pH_comp', '$dens_mp', 1 )";
	$result=mysql_db_query($bd,$qry);
}




// Cod_mprima, Lote_mp, Fech_analisis, apraciencia_mp, olor_mp, color_mp, pH_mp, densidad_mp, est_mprima  tabla cal_mprimas
?>