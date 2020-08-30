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

    public function deleteDetOProd($lote)
    {
        $qry = "DELETE FROM det_ord_prod WHERE lote= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($lote));
    }


    public function getTableDetOProd($lote)
    {
        $qry = "SELECT dop.codMPrima, aliasMPrima, loteMP, cantidadMPrima
                FROM det_ord_prod dop
                LEFT JOIN mprimas m on dop.codMPrima = m.codMPrima
                WHERE lote = ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($lote));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getDetOProd($lote, $codMPrima)
    {
        $qry = "SELECT nomMPrima, cantidadMPrima, dop.codMPrima, loteMP,  aliasMPrima
                FROM det_ord_prod dop
                   LEFT JOIN mprimas m on dop.codMPrima = m.codMPrima
                WHERE lote= ? AND dop.codMPrima=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($lote, $codMPrima));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);;
        return $result;
    }

    public function getDetOrdMPTrazabilidad($codMPrima, $loteMP)
    {
        $qry = "SELECT dop.lote, fechProd, nomProducto, cantidadMPrima
                FROM det_ord_prod dop
                         LEFT JOIN ord_prod op ON dop.lote = op.lote
                         LEFT JOIN productos p ON op.codProducto = p.codProducto
                WHERE dop.codMPrima = ?
                  AND loteMP = ?
                ORDER BY fechProd";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($codMPrima, $loteMP));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);;
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
        $qry = "UPDATE det_ord_prod SET cantidadMPrima=? WHERE lote=? AND codMPrima=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function setDb()
    {

        $this->_pdo = Conectar::conexion(); //Almacenamos en _pdo la llamada la clase estática Conectar;

    }
}
