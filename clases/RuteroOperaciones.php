<?php

class RuteroOperaciones
{
    private $_pdo; // Instance de PDO.

    public function __construct()
    {
        $this->setDb();
    }
    public function makeRutero($fechaRutero, $listaPedidos)
    {
        /*Preparo la insercion */
        $qry = "INSERT INTO rutero (fechaRutero, listaPedidos) VALUES(?, ?)";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($fechaRutero, $listaPedidos));
        return $this->_pdo->lastInsertId();
    }
    public function deleteRutero($idRutero)
    {
        $qry = "DELETE FROM rutero WHERE idRutero= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idRutero));
    }
    public function getListaPedidosRutero()
    {
        $qry = "SELECT p.idPedido,
                       fp.facturaId idFactura,
                       r.idRemision,
                       fechaPedido,
                       nomCliente,
                       nomSucursal,
                       idRutero,
                       fechaRutero
                FROM pedido p
                         LEFT JOIN clientes c on c.idCliente = p.idCliente
                         LEFT JOIN clientes_sucursal cs on p.idCliente = cs.idCliente AND p.idSucursal = cs.idSucursal
                         LEFT JOIN factura_pedido fp on fp.pedidoId = p.idPedido
                         LEFT JOIN remision r on p.idPedido = r.idPedido
                         LEFT JOIN rutero ru on ru.listaPedidos LIKE CONCAT('%', p.idPedido, '%')
                WHERE p.estado = 7 AND ru.idRutero IS NOT NULL";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getRutero($idRutero)
    {
        $qry = "SELECT idRutero, fechaRutero, listaPedidos FROM rutero WHERE idRutero = ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idRutero));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getLastRutero()
    {
        $qry = "SELECT MAX(idRutero) ultimo_rutero FROM rutero";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['ultimo_rutero'];
    }

    public function isValidIdRutero($idRutero)
    {
        $qry = "SELECT * FROM rutero WHERE idRutero=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idRutero));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if($result==false){
            return false;
        }
        else{
            return true;
        }
    }

    public function updateRutero($datos)
    {
        $qry = "UPDATE rutero SET listaPedidos=? WHERE idRutero=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function setDb()
    {

        $this->_pdo = Conectar::conexion(); //Almacenamos en _pdo la llamada la clase estática Conectar;

    }
}
