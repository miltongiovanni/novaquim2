<?php

class PedidosOperaciones
{
    private $_pdo; // Instance de PDO.

    public function __construct()
    {
        $this->setDb();
    }

    public function makePedido($datos)
    {
        /*Preparo la insercion */
        $qry = "INSERT INTO pedido (idCliente, fechaPedido, fechaEntrega, tipoPrecio, estado, idSucursal, idUsuario) VALUES(?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
        return $this->_pdo->lastInsertId();
    }

    public function deletePedido($idPedido)
    {
        $qry = "DELETE FROM pedido WHERE idPedido= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idPedido));
    }


    public function isValidIdPedido($idPedido)
    {
        $qry = "SELECT * FROM pedido WHERE idPedido=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idPedido));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if($result==false){
            return false;
        }
        else{
            return true;
        }
    }

    public function getCotizacionsByTipo($tipoCompra)
    {
        $qry = "SELECT idPedido, nomCotizacion FROM pedido WHERE idCatCotizacion = $tipoCompra ORDER BY nomCotizacion;";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array());
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getPedidosByEstado($estado)
    {
        $qry = "SELECT idPedido, c.nomCliente, cs.nomSucursal FROM pedido p
                LEFT JOIN clientes c on c.idCliente = p.idCliente
                LEFT JOIN clientes_sucursal cs on c.idCliente = cs.idCliente AND p.idSucursal=cs.idSucursal
                WHERE estado=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($estado));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getCotizacionsByName($q)
    {
        $qry = "SELECT idPedido, nomCotizacion FROM pedido WHERE nomCotizacion like '%" . $q . "%' ORDER BY nomCotizacion;";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array());
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
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

    public function getProductosDistPedido($distribucion)
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

    public function getProdTerminadosByIdPedido($idPedido)
    {
        $qry = "SELECT t.codPresentacion, t.presentacion
                FROM (SELECT pp.codPresentacion, pp.presentacion
                      FROM prodpre pp
                      WHERE cotiza = 1
                        AND presentacionActiva = 1) t
                         LEFT JOIN (SELECT codProducto FROM det_pedido WHERE idPedido = ?) dr1
                                   ON dr1.codProducto = t.codPresentacion
                WHERE dr1.codProducto IS NULL
                ORDER BY t.presentacion";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idPedido));
        $result = $stmt->fetchall(PDO::FETCH_ASSOC);
        return $result;
    }


    public function getProdDistribucionByIdPedido($idPedido)
    {
        $qry = "SELECT idDistribucion, producto
                FROM (SELECT d.idDistribucion, d.producto
                      FROM distribucion d
                      WHERE cotiza = 1 AND activo =1) t
                         LEFT JOIN (SELECT codProducto FROM det_pedido WHERE idPedido = ?) dr1
                                   ON dr1.codProducto = t.idDistribucion
                WHERE dr1.codProducto IS NULL
                ORDER BY producto";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idPedido));
        $result = $stmt->fetchall(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getServicioByIdPedido($idPedido)
    {
        $qry = "SELECT idServicio, desServicio
                FROM (SELECT idServicio, desServicio
                      FROM servicios s
                      WHERE activo =1) t
                         LEFT JOIN (SELECT codProducto FROM det_pedido WHERE idPedido = ?) dr1
                                   ON dr1.codProducto = t.idServicio
                WHERE dr1.codProducto IS NULL
                ORDER BY desServicio";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idPedido));
        $result = $stmt->fetchall(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getCotizacionesGastos($q)
    {
        $qry = "SELECT idPedido, nomCotizacion FROM pedido WHERE (idCatCotizacion=5 OR idCatCotizacion=6) AND nomCotizacion like '%" . $q . "%' ORDER BY nomCotizacion;";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getTablePedidos($estado)
    {
        $qry = "SELECT idPedido,
                       fechaPedido,
                       fechaEntrega,
                       tp.tipoPrecio,
                       nomCliente,
                       IF(p.estado='A', 'Anulado', IF(p.estado='F', 'Facturado', IF(p.estado='P','Pendiente', IF(p.estado='L','Por entregar', 'Por facturar')))) estadoPedido,
                       nomSucursal,
                       dirSucursal
                FROM pedido p
                         LEFT JOIN clientes c on c.idCliente = p.idCliente
                         LEFT JOIN clientes_sucursal cs on p.idCliente = cs.idCliente AND p.idSucursal = cs.idSucursal
                         LEFT JOIN tip_precio tp ON p.tipoPrecio = tp.idPrecio";
        if($estado == 'A'){
            $qry .= " WHERE p.estado='A'";
        }elseif ($estado == 'P'){
            $qry .= " WHERE p.estado='P' OR p.estado='L'";
        }else{
            $qry .= " WHERE( YEAR(now())-YEAR(fechaPedido))<=1";
        }
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getTablePedidosCliente($idCliente)
    {
        $qry = "SELECT idPedido,
                       fechaPedido,
                       fechaEntrega,
                       tp.tipoPrecio,
                       nomCliente,
                       IF(p.estado='A', 'Anulado', IF(p.estado='F', 'Facturado', IF(p.estado='P','Pendiente', IF(p.estado='L','Por entregar', 'Por facturar')))) estadoPedido,
                       nomSucursal,
                       dirSucursal
                FROM pedido p
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

    public function getPedidosPorFacturarCliente($idCliente)
    {
        $qry = "SELECT idPedido, nomSucursal
                FROM pedido p
                         LEFT JOIN clientes c on c.idCliente = p.idCliente
                         LEFT JOIN clientes_sucursal cs on c.idCliente = cs.idCliente AND cs.idSucursal=p.idSucursal
                         LEFT JOIN ciudades c2 on c2.idCiudad = c.ciudadCliente
                WHERE p.idCliente =$idCliente AND estado ='E'";

        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getSucursalClientePorPedido($idPedido)
    {
        $qry = "SELECT idPedido, nomSucursal
                FROM pedido p
                    LEFT JOIN clientes c on c.idCliente = p.idCliente
                    LEFT JOIN clientes_sucursal cs on c.idCliente = cs.idCliente and cs.idSucursal=p.idSucursal
                WHERE idPedido =$idPedido";

        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['idPedido']. ' - '. $result['nomSucursal'];
    }

    public function getRemisionPorPedido($idPedido)
    {
        $qry = "SELECT idRemision FROM remision WHERE idPedido=$idPedido";

        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['idRemision'];
    }

    public function getTablePedidosPendientes()
    {
        $qry = "SELECT idPedido,
                       fechaPedido,
                       fechaEntrega,
                       tp.tipoPrecio,
                       nomCliente,
                       IF(p.estado='A', 'Anulado', IF(p.estado='F', 'Facturado', IF(p.estado='P','Pendiente', IF(p.estado='L','Por entregar', 'Por facturar')))) estadoPedido,
                       nomSucursal,
                       dirSucursal
                FROM pedido p
                         LEFT JOIN clientes c on c.idCliente = p.idCliente
                         LEFT JOIN clientes_sucursal cs on p.idCliente = cs.idCliente AND p.idSucursal = cs.idSucursal
                         LEFT JOIN tip_precio tp ON p.tipoPrecio = tp.idPrecio
                 WHERE p.estado='P' ORDER BY idPedido";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public function getPedido($idPedido)
    {
        $qry = "SELECT idPedido,
                       p.idCliente,
                       nomCliente,
                       telCliente,
                       fechaPedido,
                       fechaEntrega,
                       p.tipoPrecio idPrecio,
                       tp.tipoPrecio,
                       p.estado,
                       IF(p.estado = 'A', 'Anulado',
                          IF(p.estado = 'F', 'Facturado', IF(p.estado = 'P', 'Pendiente', IF(p.estado='L','Por entregar', 'Por facturar')))) estadoPedido,
                       p.idSucursal,
                       nomSucursal,
                       dirSucursal,
                       codVendedor,
                       nomPersonal
                FROM pedido p
                         LEFT JOIN clientes c on c.idCliente = p.idCliente
                         LEFT JOIN clientes_sucursal cs on p.idCliente = cs.idCliente AND p.idSucursal = cs.idSucursal
                         LEFT JOIN tip_precio tp on tp.idPrecio = p.tipoPrecio
                         LEFT JOIN personal p2 on c.codVendedor = p2.idPersonal
                WHERE idPedido =$idPedido";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getPedidoForPrint($idPedido)
    {
        $qry = "SELECT idPedido,
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
                FROM pedido c
                         LEFT JOIN clientes_cotiz cc on cc.idCliente = c.idCliente
                         LEFT JOIN personal p on p.idPersonal = cc.codVendedor
                         LEFT JOIN ciudades c2 on c2.idCiudad = cc.idCiudad
                         LEFT JOIN cargos_personal cp ON p.cargoPersonal = cp.idCargo
                         LEFT JOIN cat_clien cc2 on cc2.idCatClien = cc.idCatCliente
                WHERE idPedido =?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idPedido));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function updatePedido($datos)
    {
        $qry = "UPDATE pedido SET idCliente=?, fechaPedido=?, fechaEntrega=?, tipoPrecio=?, estado=?, idSucursal=?
                 WHERE idPedido=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function updateEstadoPedido($estado, $idPedido)
    {
        $qry = "UPDATE pedido SET estado=?
                 WHERE idPedido=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($estado, $idPedido));
    }

    public function setDb()
    {

        $this->_pdo = Conectar::conexion(); //Almacenamos en _pdo la llamada la clase estática Conectar;

    }
}
