<?php

class RemisionesOperaciones
{
    private $_pdo; // Instance de PDO.

    public function __construct()
    {
        $this->setDb();
    }

    public function setDb()
    {

        $this->_pdo = Conectar::conexion(); //Almacenamos en _pdo la llamada la clase estática Conectar;

    }

    public function makeRemision($datos)
    {
        /*Preparo la insercion */
        $qry = "INSERT INTO remision1 (cliente, fechaRemision) VALUES (?, ?)";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
        return $this->_pdo->lastInsertId();
    }

    public function makeRemisionFactura($datos)
    {
        /*Preparo la insercion */
        $qry = "INSERT INTO remision (idCliente, fechaRemision, idPedido, idSucursal) VALUES (?, ?, ?, ?)";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
        return $this->_pdo->lastInsertId();
    }

    public function deleteSalidaRemision($idRemision)
    {
        $qry = "DELETE FROM remision WHERE idRemision= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idRemision));
    }

    public function getTableRemisiones()
    {
        $qry = "SELECT idRemision, nitProv, nomProv, numFact, fechRemision, fechVenc, descEstado, CONCAT('$', FORMAT(totalRemision, 0)) totalRemision,
                CONCAT('$', FORMAT(retefuenteRemision, 0)) retefuenteRemision, CONCAT('$', FORMAT(reteicaRemision, 0)) reteicaRemision,
                CONCAT('$', FORMAT(totalRemision-retefuenteRemision-reteicaRemision, 0))  vreal
                FROM remision1
                   LEFT JOIN estados e on remision1.estadoRemision = e.idEstado
                   LEFT JOIN proveedores p on remision1.idProv = p.idProv
                ORDER BY idRemision DESC;";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getTableSalidasPorFecha($fechaIni, $fechaFin)
    {
        $qry = "SELECT idRemision, cliente, fechaRemision, CONCAT('$', FORMAT(valor, 0)) valorFormatted
                FROM remision1
                WHERE fechaRemision>=? AND fechaRemision<=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($fechaIni, $fechaFin));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getTableSalidaRemisiones($limit, $order, $where, $bindings)
    {
        $qry = "SELECT idRemision, fechaRemision, nomCliente, nomSucursal, r.idPedido, fechaPedido
                FROM remision r
                         LEFT JOIN clientes c on c.idCliente = r.idCliente
                         LEFT JOIN clientes_sucursal cs on cs.idCliente = r.idCliente AND r.idSucursal=cs.idSucursal
                         LEFT JOIN pedido p on r.idPedido = p.idPedido 
                $where
                $order
                $limit
                ";
        $stmt = $this->_pdo->prepare($qry);
        // Bind parameters
        if (is_array($bindings)) {
            for ($i = 0, $ien = count($bindings); $i < $ien; $i++) {
                $binding = $bindings[$i];
                $stmt->bindValue($binding['key'], $binding['val'], $binding['type']);
            }
        }
        // Execute
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getTotalTableSalidaRemisiones($where, $bindings)
    {
        $qry = "select COUNT(idRemision) c from (SELECT idRemision, fechaRemision, nomCliente, nomSucursal, r.idPedido, fechaPedido
                FROM remision r
                         LEFT JOIN clientes c on c.idCliente = r.idCliente
                         LEFT JOIN clientes_sucursal cs on cs.idCliente = r.idCliente AND r.idSucursal=cs.idSucursal
                         LEFT JOIN pedido p on r.idPedido = p.idPedido) rccp 
                $where
                ";
        $stmt = $this->_pdo->prepare($qry);
        // Bind parameters
        if (is_array($bindings)) {
            for ($i = 0, $ien = count($bindings); $i < $ien; $i++) {
                $binding = $bindings[$i];
                $stmt->bindValue($binding['key'], $binding['val'], $binding['type']);
            }
        }
        // Execute
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['c'];
    }

    public function getRemision($idRemision)
    {
        $qry = "SELECT idRemision,
                       nitCliente,
                       idPedido,
                       fechaRemision,
                       nomCliente,
                       telCliente,
                       dirCliente,
                       ciudad,
                       nomSucursal,
                       dirSucursal
                FROM remision r
                         LEFT JOIN clientes c on c.idCliente = r.idCliente
                         LEFT JOIN clientes_sucursal cs on r.idCliente = cs.idCliente AND cs.idSucursal=r.idSucursal
                         LEFT JOIN ciudades c2 on c2.idCiudad = c.ciudadCliente
                WHERE idRemision =?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idRemision));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getRemisionById($idRemision)
    {
        $qry = "SELECT idRemision, cliente, fechaRemision, valor
                FROM remision1
                WHERE idRemision =?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idRemision));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getProdTerminadosByIdRemision($idRemision)
    {
        $qry = "SELECT t.codPresentacion, t.presentacion
                FROM (SELECT DISTINCT ip.codPresentacion, p.presentacion
                      FROM inv_prod ip
                               LEFT JOIN prodpre p on ip.codPresentacion = p.codPresentacion
                      WHERE invProd > 0) t
                         LEFT JOIN (SELECT codProducto FROM det_remision1 WHERE idRemision = ?) dr1
                                   ON dr1.codProducto = t.codPresentacion
                WHERE dr1.codProducto IS NULL
                ORDER BY t.presentacion";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idRemision));
        $result = $stmt->fetchall(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getProdDistribucionByIdRemision($idRemision)
    {
        $qry = "SELECT codDistribucion, producto
                FROM (SELECT codDistribucion, producto
                      FROM inv_distribucion id
                               LEFT JOIN distribucion d on id.codDistribucion = d.idDistribucion
                      WHERE invDistribucion > 0) t
                         LEFT JOIN (SELECT codProducto FROM det_remision1 WHERE idRemision = ?) dr1
                                   ON dr1.codProducto = t.codDistribucion
                WHERE dr1.codProducto IS NULL
                ORDER BY producto";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idRemision));
        $result = $stmt->fetchall(PDO::FETCH_ASSOC);
        return $result;
    }

    public function checkFactura($idProv, $numFact)
    {
        $qry = "SELECT idRemision  FROM remision1 WHERE idProv= ? AND numFact= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idProv, $numFact));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function isValidIdRemision($idRemision)
    {
        $qry = "SELECT * FROM remision1 WHERE idRemision=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idRemision));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result == false) {
            return false;
        } else {
            return true;
        }
    }

    public function isValidRemision($idRemision)
    {
        $qry = "SELECT * FROM remision WHERE idRemision=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idRemision));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result == false) {
            return false;
        } else {
            return true;
        }
    }

    public function updateRemision($datos)
    {
        $qry = "UPDATE remision1 SET cliente=?, fechaRemision=?, valor=? WHERE idRemision=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function cancelaRemision($estadoRemision, $fechPago, $idRemision)
    {
        $qry = "UPDATE remision1 SET estadoRemision=?, fechCancelacion=? WHERE idRemision=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($estadoRemision, $fechPago, $idRemision));
    }

    public function updateEstadoRemision($datos)
    {
        $qry = "UPDATE remision1 SET estadoRemision=? WHERE idRemision=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function updateTotalRemision($idRemision)
    {
        $qry = "UPDATE remision1, (SELECT SUM(cantProducto*precioProducto) total FROM det_remision1 WHERE idRemision=$idRemision) t SET valor = t.total  WHERE idRemision=$idRemision AND t.total > 0";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
    }

    public function updateTotalesRemision($base, $idRemision)
    {
        $qry = "UPDATE remision1,
                (SELECT IF(SUM(precRemision * cantRemision) IS NULL, 0, ROUND(SUM(precRemision * cantRemision), 2)) subtotal,
                        IF(SUM(precRemision * cantRemision) IS NULL, 0,
                           ROUND(SUM(precRemision * cantRemision * tasaIva), 2)) AS iva,
                        IF(SUM(precRemision * cantRemision) IS NULL, 0,
                           ROUND((SUM(precRemision * cantRemision) + SUM(precRemision * cantRemision * tasaIva)),
                                 0)) total,
                        IF(autoretProv = 1, 0,
                           IF(SUM(precRemision * cantRemision) >= $base, ROUND(SUM(precRemision * cantRemision * tasaRetIca), 0),
                              0)) AS reteica,
                        IF(autoretProv = 1, 0,
                           IF(SUM(precRemision * cantRemision) >= $base, ROUND(SUM(precRemision * cantRemision * tasaRetefuente), 0),
                              0)) AS retefuente
                 FROM det_remision1 dg
                          LEFT JOIN remision1 g ON dg.idRemision = g.idRemision
                          LEFT JOIN tasa_iva ti ON dg.codIva = ti.idTasaIva
                          LEFT JOIN proveedores p ON g.idProv = p.idProv
                          LEFT JOIN tasa_reteica tr on p.idTasaIcaProv = tr.idTasaRetIca
                          LEFT JOIN tasa_retefuente t on p.idRetefuente = t.idTasaRetefuente
                      WHERE dg.idRemision = $idRemision) tabla
            SET totalRemision=total,
                subtotalRemision=subtotal,
                ivaRemision=iva,
                retefuenteRemision=retefuente,
                reteicaRemision=reteica
            WHERE idRemision = $idRemision";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
    }
}
