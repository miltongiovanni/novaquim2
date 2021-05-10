<?php

class DetRemisionesOperaciones
{
    private $_pdo; // Instance de PDO.

    public function __construct()
    {
        $this->setDb();
    }

    public function makeDetRemision($datos)
    {
        $qry = "INSERT INTO det_remision1 (idRemision, codProducto, cantProducto, loteProducto) VALUES (?, ?, ?, ?)";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
        return $this->_pdo->lastInsertId();
    }

    public function makeDetRemisionFactura($datos)
    {
        $qry = "INSERT INTO det_remision (idRemision, codProducto, cantProducto, loteProducto) VALUES (?, ?, ?, ?)";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
        return $this->_pdo->lastInsertId();
    }

    public function deleteDetRemision($datos)
    {
        $qry = "DELETE FROM det_remision1 WHERE idRemision= ? AND codProducto=? AND loteProducto=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function deleteDetRemisionFactura($idRemision)
    {
        $qry = "DELETE FROM det_remision WHERE idRemision= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idRemision));
    }


    public function getTableDetRemisiones($idRemision)
    {
        $qry = "SELECT dr1.codProducto, presentacion producto, SUM(cantProducto) cantProducto
                FROM det_remision1 dr1
                         LEFT JOIN prodpre p on dr1.codProducto = p.codPresentacion
                WHERE idRemision = $idRemision
                  AND dr1.codProducto < 100000 
                GROUP BY dr1.codProducto, presentacion
                UNION
                SELECT dr1.codProducto, producto, cantProducto
                FROM det_remision1 dr1
                         LEFT JOIN distribucion ON dr1.codProducto = idDistribucion
                WHERE idRemision = $idRemision
                  AND dr1.codProducto > 100000";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public function getTableDetRemisionFactura($idRemision)
    {
        $qry = "SELECT CONCAT('003000', dr.codProducto) codigo, presentacion producto, SUM(cantProducto) cantProducto, 1 orden
                FROM det_remision dr
                         LEFT JOIN prodpre p on dr.codProducto = p.codPresentacion
                WHERE idRemision = $idRemision
                  AND dr.codProducto < 100000 
                GROUP BY dr.codProducto, presentacion
                UNION
                SELECT CONCAT('003000', dr.codProducto) codigo, producto, cantProducto, 2 orden
                FROM det_remision dr
                         LEFT JOIN distribucion ON dr.codProducto = idDistribucion
                WHERE idRemision = $idRemision
                  AND dr.codProducto > 100000
                  ORDER BY orden, producto";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getDetRemision($idRemision, $codProducto)
    {
        $qry = "SELECT dr1.codProducto, presentacion producto, cantProducto, loteProducto
                FROM det_remision1 dr1
                         LEFT JOIN prodpre p on dr1.codProducto = p.codPresentacion
                WHERE idRemision = $idRemision
                  AND dr1.codProducto < 100000 AND dr1.codProducto=$codProducto
                UNION
                SELECT dr1.codProducto, producto, cantProducto, loteProducto
                FROM det_remision1 dr1
                         LEFT JOIN distribucion ON dr1.codProducto = idDistribucion
                WHERE idRemision = $idRemision
                  AND dr1.codProducto > 100000 AND dr1.codProducto=$codProducto";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);;
        return $result;
    }

    public function getDetRemisionLote($idRemision)
    {
        $qry = "SELECT dr.codProducto, presentacion producto, cantProducto, loteProducto
                FROM det_remision dr
                         LEFT JOIN prodpre p on dr.codProducto = p.codPresentacion
                WHERE idRemision = $idRemision
                  AND dr.codProducto < 100000 AND dr.codProducto>10000
                UNION
                SELECT dr.codProducto, producto, cantProducto, loteProducto
                FROM det_remision dr
                         LEFT JOIN distribucion ON dr.codProducto = idDistribucion
                WHERE idRemision = $idRemision
                  AND dr.codProducto > 100000 ";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);;
        return $result;
    }
    public function getDetRemisionProducto($idRemision, $codProducto)
    {
        $qry = "SELECT dr.codProducto, presentacion producto, cantProducto, loteProducto
                FROM det_remision dr
                         LEFT JOIN prodpre p on dr.codProducto = p.codPresentacion
                WHERE idRemision = $idRemision
                  AND dr.codProducto < 100000 AND dr.codProducto>10000 AND dr.codProducto=$codProducto
                UNION
                SELECT dr.codProducto, producto, cantProducto, loteProducto
                FROM det_remision dr
                         LEFT JOIN distribucion ON dr.codProducto = idDistribucion
                WHERE idRemision = $idRemision
                  AND dr.codProducto > 100000 AND dr.codProducto=$codProducto";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);;
        return $result;
    }

    public function getDetTotalRemision($idRemision, $codProducto)
    {
        $qry = "SELECT dr1.codProducto, presentacion producto, SUM(cantProducto) cantProducto
                FROM det_remision1 dr1
                         LEFT JOIN prodpre p on dr1.codProducto = p.codPresentacion
                WHERE idRemision = $idRemision
                  AND dr1.codProducto < 100000 AND dr1.codProducto=$codProducto
                GROUP BY dr1.codProducto, presentacion
                UNION
                SELECT dr1.codProducto, producto, cantProducto
                FROM det_remision1 dr1
                         LEFT JOIN distribucion ON dr1.codProducto = idDistribucion
                WHERE idRemision = $idRemision
                  AND dr1.codProducto > 100000 AND dr1.codProducto=$codProducto";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);;
        return $result;
    }

    public function updateDetRemision($datos)
    {
        $qry = "UPDATE det_remision1 SET cantProducto=?  WHERE idRemision=? AND codProducto=? AND loteProducto=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function setDb()
    {

        $this->_pdo = Conectar::conexion(); //Almacenamos en _pdo la llamada la clase estática Conectar;

    }
}
