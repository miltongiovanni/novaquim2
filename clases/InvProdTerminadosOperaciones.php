<?php

class InvProdTerminadosOperaciones
{
    private $_pdo; // Instance de PDO.

    public function __construct()
    {
        $this->setDb();
    }

    public function makeInvProdTerminado($datos)
    {
        /*Preparo la insercion */
        $qry = "INSERT INTO inv_prod (codPresentacion, loteProd, invProd) VALUES(?, ?, ?)";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
        return $this->_pdo->lastInsertId();
    }

    public function deleteInvProdTerminado($datos)
    {
        $qry = "DELETE FROM inv_prod WHERE codPresentacion= ? AND loteProd=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function deleteAllDetCompra($idProv)
    {
        $qry = "DELETE FROM inv_prod WHERE idProv= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idProv));
    }

    public function getFechaLoteInvProdTerminado($codPresentacion, $loteProd)
    {
        $qry = "SELECT fechLote FROM inv_prod WHERE codPresentacion=? AND loteProd=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($codPresentacion, $loteProd));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['fechLote'];
    }

    public function getInvProdTerminadoByLote($codPresentacion, $loteProd)
    {
        $qry = "SELECT invProd FROM inv_prod WHERE codPresentacion=? AND loteProd=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($codPresentacion, $loteProd));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result == null) {
            return 0;
        } else {
            return $result['invProd'];
        }
    }

