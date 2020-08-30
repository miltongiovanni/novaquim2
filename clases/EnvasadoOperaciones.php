<?php

class EnvasadoOperaciones
{
    private $_pdo; // Instance de PDO.

    public function __construct()
    {
        $this->setDb();
    }

    public function makeEnvasado($datos)
    {
        $qry = "INSERT INTO envasado (lote, codPresentacion, cantPresentacion)VALUES(?, ?, ?)";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
        return $this->_pdo->lastInsertId();
    }

    public function deleteEnvasado($lote)
    {
        $qry = "DELETE FROM envasado WHERE lote= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($lote));
    }


    public function getTableEnvasado($lote)
    {
        $qry = "SELECT e.codPresentacion, presentacion, cantPresentacion FROM envasado e
                LEFT JOIN prodpre p on e.codPresentacion = p.codPresentacion
                WHERE lote = ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($lote));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getPresentacionesEnvasadas($lote)
    {
        $qry = "SELECT lote, codPresentacion, cantPresentacion FROM envasado
                WHERE lote = ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($lote));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getCantidadPorEnvasar($lote)
    {
        $qry = "SELECT ROUND(cantidadKg*2/(densMax+densMin) - IF(SUM(cantPresentacion*cantMedida/1000)>0,SUM(cantPresentacion*cantMedida/1000),0) ,0) uso
                FROM ord_prod op
                         LEFT JOIN envasado e on e.lote = op.lote
                         LEFT JOIN prodpre p on e.codPresentacion = p.codPresentacion
                         LEFT JOIN medida m on p.codMedida = m.idMedida
                         LEFT JOIN productos p2 on op.codProducto = p2.codProducto
                WHERE op.lote=?
                GROUP BY op.lote";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($lote));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['uso'];
    }

    public function getPresentacionesPorEnvasar($lote)
    {
        $qry = "SELECT t.codPresentacion, t.presentacion
                FROM (SELECT p.codPresentacion, presentacion
                FROM prodpre p
                    LEFT JOIN ord_prod op on p.codProducto = op.codProducto
                WHERE op.lote=$lote AND p.presentacionActiva=1) t
                LEFT JOIN envasado e ON e.codPresentacion=t.codPresentacion AND e.lote=$lote
                WHERE e.codPresentacion IS NULL";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getEnvasado($lote, $codPresentacion)
    {
        $qry = "SELECT p.codPresentacion, presentacion, cantPresentacion, codEnvase, codTapa, codEtiq, op.fechProd
                FROM envasado e
                   LEFT JOIN prodpre p on e.codPresentacion = p.codPresentacion
                   LEFT JOIN ord_prod op on op.lote = e.lote
                WHERE e.lote= ? AND e.codPresentacion=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($lote, $codPresentacion));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);;
        return $result;
    }

    public function getVolumenEnvasado($codPresentacion, $cantPresentacion)
    {
        $qry = "SELECT m.cantMedida*$cantPresentacion/1000 volumen FROM prodpre p
                LEFT JOIN medida m on p.codMedida = m.idMedida
                WHERE codPresentacion=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($codPresentacion));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);;
        return $result['volumen'];
    }


    public function productoExiste($lote, $producto)
    {
        $qry = "SELECT COUNT(*) c from envasado where lote=? AND producto=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($lote, $producto));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $productoExiste = $result['c'] > 0;
        return $productoExiste;
    }


    public function updateEnvasado($datos)
    {
        $qry = "UPDATE envasado SET cantPresentacion=? WHERE lote=? AND codPresentacion=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function setDb()
    {

        $this->_pdo = Conectar::conexion(); //Almacenamos en _pdo la llamada la clase estática Conectar;

    }
}
