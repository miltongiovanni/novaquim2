<?php

class DetOProdMPrimaOperaciones
{
    private $_pdo; // Instance de PDO.

    public function __construct()
    {
        $this->setDb();
    }

    public function makeDetOProdMPrimas($datos)
    {
        $qry = "INSERT INTO det_ord_prod_mp (loteMP, idMPrima, cantMPrima, loteMPrima) VALUES(?, ?, ?, ?)";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
        return $this->_pdo->lastInsertId();
    }

    public function deleteDetOProdMPrimas($loteMP)
    {
        $qry = "DELETE FROM det_ord_prod_mp WHERE loteMP= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($loteMP));
    }


    public function getTableDetOProdMPrimas($loteMP)
    {
        $qry = "SELECT dop.idMPrima, aliasMPrima, loteMPrima, cantMPrima
                FROM det_ord_prod_mp dop
                LEFT JOIN mprimas m on dop.idMPrima = m.codMPrima
                WHERE loteMP = ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($loteMP));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getDetOProdMPrimas($loteMP, $idMPrima)
    {
        $qry = "SELECT nomMPrima, cantMPrima, dop.idMPrima, loteMPrima,  aliasMPrima
                FROM det_ord_prod_mp dop
                   LEFT JOIN mprimas m on dop.idMPrima = m.codMPrima
                WHERE loteMP= ? AND dop.idMPrima=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($loteMP, $idMPrima));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);;
        return $result;
    }


    public function productoExiste($loteMP, $producto)
    {
        $qry = "SELECT COUNT(*) c from det_ord_prod_mp where loteMP=? AND producto=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($loteMP, $producto));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $productoExiste = $result['c'] > 0;
        return $productoExiste;
    }


    public function updateDetOProdMPrimas($datos)
    {
        $qry = "UPDATE det_ord_prod_mp SET cantMPrima=? WHERE loteMP=? AND idMPrima=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function setDb()
    {

        $this->_pdo = Conectar::conexion(); //Almacenamos en _pdo la llamada la clase estática Conectar;

    }
}
