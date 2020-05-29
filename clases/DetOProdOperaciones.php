<?php

class DetOProdOperaciones
{
    private $_pdo; // Instance de PDO.

    public function __construct()
    {
        $this->setDb();
    }

    public function makeDetOProd($datos)
    {
        $qry = "INSERT INTO det_ord_prod (lote, codMPrima, cantidadMPrima, orden, loteMP)VALUES(?, ?, ?, ?, ?)";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
        return $this->_pdo->lastInsertId();
    }

    public function deleteDetOProd($datos)
    {
        $qry = "DELETE FROM det_ord_prod WHERE lote= ? AND producto=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }


    public function getTableDetOProd($lote)
    {
        $qry = "SELECT dop.codMPrima, aliasMPrima, loteMP, cantidadMPrima
                FROM det_ord_prod dop
                LEFT JOIN mprimas m on dop.codMPrima = m.codMPrima
                WHERE lote = ?
                ORDER BY orden";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($lote));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getDetOProd($lote, $producto)
    {
        $qry = "SELECT lote, producto, cantGasto, precGasto,
                codIva, CONCAT(format((tasaIva*100),0), ' %') iva
                FROM det_ord_prod
                LEFT JOIN tasa_iva ti on det_ord_prod.codIva = ti.idTasaIva
                WHERE lote=? AND producto=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($lote, $producto));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);;
        return $result;
    }


    public function productoExiste($lote, $producto)
    {
        $qry = "SELECT COUNT(*) c from det_ord_prod where lote=? AND producto=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($lote, $producto));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $productoExiste = $result['c'] > 0;
        return $productoExiste;
    }


    public function updateDetOProd($datos)
    {
        $qry = "UPDATE det_ord_prod SET cantGasto=?, precGasto=?, codIva=? WHERE lote=? AND producto=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function setDb()
    {

        $this->_pdo = Conectar::conexion(); //Almacenamos en _pdo la llamada la clase estática Conectar;

    }
}
