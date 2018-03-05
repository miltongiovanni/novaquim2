<?php

function verifica($nit)
{
 	$primos = array(3, 7, 13, 17, 19, 23, 29, 37, 41, 43, 47, 53, 59, 67, 71);
	$suma = 0;
	for ($i=0; $i<=(strlen($nit)-1); $i++ ){
		$suma += substr($nit, -($i+1), 1) * $primos[$i];
		}
	$resto = $suma % 11;
	if ( $resto == 0 || $resto == 1 )
		$digitov = $resto;
	else
		$digitov = 11 - $resto;
	return $digitov;
}
?>
