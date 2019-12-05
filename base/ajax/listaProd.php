<?php

function cargarClases($classname)
    {
      require '../../clases/'.$classname.'.php';
    }

    spl_autoload_register('cargarClases');
    $conn = Conectar::conexion(); 
    $qry = "SELECT codProducto, nomProducto, catProd, densMin, densMax, pHmin, pHmax, fragancia, color, apariencia 
    FROM  productos, cat_prod
    WHERE productos.idCatProd=cat_prod.idCatProd and prodActivo=0
    ORDER BY codProducto;";
    $stmt = $conn->prepare($qry);
    $stmt->execute();
    $titulo  = array(
        'draw' => 0,
        'recordsTotal'    => $stmt->rowCount(),
        'recordsFiltered' => $stmt->rowCount()
        ); 
    while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
        $datos[]  = array(
            $result["codProducto"],
            $result["nomProducto"],
            $result["catProd"],
            $result["densMin"],
            $result["densMax"],
            $result["pHmin"],
            $result["pHmax"],
            $result["fragancia"],
            $result["color"],
            $result["apariencia"]
    ); 
    }
    $datosRetorno  = array(
        $titulo,  
        'data'    => $datos
       ); 


print json_encode($datosRetorno);


?>