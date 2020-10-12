<?php 
include "../includes/valAcc.php";
?><?php
include "includes/empleadObj.php";
include "includes/calcularDias.php";

foreach ($_POST as $nombre_campo => $valor) {
    ${$nombre_campo} = $valor;
    if(is_array($valor)){
        //echo $nombre_campo.print_r($valor).'<br>';
    }else{
        //echo $nombre_campo. '=' .${$nombre_campo}.'<br>';
    }
}  
$empleado=new emplead();
if($result=$empleado->makeEmplead($cedula, $nombre1, $nombre2, $apellido1, $apellido2, $arl_emp, $emps_emp, $afp_emp, $caja_emp, $FchIng, $sal_emp, $estado, $area, $cargo, $ces_emp, $cat_arl_emp))
{
  $ruta="listarEmp.php";
  /******LOG DE CREACION ********
  $IdUser=$_SESSION['IdUsuario'];
  $hh=strftime("%H:").strftime("%M:").strftime("%S");	              
  $Fecha=date("Y")."-".date("m")."-".date("d")." ".$hh;
  $link=conectarServidor();
  $qryAcces="insert into logusuarios(IdUsuario, Fecha, Motivo) values($IdUser,'$Fecha','CREACION DE USUARIO')";
  $ResutLog=mysql_db_query("users",$qryAcces);
  mysql_close($link);
  /*********FIN DEL LOG CREACION*****/
  mover_pag($ruta,"Empleado Ingresado Correctamente");
}
else
{
  $ruta="makeEmpForm.php";
  mover_pag($ruta,"Error al Ingresar al Empleado");
}



?>
