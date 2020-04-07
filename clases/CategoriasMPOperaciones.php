<?php

class CategoriasMPOperaciones
{
    private $_pdo; // Instance de PDO.

    public function __construct()
    {
        $this->setDb();
    }
    public function makeCatMP($datos)
    {
        /*Preparo la insercion */
        $qry = "INSERT INTO cat_mp VALUES(?, ?)";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
        return $this->_pdo->lastInsertId();
    }
    public function deleteCatMP($idCatMP)
    {
        $qry = "DELETE FROM cat_mp WHERE idCatMP= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idCatMP));
    }
    public function getCatsMP()
    {
        $qry = "SELECT idCatMP, catMP FROM cat_mp order by idCatMP";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getLastCatMP()
    {
        $qry = "SELECT MAX(idCatMP) AS valor FROM cat_mp order by idCatMP";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result["valor"];
    }

    public function getCatsMPTable()
    {
        $qry = "SELECT idCatMP, catMP FROM cat_mp order by idCatMP";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getCatMP($idCatMP)
    {
        $qry = "SELECT idCatMP, catMP from cat_mp where idCatMP=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idCatMP));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function updateCatMP($datos)
    {
        $qry = "UPDATE cat_mp SET catMP=? WHERE idCatMP=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function setDb()
    {

        $this->_pdo = Conectar::conexion(); //Almacenamos en _pdo la llamada la clase estática Conectar;

    }
}
