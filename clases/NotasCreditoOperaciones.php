<?php

class NotasCreditoOperaciones
{
    private $_pdo; // Instance de PDO.

    public function __construct()
    {
        $this->setDb();
    }

    public function makeNotaC($datos)
    {
        /*Preparo la insercion */
        $qry = "INSERT INTO nota_c (idCliente, fechaNotaC, facturaOrigen, facturaDestino, motivo, descuentoFactOrigen) VALUES(?, ?, ?, ?, ?, ?)";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
        return $this->_pdo->lastInsertId();
    }

    public function deleteNotaC($idNotaC)
    {
        $qry = "DELETE FROM nota_c WHERE idNotaC= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idNotaC));
    }


    public function isValidIdNotaC($idNotaC)
    {
        $qry = "SELECT * FROM nota_c WHERE idNotaC=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idNotaC));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result == false) {
            return false;
        } else {
            return true;
        }
    }

    public function getEstadoNotaC($idNotaC)
    {
        $qry = "SELECT estado FROM nota_c WHERE idNotaC = $idNotaC";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array());
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['estado'];
    }

    public function getNotasCreditoSinDestino()
    {
        $qry = "SELECT idNotaC, nomCliente, nc.idCliente, CONCAT('$', FORMAT(nc.totalNotaC, 0)) 'totalNota'
                FROM nota_c nc
                LEFT JOIN clientes c on c.idCliente = nc.idCliente
                WHERE facturaDestino IS NULL";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getTotalesNotaC($idNotaC)
    {
        $qry = "SELECT idNotaC,
                       CONCAT('$', FORMAT(SUM(subtotal), 0))                           subtotalnota_c,
                       ROUND(SUM(subtotal), 0)                                         subtotal,
                       CONCAT('$', FORMAT(SUM(iva10), 0))                              iva10nota_c,
                       CONCAT('$', FORMAT(SUM(iva19), 0))                              iva19nota_c,
                       CONCAT('$', FORMAT(SUM(subtotal) + SUM(iva19) + SUM(iva10), 0)) totalFormatNota_c,
                       ROUND(SUM(iva19) + SUM(iva10), 0)                               iva,
                       ROUND(SUM(subtotal) + SUM(iva19) + SUM(iva10), 0)               totalNotaC
                FROM (SELECT dnc.idNotaC,
                             dnc.cantProducto,
                             precioProducto,
                             dnc.cantProducto * precioProducto * (1 - descuentoFactOrigen)                  subtotal,
                             IF(idTasaIvaProducto = 5 OR idTasaIvaProducto = 2,
                                dnc.cantProducto * precioProducto * tasaIva * (1 - descuentoFactOrigen), 0) iva10,
                             IF(idTasaIvaProducto = 3 OR idTasaIvaProducto = 7,
                                dnc.cantProducto * precioProducto * tasaIva * (1 - descuentoFactOrigen), 0) iva19
                      FROM det_nota_c dnc
                               LEFT JOIN nota_c nc on nc.idNotaC = dnc.idNotaC
                               LEFT JOIN factura f ON nc.facturaOrigen = f.idFactura
                               LEFT JOIN det_factura df ON df.codProducto = dnc.codProducto AND df.idFactura = f.idFactura
                               LEFT JOIN prodpre p on dnc.codProducto = p.codPresentacion
                               LEFT JOIN tasa_iva ti on ti.idTasaIva = df.idTasaIvaProducto
                      WHERE dnc.idNotaC = $idNotaC
                        AND dnc.codProducto > 10000
                        AND dnc.codProducto < 100000
                      UNION
                      SELECT dnc2.idNotaC,
                             dnc2.cantProducto,
                             precioProducto,
                             dnc2.cantProducto * precioProducto * (1 - descuentoFactOrigen)                  subtotal,
                             IF(idTasaIvaProducto = 5 OR idTasaIvaProducto = 2,
                                dnc2.cantProducto * precioProducto * tasaIva * (1 - descuentoFactOrigen), 0) iva10,
                             IF(idTasaIvaProducto = 3 OR idTasaIvaProducto = 7,
                                dnc2.cantProducto * precioProducto * tasaIva * (1 - descuentoFactOrigen), 0) iva19
                      FROM det_nota_c dnc2
                               LEFT JOIN nota_c nc2 on nc2.idNotaC = dnc2.idNotaC
                               LEFT JOIN factura f ON nc2.facturaOrigen = f.idFactura
                               LEFT JOIN det_factura df ON df.codProducto = dnc2.codProducto AND df.idFactura = f.idFactura
                               LEFT JOIN distribucion d on dnc2.codProducto = d.idDistribucion
                               LEFT JOIN tasa_iva ti on ti.idTasaIva = df.idTasaIvaProducto
                      WHERE dnc2.idNotaC = $idNotaC
                        AND dnc2.codProducto > 100000) t
                GROUP BY idNotaC";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array());
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getDetClienteNotaC($idNotaC)
    {
        $qry = "SELECT idNotaC, idCatCliente, nomCliente,ciudadCliente, retIva, retIca, retFte, codVendedor, retCree, fchCreacionCliente, exenIva
                FROM nota_c f
                LEFT JOIN clientes c on c.idCliente = f.idCliente
                WHERE idNotaC = $idNotaC";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array());
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getProductosNotaC($idNotaC, $facturaOrigen)
    {
        $qry = "SELECT t.codProducto, t.producto, t.cantProducto
                FROM (SELECT df.codProducto, presentacion as producto, cantProducto
                      FROM det_factura df
                               LEFT JOIN prodpre p ON df.codProducto = p.codPresentacion
                      WHERE idFactura = $facturaOrigen
                        AND p.codPresentacion IS NOT NULL
                      UNION
                      SELECT codProducto, producto, cantProducto
                      FROM det_factura df2
                               LEFT JOIN distribucion d ON df2.codProducto = d.idDistribucion
                      WHERE idFactura = $facturaOrigen
                        AND d.idDistribucion IS NOT NULL) t
                         LEFT JOIN (SELECT codProducto FROM det_nota_c WHERE idNotaC=$idNotaC) dnc ON t.codProducto = dnc.codProducto
                WHERE dnc.codProducto  IS NULL";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getCantDetProductosNotaC($facturaOrigen, $codProducto)
    {
        $qry = "SELECT t.codProducto, t.producto, t.cantProducto
                FROM (SELECT df.codProducto, presentacion as producto, cantProducto
                      FROM det_factura df
                               LEFT JOIN prodpre p ON df.codProducto = p.codPresentacion
                      WHERE idFactura = $facturaOrigen
                        AND p.codPresentacion IS NOT NULL
                      UNION
                      SELECT codProducto, producto, cantProducto
                      FROM det_factura df2
                               LEFT JOIN distribucion d ON df2.codProducto = d.idDistribucion
                      WHERE idFactura = $facturaOrigen
                        AND d.idDistribucion IS NOT NULL) t
                WHERE t.codProducto  =$codProducto;";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['cantProducto'];
    }

    public function getProductosDistNotaC($distribucion)
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

    public function getProdTerminadosByIdNotaC($idNotaC)
    {
        $qry = "SELECT t.codPresentacion, t.presentacion
                FROM (SELECT pp.codPresentacion, pp.presentacion
                      FROM prodpre pp
                      WHERE cotiza = 1
                        AND presentacionActiva = 1) t
                         LEFT JOIN (SELECT codProducto FROM det_nota_c WHERE idNotaC = ?) dr1
                                   ON dr1.codProducto = t.codPresentacion
                WHERE dr1.codProducto IS NULL
                ORDER BY t.presentacion";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idNotaC));
        $result = $stmt->fetchall(PDO::FETCH_ASSOC);
        return $result;
    }


    public function getProdDistribucionByIdNotaC($idNotaC)
    {
        $qry = "SELECT idDistribucion, producto
                FROM (SELECT d.idDistribucion, d.producto
                      FROM distribucion d
                      WHERE cotiza = 1 AND activo =1) t
                         LEFT JOIN (SELECT codProducto FROM det_nota_c WHERE idNotaC = ?) dr1
                                   ON dr1.codProducto = t.idDistribucion
                WHERE dr1.codProducto IS NULL
                ORDER BY producto";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idNotaC));
        $result = $stmt->fetchall(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getServicioByIdNotaC($idNotaC)
    {
        $qry = "SELECT idServicio, desServicio
                FROM (SELECT idServicio, desServicio
                      FROM servicios s
                      WHERE activo =1) t
                         LEFT JOIN (SELECT codProducto FROM det_nota_c WHERE idNotaC = ?) dr1
                                   ON dr1.codProducto = t.idServicio
                WHERE dr1.codProducto IS NULL
                ORDER BY desServicio";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idNotaC));
        $result = $stmt->fetchall(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getCotizacionesGastos($q)
    {
        $qry = "SELECT idNotaC, nomCotizacion FROM nota_c WHERE (idCatCotizacion=5 OR idCatCotizacion=6) AND nomCotizacion like '%" . $q . "%' ORDER BY nomCotizacion;";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getTableNotasCredito()
    {
        $qry = "SELECT idNotaC,
                       nomCliente,
                       fechaNotaC,
                       facturaOrigen,
                       facturaDestino,
                       IF(motivo = 0, 'Devolución', 'Descuento no aplicado') motivo,
                       CONCAT('$', FORMAT(totalNotaC, 0)) totalNotaC
                FROM nota_c nc
                         LEFT JOIN clientes c on c.idCliente = nc.idCliente";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getTableNotasCreditoPorFecha($fechaIni, $fechaFin)
    {
        $qry = "SELECT idNotaC,
                       c.nitCliente,
                       c.nomCliente,
                       fechaNotaC,
                       CONCAT('$', FORMAT(subtotalNotaC, 0)) subtotalNotaC,
                       CONCAT('$', FORMAT(totalNotaC, 0)) totalNotaC,
                       CONCAT('$', FORMAT(ivaNotaC, 0)) ivaNotaC,
                       CONCAT('$', FORMAT(retFteNotaC, 0)) retFteNotaC,
                       CONCAT('$', FORMAT(retIcaNotaC, 0)) retIcaNotaC,
                       CONCAT('$', FORMAT(retIvaNotaC, 0)) retIvaNotaC,
                       facturaOrigen,
                       facturaDestino,
                       IF(motivo = 0, 'Devolución', 'Descuento no aplicado') razon
                FROM nota_c nc
                LEFT JOIN clientes c on c.idCliente = nc.idCliente
                WHERE fechaNotaC >= ?
                  AND fechaNotaC <= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($fechaIni, $fechaFin));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getTableNotasCreditoCliente($idCliente)
    {
        $qry = "SELECT idNotaC,
                       fechaNotaC,
                       fechaEntrega,
                       tp.tipoPrecio,
                       nomCliente,
                       IF(p.estado='A', 'Anulado', IF(p.estado='F', 'NotaCdo', IF(p.estado='P','Pendiente', 'Por nota_cr'))) estadoNotaC,
                       nomSucursal,
                       dirSucursal
                FROM nota_c p
                         LEFT JOIN clientes c on c.idCliente = p.idCliente
                         LEFT JOIN clientes_sucursal cs on p.idCliente = cs.idCliente AND p.idSucursal = cs.idSucursal
                         LEFT JOIN tip_precio tp ON p.tipoPrecio = tp.idPrecio
                 WHERE p.estado='A'
                 ";

        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getTableNotasCreditoPendientes($idCliente)
    {
        $qry = "SELECT idNotaC,
                       fechaNotaC,
                       fechaEntrega,
                       tp.tipoPrecio,
                       IF(p.estado='A', 'Anulado', IF(p.estado='F', 'NotaCdo', IF(p.estado='P','Pendiente', 'Por nota_cr'))) estadoNotaC,
                       nomSucursal,
                       dirSucursal
                FROM nota_c p
                         LEFT JOIN clientes c on c.idCliente = p.idCliente
                         LEFT JOIN clientes_sucursal cs on p.idCliente = cs.idCliente AND p.idSucursal = cs.idSucursal
                         LEFT JOIN tip_precio tp ON p.tipoPrecio = tp.idPrecio
                 WHERE c.idCliente=$idCliente";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getNotaC($idNotaC)
    {
        $qry = "SELECT idNotaC,
                       nc.idCliente,
                       nomCliente,
                       nitCliente,
                       dirCliente,
                       telCliente,
                       ciudad,
                       fechaNotaC,
                       facturaOrigen,
                       facturaDestino,
                       f.fechaFactura,
                       CONCAT('$', FORMAT(subtotalNotaC*descuentoFactOrigen, 0)) descuentoNotaC,
                       motivo,
                       IF(motivo = 0, 'Devolución', 'Descuento no aplicado') descMotivo,
                       ROUND(totalNotaC)                                     totalNotaC,
                       CONCAT('$', FORMAT(SUM(totalNotaC), 0))               totalNotaCrFormated,
                       ROUND(retFteNotaC)                                     retFteNotaC,
                       CONCAT('$', FORMAT(SUM(retFteNotaC), 0))               retFteNotaCrFormated,
                       ROUND(retIcaNotaC)                                     retIcaNotaC,
                       CONCAT('$', FORMAT(SUM(retIcaNotaC), 0))               retIcaNotaCrFormated,
                       ROUND(retIvaNotaC)                                     retIvaNotaC,
                       CONCAT('$', FORMAT(SUM(retIvaNotaC), 0))               retIvaNotaCrFormated,
                       CONCAT('$', FORMAT(SUM(subtotalNotaC), 0))            subtotalNotaC,
                       CONCAT('$', FORMAT(SUM(ivaNotaC), 0))                 ivaNotaC
                FROM nota_c nc
                         LEFT JOIN clientes c on c.idCliente = nc.idCliente
                         LEFT JOIN ciudades c2 on c.ciudadCliente = c2.idCiudad
                LEFT JOIN factura f on nc.facturaOrigen = f.idFactura
                WHERE idNotaC =?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idNotaC));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getNotaCForPrint($idNotaC)
    {
        $qry = "SELECT idNotaC,
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
                FROM nota_c c
                         LEFT JOIN clientes_cotiz cc on cc.idCliente = c.idCliente
                         LEFT JOIN personal p on p.idPersonal = cc.codVendedor
                         LEFT JOIN ciudades c2 on c2.idCiudad = cc.idCiudad
                         LEFT JOIN cargos_personal cp ON p.cargoPersonal = cp.idCargo
                         LEFT JOIN cat_clien cc2 on cc2.idCatClien = cc.idCatCliente
                WHERE idNotaC =?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idNotaC));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function updateTotalesNotaC($datos)
    {
        $qry = "UPDATE nota_c SET subtotalNotaC=?, totalNotaC=?, ivaNotaC=?, retFteNotaC=?, retIcaNotaC=?, retIvaNotaC=?
                 WHERE idNotaC=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function updateNotaC($datos)
    {
        $qry = "UPDATE nota_c SET fechaNotaC=?, facturaOrigen=?, facturaDestino=?, motivo=?, descuentoFactOrigen=?
                 WHERE idNotaC=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function updateFacturaDestNotaC($facturaDestino, $idNotaC)
    {
        $qry = "UPDATE nota_c SET facturaDestino=?
                 WHERE idNotaC=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($facturaDestino, $idNotaC));
    }

    public function anularNotaC($observaciones, $idNotaC)
    {
        $qry = "UPDATE nota_c SET estado='A', observaciones=?, total=0, subtotal=0, iva=0, descuento=0, 
                   retencionIva=0, retencionIca=0, retencionFte=0, totalR=0
                 WHERE idNotaC=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($observaciones, $idNotaC));
    }

    public function setDb()
    {

        $this->_pdo = Conectar::conexion(); //Almacenamos en _pdo la llamada la clase estática Conectar;

    }
}
