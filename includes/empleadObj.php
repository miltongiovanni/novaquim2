<?php
include "conect.php";
class emplead
{
  function makeEmplead($cedula, $nombre1, $nombre2, $apellido1, $apellido2, $arl_emp, $emps_emp, $afp_emp, $caja_emp, $FchIng, $sal_emp, $estado, $area, $cargo, $ces_emp, $cat_arl_emp)
  {
	$qry="insert into empleados (Id_empleado, 1nom_emp, 2nom_emp, 1apell_emp, 2apell_emp, arl_emp, eps_emp, afp_emp, caj_comp_emp, sal_empleado, fech_ing_emp, est_empleado, Area_emp, cargo_emp, ces_emp, cat_arl_emp) 
	values ($cedula, '$nombre1', '$nombre2', '$apellido1','$apellido2', $arl_emp, $emps_emp, $afp_emp, $caja_emp, $sal_emp, '$FchIng', $estado, $area, $cargo, $ces_emp, $cat_arl_emp)";
	echo $qry;
	$link=conectarServidor();
	$result=mysqli_query($link, $qry);
	mysqli_close($link);
	return $result;
  }
  function deleteEmplead($Id_empleado)
  {
	$link=conectarServidor();
	$qry="delete from empleados where Id_empleado=$Id_empleado";
	$result=mysqli_query($link, $qry);
	mysqli_close($link);
	if($result==1)
		return 1;
	else
		return 0;
  }	
  function updateEmplead($cedula, $nombre1, $nombre2, $apellido1, $apellido2, $arl_emp, $emps_emp, $afp_emp, $caja_emp, $FchIng, $estado, $area, $cargo, $ces_emp, $cat_arl_emp)	
  {
	$qry="update empleados set 
	1nom_emp='$nombre1', 
	2nom_emp='$nombre2', 
	1apell_emp='$apellido1', 
	2apell_emp='$apellido2', 
	arl_emp=$arl_emp,
	eps_emp=$emps_emp, 
	afp_emp=$afp_emp, 
	caj_comp_emp=$caja_emp, 
	sal_empleado=$sal_emp, 
	fech_ing_emp='$FchIng', 
	est_empleado=$estado, 
	Area_emp=$area, 
	cargo_emp=$cargo,
	ces_emp=$ces_emp,
	cat_arl_emp=$cat_arl_emp
	where Id_empleado=$cedula";
	$link=conectarServidor();
	$result=mysqli_query($link, $qry);
	mysqli_close($link);
	return $result;
  }
}
?>
