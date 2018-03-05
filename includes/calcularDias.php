<?php
date_default_timezone_set('America/Bogota');
function Calc_Dias($fecFinal,$fecInicial) 
{
	
   //ORIENTADO A OBJETOS
	$datetime1= new DateTime($fecFinal);
	$datetime2= new DateTime($fecInicial);
	//$interval = $datetime1->diff($datetime2);
	//echo "interval ".$interval->format('%r%a');
	$interval2 = $datetime2->diff($datetime1);
	//echo "interval2 ".$interval2->format('%r%a');
	
	//PROCEDIMIENTOS
	//$datetime1 = date_create('$fecFinal');
	//$datetime2 = date_create('$fecInicial');
	//$interval = date_diff($datetime1, $datetime2);
	//echo $interval->format('%a días');

	//$i=(int)$interval;
	return $interval2->format('%r%a');
	/*PARA CUANDO TENGA LA VERSION PHP 5.4
	*/
	

	/*$dias	= (strtotime($fecFinal)-strtotime($fecInicial))/86400;
	//$dias 	= abs($dias); 
	$dias = floor($dias);		
	return $dias;*/
	
}

function hoy(){
	//Genera la fecha del sistema
   $Fecha=date("Y")."-".date("m")."-".date("d");
   return $Fecha;
}

?>