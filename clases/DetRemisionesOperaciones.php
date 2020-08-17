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

    public function deleteDetRemision($datos)
    {
        $qry = "DELETE FROM det_remision1 WHERE idRemision= ? AND codProducto=? AND loteProducto=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
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
