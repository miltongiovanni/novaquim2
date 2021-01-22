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
        $qry = "INSERT INTO factura (idFactura, idPedido, idCliente, fechaFactura, fechaVenc, tipPrecio, estado, idRemision, ordenCompra, descuento, observaciones) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
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
        if($result==false){
            return false;
        }
        else{
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
        $qry = "SELECT idFactura, SUM(subtotal) subtotalfactura, SUM(iva10) iva10factura, SUM(iva19) iva19factura
                FROM
                    (SELECT dp.idFactura, cantProducto, precioProducto,
                            cantProducto*precioProducto subtotal, IF(idTasaIvaProducto=5 OR idTasaIvaProducto=2, cantProducto*precioProducto*tasaIva,0  ) iva10,
                            IF(idTasaIvaProducto=3 OR idTasaIvaProducto=7, cantProducto*precioProducto*tasaIva,0 ) iva19
                     FROM det_factura dp
                              LEFT JOIN factura f on f.idFactura = dp.idFactura
                              LEFT JOIN prodpre p on dp.codProducto = p.codPresentacion
                              LEFT JOIN tasa_iva ti on ti.idTasaIva = dp.idTasaIvaProducto
                     WHERE dp.idFactura = $idFactura
                       AND dp.codProducto > 10000
                       AND dp.codProducto < 100000
                     UNION
                     SELECT dp.idFactura, cantProducto, precioProducto,
                            cantProducto*precioProducto subtotal, IF(idTasaIvaProducto=5 OR idTasaIvaProducto=2, cantProducto*precioProducto*tasaIva,0  ) iva10,
                            IF(idTasaIvaProducto=3 OR idTasaIvaProducto=7, cantProducto*precioProducto*tasaIva,0 ) iva19
                     FROM det_factura dp
                              LEFT JOIN factura f on f.idFactura = dp.idFactura
                              LEFT JOIN distribucion d on dp.codProducto = d.idDistribucion
                              LEFT JOIN tasa_iva ti on ti.idTasaIva = dp.idTasaIvaProducto
                     WHERE dp.idFactura = $idFactura
                       AND dp.codProducto > 100000
                     UNION
                     SELECT dp.idFactura, cantProducto, precioProducto,
                            cantProducto*precioProducto subtotal, IF(idTasaIvaProducto=5 OR idTasaIvaProducto=2, cantProducto*precioProducto*tasaIva,0  ) iva10,
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

    public function getCotizacionesGastos($q)
    {
        $qry = "SELECT idFactura, nomCotizacion FROM factura WHERE (idCatCotizacion=5 OR idCatCotizacion=6) AND nomCotizacion like '%" . $q . "%' ORDER BY nomCotizacion;";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getTableFacturas()
    {
        $qry = "SELECT idFactura,
                       idPedido,
                       idRemision,
                       nomCliente,
                       fechaFactura,
                       fechaVenc,
                       tp.tipoPrecio,
                       IF(f.estado='A', 'Anulada', IF(f.estado='C', 'Cancelada', 'Pendiente')) estadoFactura,
                       CONCAT('$', FORMAT(total, 0)) totalFactura
                FROM factura f
                         LEFT JOIN clientes c on c.idCliente = f.idCliente
                         LEFT JOIN tip_precio tp ON f.tipPrecio = tp.idPrecio
                WHERE( YEAR(now())-YEAR(fechaFactura))<=1";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getTableFacturasCliente($idCliente)
    {
        $qry = "SELECT idFactura,
                       idPedido,
                       idRemision,
                       nomCliente,
                       fechaFactura,
                       fechaVenc,
                       tp.tipoPrecio,
                       IF(f.estado='A', 'Anulada', IF(f.estado='C', 'Cancelada', 'Pendiente')) estadoFactura,
                       CONCAT('$', FORMAT(total, 0)) totalFactura
                FROM factura f
                         LEFT JOIN clientes c on c.idCliente = f.idCliente
                         LEFT JOIN tip_precio tp ON f.tipPrecio = tp.idPrecio
                WHERE f.idCliente=$idCliente";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getFacturasClienteForNotas($idCliente)
    {
        $qry = "SELECT idFactura FROM factura f WHERE f.idCliente=? AND (f.estado!='A' AND f.estado!='C') ORDER BY idFactura DESC";
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
                   idPedido,
                   f.idCliente,
                   nitCliente,
                   descuento,
                   fechaFactura,
                   fechaVenc,
                   idRemision,
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
                   IF(f.estado = 'A', 'Anulada',
                      IF(f.estado = 'P', 'Pendiente', IF(f.estado = 'C', 'Cancelada', 'En proceso'))) estadoFactura
            
            FROM factura f
                     LEFT JOIN clientes c on c.idCliente = f.idCliente
                     LEFT JOIN personal p on p.idPersonal = c.codVendedor
                     LEFT JOIN ciudades c2 on c2.idCiudad = c.ciudadCliente
            WHERE idFactura = ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idFactura));
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
