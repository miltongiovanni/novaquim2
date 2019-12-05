<?php

function cargarClases($classname)
    {
      require '../../clases/'.$classname.'.php';
    }

    spl_autoload_register('cargarClases');
    $conn = Conectar::conexion(); 
    $qry = "SELECT idUsuario, nombre, apellido, usuario, estadoUsuario, usuarios.idPerfil, perfiles.descripcion perfil, estados_usuarios.descripcion estado, fecCrea, fecCambio 
            FROM usuarios, perfiles, estados_usuarios WHERE usuarios.idPerfil=perfiles.idPerfil AND estadoUsuario=idEstado AND estadoUsuario=2 ORDER BY idUsuario;";
    $stmt = $conn->prepare($qry);
    $stmt->execute();
    $titulo  = array(
        'draw' => 0,
        'recordsTotal'    => $stmt->rowCount(),
        'recordsFiltered' => $stmt->rowCount()
        ); 
    while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
        $datos[]  = array(
            $result["idUsuario"],
            $result["nombre"],
            $result["apellido"],
            $result["usuario"],
            $result["fecCrea"],
            $result["estado"],
            $result["perfil"]
    ); 
    }
    $datosRetorno  = array(
        $titulo,  
        'data'    => $datos
       ); 


print json_encode($datosRetorno);


?>