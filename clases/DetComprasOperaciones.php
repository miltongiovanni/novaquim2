<?php

class DetComprasOperaciones
{
    private $_pdo; // Instance de PDO.

    public function __construct()
    {
        $this->setDb();
    }

    public function makeDetCompra($tipoCompra, $datos)
    {
        /*Preparo la insercion */
        if($tipoCompra==1){
            $qry = "INSERT INTO det_compras (idCompra, codigo, cantidad, precio, lote)VALUES(?, ?, ?, ?, ?)";
        }
        else{
            $qry = "INSERT INTO det_compras (idCompra, codigo, cantidad, precio)VALUES(?, ?, ?, ?)";
        }
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
        return $this->_pdo->lastInsertId();
    }

    public function deleteDetCompra($datos)
    {
        $qry = "DELETE FROM det_compras WHERE idCompra= ? AND codigo=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function getTableDetCompras($idCompra, $tipoCompra)
    {
        switch (intval($tipoCompra)) {
            case 1:
                $qry = "SELECT idCompra, codigo, nomMPrima Producto, lote, cantidad, CONCAT('$', FORMAT(precio, 0)) precio,
                        CONCAT(format((tasaIva*100),0), ' %') iva
                        FROM det_compras
                        LEFT JOIN mprimas ON codigo=codMPrima
                        LEFT JOIN tasa_iva ti on mprimas.codIva = ti.idTasaIva
                        WHERE idCompra=$idCompra";
                break;
            case 2:
                $qry = "SELECT idCompra, codigo, nomEnvase Producto, lote, cantidad, CONCAT('$', FORMAT(precio, 0)) precio,
                        CONCAT(format((tasaIva*100),0), ' %') iva
                        FROM det_compras
                        LEFT JOIN envases ON codigo=codEnvase
                        LEFT JOIN tasa_iva ti on envases.codIva = ti.idTasaIva
                        WHERE idCompra=$idCompra AND codigo < 100
                        UNION
                        SELECT idCompra, codigo, tapa Producto, lote, cantidad, CONCAT('$', FORMAT(precio, 0)) precio,
                        CONCAT(format((tasaIva*100),0), ' %') iva
                        FROM det_compras
                        LEFT JOIN tapas_val ON codigo=codTapa
                        LEFT JOIN tasa_iva t on tapas_val.codIva = t.idTasaIva
                        WHERE idCompra=$idCompra AND codigo > 100";
                break;
            case 3:
                $qry = "SELECT idCompra, codigo, nomEtiqueta Producto, lote, cantidad, CONCAT('$', FORMAT(precio, 0)) precio,
                        CONCAT(format((tasaIva*100),0), ' %') iva
                        FROM det_compras
                        LEFT JOIN etiquetas ON codigo=codEtiqueta
                        LEFT JOIN tasa_iva ti on etiquetas.codIva = ti.idTasaIva
                        WHERE idCompra=$idCompra ;";
                break;
            case 5:
                $qry = "SELECT idCompra, codigo, producto Producto, lote, cantidad, CONCAT('$', FORMAT(precio, 0)) precio,
                        CONCAT(format((tasaIva*100),0), ' %') iva
                        FROM det_compras
                        LEFT JOIN distribucion ON codigo=idDistribucion
                        LEFT JOIN tasa_iva ti on distribucion.codIva = ti.idTasaIva
                        WHERE idCompra=$idCompra";
                break;
        }
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idCompra));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getDetCompra($idCompra, $tipoCompra, $codigo)
    {
        switch (intval($tipoCompra)) {
            case 1:
                $qry = "SELECT idCompra, codigo, nomMPrima Producto, lote, cantidad, precio
                        FROM det_compras
                        LEFT JOIN mprimas ON codigo=codMPrima
                        WHERE idCompra=$idCompra AND codigo=$codigo";
                break;
            case 2:
                if($codigo < 100){
                    $qry = "SELECT codigo, nomEnvase Producto, lote, cantidad, precio FROM det_compras
                        LEFT JOIN envases ON codigo=codEnvase
                        WHERE idCompra=$idCompra AND codigo < 100";
                }
                else{
                    $qry = "SELECT codigo, tapa Producto, lote, cantidad, precio FROM det_compras
                        LEFT JOIN tapas_val ON codigo=codTapa
                        WHERE idCompra=$idCompra AND codigo > 100";
                }

                break;
            case 3:
                $qry = "SELECT codigo, nomEtiqueta Producto, lote, cantidad, precio FROM det_compras
                        LEFT JOIN etiquetas ON codigo=codEtiqueta
                        WHERE idCompra=$idCompra ;";
                break;
            case 5:
                $qry = "SELECT codigo, producto Producto, lote, cantidad, precio FROM det_compras
                        LEFT JOIN distribucion ON codigo=idDistribucion
                        WHERE idCompra=$idCompra";
                break;
        }
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idCompra));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);;
        return $result;
    }

    public function getHistoricoComprasDistribucion($idCompra)
    {
        $qry = "SELECT fechComp, nomProv, CONCAT('$', FORMAT(precio*(1+tasaIva), 0)) precioConIva, CONCAT('$', FORMAT(precio, 0)) precioSinIva, FORMAT(cantidad, 0) cantidad  FROM det_compras dc
                LEFT JOIN compras c on dc.idCompra = c.idCompra
                LEFT JOIN proveedores pr ON c.idProv = pr.idProv
                LEFT JOIN distribucion d on dc.codigo = d.idDistribucion
                LEFT JOIN tasa_iva ti on d.codIva = ti.idTasaIva
                WHERE codigo=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idCompra));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function productoExiste($idCompra, $codigo)
    {
        $qry = "SELECT COUNT(*) c from det_compras where idCompra=? AND codigo=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idCompra, $codigo));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $productoExiste = $result['c']>0;
        return $productoExiste;
    }


    public function updateDetCompra($tipoCompra, $datos)
    {
        if($tipoCompra==1){
            $qry = "UPDATE det_compras SET cantidad=?, precio=?, lote=? WHERE idCompra=? AND codigo=?";
        }
        else{
            $qry = "UPDATE det_compras SET cantidad=?, precio=? WHERE idCompra=? AND codigo=?";
        }

        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function setDb()
    {

        $this->_pdo = Conectar::conexion(); //Almacenamos en _pdo la llamada la clase estática Conectar;

    }
}
