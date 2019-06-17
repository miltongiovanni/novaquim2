<?php

class CategoriasDisOperaciones
{
    private $_pdo; // Instance de PDO.

    public function __construct()
    {
        $this->setDb();
    }
    public function makeCatDis($datos)
    {
        /*Preparo la insercion */
        $qry = "INSERT INTO cat_dis VALUES(?, ?)";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
        return $this->_pdo->lastInsertId();
    }
    public function deleteCatDis($idCatDis)
    {
        $qry = "DELETE FROM cat_dis WHERE idCatDis= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idCatDis));
    }
    public function getCatsDis()
    {
        $qry = "SELECT idCatDis, catDis FROM cat_dis order by idCatDis";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getLastCatDis()
    {
        $qry = "SELECT MAX(idCatDis) AS valor FROM cat_dis order by idCatDis";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result["valor"];
    }

    public function getCatsDisTable()
    {
        $qry = "SELECT idCatDis as 'Código', catDis as 'Categoría' FROM cat_dis order by idCatDis";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }

    public function getCatDis($idCatDis)
    {
        $qry = "SELECT idCatDis, catDis from cat_dis where idCatDis=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idCatDis));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function updateCatDis($datos)
    {
        $qry = "UPDATE cat_dis SET catDis=? WHERE idCatDis=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function setDb()
    {

        $this->_pdo = Conectar::conexion(); //Almacenamos en _pdo la llamada la clase estática Conectar;

    }
}
