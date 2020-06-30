<?php

class RelDisMPrimaOperaciones
{
    private $_pdo; // Instance de PDO.

    public function __construct()
    {
        $this->setDb();
    }

    public function makeRelEnvDis($datos)
    {
        /*Preparo la insercion */
        $qry = "INSERT INTO rel_dist_mp (codMPrimaDist, codDist, codMedida, codEnvase, codTapa) VALUES(?, ?, ?, ?, ?)";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
        return $this->_pdo->lastInsertId();
    }

    public function deleteRelEnvDis($idEnvDis)
    {
        $qry = "DELETE FROM rel_dist_mp WHERE idEnvDis= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idEnvDis));
    }

    public function checkDistribucion($idDis)
    {
        $qry = "SELECT idDis, idEnvDis  FROM rel_dist_mp WHERE idDis= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idDis));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getRelsDisMPrima()
    {
        $qry = "SELECT codDist, producto
                FROM rel_dist_mp
                         LEFT JOIN distribucion d on rel_dist_mp.codDist = d.idDistribucion
                ORDER BY producto";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getTableRelsEnvDis()
    {
        $qry = "SELECT rel_dist_mp.idEnvDis, d.producto, e.nomEnvase, tv.tapa FROM rel_dist_mp
                LEFT JOIN distribucion d on rel_dist_mp.idDis = d.idDistribucion
                LEFT JOIN envases e on rel_dist_mp.idEnv = e.codEnvase
                LEFT JOIN tapas_val tv on rel_dist_mp.idTapa = tv.codTapa";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getRelEnvDis($idEnvDis)
    {
        $qry = "SELECT rel_dist_mp.idEnvDis, d.idDistribucion, d.producto, e.codEnvase, e.nomEnvase, tv.codTapa, tv.tapa FROM rel_dist_mp
                LEFT JOIN distribucion d on rel_dist_mp.idDis = d.idDistribucion
                LEFT JOIN envases e on rel_dist_mp.idEnv = e.codEnvase
                LEFT JOIN tapas_val tv on rel_dist_mp.idTapa = tv.codTapa
                WHERE idEnvDis=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idEnvDis));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function updateRelEnvDis($datos)
    {
        $qry = "UPDATE rel_dist_mp SET idDis=?, idEnv=?, idTapa=? WHERE idEnvDis=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function setDb()
    {

        $this->_pdo = Conectar::conexion(); //Almacenamos en _pdo la llamada la clase estática Conectar;

    }
}
