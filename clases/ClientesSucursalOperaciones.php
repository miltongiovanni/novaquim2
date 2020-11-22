<?php

class ClientesSucursalOperaciones
{
    private $_pdo; // Instance de PDO.

    public function __construct()
    {
        $this->setDb();
    }

    public function makeClienteSucursal($datos)
    {
        /*Preparo la insercion */
        $qry = "INSERT INTO clientes_sucursal (idCliente, idSucursal, dirSucursal, ciudadSucursal, telSucursal, nomSucursal) VALUES(?, ?, ?,? ,? ,?)";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
        return $this->_pdo->lastInsertId();
    }

    public function deleteClienteSucursal($datos)
    {
        $qry = "DELETE FROM clientes_sucursal WHERE idCliente= ? AND idSucursal=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function deleteAllClientesSucursal($idCliente)
    {
        $qry = "DELETE FROM clientes_sucursal WHERE idCliente= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idCliente));
    }

    public function getSucursalesCliente($idCliente)
    {
        $qry = "SELECT idSucursal, nomSucursal
                FROM clientes_sucursal cs
                WHERE idCliente = ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idCliente));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getTableClienteSucursales($idCliente)
    {
        $qry = "SELECT idSucursal, nomSucursal, telSucursal,dirSucursal, ciudad, idCiudad
                FROM clientes_sucursal cs
                LEFT JOIN ciudades c on cs.ciudadSucursal = c.idCiudad
                WHERE idCliente = ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idCliente));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getSucursalCliente($idCliente, $idSucursal)
    {
        $qry = "SELECT idSucursal, nomSucursal, telSucursal,dirSucursal, ciudad, idCiudad
                FROM clientes_sucursal cs
                LEFT JOIN ciudades c on cs.ciudadSucursal = c.idCiudad
                WHERE idCliente = ? AND idSucursal = ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idCliente, $idSucursal));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getProdPorCategoria($idCliente, $idCatProv)
    {
        switch (intval($idCatProv)) {
            case 1:
                $qry = "SELECT codMPrima Codigo, nomMPrima Producto FROM mprimas
                        LEFT JOIN clientes_sucursal dp ON dp.Codigo=codMPrima AND dp.idCliente=? WHERE dp.Codigo IS NULL ORDER BY Producto";
                break;
            case 2:
                $qry = "SELECT codEnvase Codigo, nomEnvase Producto  FROM envases
                        LEFT JOIN clientes_sucursal ON Codigo=codEnvase AND idCliente=? WHERE Codigo IS NULL
                        UNION
                        SELECT codTapa Codigo, tapa Producto FROM tapas_val
                        LEFT JOIN clientes_sucursal ON Codigo=codTapa AND idCliente=? AND codTapa<>114 WHERE Codigo IS NULL ORDER BY Producto;
                        ";
                break;
            case 3:
                $qry = "SELECT codEtiqueta Codigo, nomEtiqueta Producto FROM etiquetas
                        LEFT JOIN clientes_sucursal ON Codigo=codEtiqueta and idCliente=? WHERE Codigo IS NULL ORDER BY Producto;";
                break;
            case 5:
                $qry = "SELECT idDistribucion Codigo, producto Producto FROM distribucion
                        LEFT JOIN clientes_sucursal ON Codigo=idDistribucion AND idCliente=? WHERE Codigo IS NULL order by Producto";
                break;
            case 6:
                $qry = "SELECT idDistribucion Codigo, producto Producto FROM distribucion
                        LEFT JOIN clientes_sucursal ON Codigo=idDistribucion AND idCliente=? WHERE Codigo IS NULL order by Producto";
                break;
        }

        $stmt = $this->_pdo->prepare($qry);

        $stmt->execute(array($idCliente));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getProdPorProveedor($idCliente, $idCatProv)
    {
        switch (intval($idCatProv)) {
            case 1:
                $qry = "SELECT codMPrima Codigo, nomMPrima Producto FROM clientes_sucursal
                        LEFT JOIN mprimas mp ON mp.codMPrima=Codigo
                        WHERE idCliente=$idCliente ORDER BY Producto";
                break;
            case 2:
                $qry = "SELECT codEnvase Codigo, nomEnvase Producto FROM clientes_sucursal
                        LEFT JOIN envases e ON e.codEnvase=Codigo
                        WHERE idCliente=$idCliente AND Codigo < 100
                        UNION
                        SELECT codTapa Codigo, tapa Producto FROM clientes_sucursal
                        LEFT JOIN tapas_val tv ON tv.codTapa=Codigo
                        WHERE idCliente=$idCliente AND Codigo > 100 ORDER BY Producto";
                break;
            case 3:
                $qry = "SELECT codEtiqueta Codigo, nomEtiqueta Producto FROM clientes_sucursal
                            LEFT JOIN etiquetas e ON e.codEtiqueta=Codigo
                        WHERE idCliente=$idCliente ORDER BY Producto";
                break;
            case 5:
                $qry = "SELECT idDistribucion Codigo, producto Producto FROM clientes_sucursal
                            LEFT JOIN distribucion d ON d.idDistribucion=Codigo
                        WHERE idCliente=$idCliente ORDER BY Producto;";
                break;
        }
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getClienteSucursal($idCliente)
    {
        $qry = "SELECT codProveedor, nomProveedor, catProd, clientes_sucursal.idCatProd, prodActivo, densMin, densMax, pHmin, pHmax, fragancia, color, apariencia
        FROM  clientes_sucursal
        LEFT JOIN cat_prod cp on clientes_sucursal.idCatProd = cp.idCatProd
        WHERE codProveedor=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($codProveedor));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getMaxSucursalByIdCliente($idCliente)
    {
        $qry = "SELECT MAX(idSucursal) AS id FROM clientes_sucursal WHERE idCliente=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idCliente));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['id'];
    }


    public function updateClienteSucursal($datos)
    {
        $qry = "UPDATE clientes_sucursal SET dirSucursal=?, ciudadSucursal=?, telSucursal=?, nomSucursal=? WHERE idCliente=? AND idSucursal=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function setDb()
    {

        $this->_pdo = Conectar::conexion(); //Almacenamos en _pdo la llamada la clase estática Conectar;

    }
}
