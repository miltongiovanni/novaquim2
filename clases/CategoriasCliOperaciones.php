<?php

class CategoriasCliOperaciones
{
    private $_pdo; // Instance de PDO.

    public function __construct()
    {
        $this->setDb();
    }
    public function makeCatCli($datos)
    {
        /*Preparo la insercion */
        $qry = "INSERT INTO cat_clien VALUES(?, ?)";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
        return $this->_pdo->lastInsertId();
    }
    public function deleteCatCli($idCatClien)
    {
        $qry = "DELETE FROM cat_clien WHERE idCatClien= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idCatClien));
    }
    public function getCatsCli()
    {
        $qry = "SELECT idCatClien, desCatClien FROM cat_clien order by desCatClien";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getLastCatCli()
    {
        $qry = "SELECT MAX(idCatClien) AS valor FROM cat_clien order by idCatClien";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result["valor"];
    }

    public function getCatsCliTable()
    {
        $qry = "SELECT idCatClien, desCatClien FROM cat_clien order by idCatClien";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getCatCli($idCatClien)
    {
        $qry = "SELECT idCatClien, desCatClien from cat_clien where idCatClien=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idCatClien));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function updateCatCli($datos)
    {
        $qry = "UPDATE cat_clien SET desCatClien=? WHERE idCatClien=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function setDb()
    {

        $this->_pdo = Conectar::conexion(); //Almacenamos en _pdo la llamada la clase estática Conectar;

    }
}
