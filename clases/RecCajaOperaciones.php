<?php

class RecCajaOperaciones
{
    private $_pdo; // Instance de PDO.

    public function __construct()
    {
        $this->setDb();
    }

    public function makeRecCaja($idFactura)
    {
        /*Preparo la insercion */
        $qry = "INSERT INTO r_caja (idFactura, cobro, fechaRecCaja, descuento_f, idCheque, codBanco) VALUES(?, 0, NOW(), 0, 0, 0)";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idFactura));
        return $this->_pdo->lastInsertId();
    }
    public function isValidIdRecCaja($idRecCaja)
    {
        $qry = "SELECT * FROM r_caja WHERE idRecCaja=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idRecCaja));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if($result==false){
            return false;
        }
        else{
            return true;
        }
    }
    public function deleteRecCaja($idRecCaja)
    {
        $qry = "DELETE FROM r_caja WHERE idProv= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idRecCaja));
    }

    public function getRecCajaes($actif)
    {
        if ($actif == true) {
            $qry = "SELECT idProv, nomProv FROM r_caja WHERE estProv=1 ORDER BY nomProv;";
        } else {
            $qry = "SELECT idProv, nomProv FROM r_caja ORDER BY nomProv;";
        }

        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getRecCajaesByTipo($tipoCompra)
    {
        $qry = "SELECT idProv, nomProv FROM r_caja WHERE idCatProv = $tipoCompra ORDER BY nomProv;";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array());
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getAllRecCajaesGastos()
    {
        $qry = "SELECT idProv, nomProv FROM r_caja WHERE (idCatProv = 5 OR idCatProv = 6) ORDER BY nomProv;";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array());
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getRecCajaesByName($q)
    {
        $qry = "SELECT idProv, nomProv FROM r_caja WHERE nomProv like '%" . $q . "%' ORDER BY nomProv;";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array());
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getRecCajaesByNameAndTipoCompra($q, $tipoCompra)
    {
        $qry = "SELECT idProv, nomProv FROM r_caja WHERE idCatProv=? AND nomProv like '%" . $q . "%' ORDER BY nomProv;";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($tipoCompra));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getRecCajaesGastos($q)
    {
        $qry = "SELECT idProv, nomProv FROM r_caja WHERE (idCatProv=5 OR idCatProv=6) AND nomProv like '%" . $q . "%' ORDER BY nomProv;";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getTableFacturasXcobrar()
    {
        $qry = "SELECT f.idFactura,
                       nomCliente,
                       contactoCliente,
                       cargoCliente,
                       dirCliente,
                       telCliente,
                       celCliente,
                       fechaFactura,
                       fechaVenc,
                       CONCAT('$', FORMAT(Total, 0))                                                                       TotalFormat,
                       descuento * f.subtotal                                                                              des,
                       CONCAT('$', FORMAT(totalR, 0))                                                                      totalRFormat,
                       retencionIva,
                       retencionIca,
                       retencionFte,
                       Subtotal,
                       IVA,
                       parcial,
                       pago_nc,
                       fechaNotaC,
                       CONCAT('$', FORMAT(IF(parcial IS NULL, 0, parcial) + IF(pago_nc IS NULL, 0, pago_nc),0))           cobradoFormat,
                       CONCAT('$', FORMAT(total - (IF(parcial IS NULL, 0, parcial) + IF(pago_nc IS NULL, 0, pago_nc)), 0)) saldo
                
                FROM factura f
                         LEFT JOIN clientes c on c.idCliente = f.idCliente
                         LEFT JOIN (SELECT SUM(cobro) parcial, idFactura FROM r_caja GROUP BY idFactura) t ON t.idFactura = f.idFactura
                         LEFT JOIN (SELECT ROUND(totalNotaC) as pago_nc, fechaNotaC, facturaDestino
                                    FROM nota_c
                                    WHERE fechaNotaC > '2016-04-05') n ON n.facturaDestino = f.idFactura
                WHERE f.Estado = 'P'";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getTableFacturasAccClienteXcobrar()
    {
        $qry = "SELECT c.idCliente,
                       nomCliente,
                       nitCliente,
                       contactoCliente,
                       cargoCliente,
                       telCliente,
                       celCliente,
                       dirCliente,
                       CONCAT('$', FORMAT(SUM(total - (IF(parcial IS NULL, 0, parcial) + IF(pago_nc IS NULL, 0, pago_nc))),
                                          0)) totalSaldoFormat
                
                FROM factura f
                         LEFT JOIN clientes c on c.idCliente = f.idCliente
                         LEFT JOIN (SELECT SUM(cobro) parcial, idFactura FROM r_caja GROUP BY idFactura) t
                                   ON t.idFactura = f.idFactura AND f.Estado = 'P'
                         LEFT JOIN (SELECT ROUND(totalNotaC) as pago_nc, fechaNotaC, facturaDestino
                                    FROM nota_c
                                    WHERE fechaNotaC > '2016-04-05') n ON n.facturaDestino = f.idFactura AND f.Estado = 'P'
                WHERE f.Estado = 'P'
                  AND DATEDIFF(fechaVenc, NOW()) < 0
                GROUP BY f.idCliente";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getDetalleFacturasAccClienteXcobrar($idCliente)
    {
        $qry = "SELECT f.idFactura,
                   fechaFactura,
                   fechaVenc,
                   CONCAT('$', FORMAT(Subtotal, 0))                                                                    SubtotalFormat,
                   CONCAT('$', FORMAT(retencionIva, 0))                                                                retencionIvaFormat,
                   CONCAT('$', FORMAT(retencionIca, 0))                                                                retencionIcaFormat,
                   CONCAT('$', FORMAT(retencionFte, 0))                                                                retencionFteFormat,
                   CONCAT('$', FORMAT(iva, 0))                                                                         ivaFormat,
                   CONCAT('$', FORMAT(Total, 0))                                                                       TotalFormat,
                   CONCAT('$', FORMAT(totalR, 0))                                                                      totalRFormat,
                   IVA,
                   CONCAT('$', FORMAT(IF(parcial IS NULL, 0, parcial) + IF(pago_nc IS NULL, 0, pago_nc),
                                      0))                                                                              cobradoFormat,
                   CONCAT('$', FORMAT(total - (IF(parcial IS NULL, 0, parcial) + IF(pago_nc IS NULL, 0, pago_nc)), 0)) saldo
            
            FROM factura f
                     LEFT JOIN (SELECT SUM(cobro) parcial, rc.idFactura
                                FROM r_caja rc
                                         LEFT JOIN factura f2 on f2.idFactura = rc.idFactura
                                WHERE f2.idCliente = $idCliente
                                  AND f2.estado = 'P'
                                GROUP BY rc.idFactura) t ON t.idFactura = f.idFactura
                     LEFT JOIN (SELECT ROUND(totalNotaC) as pago_nc, facturaDestino
                                FROM nota_c
                                WHERE fechaNotaC > '2016-04-05' AND idCliente=$idCliente) n ON n.facturaDestino = f.idFactura
            WHERE f.estado = 'P'
              AND DATEDIFF(fechaVenc, NOW()) < 0
              AND f.idCliente = $idCliente";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getEstadoCuentaCliente($idCliente)
    {
        $qry = "SELECT f.idFactura,
                       fechaFactura,
                       fechaVenc,
                       CONCAT('$', FORMAT(total, 0)) totalFactura,
                       CONCAT('$', FORMAT((ROUND(totalR) - retencionIva - retencionIca - retencionFte), 0)) totalReal,
                       CONCAT('$', FORMAT(IF(abonos IS NULL, 0, abonos), 0))                                abono,
                       CONCAT('$', FORMAT(IF(notaC IS NULL, 0, notaC), 0))                                  totalNotaC,
                       CONCAT('$', FORMAT(
                               (ROUND(totalR) - retencionIva - retencionIca - retencionFte - IF(abonos IS NULL, 0, abonos) -
                                IF(notaC IS NULL, 0, notaC)), 0)) as                                        'Saldo',
                       fechaCancelacion,
                       IF(estado = 'C', 'Cancelada', 'Pendiente')                                           estadoFactura
                FROM factura f
                         LEFT JOIN (SELECT SUM(cobro) abonos, idFactura FROM r_caja group by idFactura) t ON
                    t.idFactura = f.idFactura
                         LEFT JOIN (SELECT ROUND(totalNotaC) notaC, facturaDestino
                                    FROM nota_c
                                    WHERE fechaNotaC > '2016-04-05') nc ON nc.facturaDestino = f.idFactura
                WHERE idCliente = $idCliente
                  AND estado != 'A'
                ORDER BY idFactura desc";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getFormRecCaja($idRecCaja)
    {
        $qry = "SELECT idRecCaja, e.idCompra, e.tipoCompra, CONCAT('$', FORMAT(pago, 0)) pago, pago pagon, fechPago, descuentoE, formPago, formaPago, estadoCompra,
                       numFact, fechComp, fechVenc, CONCAT('$', FORMAT(total, 0)) total, nitProv, nomProv, CONCAT('$', FORMAT(retefuente, 0)) retefuente, CONCAT('$', FORMAT(reteica, 0)) reteica, pago vlr_pago,
                       CONCAT('$', FORMAT(total-retefuente-reteica, 0))  vreal, (total-retefuente-reteica) treal 
                FROM r_caja e
                LEFT JOIN ( SELECT idCompra id, tipoCompra, numFact, fechComp, fechVenc, totalCompra total, estadoCompra,
                              nitProv, nomProv, retefuenteCompra retefuente, reteicaCompra reteica
                       FROM compras c
                                LEFT JOIN proveedores p on c.idProv = p.idProv
                       UNION
                       SELECT idGasto id, tipoCompra, numFact, fechGasto fechComp, fechVenc, totalGasto total, estadoGasto estadoCompra,
                              nitProv, nomProv, retefuenteGasto retefuente, reteicaGasto reteica
                       FROM gastos g
                                LEFT JOIN proveedores p on g.idProv = p.idProv
                ) t ON e.idCompra=t.id AND e.tipoCompra=t.tipoCompra
                LEFT JOIN form_pago fp on e.formPago = fp.idFormaPago 
                WHERE idRecCaja=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idRecCaja));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getRecCaja($idRecCaja)
    {
        $qry = "SELECT idRecCaja,
                       cobro,
                       fechaRecCaja,
                       descuento_f,
                       form_pago,
                       reten,
                       idCheque,
                       codBanco,
                       banco,
                       rc.idFactura,
                       nitCliente,
                       nomCliente,
                       contactoCliente,
                       cargoCliente,
                       telCliente,
                       fechaFactura,
                       fechaVenc,
                       total,
                       totalR,
                       retencionIva,
                       f.retencionIca,
                       retencionFte,
                       subtotal,
                       iva
                FROM r_caja rc
                         LEFT JOIN factura f ON f.idFactura = rc.idFactura
                         LEFT JOIN clientes c on c.idCliente = f.idCliente
                         LEFT JOIN bancos b on b.idBanco = rc.codBanco
                WHERE idRecCaja =?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idRecCaja));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getTotalesxCobrarxVen8dias()
    {
        $qry = "SELECT SUM(total - (IF(parcial IS NULL, 0, parcial) + IF(pago_nc IS NULL, 0, pago_nc))) totalSaldo,
                       CONCAT('$', FORMAT(SUM(total - (IF(parcial IS NULL, 0, parcial) + IF(pago_nc IS NULL, 0, pago_nc))), 0)) totalSaldoFormat
                
                FROM factura f
                         LEFT JOIN clientes c on c.idCliente = f.idCliente
                         LEFT JOIN (SELECT SUM(cobro) parcial, idFactura FROM r_caja GROUP BY idFactura) t ON t.idFactura = f.idFactura
                         LEFT JOIN (SELECT ROUND(totalNotaC) as pago_nc, fechaNotaC, facturaDestino
                                    FROM nota_c
                                    WHERE fechaNotaC > '2016-04-05') n ON n.facturaDestino = f.idFactura
                WHERE f.Estado = 'P' AND DATEDIFF(fechaVenc,NOW() )>= 8";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getTotalesxCobrarxVencidos()
    {
        $qry = "SELECT SUM(total - (IF(parcial IS NULL, 0, parcial) + IF(pago_nc IS NULL, 0, pago_nc))) totalSaldo,
                       CONCAT('$', FORMAT(SUM(total - (IF(parcial IS NULL, 0, parcial) + IF(pago_nc IS NULL, 0, pago_nc))), 0)) totalSaldoFormat
                
                FROM factura f
                         LEFT JOIN clientes c on c.idCliente = f.idCliente
                         LEFT JOIN (SELECT SUM(cobro) parcial, idFactura FROM r_caja GROUP BY idFactura) t ON t.idFactura = f.idFactura
                         LEFT JOIN (SELECT ROUND(totalNotaC) as pago_nc, fechaNotaC, facturaDestino
                                    FROM nota_c
                                    WHERE fechaNotaC > '2016-04-05') n ON n.facturaDestino = f.idFactura
                WHERE f.Estado = 'P' AND DATEDIFF(fechaVenc,NOW() )< 0";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getTotalesxCobrarxVenc1sem()
    {
        $qry = "SELECT SUM(total - (IF(parcial IS NULL, 0, parcial) + IF(pago_nc IS NULL, 0, pago_nc))) totalSaldo,
                       CONCAT('$', FORMAT(SUM(total - (IF(parcial IS NULL, 0, parcial) + IF(pago_nc IS NULL, 0, pago_nc))), 0)) totalSaldoFormat
                
                FROM factura f
                         LEFT JOIN clientes c on c.idCliente = f.idCliente
                         LEFT JOIN (SELECT SUM(cobro) parcial, idFactura FROM r_caja GROUP BY idFactura) t ON t.idFactura = f.idFactura
                         LEFT JOIN (SELECT ROUND(totalNotaC) as pago_nc, fechaNotaC, facturaDestino
                                    FROM nota_c
                                    WHERE fechaNotaC > '2016-04-05') n ON n.facturaDestino = f.idFactura
                WHERE f.Estado = 'P' AND DATEDIFF(fechaVenc,NOW() )>= 0  AND DATEDIFF(fechaVenc, NOW())< 8";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getPagosXIdTipoCompra($id, $tipoCompra)
    {
        $qry = "SELECT CONCAT('$', FORMAT(pago, 0)) pago, CONCAT('$', FORMAT(descuentoE, 0)) descuento, fechPago, formaPago
                FROM r_caja 
                LEFT JOIN form_pago fp on r_caja.formPago = fp.idFormaPago
                WHERE idCompra=? and tipoCompra=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($id, $tipoCompra));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getPagoXIdTipoCompra($id, $tipoCompra)
    {
        $qry = "SELECT SUM(pago) parcial FROM r_caja WHERE idCompra=? and tipoCompra=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($id, $tipoCompra));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result && $result != null) {
            return $result['parcial'];
        } else {
            return 0;
        }
    }

    public function getTableRecCaja()
    {
        $qry = "SELECT idRecCaja,
                   rc.idFactura,
                   nomCliente,
                   CONCAT('$ ', FORMAT(cobro, 0)) pago,
                   fechaRecCaja,
                   formaPago
            FROM r_caja rc
                     LEFT JOIN factura f on f.idFactura = rc.idFactura
                     LEFT JOIN clientes c on c.idCliente = f.idCliente
                     LEFT JOIN form_pago fp on fp.idFormaPago = rc.form_pago";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getRecCajaFactura($idFactura)
    {
        $qry = "SELECT idRecCaja,
                        CONCAT('$ ', FORMAT(cobro, 0)) pago,
                       fechaRecCaja,
                       formaPago
                FROM r_caja rc
                         LEFT JOIN factura f on f.idFactura = rc.idFactura
                         LEFT JOIN clientes c on c.idCliente = f.idCliente
                         LEFT JOIN form_pago fp on fp.idFormaPago = rc.form_pago WHERE rc.idFactura=$idFactura";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getCobrosFactura($idFactura)
    {
        $qry = "SELECT SUM(cobro) parcial
                FROM r_caja
                WHERE idFactura =$idFactura";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array());
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if($result==null){
            return 0;
        }else{
            return $result['parcial'];
        }

    }
    public function getCobrosAnterioresFactura($idFactura, $idRecCaja)
    {
        $qry = "SELECT SUM(cobro) parcial
                FROM r_caja
                WHERE idFactura =$idFactura AND idRecCaja!=$idRecCaja";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array());
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if($result==null){
            return 0;
        }else{
            return $result['parcial'];
        }

    }

    public function checkRecCaja($idCompra, $tipoCompra)
    {
        $qry = "SELECT idRecCaja  FROM r_caja WHERE idCompra = ? AND tipoCompra = ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idCompra, $tipoCompra));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function updateRecCaja($datos)
    {
        $qry = "UPDATE r_caja SET cobro=?, fechaRecCaja=?, descuento_f=?, form_pago=?, reten=?, idCheque=?, codBanco=?, reten_ica=? WHERE idRecCaja=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function setDb()
    {

        $this->_pdo = Conectar::conexion(); //Almacenamos en _pdo la llamada la clase estática Conectar;

    }
}
