<?php

class CalProdTerminadoOperaciones
{
    private $_pdo; // Instance de PDO.

    public function __construct()
    {
        $this->setDb();
    }

    public function makeCalProdTerminado($datos)
    {
        /*Preparo la insercion */
        $qry = "INSERT INTO cal_prod_terminado (lote, etiquetado, envasado, observaciones) VALUES(?, ?, ?, ?)";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
        return $this->_pdo->lastInsertId();
    }

    public function deleteCalProdTerminado($lote)
    {
        $qry = "DELETE FROM cal_prod_terminado WHERE lote= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($lote));
    }

    public function getCalProdTerminado($lote)
    {

        $qry = "SELECT lote, densidadProd, pHProd, olorProd, colorProd, aparienciaProd, observacionesProd
                FROM cal_prod_terminado
                WHERE lote = ?";

        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($lote));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function isValidLoteCalidad($lote)
    {
        $qry = "SELECT * FROM cal_prod_terminado WHERE lote=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($lote));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if($result==false){
            return false;
        }
        else{
            return true;
        }
    }

    public function getTableCalProdTerminado()
    {
        $qry = "SELECT lote, nomCalProd, celCalProd, emlCalProd, area, cargo
                FROM cal_prod_terminado
                LEFT JOIN areas_cal_prod_terminado ap on cal_prod_terminado.areaCalProd = ap.idArea
                LEFT JOIN cargos_cal_prod_terminado cp on cal_prod_terminado.cargoCalProd = cp.idCargo
                wHERE activoCalProd=1 ORDER BY lote";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getCalProdTerminadoProd()
    {
        $qry = "SELECT lote, nomCalProd 
        FROM cal_prod_terminado
        wHERE (areaCalProd=5 or areaCalProd=2) and activoCalProd=1 ORDER BY lote";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getPerson($lote)
    {
        $qry = "SELECT lote, nomCalProd, celCalProd, emlCalProd, areas_cal_prod_terminado.area, cargo, activoCalProd, areaCalProd, cargoCalProd, estadoPersona 
        from cal_prod_terminado, areas_cal_prod_terminado, estados_pers, cargos_cal_prod_terminado
        wHERE areaCalProd=idArea AND cargoCalProd=idCargo AND idEstado=activoCalProd AND lote=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($lote));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function updateCalProdTerminado($datos)
    {
        $qry = "UPDATE cal_prod_terminado SET densidadProd=?, pHProd=?, olorProd=?, colorProd=?, aparienciaProd=?, observacionesProd=? WHERE lote=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function setDb()
    {

        $this->_pdo = Conectar::conexion(); //Almacenamos en _pdo la llamada la clase estática Conectar;

    }
}
