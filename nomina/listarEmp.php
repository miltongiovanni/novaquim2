<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
<title>Lista de Empleados Activos</title>
<meta charset="utf-8">
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="contenedor">

<div id="saludo1"><strong>LISTADO DE EMPLEADOS ACTIVOS</strong></div> 
<table width="100%" border="0" summary="encabezado">
	<tr> 
    	<td><div align="right"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Men&uacute;"></div></td>
    </tr>
</table>

<?php
include "includes/utilTabla.php";
include "includes/conect.php" ;
$link=conectarServidor();
$sql="SELECT format(Id_empleado,0) as 'Identificación', 1apell_emp as '1 Apellido', 2apell_emp as '2 Apellido', 1nom_emp as '1 Nombre', 2nom_emp as '2 Nombre', fech_ing_emp as 'Fch Ingreso', concat('$ ',format(sal_empleado,0)) as 'Salario',
Nom_eps as Eps, nom_f_pension as 'AFP Emp', nom_caja as 'Caja Comp', nom_f_cesant as 'Cesantías', trabajo as 'Sitio de Trabajo', cargo as Cargo, area as 'Área' 
from empleados, eps, f_pension, caja_comp, cargos_personal, areas_personal, arl, f_cesantias, cat_arp
where eps_emp=Id_eps and afp_emp=Id_f_pension and caj_comp_emp=Id_caja and est_empleado=1 and Area_emp=Id_area and cargo_emp=Id_cargo and arl_emp=Id_arl and ces_emp=Id_f_cesant and cat_arl_emp=Id_cat_arl order by 1apell_emp, 2apell_emp;";
	//llamar funcion de tabla
	verTabla($sql, $link);
?>
<div align="center"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Men&uacute;"></div>
</div>
</body>
</html>