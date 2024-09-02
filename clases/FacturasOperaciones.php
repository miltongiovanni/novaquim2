<?php

class FacturasOperaciones
{
    private $_pdo; // Instance de PDO.

    public function __construct()
    {
        $this->setDb();
    }

    public function makeFactura($datos)
    {
        /*Preparo la insercion */
        $qry = "INSERT INTO factura (idFactura, idCliente, fechaFactura, fechaVenc, tipPrecio, estado, ordenCompra, descuento, observaciones) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
        return $this->_pdo->lastInsertId();
    }

    public function makeFacturaPedido($datos)
    {
        /*Preparo la insercion */
        $qry = "INSERT INTO factura_pedido (facturaId, pedidoId) VALUES(?, ?)";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
        return $this->_pdo->lastInsertId();
    }

    public function deleteFactura($idFactura)
    {
        $qry = "DELETE FROM factura WHERE idFactura= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idFactura));
    }


    public function isValidIdFactura($idFactura)
    {
        $qry = "SELECT * FROM factura WHERE idFactura=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idFactura));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result == false) {
            return false;
        } else {
            return true;
        }
    }

    public function getEstadoFactura($idFactura)
    {
        $qry = "SELECT estado FROM factura WHERE idFactura = $idFactura";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array());
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['estado'];
    }

    public function getFacturasByEstado($estado)
    {
        $qry = "SELECT idFactura FROM factura WHERE estado=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($estado));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getTotalesFactura($idFactura)
    {
        $qry = "SELECT idFactura, SUM(subtotal) subtotalfactura, ROUND(SUM(iva10),2) iva10factura, ROUND(SUM(iva19),2) iva19factura
                FROM
                    (SELECT dp.idFactura, dp.codProducto, cantProducto, precioProducto,
                            cantProducto*precioProducto subtotal, IF(idTasaIvaProducto=5 OR idTasaIvaProducto=2, ROUND(cantProducto*precioProducto*tasaIva,2),0  ) iva10,
                            IF(idTasaIvaProducto=3 OR idTasaIvaProducto=7, ROUND(cantProducto*precioProducto*tasaIva,0),0 ) iva19
                     FROM det_factura dp
                              LEFT JOIN factura f on f.idFactura = dp.idFactura
                              LEFT JOIN prodpre p on dp.codProducto = p.codPresentacion
                              LEFT JOIN tasa_iva ti on ti.idTasaIva = dp.idTasaIvaProducto
                     WHERE dp.idFactura = $idFactura
                       AND dp.codProducto > 10000
                       AND dp.codProducto < 100000
                     UNION
                     SELECT dp.idFactura, dp.codProducto, cantProducto, precioProducto,
                            cantProducto*precioProducto subtotal, IF(idTasaIvaProducto=5 OR idTasaIvaProducto=0, cantProducto*precioProducto*tasaIva,0  ) iva10,
                            IF(idTasaIvaProducto=3 OR idTasaIvaProducto=7, cantProducto*precioProducto*tasaIva,0 ) iva19
                     FROM det_factura dp
                              LEFT JOIN factura f on f.idFactura = dp.idFactura
                              LEFT JOIN distribucion d on dp.codProducto = d.idDistribucion
                              LEFT JOIN tasa_iva ti on ti.idTasaIva = dp.idTasaIvaProducto
                     WHERE dp.idFactura = $idFactura
                       AND dp.codProducto > 100000
                     UNION
                     SELECT dp.idFactura, dp.codProducto, cantProducto, precioProducto,
                            cantProducto*precioProducto subtotal, IF(idTasaIvaProducto=5 OR idTasaIvaProducto=0, cantProducto*precioProducto*tasaIva,0  ) iva10,
                            IF(idTasaIvaProducto=3 OR idTasaIvaProducto=7, cantProducto*precioProducto*tasaIva,0 ) iva19
                     FROM det_factura dp
                              LEFT JOIN factura f on f.idFactura = dp.idFactura
                              LEFT JOIN servicios s on dp.codProducto = s.idServicio
                              LEFT JOIN tasa_iva i on i.idTasaIva = dp.idTasaIvaProducto
                     WHERE dp.idFactura = $idFactura
                       AND dp.codProducto < 100) t
                GROUP BY idFactura";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array());
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getTableFacturasPorFecha($fechaIni, $fechaFin)
    {
        $qry = "SELECT idFactura,
                       nitCliente,
                       nomCliente,
                       fechaFactura,
                       ultimaCompra,
                       tipoPrecio,
                       CONCAT('$', FORMAT(subtotal, 0))             subtotal,
                       CONCAT('$', FORMAT(subtotal * descuento, 0)) descuentoF,
                       CONCAT('$', FORMAT(iva, 0))                  iva,
                       CONCAT('$', FORMAT(retencionFte, 0))         retencionFte,
                       CONCAT('$', FORMAT(retencionIva, 0))         retencionIva,
                       CONCAT('$', FORMAT(retencionIca, 0))         retencionIca,
                       CONCAT('$', FORMAT(total, 0))                total,
                       CONCAT('$', FORMAT(totalR, 0))               totalR
                FROM factura f
                         LEFT JOIN clientes c on f.idCliente = c.idCliente
                    LEFT JOIN tip_precio tp ON tp.idPrecio = f.tipPrecio
                LEFT JOIN (SELECT idCliente, MAX(fechaFactura) ultimaCompra FROM factura GROUP BY idCliente) u ON u.idCliente = c.idCliente
                WHERE fechaFactura >= ?
                  AND fechaFactura <= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($fechaIni, $fechaFin));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }


    public function getTotalesFacturasPorFecha($fechaIni, $fechaFin)
    {
        $qry = "SELECT CONCAT('$', FORMAT(SUM(subtotal), 0))             subtotalPeriodo,
                       CONCAT('$', FORMAT(SUM(subtotal * descuento), 0)) descuentoPeriodo,
                       CONCAT('$', FORMAT(SUM(iva), 0))                  ivaPeriodo,
                       CONCAT('$', FORMAT(SUM(total), 0))                totalPeriodo,
                       CONCAT('$', FORMAT(SUM(retencionFte), 0))         retefuentePeriodo,
                       CONCAT('$', FORMAT(SUM(retencionIva), 0))         reteivaPeriodo,
                       CONCAT('$', FORMAT(SUM(retencionIca), 0))         reteicaPeriodo
                FROM factura
                WHERE fechaFactura >= ?
                  AND fechaFactura <= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($fechaIni, $fechaFin));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getDetClienteFactura($idFactura)
    {
        $qry = "SELECT idFactura, idCatCliente, nomCliente,ciudadCliente, retIva, retIca, retFte, codVendedor, retCree, fchCreacionCliente, exenIva
                FROM factura f
                LEFT JOIN clientes c on c.idCliente = f.idCliente
                WHERE idFactura = $idFactura";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array());
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getMaxFecha()
    {
        $qry = "SELECT MAX(fechaFactura) maxFecha FROM factura";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array());
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['maxFecha'];
    }

    public function getProductosCotizacion($precio, $presentaciones, $productos_c)
    {
        if ($precio == 1) {
            $lista = 'fabrica';
        }
        if ($precio == 2) {
            $lista = 'distribuidor';
        }
        if ($precio == 3) {
            $lista = 'detal';
        }
        if ($precio == 4) {
            $lista = 'mayor';
        }
        if ($precio == 5) {
            $lista = 'super';
        }
        //SELECCIONA EL TIPO DE PRESENTACIONES 1 PARA TODAS, 2 PARA PEQUEÑAS Y 3 PARA GRANDES
        if ($presentaciones == 1)
            $wh = " AND cantMedida<=20000";
        if ($presentaciones == 2)
            $wh = " AND cantMedida<4000";
        if ($presentaciones == 3)
            $wh = " AND cantMedida>3500";
        $seleccion_p = explode(",", $productos_c);
        $b = count($seleccion_p);
        $qryp = " AND (";
        for ($k = 0; $k < $b; $k++) {
            $qryp = $qryp . " p2.idCatProd=" . ($seleccion_p[$k]);
            if ($k <= ($b - 2))
                $qryp = $qryp . " OR ";
        }
        $qryp = $qryp . ")";
        $qry = "SELECT DISTINCT pr.codigoGen,
                                producto,
                                FORMAT($lista, 0)      $lista
                FROM precios pr
                         LEFT JOIN prodpre p on pr.codigoGen = p.codigoGen
                         LEFT JOIN medida m on p.codMedida = m.idMedida
                         LEFT JOIN productos p2 on p.codProducto = p2.codProducto
                         LEFT JOIN cat_prod cp on p2.idCatProd = cp.idCatProd
                WHERE presActiva = 1
                  AND presLista = 1
                  $wh
                  $qryp
                  ORDER BY producto";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_NUM);
        return $result;
    }

    public function getProductosDistFactura($distribucion)
    {
        $qryd = '';
        if ($distribucion != NULL) {
            $seleccion = explode(",", $distribucion);
            $qryd = " AND ( ";
            $a = count($seleccion);
            for ($j = 0; $j < $a; $j++) {
                $qryd = $qryd . "(idDistribucion > " . ($seleccion[$j] * 100000) . " and idDistribucion < " . (($seleccion[$j] + 1) * 100000) . ")";
                if ($j <= ($a - 2))
                    $qryd = $qryd . " or ";
            }
            $qryd = $qryd . ")";
        }
        $qry = "SELECT idDistribucion, producto, precioVta
                FROM distribucion
                WHERE cotiza=1 AND activo=1
                $qryd
                ORDER BY producto";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_NUM);
        return $result;
    }

    public function getProdTerminadosByIdFactura($idFactura)
    {
        $qry = "SELECT t.codPresentacion, t.presentacion
                FROM (SELECT pp.codPresentacion, pp.presentacion
                      FROM prodpre pp
                      WHERE cotiza = 1
                        AND presentacionActiva = 1) t
                         LEFT JOIN (SELECT codProducto FROM det_factura WHERE idFactura = ?) dr1
                                   ON dr1.codProducto = t.codPresentacion
                WHERE dr1.codProducto IS NULL
                ORDER BY t.presentacion";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idFactura));
        $result = $stmt->fetchall(PDO::FETCH_ASSOC);
        return $result;
    }


    public function getProdDistribucionByIdFactura($idFactura)
    {
        $qry = "SELECT idDistribucion, producto
                FROM (SELECT d.idDistribucion, d.producto
                      FROM distribucion d
                      WHERE cotiza = 1 AND activo =1) t
                         LEFT JOIN (SELECT codProducto FROM det_factura WHERE idFactura = ?) dr1
                                   ON dr1.codProducto = t.idDistribucion
                WHERE dr1.codProducto IS NULL
                ORDER BY producto";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idFactura));
        $result = $stmt->fetchall(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getServicioByIdFactura($idFactura)
    {
        $qry = "SELECT idServicio, desServicio
                FROM (SELECT idServicio, desServicio
                      FROM servicios s
                      WHERE activo =1) t
                         LEFT JOIN (SELECT codProducto FROM det_factura WHERE idFactura = ?) dr1
                                   ON dr1.codProducto = t.idServicio
                WHERE dr1.codProducto IS NULL
                ORDER BY desServicio";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idFactura));
        $result = $stmt->fetchall(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getServiciosByIdFactura($idFactura)
    {
        $qry = "SELECT codProducto, cantProducto, precioProducto, idTasaIvaProducto
                FROM det_factura df
                WHERE df.idFactura = ?
                  AND codProducto < 100";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idFactura));
        $result = $stmt->fetchall(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getCotizacionesGastos($q)
    {
        $qry = "SELECT idFactura, nomCotizacion FROM factura WHERE (idCatCotizacion=5 OR idCatCotizacion=6) AND nomCotizacion like '%" . $q . "%' ORDER BY nomCotizacion;";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getTableFacturas($limit, $order, $where, $bindings)
    {
        $qry = "SELECT * FROM (SELECT f.idFactura,
                       pedidos idPedido,
                       remisiones idRemision,
                       c.nomCliente,
                       f.fechaFactura,
                       f.fechaVenc,
                       tp.tipoPrecio,
                       IF(f.estado='A', 'Anulada', IF(f.estado='C', 'Cancelada', IF(f.estado='E', 'En proceso', 'Pendiente'))) estadoFactura,
                       CONCAT('$', FORMAT(f.total, 0)) totalFactura
                FROM factura f
                LEFT JOIN clientes c ON c.idCliente = f.idCliente
                LEFT JOIN tip_precio tp ON f.tipPrecio = tp.idPrecio
                LEFT JOIN (SELECT fp.facturaId,
                       GROUP_CONCAT(DISTINCT fp.pedidoId
                                    ORDER BY fp.pedidoId SEPARATOR ', ') pedidos,
                       GROUP_CONCAT(DISTINCT r.idRemision
                                    ORDER BY r.idRemision SEPARATOR ', ') remisiones
                FROM factura_pedido fp
                LEFT JOIN remision r ON fp.pedidoId = r.idPedido
                GROUP BY fp.facturaId) t ON t.facturaId = f.idFactura) fct
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
        $result = $stmt->fetchAll(PDO::FETCH_BOTH);
        return $result;
    }


    public function getTotalNumeroFacturas($where, $bindings)
    {
        $qry = "select COUNT(idFactura) c FROM (SELECT f.idFactura,
                       pedidos idPedido,
                       remisiones idRemision,
                       c.nomCliente,
                       f.fechaFactura,
                       f.fechaVenc,
                       tp.tipoPrecio,
                       IF(f.estado='A', 'Anulada', IF(f.estado='C', 'Cancelada', IF(f.estado='E', 'En proceso','Pendiente'))) estadoFactura,
                       CONCAT('$', FORMAT(f.total, 0)) totalFactura
                FROM factura f
                         LEFT JOIN clientes c on c.idCliente = f.idCliente
                         LEFT JOIN tip_precio tp ON f.tipPrecio = tp.idPrecio
                        LEFT JOIN (SELECT fp.facturaId,
                               GROUP_CONCAT(DISTINCT fp.pedidoId
                                            ORDER BY fp.pedidoId SEPARATOR ', ') pedidos,
                               GROUP_CONCAT(DISTINCT r.idRemision
                                            ORDER BY r.idRemision SEPARATOR ', ') remisiones
                        FROM factura_pedido fp
                        LEFT JOIN remision r ON fp.pedidoId = r.idPedido
                        GROUP BY fp.facturaId) t ON t.facturaId = f.idFactura) fctc
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
        $result = $stmt->fetch(PDO::FETCH_BOTH);
        return $result['c'];
    }

    public function getTableFacturasCliente($idCliente)
    {
        $qry = "SELECT idFactura,
                       pedidos idPedido,
                       remisiones idRemision,
                       nomCliente,
                       fechaFactura,
                       fechaVenc,
                       tp.tipoPrecio,
                       IF(f.estado='A', 'Anulada', IF(f.estado='C', 'Cancelada', 'Pendiente')) estadoFactura,
                       CONCAT('$', FORMAT(total, 0)) totalFactura
                FROM factura f
                         LEFT JOIN clientes c on c.idCliente = f.idCliente
                         LEFT JOIN tip_precio tp ON f.tipPrecio = tp.idPrecio
                        LEFT JOIN (SELECT fp.facturaId,
                               GROUP_CONCAT(fp.pedidoId
                                            ORDER BY fp.pedidoId SEPARATOR ', ') pedidos,
                               GROUP_CONCAT(r.idRemision
                                            ORDER BY r.idRemision SEPARATOR ', ') remisiones
                        FROM factura_pedido fp
                        LEFT JOIN remision r ON fp.pedidoId = r.idPedido
                        GROUP BY fp.facturaId) t ON t.facturaId = f.idFactura
                WHERE f.idCliente=$idCliente";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getFacturasClienteForNotas($idCliente)
    {
        $qry = "SELECT idFactura, CONCAT('$', FORMAT(total, 0)) 'totalFactura' FROM factura f WHERE f.idCliente=? AND (f.estado!='A') ORDER BY idFactura DESC";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idCliente));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getFacturasClientePorCancelar($idCliente)
    {
        $qry = "SELECT idFactura FROM factura f WHERE f.idCliente=? AND (f.estado='P') ORDER BY idFactura DESC";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idCliente));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getTableFacturasPendientes($idCliente)
    {
        $qry = "SELECT idFactura,
                       fechaFactura,
                       fechaEntrega,
                       tp.tipoPrecio,
                       IF(p.estado='A', 'Anulado', IF(p.estado='F', 'Facturado', IF(p.estado='P','Pendiente', 'Por facturar'))) estadoFactura,
                       nomSucursal,
                       dirSucursal
                FROM factura p
                         LEFT JOIN clientes c on c.idCliente = p.idCliente
                         LEFT JOIN clientes_sucursal cs on p.idCliente = cs.idCliente AND p.idSucursal = cs.idSucursal
                         LEFT JOIN tip_precio tp ON p.tipoPrecio = tp.idPrecio
                 WHERE c.idCliente=$idCliente";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getFactura($idFactura)
    {
        $qry = "SELECT idFactura,
                   pedidos idPedido,
                   f.idCliente,
                   nitCliente,
                   descuento,
                   fechaFactura,
                   fechaVenc,
                   remisiones idRemision,
                   ordenCompra,
                   tipPrecio,
                   nomCliente,
                   telCliente,
                   dirCliente,
                   Ciudad,
                   idPersonal,
                   nomPersonal vendedor,
                   observaciones,
                   retencionIva,
                   retencionFte,
                   retencionIca,
                   total,
                   totalR,
                   subtotal,
                   iva,
                   f.Estado,
                   IF(f.estado = 'A', 'Anulada', IF(f.estado = 'P', 'Pendiente', IF(f.estado = 'C', 'Cancelada', 'En proceso'))) estadoFactura
            FROM factura f
            LEFT JOIN clientes c ON c.idCliente = f.idCliente
            LEFT JOIN personal p ON p.idPersonal = c.codVendedor
            LEFT JOIN ciudades c2 ON c2.idCiudad = c.ciudadCliente
            LEFT JOIN
              (SELECT fp.facturaId,
                      GROUP_CONCAT(fp.pedidoId
                                   ORDER BY fp.pedidoId SEPARATOR ', ') pedidos,
                      GROUP_CONCAT(r.idRemision
                                   ORDER BY r.idRemision SEPARATOR ', ') remisiones
               FROM factura_pedido fp
               LEFT JOIN remision r ON fp.pedidoId = r.idPedido
               WHERE fp.facturaId = $idFactura) t ON t.facturaId = f.idFactura
            WHERE idFactura = $idFactura";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getFacturaForPrint($idFactura)
    {
        $qry = "SELECT idFactura,
                       c.idCliente,
                       nomCliente,
                       contactoCliente,
                       cargoContacto,
                       fechaCotizacion,
                       nomPersonal,
                       tipPrecio tipoPrecio,
                       IF(tipPrecio = 1, 'Fábrica', IF(tipPrecio = 2, 'Distribuidor',
                                                       IF(tipPrecio = 3, 'Detal', IF(tipPrecio = 4, 'Mayorista', 'Super')))) tipPrecio,
                       destino,
                       c2.ciudad,
                       nomPersonal,
                       celPersonal,
                       emlPersonal,
                       cargo,
                       cc2.desCatClien
                FROM factura c
                         LEFT JOIN clientes_cotiz cc on cc.idCliente = c.idCliente
                         LEFT JOIN personal p on p.idPersonal = cc.codVendedor
                         LEFT JOIN ciudades c2 on c2.idCiudad = cc.idCiudad
                         LEFT JOIN cargos_personal cp ON p.cargoPersonal = cp.idCargo
                         LEFT JOIN cat_clien cc2 on cc2.idCatClien = cc.idCatCliente
                WHERE idFactura =?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idFactura));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function updateTotalesFactura($datos)
    {
        $qry = "UPDATE factura SET total=?, retencionIva=?, retencionIca=?, retencionFte=?, subtotal=?, iva=?, totalR=?
                 WHERE idFactura=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function updateFactura($datos)
    {
        $qry = "UPDATE factura SET fechaFactura=?, fechaVenc=?, tipPrecio=?, descuento=?
                 WHERE idFactura=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function updateEstadoFactura($estado, $idFactura)
    {
        $qry = "UPDATE factura SET estado=?
                 WHERE idFactura=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($estado, $idFactura));
    }

    public function anularFactura($observaciones, $idFactura)
    {
        $qry = "UPDATE factura SET estado='A', observaciones=?, total=0, subtotal=0, iva=0, descuento=0, 
                   retencionIva=0, retencionIca=0, retencionFte=0, totalR=0
                 WHERE idFactura=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($observaciones, $idFactura));
    }

    public function cancelarFactura($fechaCancelacion, $idFactura)
    {
        $qry = "UPDATE factura SET estado='C', fechaCancelacion=? WHERE idFactura=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($fechaCancelacion, $idFactura));
    }

    public function setDb()
    {

        $this->_pdo = Conectar::conexion(); //Almacenamos en _pdo la llamada la clase estática Conectar;

    }
}
