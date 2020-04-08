<?php

class CategoriasProvOperaciones
{
    private $_pdo; // Instance de PDO.

    public function __construct()
    {
        $this->setDb();
    }
    public function makeCatProv($datos)
    {
        /*Preparo la insercion */
        $qry = "INSERT INTO cat_prov VALUES(?, ?)";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
        return $this->_pdo->lastInsertId();
    }
    public function deleteCatProv($idCatProv)
    {
        $qry = "DELETE FROM cat_prov WHERE idCatProv= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idCatProv));
    }
    public function getCatsProv()
    {
        $qry = "SELECT idCatProv, desCatProv FROM cat_prov order by idCatProv";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getLastCatProv()
    {
        $qry = "SELECT MAX(idCatProv) AS valor FROM cat_prov order by idCatProv";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result["valor"];
    }

    public function getCatsProvTable()
    {
        $qry = "SELECT idCatProv, desCatProv FROM cat_prov order by idCatProv";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getCatProv($idCatProv)
    {
        $qry = "SELECT idCatProv, desCatProv from cat_prov where idCatProv=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idCatProv));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function updateCatProv($datos)
    {
        $qry = "UPDATE cat_prov SET desCatProv=? WHERE idCatProv=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function setDb()
    {

        $this->_pdo = Conectar::conexion(); //Almacenamos en _pdo la llamada la clase estática Conectar;

    }
}
