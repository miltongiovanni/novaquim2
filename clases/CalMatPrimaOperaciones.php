<?php

class CalMatPrimaOperaciones
{
    private $_pdo; // Instance de PDO.

    public function __construct()
    {
        $this->setDb();
    }

    public function makeCalMatPrima($datos)
    {
        /*Preparo la insercion */
        $qry = "INSERT INTO cal_mprimas (cod_mprima, lote_mp, cantidad, fecha_lote, id_compra) VALUES(?, ?, ?, ?, ?)";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
        return $this->_pdo->lastInsertId();
    }

    public function deleteCalMatPrima($id)
    {
        $qry = "DELETE FROM cal_mprimas WHERE id= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($id));
    }

    public function getIdCalMatPrimaToUpdateCompra($codMprima, $loteMprima, $idCompra)
    {

        $qry = "SELECT id
                FROM cal_mprimas
                WHERE cod_mprima = ? AND lote_mp = ? AND id_compra = ?";

        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($codMprima, $loteMprima, $idCompra));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['id'];
    }

    public function getMPrimaXCalidad()
    {
        $qry = "SELECT id, cod_mprima, lote_mp, cantidad, m.nomMPrima
                FROM cal_mprimas cmp
                LEFT JOIN mprimas m ON m.codMPrima = cmp.cod_mprima
                WHERE est_mprima =1";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public function getEstadosMPrimaCalidad()
    {
        $qry = "SELECT id, descripcion FROM estados_m_primas";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getFechaLoteCalMPrima($codMP, $loteMP)
    {
        $qry = "SELECT fecha_lote FROM cal_mprimas WHERE cod_mprima=? AND lote_mp=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($codMP, $loteMP));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['fecha_lote'];
    }

    public function isValidLoteCalidad($lote)
    {
        $qry = "SELECT * FROM cal_mprimas WHERE lote=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($lote));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result == false) {
            return false;
        } else {
            return true;
        }
    }

    public function getTableCalMatPrima()
    {
        $qry = "SELECT lote, nomCalProd, celCalProd, emlCalProd, area, cargo
                FROM cal_mprimas
                LEFT JOIN areas_cal_mprimas ap on cal_mprimas.areaCalProd = ap.idArea
                LEFT JOIN cargos_cal_mprimas cp on cal_mprimas.cargoCalProd = cp.idCargo
                wHERE activoCalProd=1 ORDER BY lote";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getCalMatPrimaProd()
    {
        $qry = "SELECT lote, nomCalProd 
        FROM cal_mprimas
        wHERE (areaCalProd=5 or areaCalProd=2) and activoCalProd=1 ORDER BY lote";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getControlCalidadById($id)
    {
        $qry = "SELECT cmp.id, cod_mprima, lote_mp, id_compra, fecha_lote, cantidad, fecha_vencimiento, fecha_analisis, apariencia_mp, olor_mp, color_mp, pH_mp,
                densidad_mp, est_mprima, observaciones, nomMPrima, aliasMPrima, aparienciaMPrima, olorMPrima, colorMPrima, pHmPrima, densidadMPrima, emp.descripcion
                FROM cal_mprimas cmp
                LEFT JOIN mprimas m on m.codMPrima = cmp.cod_mprima
                LEFT JOIN estados_m_primas emp on emp.id = cmp.est_mprima
                WHERE cmp.id = ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($id));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
    public function getLotesByMPrima($codMPrima)
    {
        $qry = "SELECT id, CONCAT (lote_mp, ' (', fecha_analisis, ')') lote FROM cal_mprimas WHERE cod_mprima = $codMPrima";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public function updateEncabezadoCalMatPrima($datos)
    {
        $qry = "UPDATE cal_mprimas SET lote_mp=?, fecha_lote=?, cantidad=? WHERE id=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function updateCalMatPrima($datos)
    {

        $qry = "UPDATE cal_mprimas SET ";
        $i = 0;
        foreach ($datos as $campo =>$valor){
            if ($campo != 'id' ){

                $qry .= " {$campo} = '{$valor}'".($i++ < (count($datos)-2) ? ',': '');
            }
        }
        $qry .= " WHERE id = {$datos['id']}";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
    }

    public function setDb()
    {

        $this->_pdo = Conectar::conexion(); //Almacenamos en _pdo la llamada la clase estática Conectar;

    }
}
