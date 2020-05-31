<?php

class DetOProdColorOperaciones
{
    private $_pdo; // Instance de PDO.

    public function __construct()
    {
        $this->setDb();
    }

    public function makeDetOProdColor($datos)
    {
        $qry = "INSERT INTO det_ord_prod_col (loteColor, codMPrima, cantMPrima, loteColorMPrima) VALUES(?, ?, ?, ?)";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
        return $this->_pdo->lastInsertId();
    }

    public function deleteDetOProdColor($loteColor)
    {
        $qry = "DELETE FROM det_ord_prod_col WHERE loteColor= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($loteColor));
    }


    public function getTableDetOProdColor($loteColor)
    {
        $qry = "SELECT dop.codMPrima, aliasMPrima, loteMPrima, cantMPrima
                FROM det_ord_prod_col dop
                LEFT JOIN mprimas m on dop.codMPrima = m.codMPrima
                WHERE loteColor = ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($loteColor));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getDetOProdColor($loteColor, $codMPrima)
    {
        $qry = "SELECT nomMPrima, cantMPrima, dop.codMPrima, loteMPrima,  aliasMPrima
                FROM det_ord_prod_col dop
                   LEFT JOIN mprimas m on dop.codMPrima = m.codMPrima
                WHERE loteColor= ? AND dop.codMPrima=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($loteColor, $codMPrima));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);;
        return $result;
    }


    public function productoExiste($loteColor, $producto)
    {
        $qry = "SELECT COUNT(*) c from det_ord_prod_col where loteColor=? AND producto=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($loteColor, $producto));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $productoExiste = $result['c'] > 0;
        return $productoExiste;
    }


    public function updateDetOProdColor($datos)
    {
        $qry = "UPDATE det_ord_prod_col SET cantMPrima=? WHERE loteColor=? AND codMPrima=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function setDb()
    {

        $this->_pdo = Conectar::conexion(); //Almacenamos en _pdo la llamada la clase estática Conectar;

    }
}
