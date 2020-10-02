<?php

class CiudadesOperaciones
{
    private $_pdo; // Instance de PDO.

    public function __construct()
    {
        $this->setDb();
    }
    public function makeCiudad($ciudad)
    {
        /*Preparo la insercion */
        $qry = "INSERT INTO ciudades VALUES(0, ?)";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($ciudad));
        return $this->_pdo->lastInsertId();
    }
    public function deleteCiudad($idCiudad)
    {
        $qry = "DELETE FROM ciudades WHERE idCiudad= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idCiudad));
    }
    public function getCiudades()
    {
        $qry = "SELECT idCiudad, ciudad FROM ciudades";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getCiudad($idCiudad)
    {
        $qry = "SELECT ciudad from ciudades where idCiudad=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idCiudad));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['ciudad'];
    }

    public function updateCiudad($datos)
    {
        $qry = "UPDATE ciudades SET ciudad=? WHERE idCiudad=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function setDb()
    {

        $this->_pdo = Conectar::conexion(); //Almacenamos en _pdo la llamada la clase estática Conectar;

    }
}
