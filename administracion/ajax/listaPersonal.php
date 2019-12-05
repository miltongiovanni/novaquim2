<?php

function cargarClases($classname)
    {
      require '../../clases/'.$classname.'.php';
    }

    spl_autoload_register('cargarClases');
    $conn = Conectar::conexion(); 
    $qry = "SELECT idPersonal, nomPersonal, celPersonal, emlPersonal, areas_personal.area, cargo 
    FROM personal, areas_personal, cargos_personal
    wHERE areaPersonal=idArea AND activoPersonal=1 AND cargoPersonal=idCargo ORDER BY idPersonal";
    $stmt = $conn->prepare($qry);
    $stmt->execute();
    $titulo  = array(
        'draw' => 0,
        'recordsTotal'    => $stmt->rowCount(),
        'recordsFiltered' => $stmt->rowCount()
        ); 
    while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
        $datos[]  = array(
            $result["idPersonal"],
            $result["nomPersonal"],
            $result["celPersonal"],
            $result["emlPersonal"],
            $result["area"],
            $result["cargo"]
    ); 
    }
    $datosRetorno  = array(
        $titulo,  
        'data'    => $datos
       ); 


print json_encode($datosRetorno);


?>