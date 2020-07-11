<?php

class CalProdOperaciones
{
    private $_pdo; // Instance de PDO.

    public function __construct()
    {
        $this->setDb();
    }

    public function makeCalProd($datos)
    {
        /*Preparo la insercion */
        $qry = "INSERT INTO cal_producto (lote, densidadProd, pHProd, olorProd, colorProd, aparienciaProd, observacionesProd) VALUES(?, ?, ?, ?, ?, ?,?)";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
        return $this->_pdo->lastInsertId();
    }

    public function deleteCalProd($lote)
    {
        $qry = "DELETE FROM cal_producto WHERE lote= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($lote));
    }

    public function getCalProd($lote)
    {

        $qry = "SELECT lote, densidadProd, pHProd, olorProd, colorProd, aparienciaProd, observacionesProd
                FROM cal_producto
                WHERE lote = ?";

        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($lote));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function isValidLoteCalidad($lote)
    {
        $qry = "SELECT * FROM cal_producto WHERE lote=?";
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

    public function getTableCalProd()
    {
        $qry = "SELECT lote, nomCalProd, celCalProd, emlCalProd, area, cargo
                FROM cal_producto
                LEFT JOIN areas_cal_producto ap on cal_producto.areaCalProd = ap.idArea
                LEFT JOIN cargos_cal_producto cp on cal_producto.cargoCalProd = cp.idCargo
                wHERE activoCalProd=1 ORDER BY lote";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getCalProdProd()
    {
        $qry = "SELECT lote, nomCalProd 
        FROM cal_producto
        wHERE (areaCalProd=5 or areaCalProd=2) and activoCalProd=1 ORDER BY lote";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getPerson($lote)
    {
        $qry = "SELECT lote, nomCalProd, celCalProd, emlCalProd, areas_cal_producto.area, cargo, activoCalProd, areaCalProd, cargoCalProd, estadoPersona 
        from cal_producto, areas_cal_producto, estados_pers, cargos_cal_producto
        wHERE areaCalProd=idArea AND cargoCalProd=idCargo AND idEstado=activoCalProd AND lote=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($lote));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function updateCalProd($datos)
    {
        $qry = "UPDATE cal_producto SET densidadProd=?, pHProd=?, olorProd=?, colorProd=?, aparienciaProd=?, observacionesProd=? WHERE lote=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function setDb()
    {

        $this->_pdo = Conectar::conexion(); //Almacenamos en _pdo la llamada la clase estática Conectar;

    }
}
