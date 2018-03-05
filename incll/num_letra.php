<?

function numletra($numero)
{
  	$numletra3 = cientos($numero % 1000);
    if((intval($numero / 1000000)) == 0)
	     $numletra1 = "";
    else
	{
        if(intval($numero / 1000000) == 1)
			$numletra1 = cientos(intval($numero / 1000000))." MILLON";
        if(intval($numero / 1000000) != 1)
			$numletra1 = cientos(intval($numero / 1000000))." MILLONES";
	}
    if ((intval($numero / 1000) % 1000) == 0) 
		$numletra2 = "";
    else
        $numletra2 = cientos(intval($numero / 1000) % 1000)." MIL";
	if ($numletra1 == "")
		if($numletra2=="")
			$numletra = $numletra3." PESOS MCTE";
		else
			$numletra = $numletra2." ".$numletra3." PESOS MCTE";
	else
	{
		if($numletra2=="")
			$numletra = $numletra1." ".$numletra2." ".$numletra3." PESOS MCTE";
		else
		$numletra = $numletra1." ".$numletra2." ".$numletra3." PESOS MCTE";
	}
	return $numletra;
}

function cientos($numciento)
{
    if(intval($numciento / 100) == 9)
		$cienletra1 = "NOVECIENTOS ";
	if(intval($numciento / 100) == 8)
		$cienletra1 = "OCHOCIENTOS ";
	if(intval($numciento / 100) == 7)
		$cienletra1 = "SETECIENTOS ";
	if(intval($numciento / 100) == 6)
		$cienletra1 = "SEISCIENTOS ";
	if(intval($numciento / 100) == 5)
		$cienletra1 = "QUINIENTOS ";
	if(intval($numciento / 100) == 4)
		$cienletra1 = "CUATROCIENTOS ";
	if(intval($numciento / 100) == 3)
		$cienletra1 = "TRESCIENTOS ";
	if(intval($numciento / 100) == 2)
		$cienletra1 = "DOSCIENTOS ";
	if(intval($numciento / 100) == 1)
		$cienletra1 = "CIENTO ";
	if(intval($numciento / 100) == 0)
		$cienletra1 = " ";
    $numaux = $numciento % 100;
    if ($numaux > 15) 
	{
        if(intval($numaux / 10) == 9)
			$cienletra2 = "NOVENTA";
		if(intval($numaux / 10) == 8)
			$cienletra2 = "OCHENTA";
		if(intval($numaux / 10) == 7)
			$cienletra2 = "SETENTA";
		if(intval($numaux / 10) == 6)
			$cienletra2 = "SESENTA";
		if(intval($numaux / 10) == 5)
			$cienletra2 = "CINCUENTA";	
		if(intval($numaux / 10) == 4)
			$cienletra2 = "CUARENTA";	
		if(intval($numaux / 10) == 3)
			$cienletra2 = "TREINTA";	
		if(intval($numaux / 10) == 2)
			$cienletra2 = "VENTI";
		if(intval($numaux / 10) == 1)
			$cienletra2 = "DIEZ";
		if(intval($numaux / 10) != 2 && ($numaux % 10)!=0)
			$cienletra2 = $cienletra2." Y ";
		if($numaux == 20)
			$cienletra2 = "VEINTE";   
        if($numaux % 10 == 9)
			$cienletra2 = $cienletra2."NUEVE";
        if($numaux % 10 == 8)
			$cienletra2 = $cienletra2."OCHO";
		if($numaux % 10 == 7)
			$cienletra2 = $cienletra2."SIETE";
        if($numaux % 10 == 6)
			$cienletra2 = $cienletra2."SEIS";
		if($numaux % 10 == 5)
			$cienletra2 = $cienletra2."CINCO";
        if($numaux % 10 == 4)
			$cienletra2 = $cienletra2."CUATRO";
		if($numaux % 10 == 3)
			$cienletra2 = $cienletra2."TRES";
        if($numaux % 10 == 2)
			$cienletra2 = $cienletra2."DOS";
		if($numaux % 10 == 1)
			$cienletra2 = $cienletra2."UN";
	}
    else
	{
        if ($numaux == 15)
			$cienletra2 = "QUINCE";
		if ($numaux == 14)
			$cienletra2 = "CATORCE";
		if ($numaux == 13)
			$cienletra2 = "TRECE";
		if ($numaux == 12)
			$cienletra2 = "DOCE";
		if ($numaux == 11)
			$cienletra2 = "ONCE";
		if ($numaux == 10)
			$cienletra2 = "DIEZ";
		if ($numaux == 9)
			$cienletra2 = "NUEVE";
		if ($numaux == 8)
			$cienletra2 = "OCHO";
		if ($numaux == 7)
			$cienletra2 = "SIETE";
		if ($numaux == 6)
			$cienletra2 = "SEIS";
		if ($numaux == 5)
			$cienletra2 = "CINCO";
		if ($numaux == 4)
			$cienletra2 = "CUATRO";
		if ($numaux == 3)
			$cienletra2 = "TRES";
		if ($numaux == 2)
			$cienletra2 = "DOS";
		if ($numaux == 1)
			$cienletra2 = "UN";
    }
    if ($numciento == 100)
	    $cientos = "CIEN";
    else
        $cientos = ($cienletra1.$cienletra2);
	return $cientos;
}
?>