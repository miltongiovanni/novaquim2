<?php

class RelEnvDisOperaciones
{
    private $_pdo; // Instance de PDO.

    public function __construct()
    {
        $this->setDb();
    }

    public function makeRelEnvDis($datos)
    {
        /*Preparo la insercion */
        $qry = "INSERT INTO rel_env_dis (idDis, idEnv, idTapa) VALUES(?, ?, ?)";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
        return $this->_pdo->lastInsertId();
    }

    public function deleteRelEnvDis($idEnvDis)
    {
        $qry = "DELETE FROM rel_env_dis WHERE idEnvDis= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idEnvDis));
    }

    public function checkDistribucion($idDis)
    {
        $qry = "SELECT COUNT(idDis) c FROM rel_env_dis WHERE idDis= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idDis));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['c'];
    }

    public function getRelsEnvDis()
    {
        $qry = "SELECT rel_env_dis.idEnvDis, d.producto FROM rel_env_dis
                LEFT JOIN distribucion d on rel_env_dis.idDis = d.idDistribucion
                ORDER BY producto";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getTableRelsEnvDis()
    {
        $qry = "SELECT rel_env_dis.idEnvDis, d.producto, e.nomEnvase, tv.tapa FROM rel_env_dis
                LEFT JOIN distribucion d on rel_env_dis.idDis = d.idDistribucion
                LEFT JOIN envases e on rel_env_dis.idEnv = e.codEnvase
                LEFT JOIN tapas_val tv on rel_env_dis.idTapa = tv.codTapa";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }

    public function getRelEnvDis($idEnvDis)
    {
        $qry = "SELECT rel_env_dis.idEnvDis, d.idDistribucion, d.producto, e.codEnvase, e.nomEnvase, tv.codTapa, tv.tapa FROM rel_env_dis
                LEFT JOIN distribucion d on rel_env_dis.idDis = d.idDistribucion
                LEFT JOIN envases e on rel_env_dis.idEnv = e.codEnvase
                LEFT JOIN tapas_val tv on rel_env_dis.idTapa = tv.codTapa
                WHERE idEnvDis=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idEnvDis));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getUltimoProdDisxCat($idCatDis)
    {
        $qry = "SELECT MAX(idDistribucion) as Cod from rel_env_dis where idCatDis=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idCatDis));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['Cod'];
    }


    public function updateRelEnvDis($datos)
    {
        $qry = "UPDATE rel_env_dis SET idDis=?, idEnv=?, idTapa=? WHERE idEnvDis=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function setDb()
    {

        $this->_pdo = Conectar::conexion(); //Almacenamos en _pdo la llamada la clase estática Conectar;

    }
}
