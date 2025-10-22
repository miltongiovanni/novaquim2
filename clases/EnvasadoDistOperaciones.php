<?php

class EnvasadoDistOperaciones
{
    private $_pdo; // Instance de PDO.

    public function __construct()
    {
        $this->setDb();
    }

    public function makeEnvasadoDist($datos)
    {
        $qry = "INSERT INTO envasado_dist (fechaEnvDist, codDist, cantidad)VALUES(?, ?, ?)";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
        return $this->_pdo->lastInsertId();
    }

    public function deleteEnvasado($lote)
    {
        $qry = "DELETE FROM envasado_dist WHERE lote= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($lote));
    }

    public function getProdDistxRelMP()
    {
        $qry = "SELECT idDistribucion, producto
                FROM distribucion d
                         LEFT JOIN rel_dist_mp rdmp ON d.idDistribucion = rdmp.codDist
                WHERE activo = 1
                  AND rdmp.codDist IS NULL
                ORDER BY producto";

        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getTableEnvasadoDist()
    {
        $qry = "SELECT ed.idEnvDist, fechaEnvDist, codDist, producto, cantidad
                FROM envasado_dist ed
                LEFT JOIN distribucion d on ed.codDist = d.idDistribucion";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getMPrimasDist(){
        $qry = "SELECT codMPrimaDist, producto FROM mprimadist;";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getCantMPrimaAcXMes($fecha, $codMPrima)
    {
        $qry = "SELECT ROUND(SUM(cantidad*densidad*cantMedida/1000),1) cantEnvasadoMPrima
                FROM envasado_dist
                LEFT JOIN rel_dist_mp rdm on envasado_dist.codDist = rdm.codDist
                LEFT JOIN mprimadist m on rdm.codMPrimaDist = m.codMPrimaDist
                LEFT JOIN medida m2 on rdm.codMedida = m2.idMedida
                WHERE MONTH(fechaEnvDist) = MONTH('$fecha')
                  AND YEAR(fechaEnvDist) = YEAR('$fecha')
                AND codMPrima=$codMPrima";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if($result === null){
            return 0;
        } else{
            return $result['cantEnvasadoMPrima'];
        }
    }

    public function getCantidadPorEnvasar($lote)
    {
        $qry = "SELECT ROUND(cantidadKg*2/(densMax+densMin) - IF(SUM(cantPresentacion*cantMedida/1000)>0,SUM(cantPresentacion*cantMedida/1000),0) ,0) uso
                FROM ord_prod op
                         LEFT JOIN envasado_dist e on e.lote = op.lote
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
                WHERE op.lote=$lote) t
                LEFT JOIN envasado_dist e ON e.codPresentacion=t.codPresentacion AND e.lote=$lote
                WHERE e.codPresentacion IS NULL";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getEnvasado($lote, $codPresentacion)
    {
        $qry = "SELECT p.codPresentacion, presentacion, cantPresentacion, codEnvase, codTapa, codEtiq
                FROM envasado_dist e
                   LEFT JOIN prodpre p on e.codPresentacion = p.codPresentacion
                WHERE lote= ? AND e.codPresentacion=?";
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
        $qry = "SELECT COUNT(*) c from envasado_dist where lote=? AND producto=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($lote, $producto));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $productoExiste = $result['c'] > 0;
        return $productoExiste;
    }


    public function updateEnvasado($datos)
    {
        $qry = "UPDATE envasado_dist SET cantPresentacion=? WHERE lote=? AND codPresentacion=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function setDb()
    {

        $this->_pdo = Conectar::conexion(); //Almacenamos en _pdo la llamada la clase estática Conectar;

    }
}
