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


    public function getProdTerminadosByIdPedido($idPedido)
    {
        $qry = "SELECT t.codPresentacion, t.presentacion
                FROM (SELECT pp.codPresentacion, pp.presentacion
                      FROM prodpre pp
                      WHERE presentacionActiva = 1) t
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
                      WHERE activo =1) t
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


    public function getTablePedidos($estado, $limit, $order, $where, $bindings)
    {
        $andWhere = '';
        if($estado == 6){
            $andWhere = $where=='' ? " WHERE estado=6 " : " AND estado=6 ";
        }elseif ($estado == 1){
            $andWhere = $where=='' ? " WHERE estado=1 OR estado=2 " : " AND estado=1 OR estado=2 ";
        }
        $qry = "select * from (SELECT idPedido,
                       fechaPedido,
                       fechaEntrega,
                       tp.tipoPrecio,
                       nomCliente,
                       estado,
                       ep.descEstado estadoPedido,
                       nomSucursal,
                       dirSucursal
                FROM pedido p
                         LEFT JOIN clientes c on c.idCliente = p.idCliente
                         LEFT JOIN clientes_sucursal cs on p.idCliente = cs.idCliente AND p.idSucursal = cs.idSucursal
                         LEFT JOIN tip_precio tp ON p.tipoPrecio = tp.idPrecio
                         LEFT JOIN estados_pedidos ep on p.estado = ep.idEstado) pccte
                $where
                $andWhere
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

    public function getTotalTablePedidos($estado, $where, $bindings)
    {
        $andWhere = '';
        if($estado == 6){
            $andWhere = $where=='' ? " WHERE estado=6 " : " AND estado=6 ";
        }elseif ($estado == 1){
            $andWhere = $where=='' ? " WHERE estado=1 OR estado=2 " : " AND estado=1 OR estado=2 ";
        }
        $qry = "select COUNT(idPedido) c from (SELECT idPedido,
                       fechaPedido,
                       fechaEntrega,
                       tp.tipoPrecio,
                       nomCliente,
                       estado,
                       ep.descEstado estadoPedido,
                       nomSucursal,
                       dirSucursal
                FROM pedido p
                         LEFT JOIN clientes c on c.idCliente = p.idCliente
                         LEFT JOIN clientes_sucursal cs on p.idCliente = cs.idCliente AND p.idSucursal = cs.idSucursal
                         LEFT JOIN tip_precio tp ON p.tipoPrecio = tp.idPrecio
                         LEFT JOIN estados_pedidos ep on p.estado = ep.idEstado) pccte
                $where
                $andWhere
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

    public function getTablePedidosCliente($idCliente)
    {
        $qry = "SELECT idPedido,
                       fechaPedido,
                       fechaEntrega,
                       tp.tipoPrecio,
                       nomCliente,
                       ep.descEstado estadoPedido,
                       nomSucursal,
                       dirSucursal
                FROM pedido p
                         LEFT JOIN clientes c on c.idCliente = p.idCliente
                         LEFT JOIN clientes_sucursal cs on p.idCliente = cs.idCliente AND p.idSucursal = cs.idSucursal
                         LEFT JOIN tip_precio tp ON p.tipoPrecio = tp.idPrecio
                         LEFT JOIN estados_pedidos ep on p.estado = ep.idEstado
                 WHERE c.idCliente=$idCliente
                 ";

        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getPedidosPorFacturarCliente($idCliente)
    {
        $qry = "SELECT p.idPedido, nomSucursal
                 FROM pedido p
                          LEFT JOIN clientes c on c.idCliente = p.idCliente
                          LEFT JOIN clientes_sucursal cs on c.idCliente = cs.idCliente AND cs.idSucursal = p.idSucursal
                          LEFT JOIN ciudades c2 on c2.idCiudad = c.ciudadCliente
                          LEFT JOIN factura_pedido fp on fp.pedidoId = p.idPedido
                 WHERE p.idCliente = $idCliente  AND p.estaFacturado =0 
                   AND (p.estado = 3 OR ((p.estado = 5 OR p.estado = 7) AND fp.facturaId IS NULL)) ORDER BY p.idPedido DESC";

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
                       ep.descEstado estadoPedido,
                       nomSucursal,
                       dirSucursal
                FROM pedido p
                         LEFT JOIN clientes c on c.idCliente = p.idCliente
                         LEFT JOIN clientes_sucursal cs on p.idCliente = cs.idCliente AND p.idSucursal = cs.idSucursal
                         LEFT JOIN tip_precio tp ON p.tipoPrecio = tp.idPrecio
                         LEFT JOIN estados_pedidos ep on p.estado = ep.idEstado
                 WHERE p.estado=1 ORDER BY idPedido";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public function getPedidosPorEntregarRutero()
    {
        $qry = "SELECT DISTINCT p.idPedido,
                        fp.facturaId idFactura,
                        r.idRemision,
                        fechaPedido,
                        fechaEntrega,
                        nomCliente,
                        nomSucursal,
                        dirSucursal
                 FROM pedido p
                          LEFT JOIN clientes c on c.idCliente = p.idCliente
                          LEFT JOIN clientes_sucursal cs on p.idCliente = cs.idCliente AND p.idSucursal = cs.idSucursal
                          LEFT JOIN estados_pedidos ep on p.estado = ep.idEstado
                          LEFT JOIN factura_pedido fp on fp.pedidoId = p.idPedido
                          LEFT JOIN remision r on p.idPedido = r.idPedido
                 WHERE (p.estado = 3 OR p.estado = 4)
                 ORDER BY idPedido";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public function getPedidosPorEntregar()
    {
        $qry = "SELECT p.idPedido,
                       f.idFactura,
                       r.idRemision,
                       fechaPedido,
                       fechaEntrega,
                       nomCliente,
                       nomSucursal,
                       dirSucursal
                FROM pedido p
                         LEFT JOIN clientes c on c.idCliente = p.idCliente
                         LEFT JOIN clientes_sucursal cs on p.idCliente = cs.idCliente AND p.idSucursal = cs.idSucursal
                         LEFT JOIN estados_pedidos ep on p.estado = ep.idEstado
                         LEFT JOIN factura f on f.idPedido LIKE CONCAT('%', p.idPedido, '%')
                         LEFT JOIN remision r on p.idPedido = r.idPedido
                WHERE (p.estado = 4)
                ORDER BY idPedido";
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
                       ep.descEstado estadoPedido,
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
                         LEFT JOIN estados_pedidos ep on p.estado = ep.idEstado
                WHERE idPedido =$idPedido";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getPedidoRutero($idPedido)
    {
        $qry = "SELECT p.idPedido,
                       nomCliente,
                       fechaPedido,
                       p.idSucursal,
                       nomSucursal,
                       dirSucursal,
                       codVendedor,
                       fp.facturaId idFactura,
                       r.idRemision
                FROM pedido p
                         LEFT JOIN clientes c on c.idCliente = p.idCliente
                         LEFT JOIN clientes_sucursal cs on p.idCliente = cs.idCliente AND p.idSucursal = cs.idSucursal
                         LEFT JOIN factura_pedido fp on fp.pedidoId = p.idPedido
                         LEFT JOIN remision r on p.idPedido = r.idPedido
                WHERE p.idPedido = $idPedido";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
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

    public function updateEstadoPedidoFacturado($estado, $idPedido)
    {
        $qry = "UPDATE pedido SET estado=?, estaFacturado=1
                 WHERE idPedido=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($estado, $idPedido));
    }

    public function updateEntregaPedido($fechaEntrega, $idPedido)
    {
        $qry = "UPDATE pedido SET estado=5, fechaEntrega =?
                 WHERE idPedido=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($fechaEntrega, $idPedido));
    }

    public function setDb()
    {

        $this->_pdo = Conectar::conexion(); //Almacenamos en _pdo la llamada la clase estática Conectar;

    }
}
