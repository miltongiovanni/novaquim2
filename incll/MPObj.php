<?
include "includes/valAcc.php";
?>
<?
include "includes/conect.php";
class mprim{
    function crearMP($bd,$cod_mp,$mprima, $cod_cat_mp, $min_stock, $tasa_iva)
	{
		
        $qry="insert into mprimas (Cod_mprima, Nom_mprima, Id_cat_mp, Min_stock_mp, Cod_iva)
        values ($cod_mp,'$mprima', $cod_cat_mp, $min_stock, $tasa_iva)";
        $link=conectarServidor();
        $result=mysql_db_query($bd,$qry);
        mysql_close($link);//Cerrar la conexion
		return $result;
    }
	function deleteMP($bd,$cod_mp)
	{
        $bd1=$bd;
		$link=conectarServidor();
		if($cod_mp>0)
		{
			$qry="delete from mprimas where Cod_mprima=$cod_mp";
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

	function updateMP($bd,$cod_mp,$mprima, $cod_cat_mp, $min_stock, $tasa_iva)	
	{
        $qry="update mprimas set Nom_mprima='$mprima', Id_cat_mp=$cod_cat_mp, Min_stock_mp=$min_stock, Cod_iva=$tasa_iva 
		where Cod_mprima=$cod_mp";
        $link=conectarServidor();
        $result=mysql_db_query($bd,$qry);
       	mysql_close($link);//Cerrar la conexion
		return $result;
	
    }
}
?>
