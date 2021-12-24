<?php

class InvProdTerminadosOperaciones
{
    private $_pdo; // Instance de PDO.

    public function __construct()
    {
        $this->setDb();
    }
//INSERT INTO table (id, name, age) VALUES(1, "A", 19) ON DUPLICATE KEY UPDATE
//name="A", age=19

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

    public function getInvProdTerminadoByLote($codPresentacion, $loteProd)
    {
        $qry = "SELECT invProd FROM inv_prod WHERE codPresentacion=? AND loteProd=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($codPresentacion, $loteProd));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result == null) {
            return $result;
        } else {
            return $result['invProd'];
        }
    }

    public function existeInvProdTerminadoByLote($codPresentacion, $loteProd)
    {
        $qry = "SELECT invProd FROM inv_prod WHERE codPresentacion=? AND loteProd=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($codPresentacion, $loteProd));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result == null) {
            return false;
        } else {
            return true;
        }
    }

    public function getTableInvProdTerminado()
    {
        $qry = "SELECT codPresentacion,
                       presentacion,
                       invtotal,
                       IF(invListo IS NULL, 0, invListo)              invL,
                       (invtotal - IF(invListo IS NULL, 0, invListo)) invReal
                FROM (SELECT inv_prod.codPresentacion, presentacion, ROUND(SUM(invProd), 0) invtotal
                      FROM inv_prod
                               LEFT JOIN prodpre p on inv_prod.codPresentacion = p.codPresentacion
                      GROUP BY inv_prod.codPresentacion) t1
                         LEFT JOIN (SELECT SUM(cantProducto) invListo, dp.codProducto
                                    FROM pedido p
                                             LEFT JOIN det_pedido dp on p.idPedido = dp.idPedido
                                    WHERE p.estado = '2'
                                    GROUP BY dp.codProducto) t2 ON t1.codPresentacion = t2.codProducto";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getTableDetalleInvProdTerminado()
    {
        $qry = "SELECT inv_prod.codPresentacion, presentacion, loteProd, invProd, ROUND(fabrica / (1.19 * 1.55), 2) Costo
                FROM inv_prod
                         LEFT JOIN prodpre p on inv_prod.codPresentacion = p.codPresentacion
                         LEFT JOIN precios p2 on p2.codigoGen = p.codigoGen";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getTableStockInvProdTerminado()
    {
        $qry = "SELECT inv_prod.codPresentacion, presentacion, ROUND(SUM(invProd),0) invtotal, stockPresentacion
                FROM inv_prod
                         LEFT JOIN prodpre p on inv_prod.codPresentacion = p.codPresentacion
                GROUP BY inv_prod.codPresentacion, presentacion, stockPresentacion
                HAVING SUM(invProd) < stockPresentacion";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getTableInvProdTerminadoFecha($fecha)
    {
        $qry = "SELECT i.codPresentacion,
                       i.presentacion,
                       i.invtotal,
                       ep.entradaOProduccion,
                       ec.entradaCambio,
                       entradaKit,
                       sv.salidaVentas,
                       sc.salidaCambios,
                       sk.salidaKits,
                       sr.salidaRemision
                FROM (SELECT inv_prod.codPresentacion, presentacion, ROUND(SUM(invProd), 0) invtotal
                      FROM inv_prod
                               LEFT JOIN prodpre p on inv_prod.codPresentacion = p.codPresentacion
                      GROUP BY inv_prod.codPresentacion) i
                         LEFT JOIN (SELECT codPresentacion, ROUND(SUM(cantPresentacion)) entradaOProduccion
                                    FROM ord_prod op
                                             LEFT JOIN envasado e on op.lote = e.lote
                                    WHERE fechProd >= '$fecha'
                                    GROUP BY codPresentacion) ep ON i.codPresentacion = ep.codPresentacion
                         LEFT JOIN (SELECT codPresentacionNvo, ROUND(SUM(cantPresentacionNvo)) entradaCambio
                                    FROM cambios
                                             LEFT JOIN det_cambios2 d on cambios.idCambio = d.idCambio
                                    WHERE fechaCambio > '$fecha'
                                    GROUP BY codPresentacionNvo) ec ON codPresentacionNvo = i.codPresentacion
                         LEFT JOIN (SELECT codigo, ROUND(SUM(cantArmado)) entradaKit
                                    FROM arm_kit ak
                                             LEFT JOIN kit k on ak.codKit = k.idKit
                                    WHERE fechArmado > '2020-02-01'
                                    GROUP BY codigo) ek ON codigo = i.codPresentacion
                         LEFT JOIN (SELECT codProducto, ROUND(SUM(cantProducto)) salidaVentas
                                    FROM remision
                                             LEFT JOIN det_remision dr ON remision.idRemision = dr.idRemision
                                    WHERE fechaRemision >= '$fecha'
                                    GROUP BY codProducto) sv ON codProducto = i.codPresentacion
                         LEFT JOIN (SELECT codPresentacionAnt, SUM(cantPresentacionAnt) salidaCambios
                                    FROM cambios c
                                             LEFT JOIN det_cambios dc on c.idCambio = dc.idCambio
                                    WHERE fechaCambio >= '$fecha'
                                    GROUP BY codPresentacionAnt) sc ON sc.codPresentacionAnt = i.codPresentacion
                         LEFT JOIN (SELECT codProducto, SUM(cantArmado) salidaKits
                                    FROM arm_kit ak
                                             LEFT JOIN kit k on ak.codKit = k.idKit
                                             LEFT JOIN det_kit dk on k.idKit = dk.idKit
                                    WHERE fechArmado >= '$fecha'
                                    GROUP BY codProducto) sk ON sk.codProducto = i.codPresentacion
                         LEFT JOIN (SELECT codProducto, ROUND(SUM(cantProducto)) salidaRemision
                                    FROM remision1 r1
                                             LEFT JOIN det_remision1 d on r1.idRemision = d.idRemision
                                    WHERE fechaRemision >= '$fecha'
                                    GROUP BY codProducto) sr ON sr.codProducto = i.codPresentacion";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchall(PDO::FETCH_ASSOC);
        return $result;
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

    public function getInvProdTerminadoListo($codPresentacion)
    {
        $qry = "SELECT IF(SUM(cantProducto) IS NULL , 0, SUM(cantProducto)) invListo
                FROM pedido p
                         LEFT JOIN det_pedido dp on p.idPedido = dp.idPedido
                WHERE p.estado = '2'
                  AND codProducto = ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($codPresentacion));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result == null) {
            return 0;
        } else {
            return $result['invListo'];
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
        $qry = "SELECT codPresentacion, loteProd, invProd FROM inv_prod WHERE codPresentacion=? AND invProd>0";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($codPresentacion));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getLotesPresentacion($codPresentacion)
    {
        $qry = "SELECT loteProd
                FROM inv_prod
                WHERE codPresentacion =?
                AND invProd > 0";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($codPresentacion));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getAllLotesPresentacion($codPresentacion)
    {
        $qry = "SELECT loteProd
                FROM inv_prod
                WHERE codPresentacion =?
                ORDER BY loteProd DESC";
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
                WHERE codPresentacion=? AND loteProd =?;";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($codPresentacion, $loteProd));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if($result == null){
            return $result;
        }else{
            return $result['invProd'];
        }

    }

    public function getDetRemisionTrazabilidad($codPresentacion, $loteProd)
    {
        $qry = "SELECT fechaRemision, nomCliente, ROUND(cantProducto) cantProducto
                FROM det_remision dr
                         LEFT JOIN remision r on r.idRemision = dr.idRemision
                         LEFT JOIN clientes c on c.idCliente = r.idCliente
                WHERE codProducto = $codPresentacion
                  AND loteProducto = $loteProd
                UNION
                SELECT fechaRemision, cliente nomCliente, ROUND(cantProducto) cantProducto
                FROM det_remision1 dr1
                         LEFT JOIN remision1 r1 on r1.idRemision = dr1.idRemision
                WHERE codProducto = $codPresentacion
                  AND loteProducto = $loteProd";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);;
        return $result;
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
