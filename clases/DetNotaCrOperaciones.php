<?php

class DetNotaCrOperaciones
{
    private $_pdo; // Instance de PDO.

    public function __construct()
    {
        $this->setDb();
    }

    public function makeDetNotaCr($datos)
    {
        $qry = "INSERT INTO det_nota_c (idNotaC, codProducto, cantProducto) VALUES (?, ?, ?)";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
        return $this->_pdo->lastInsertId();
    }

    public function deleteDetNotaCr($datos)
    {
        $qry = "DELETE FROM det_nota_c WHERE idNotaC= ? AND codProducto=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function deleteAllDetNotaCr($idNotaC)
    {
        $qry = "DELETE FROM det_nota_c WHERE idNotaC= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idNotaC));
    }

    public function getDetNotaCr($idNotaC)
    {
        $qry = "SELECT dnc.codProducto as codigo, presentacion as producto, dnc.cantProducto as cantidad
                FROM det_nota_c dnc
                         LEFT JOIN prodpre p ON dnc.codProducto = p.codPresentacion
                WHERE dnc.idNotaC = $idNotaC
                  AND dnc.codProducto < 100000
                  AND dnc.codProducto > 10000
                UNION
                SELECT dnc2.codProducto as codigo, Producto as producto, dnc2.cantProducto as cantidad
                FROM det_nota_c dnc2
                         LEFT JOIN distribucion d ON dnc2.codProducto = d.idDistribucion
                WHERE idNotaC = $idNotaC
                  AND dnc2.codProducto > 100000
                UNION
                SELECT codProducto                                                          codigo,
                       CONCAT('Descuento de ', cantProducto, '% no aplicado en la factura') producto,
                       cantProducto                                                         cantidad
                FROM det_nota_c
                WHERE idNotaC = $idNotaC
                  AND codProducto = 0";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getTotalSelFactura($selFactura)
    {
        $qry = "SELECT dp.codProducto, SUM(cantProducto) cantidad, presentacion producto, 1 orden
                FROM det_nota_c dp
                         LEFT JOIN prodpre p ON dp.codProducto = p.codPresentacion
                WHERE dp.codProducto < 100000
                  AND dp.codProducto > 10000
                  AND dp.idNotaC IN ($selFactura)
                GROUP BY dp.codProducto, producto
                UNION
                SELECT dp.codProducto, SUM(cantProducto) cantidad, producto, 2 orden
                FROM det_nota_c dp
                         LEFT JOIN distribucion d ON dp.codProducto = d.idDistribucion
                WHERE dp.codProducto > 100000
                  AND dp.idNotaC IN ($selFactura)
                GROUP BY dp.codProducto, producto
                ORDER BY orden, producto";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);;
        return $result;
    }

    public function getTableDetNotaCr($idNotaC)
    {
        $qry = "SELECT dcp.codProducto, p.presentacion producto, cantProducto, CONCAT('$', FORMAT(precioProducto, 0)) precioProducto,
                       CONCAT('$', FORMAT(precioProducto*cantProducto, 0)) subtotal, 1 orden
                FROM det_nota_c dcp
                         LEFT JOIN prodpre p on dcp.codProducto = p.codPresentacion
                WHERE idNotaC = $idNotaC
                  AND dcp.codProducto < 100000 AND dcp.codProducto > 10000
                UNION
                SELECT dcp.codProducto, producto, cantProducto, CONCAT('$', FORMAT(precioProducto, 0)) precioProducto,
                       CONCAT('$', FORMAT(precioProducto*cantProducto, 0)) subtotal, 2 orden
                FROM det_nota_c dcp
                         LEFT JOIN distribucion d on dcp.codProducto = d.idDistribucion
                WHERE idNotaC = $idNotaC
                  AND dcp.codProducto >= 100000
                UNION
                SELECT dcp.codProducto, s.desServicio producto, cantProducto, CONCAT('$', FORMAT(precioProducto, 0)) precioProducto,
                       CONCAT('$', FORMAT(precioProducto*cantProducto, 0)) subtotal, 3 orden
                FROM det_nota_c dcp
                         LEFT JOIN servicios s on dcp.codProducto = s.idServicio
                WHERE idNotaC = $idNotaC
                  AND dcp.codProducto < 10000
                ORDER BY orden, producto";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);;
        return $result;
    }

 public function getTotalFactura($idNotaC)
    {
        $qry = "SELECT CONCAT('$', FORMAT(SUM(cantProducto*precioProducto), 0)) totalFactura
                FROM det_nota_c dp
                WHERE dp.idNotaC= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idNotaC));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if($result){
            return $result['totalFactura'];
        }else{
            return 0;
        }

    }

 public function getTotalItemsFactura($idNotaC)
    {
        $qry = "SELECT COUNT(*) c
                FROM det_nota_c dcp
                WHERE idNotaC = ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idNotaC));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if($result){
            return $result['c'];
        }else{
            return 0;
        }
    }

    public function getDetProdFactura($idNotaC, $codProducto)
    {
        if ($codProducto > 100000) {
            $qry = "SELECT producto, cantProducto, precioProducto
                    FROM det_nota_c dcp
                             LEFT JOIN distribucion d ON dcp.codProducto=d.idDistribucion
                    WHERE idNotaC = ?
                      AND dcp.codProducto = ?";
        }elseif($codProducto < 10000){
            $qry = "SELECT desServicio producto, cantProducto, precioProducto
                    FROM det_nota_c dcp
                             LEFT JOIN servicios s on dcp.codProducto = s.idServicio
                    WHERE idNotaC = ?
                      AND dcp.codProducto = ?;";
        }else{
            $qry = "SELECT presentacion producto, cantProducto, precioProducto
                    FROM det_nota_c dcp
                             LEFT JOIN prodpre p on dcp.codProducto = p.codPresentacion
                    WHERE idNotaC = ?
                      AND dcp.codProducto = ?;";
        }
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idNotaC, $codProducto));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);;
        return $result;
    }

    public function updateDetNotaCr($datos)
    {
        $qry = "UPDATE det_nota_c SET cantProducto=?, precioProducto=?  WHERE idNotaC=? AND codProducto=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function setDb()
    {

        $this->_pdo = Conectar::conexion(); //Almacenamos en _pdo la llamada la clase estática Conectar;

    }
}
