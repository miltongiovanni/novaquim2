<?php

class BancosOperaciones
{
    private $_pdo; // Instance de PDO.

    public function __construct()
    {
        $this->setDb();
    }
    public function makeBanco($banco)
    {
        /*Preparo la insercion */
        $qry = "INSERT INTO bancos VALUES(0, ?)";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($banco));
        return $this->_pdo->lastInsertId();
    }
    public function deleteBanco($idBanco)
    {
        $qry = "DELETE FROM bancos WHERE idBanco= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idBanco));
    }
    public function getBancos()
    {
        $qry = "SELECT idBanco, banco FROM bancos";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getBanco($idBanco)
    {
        $qry = "SELECT idBanco, banco  from bancos where idBanco=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idBanco));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function updateBanco($datos)
    {
        $qry = "UPDATE bancos SET banco=? WHERE idBanco=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function setDb()
    {

        $this->_pdo = Conectar::conexion(); //Almacenamos en _pdo la llamada la clase estática Conectar;

    }
}
