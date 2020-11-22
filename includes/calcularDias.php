<?php
date_default_timezone_set('America/Bogota');
function Calc_Dias($fecFinal, $fecInicial) 
{
   //ORIENTADO A OBJETOS
	$datetime1= new DateTime($fecFinal);
	$datetime2= new DateTime($fecInicial);
	$interval2 = $datetime2->diff($datetime1);
	return $interval2->format('%r%a');
}

function hoy(){
	//Genera la fecha del sistema
   $Fecha=date("Y")."-".date("m")."-".date("d");
   return $Fecha;
}

?>