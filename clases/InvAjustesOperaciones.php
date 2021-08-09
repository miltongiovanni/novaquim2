<?php

class InvAjustesOperaciones
{
    private $_pdo; // Instance de PDO.

    public function __construct()
    {
        $this->setDb();
    }

    public function makeInvAjuste($datos)
    {
        /*Preparo la insercion */
        $qry = "INSERT INTO inv_ajustes (tipo_inv, fecha_ajuste, idResponsable, motivo_ajuste, inv_ant, inv_nvo, codigo, lote) VALUES(?, NOW(), ?, ?, ?, ?, ?, ?)";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
        return $this->_pdo->lastInsertId();
    }

    public function getTableInvAjuste()
    {
        $qry = "SELECT idAjustes, 'Materia Prima' tipo, fecha_ajuste, nomPersonal, motivo_ajuste, lote, nomMPrima item, inv_nvo, inv_ant
                FROM inv_ajustes ia
                    LEFT JOIN mprimas mp ON ia.codigo=mp.codMPrima
                    LEFT JOIN personal p on ia.idResponsable = p.idPersonal
                WHERE tipo_inv='mp'
                UNION
                SELECT idAjustes, 'Prod Terminado' tipo, fecha_ajuste, nomPersonal, motivo_ajuste, lote, presentacion item, inv_nvo, inv_ant
                FROM inv_ajustes ia
                    LEFT JOIN prodpre pt ON ia.codigo=pt.codPresentacion
                    LEFT JOIN personal p on ia.idResponsable = p.idPersonal
                WHERE tipo_inv='prod'
                UNION
                SELECT idAjustes, 'Prod Distribución' tipo, fecha_ajuste, nomPersonal, motivo_ajuste, 'N.A.' lote, producto item, inv_nvo, inv_ant
                FROM inv_ajustes ia
                    LEFT JOIN distribucion d ON ia.codigo=d.idDistribucion
                    LEFT JOIN personal p on ia.idResponsable = p.idPersonal
                WHERE tipo_inv='dist'
                UNION
                SELECT idAjustes, 'Envase' tipo, fecha_ajuste, nomPersonal, motivo_ajuste, 'N.A.' lote, nomEnvase item, inv_nvo, inv_ant
                FROM inv_ajustes ia
                    LEFT JOIN envases e ON ia.codigo=e.codEnvase
                    LEFT JOIN personal p on ia.idResponsable = p.idPersonal
                WHERE tipo_inv='env'
                UNION
                SELECT idAjustes, 'Tapas / Válvulas' tipo, fecha_ajuste, nomPersonal, motivo_ajuste, 'N.A.' lote, tapa item, inv_nvo, inv_ant
                FROM inv_ajustes ia
                    LEFT JOIN tapas_val tp ON ia.codigo=tp.codTapa
                    LEFT JOIN personal p on ia.idResponsable = p.idPersonal
                WHERE tipo_inv='tap'
                UNION
                SELECT idAjustes, 'Etiquetas' tipo, fecha_ajuste, nomPersonal, motivo_ajuste, 'N.A.' lote, nomEtiqueta item, inv_nvo, inv_ant
                FROM inv_ajustes ia
                    LEFT JOIN etiquetas et ON ia.codigo=et.codEtiqueta
                    LEFT JOIN personal p on ia.idResponsable = p.idPersonal
                WHERE tipo_inv='etq'";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }


    public function setDb()
    {

        $this->_pdo = Conectar::conexion(); //Almacenamos en _pdo la llamada la clase estática Conectar;

    }
}
