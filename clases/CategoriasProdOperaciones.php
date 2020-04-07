<?php

class CategoriasProdOperaciones
{
    private $_pdo; // Instance de PDO.

    public function __construct()
    {
        $this->setDb();
    }
    public function makeCatProd($datos)
    {
        /*Preparo la insercion */
        $qry = "INSERT INTO cat_prod VALUES(?, ?)";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
        return $this->_pdo->lastInsertId();
    }
    public function deleteCatProd($idCatProd)
    {
        $qry = "DELETE FROM cat_prod WHERE idCatProd= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idCatProd));
    }
    public function getCatsProd()
    {
        $qry = "SELECT idCatProd, catProd FROM cat_prod order by idCatProd";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getLastCatProd()
    {
        $qry = "SELECT MAX(idCatProd) AS valor FROM cat_prod order by idCatProd";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result["valor"];
    }

    public function getCatsProdTable()
    {
        $qry = "SELECT idCatProd, catProd FROM cat_prod order by idCatProd";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getCatProd($idCatProd)
    {
        $qry = "SELECT idCatProd, catProd from cat_prod where idCatProd=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idCatProd));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function updateCatProd($datos)
    {
        $qry = "UPDATE cat_prod SET catProd=? WHERE idCatProd=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function setDb()
    {

        $this->_pdo = Conectar::conexion(); //Almacenamos en _pdo la llamada la clase estática Conectar;

    }
}