    public function getTableInvProdTerminado()
    {
        $qry = "SELECT inv_prod.codPresentacion, presentacion, ROUND(SUM(invProd),0) invtotal
                FROM inv_prod
                    LEFT JOIN prodpre p on inv_prod.codPresentacion = p.codPresentacion
                GROUP BY inv_prod.codPresentacion
                ";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getEntradaInvProdTerminadoProduccion($codPresentacion, $fecha)
    {
        $qry = "SELECT ROUND(SUM(cantPresentacion)) entradaOProduccion
                FROM ord_prod op
                LEFT JOIN envasado e on op.lote = e.lote
                WHERE codPresentacion=?
                AND fechProd>?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($codPresentacion, $fecha));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result != null) {
            return $result['entradaOProduccion'];
        } else {
            return 0;
        }
    }

    public function getEntradaInvProdTerminadoCambio($codPresentacion, $fecha)
    {
        $qry = "SELECT ROUND(SUM(cantPresentacionNvo)) entradaCambio
                FROM cambios
                         LEFT JOIN det_cambios2 d on cambios.idCambio = d.idCambio
                WHERE codPresentacionNvo = ?
                  AND fechaCambio > ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($codPresentacion, $fecha));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result != null) {
            return $result['entradaCambio'];
        } else {
            return 0;
        }
    }

    public function getEntradaInvProdTerminadoKit($codPresentacion, $fecha)
    {
        $qry = "SELECT ROUND(SUM(cantArmado)) entradaKit
                FROM arm_kit ak
                LEFT JOIN kit k on ak.codKit = k.idKit
                WHERE codigo=?
                AND fechArmado> ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($codPresentacion, $fecha));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result != null) {
            return $result['entradaKit'];
        } else {
            return 0;
        }
    }

    public function getSalidaInvProdTerminadoVentas($codPresentacion, $fecha)
    {
        $qry = "SELECT ROUND(SUM(cantProducto)) salidaVentas
                FROM remision
                         LEFT JOIN det_remision dr ON remision.idRemision = dr.idRemision
                WHERE codProducto = ?
                  AND fechaRemision >= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($codPresentacion, $fecha));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result != null) {
            return $result['salidaVentas'];
        } else {
            return 0;
        }
    }

    public function getSalidaInvProdTerminadoCambios($codPresentacion, $fecha)
    {
        $qry = "SELECT SUM(cantPresentacionAnt) salidaCambios
                FROM cambios c
                         LEFT JOIN det_cambios dc on c.idCambio = dc.idCambio
                WHERE codPresentacionAnt = ?
                  AND fechaCambio >= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($codPresentacion, $fecha));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result != null) {
            return $result['salidaCambios'];
        } else {
            return 0;
        }
    }

    public function getSalidaInvProdTerminadoKits($codPresentacion, $fecha)
    {
        $qry = "SELECT SUM(cantArmado) salidaKits
                FROM arm_kit ak
                         LEFT JOIN kit k on ak.codKit = k.idKit
                         LEFT JOIN det_kit dk on k.idKit = dk.idKit
                WHERE codProducto = ?
                  AND fechArmado >= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($codPresentacion, $fecha));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result != null) {
            return $result['salidaKits'];
        } else {
            return 0;
        }
    }

    public function getSalidaInvProdTerminadoRemisiones($codPresentacion, $fecha)
    {
        $qry = "SELECT ROUND(SUM(cantProducto)) salidaRemision
                FROM remision1 r1
                         LEFT JOIN det_remision1 d on r1.idRemision = d.idRemision
                WHERE codProducto = ?
                  AND fechaRemision >= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($codPresentacion, $fecha));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result != null) {
            return $result['salidaRemision'];
        } else {
            return 0;
        }
    }

    public function getInvTotalProdTerminado($codPresentacion)
    {
        $qry = "SELECT SUM(invProd) invProd FROM inv_prod WHERE codPresentacion=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($codPresentacion));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result == null) {
            return 0;
        } else {
            return $result['invProd'];
        }
    }

    public function getDetInv($codPresentacion)
    {
        $qry = "SELECT loteProd, ROUND(invProd, 0) invProd
                FROM inv_prod
                WHERE codPresentacion = ?
                  AND invProd > 0";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($codPresentacion));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getInvProdTerminado($codPresentacion)
    {
        $qry = "SELECT codPresentacion, loteProd, invProd FROM inv_prod WHERE codPresentacion=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($codPresentacion));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getMaxLoteInvProdTerminado($codPresentacion)
    {
        $qry = "SELECT loteProd, invProd
                FROM inv_prod
                WHERE codPresentacion = $codPresentacion 
                AND loteProd= (SELECT MAX(loteProd) FROM inv_prod WHERE codPresentacion=$codPresentacion);";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getProdInv()
    {
        $qry = "SELECT DISTINCT ip.codPresentacion, presentacion
                FROM inv_prod ip
                LEFT JOIN prodpre p on ip.codPresentacion = p.codPresentacion
                WHERE invProd>0
                ORDER BY presentacion";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getLotesByProd($codPresentacion)
    {
        $qry = "SELECT loteProd
                FROM inv_prod
                WHERE codPresentacion=? AND invProd>0;";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($codPresentacion));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getInvByLoteAndProd($codPresentacion, $loteProd)
    {
        $qry = "SELECT invProd
                FROM inv_prod
                WHERE codPresentacion=? AND loteProd =? AND invProd>0;";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($codPresentacion, $loteProd));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['invProd'];
    }

    public function getDetProveedor($idProv)
    {
        $qry = "SELECT codProveedor, nomProveedor, catProd, proveedores.idCatProd, prodActivo, densMin, densMax, pHmin, pHmax, fragancia, color, apariencia
        FROM  proveedores
        LEFT JOIN cat_prod cp on proveedores.idCatProd = cp.idCatProd
        WHERE codProveedor=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($codProveedor));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getUltimoProdxCat($idCatProd)
    {
        $qry = "SELECT MAX(codProveedor) as Cod from proveedores where idCatProd=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idCatProd));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['Cod'];
    }


    public function updateInvProdTerminado($datos)
    {
        $qry = "UPDATE inv_prod SET invProd=? WHERE codPresentacion=? AND loteProd=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function setDb()
    {

        $this->_pdo = Conectar::conexion(); //Almacenamos en _pdo la llamada la clase estática Conectar;

    }
}
