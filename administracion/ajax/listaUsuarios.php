<?php

function cargarClases($classname)
    {
      require '../../clases/'.$classname.'.php';
    }

    spl_autoload_register('cargarClases');
    $UsuarioOperador = new UsuariosOperaciones();
	$usuarios=$UsuarioOperador->getTableUsers();
    $titulo  = array(
        'draw' => 0,
        'recordsTotal'    => count($usuarios),
        'recordsFiltered' => count($usuarios)
        ); 
    for($i = 0; $i < count($usuarios); $i++){
        $datos[]  = array(
            $usuarios[$i]["idUsuario"],
            $usuarios[$i]["nombre"],
            $usuarios[$i]["apellido"],
            $usuarios[$i]["usuario"],
            $usuarios[$i]["fecCrea"],
            $usuarios[$i]["estado"],
            $usuarios[$i]["perfil"]
        ); 
    }
    $datosRetorno  = array(
        $titulo,  
        'data'    => $datos
       ); 

print json_encode($datosRetorno);


?>