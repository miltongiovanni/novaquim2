<?php

class RuteroOperaciones
{
    private $_pdo; // Instance de PDO.

    public function __construct()
    {
        $this->setDb();
    }
    public function makeRutero($fechaRutero, $listaPedidos)
    {
        /*Preparo la insercion */
        $qry = "INSERT INTO rutero (fechaRutero, listaPedidos) VALUES(?, ?)";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($fechaRutero, $listaPedidos));
        return $this->_pdo->lastInsertId();
    }
    public function deleteRutero($idRutero)
    {
        $qry = "DELETE FROM rutero WHERE idRutero= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idRutero));
    }
    public function getListaRutero()
    {
        $qry = "SELECT idRutero, ciudad FROM rutero";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getRutero($idRutero)
    {
        $qry = "SELECT ciudad from rutero where idRutero=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idRutero));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['ciudad'];
    }

    public function updateRutero($datos)
    {
        $qry = "UPDATE rutero SET listaPedidos=? WHERE idRutero=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function setDb()
    {

        $this->_pdo = Conectar::conexion(); //Almacenamos en _pdo la llamada la clase estática Conectar;

    }
}
