<?
function Calc_Dias($fecFinal,$fecInicial) 
{
	$fecha2=explode('-', $fecFinal);
	$fecha1=explode('-', $fecInicial);
	$timestamp1 = mktime(0,0,0,$fecha1[1],$fecha1[2],$fecha1[0]);
	$timestamp2 = mktime(0,0,0,$fecha2[1],$fecha2[2],$fecha2[0]);
	$dias_dif=floor(($timestamp2-$timestamp1) / (60 * 60 * 24));
	return $dias_dif;
}

function hoy(){
	//Genera la fecha del sistema
   $Fecha=date("Y")."-".date("m")."-".date("d");
   return $Fecha;
}

?>