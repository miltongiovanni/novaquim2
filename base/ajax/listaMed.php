<?php

function cargarClases($classname)
    {
      require '../../clases/'.$classname.'.php';
    }

    spl_autoload_register('cargarClases');
    $PresentacionOperador = new PresentacionesOperaciones();
	$presentaciones=$PresentacionOperador->getTablePresentaciones();
    $titulo  = array(
        'draw' => 0,
        'recordsTotal'    => count($presentaciones),
        'recordsFiltered' => count($presentaciones)
        ); 
    for($i = 0; $i < count($presentaciones); $i++){
        $datos[]  = array(
            $presentaciones[$i]["codPresentacion"],
            $presentaciones[$i]["presentacion"],
            $presentaciones[$i]["desMedida"],
            $presentaciones[$i]["nomEnvase"],
            $presentaciones[$i]["tapa"],
            $presentaciones[$i]["codigoGen"],
            $presentaciones[$i]["coSiigo"]
        ); 
    }
    $datosRetorno  = array(
        $titulo,  
        'data'    => $datos
       ); 


print json_encode($datosRetorno);


?>