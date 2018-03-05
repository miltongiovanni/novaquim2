<?
include "includes/valAcc.php";
?>
<?
include "includes/conect.php";
class ProdPre{
    function crearMed($bd,$cod_pres,$producto, $cod_produ, $cod_medida, $cod_envase, $cod_tapa, $cod_ante, $cod_etiq, $stock, $fabrica, $distribuidor, $detal, $mayor, $super, $cotiza)
	{
        $qry="insert into prodpre (Cod_prese, Nombre, Cod_produc, Cod_umedid, Cod_envase, Cod_tapa, Cod_ant, Cod_etiq, stock_prese, fabrica, distribuidor, detal, mayor, super, Cod_iva, Cotiza)
        values ($cod_pres,'$producto',$cod_produ, $cod_medida, $cod_envase, $cod_tapa, $cod_ante, $cod_etiq, $stock, $fabrica, $distribuidor, $detal, $mayor, $super, 3, $cotiza)";
        $link=conectarServidor();
        $result=mysql_db_query($bd,$qry);
        mysql_close($link);//Cerrar la conexion
		return $result;
    }
	function validarMed($bd,$cod_pres, &$valida)
	{
		
        $qry="select * from prodpre where Cod_prese=$cod_pres";
        $link=conectarServidor();
        $result=mysql_db_query($bd,$qry);
		$row=mysql_fetch_array($result);
		if ($row['Cod_prese']>0)
			$valida=1;
        mysql_close($link);
		return $result;
		
    }
	function deleteMed($bd,$cod_pres)
	{
        $bd1=$bd;
		$link=conectarServidor();
		if($cod_pres>0)
		{
			$qry="delete from prodpre where Cod_prese=$cod_pres";
			$result=mysql_db_query($bd1,$qry);
			mysql_close($link);//Cerrar la conexion
			if($result==1)
				return 1;
			else
				return 0;
		}
		else{
			return 0;
		}
      }	

	function updateMed($bd,$cod_pres,$producto, $cod_produ, $cod_medida, $cod_envase, $cod_tapa, $cod_ante, $cod_etiq, $stock, $fabrica, $distribuidor, $detal, $mayor, $super, $cod_iva, $Cotiza)	
	{
        $qry="update prodpre set 
		Nombre='$producto', 
		Cod_produc=$cod_produ, 
		Cod_umedid=$cod_medida, 
		Cod_envase=$cod_envase, 
		Cod_tapa=$cod_tapa, 
		Cod_ant=$cod_ante,
		Cod_etiq=$cod_etiq,
		stock_prese=$stock,
		fabrica=$fabrica, 
		distribuidor=$distribuidor, 
		detal=$detal, 
		mayor=$mayor, 
		super=$super,
		Cotiza=$Cotiza,
		Cod_iva=$cod_iva  
		where Cod_prese=$cod_pres";
        $link=conectarServidor();
        $result=mysql_db_query($bd,$qry);
       	mysql_close($link);//Cerrar la conexion
		return $result;
	
    }
}
?>
