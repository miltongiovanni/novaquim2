<?php

class TasaReteIcaOperaciones
{
    private $_pdo; // Instance de PDO.

    public function __construct()
    {
        $this->setDb();
    }
    public function makeTasaReteIca($tasaRetIca)
    {
        /*Preparo la insercion */
        $qry = "INSERT INTO tasa_reteica VALUES(0, ?)";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($tasaRetIca));
        return $this->_pdo->lastInsertId();
    }
    public function deleteTasaReteIca($idTasaRetIca)
    {
        $qry = "DELETE FROM tasa_reteica WHERE idTasaRetIca= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idTasaRetIca));
    }
    public function getTasasReteIca()
    {
        $qry = "SELECT idTasaRetIca, CONCAT(format((tasaRetIca),2), ' por mil') reteica FROM tasa_reteica order by tasaRetIca";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getTasaReteIca($idTasaRetIca)
    {
        $qry = "SELECT idTasaRetIca, tasaRetIca  from tasa_reteica where idTasaRetIca=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idTasaRetIca));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function updateTasaReteIca($datos)
    {
        $qry = "UPDATE tasa_reteica SET tasaRetIca=? WHERE idTasaRetIca=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function setDb()
    {

        $this->_pdo = Conectar::conexion(); //Almacenamos en _pdo la llamada la clase estática Conectar;

    }
}
