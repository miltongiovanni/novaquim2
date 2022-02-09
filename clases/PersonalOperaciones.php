<?php

class PersonalOperaciones
{
    private $_pdo; // Instance de PDO.

    public function __construct()
    {
        $this->setDb();
    }
    public function makePersonal($datos)
    {
        /*Preparo la insercion */
        $qry = "INSERT INTO personal VALUES(0, ?, ?, ?, ?, ?, ?,0,0)";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
        return $this->_pdo->lastInsertId();
    }
    public function deletePersonal($idPersonal)
    {
        $qry = "DELETE FROM personal WHERE idPersonal= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idPersonal));
    }

    public function getPersonal($actif)
    {
        if ($actif == true) {
            $qry = "SELECT idPersonal, nomPersonal, celPersonal, emlPersonal, ap.area, cargo, activoPersonal, areaPersonal, cargoPersonal, areaPersonal
                    FROM personal p
                       LEFT JOIN areas_personal ap on ap.idArea = p.areaPersonal
                       LEFT JOIN cargos_personal cp on cp.idCargo = p.cargoPersonal
                    WHERE  activoPersonal = 1
                    ORDER BY idPersonal";
        } else {
            $qry = "SELECT idPersonal, nomPersonal, celPersonal, emlPersonal, ap.area, cargo, activoPersonal, areaPersonal, cargoPersonal, areaPersonal
                    FROM personal p
                       LEFT JOIN areas_personal ap on ap.idArea = p.areaPersonal
                       LEFT JOIN cargos_personal cp on cp.idCargo = p.cargoPersonal
                    ORDER BY idPersonal";
        }

        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getVendedores()
    {
        $qry = "SELECT idPersonal,
                       nomPersonal vendedor
                FROM personal
                WHERE activoPersonal = 1 AND areaPersonal=3
                ORDER BY nomPersonal;";

        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }


    public function getTablePersonal()
    {
        $qry = "SELECT idPersonal, nomPersonal, celPersonal, emlPersonal, area, cargo
                FROM personal
                LEFT JOIN areas_personal ap on personal.areaPersonal = ap.idArea
                LEFT JOIN cargos_personal cp on personal.cargoPersonal = cp.idCargo
                wHERE activoPersonal=1 ORDER BY idPersonal";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getTableComisionVendedor($idVendedor, $fechaInicio, $fechaFin)
    {
        $qry = "SELECT f.idFactura,
               nomCliente,
               CONCAT(ROUND(descuento*100, 1), ' %') desct,
               CONCAT('$',FORMAT(subtotal, 0)) subtot,
               fechaCancelacion,
               CONCAT('$',FORMAT(IF(ventaEmpresa IS NULL, 0, ventaEmpresa), 0))                 vtaEmpresa,
               CONCAT('$',FORMAT(IF(comisionEmpresa IS NULL, 0, comisionEmpresa), 0 ))          comEmpresa,
               CONCAT('$',FORMAT(IF(ventaDistribucion IS NULL, 0, ventaDistribucion), 0))       vtaDistribucion,
               CONCAT('$',FORMAT(IF(comisionDistribucion IS NULL, 0, comisionDistribucion), 0)) comDistribucion,
               CONCAT('$',FORMAT(IF(comisionEmpresa IS NULL, 0, comisionEmpresa) +
                                 IF(comisionDistribucion IS NULL, 0, comisionDistribucion), 0)) comTotal
        FROM factura f
                 LEFT JOIN clientes c on c.idCliente = f.idCliente
                 LEFT JOIN personal p on p.idPersonal = c.codVendedor
                 LEFT JOIN (SELECT f.idFactura,
                                   SUM(cantProducto * precioProducto * (1 - descuento))                   as ventaEmpresa,
                                   SUM(cantProducto * precioProducto * (1 - descuento) * comNovaPersonal) as comisionEmpresa
                            FROM factura f
                                     LEFT JOIN det_factura df on f.idFactura = df.idFactura
                                     LEFT JOIN clientes c on c.idCliente = f.idCliente
                                     LEFT JOIN personal p on p.idPersonal = c.codVendedor
                            WHERE codVendedor = $idVendedor
                              AND fechaCancelacion >= '$fechaInicio'
                              AND fechaCancelacion <= '$fechaFin'
                              AND codProducto < 100000
                              AND codProducto > 10000
                            GROUP BY f.idFactura) t1 ON t1.idFactura = f.idFactura
                 LEFT JOIN (SELECT f.idFactura,
                                   SUM(cantProducto * precioProducto * (1 - descuento))                  as ventaDistribucion,
                                   SUM(cantProducto * precioProducto * (1 - descuento) * comDisPersonal) as comisionDistribucion
                            FROM factura f
                                     LEFT JOIN det_factura df on f.idFactura = df.idFactura
                                     LEFT JOIN clientes c on c.idCliente = f.idCliente
                                     LEFT JOIN personal p on p.idPersonal = c.codVendedor
                            WHERE codVendedor = $idVendedor
                              AND fechaCancelacion >= '$fechaInicio'
                              AND fechaCancelacion <= '$fechaFin'
                              AND codProducto > 100000
                            GROUP BY f.idFactura) t2 ON t2.idFactura = f.idFactura
        WHERE codVendedor = $idVendedor
          AND fechaCancelacion >= '$fechaInicio'
          AND fechaCancelacion <= '$fechaFin'";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public function getTotalComisionVendedor($idVendedor, $fechaInicio, $fechaFin)
    {
        $qry = "SELECT CONCAT('$', FORMAT(SUM(comisionEmpresa), 0))        comEmpresa,
                       CONCAT('$', FORMAT(SUM(comisionDistribucion), 0))   comDistribucion,
                       CONCAT('$', FORMAT((SUM(comisionEmpresa) +
                                           SUM(comisionDistribucion)), 0)) comTotal
                FROM factura f
                         LEFT JOIN clientes c on c.idCliente = f.idCliente
                         LEFT JOIN personal p on p.idPersonal = c.codVendedor
                         LEFT JOIN (SELECT f.idFactura,
                                           SUM(cantProducto * precioProducto * (1 - descuento))                   as ventaEmpresa,
                                           SUM(cantProducto * precioProducto * (1 - descuento) * comNovaPersonal) as comisionEmpresa
                                    FROM factura f
                                             LEFT JOIN det_factura df on f.idFactura = df.idFactura
                                             LEFT JOIN clientes c on c.idCliente = f.idCliente
                                             LEFT JOIN personal p on p.idPersonal = c.codVendedor
                                    WHERE codVendedor = $idVendedor
                                      AND fechaCancelacion >= '$fechaInicio'
                                      AND fechaCancelacion <= '$fechaFin'
                                      AND codProducto < 100000
                                      AND codProducto > 10000
                                    GROUP BY f.idFactura) t1 ON t1.idFactura = f.idFactura
                         LEFT JOIN (SELECT f.idFactura,
                                           SUM(cantProducto * precioProducto * (1 - descuento))                  as ventaDistribucion,
                                           SUM(cantProducto * precioProducto * (1 - descuento) * comDisPersonal) as comisionDistribucion
                                    FROM factura f
                                             LEFT JOIN det_factura df on f.idFactura = df.idFactura
                                             LEFT JOIN clientes c on c.idCliente = f.idCliente
                                             LEFT JOIN personal p on p.idPersonal = c.codVendedor
                                    WHERE codVendedor = $idVendedor
                                      AND fechaCancelacion >= '$fechaInicio'
                                      AND fechaCancelacion <= '$fechaFin'
                                      AND codProducto > 100000
                                    GROUP BY f.idFactura) t2 ON t2.idFactura = f.idFactura
                WHERE codVendedor = $idVendedor
                  AND fechaCancelacion >= '$fechaInicio'
                  AND fechaCancelacion <= '$fechaFin'";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getPersonalProd()
    {
        $qry = "SELECT idPersonal, nomPersonal 
        FROM personal
        wHERE (areaPersonal=5 or areaPersonal=2) and activoPersonal=1 ORDER BY idPersonal";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getPerson($idPersonal)
    {
        $qry = "SELECT idPersonal, nomPersonal, celPersonal, emlPersonal, areas_personal.area, cargo, activoPersonal, areaPersonal, cargoPersonal, estadoPersona 
        from personal, areas_personal, estados_pers, cargos_personal
        wHERE areaPersonal=idArea AND cargoPersonal=idCargo AND idEstado=activoPersonal AND idPersonal=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idPersonal));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function updatePersonal($datos)
    {
        $qry = "UPDATE personal SET nomPersonal=?, activoPersonal=?, areaPersonal=?, celPersonal=?, emlPersonal=?, cargoPersonal=? WHERE idPersonal=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function setDb()
    {

        $this->_pdo = Conectar::conexion(); //Almacenamos en _pdo la llamada la clase estática Conectar;

    }
}
