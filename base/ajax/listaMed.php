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
    $datosRetorno  = array(
        $titulo,  
        'data'    => $presentaciones
       ); 


print json_encode($datosRetorno);


?>