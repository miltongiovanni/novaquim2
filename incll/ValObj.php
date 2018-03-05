<?
include "includes/valAcc.php";
?>
<?
include "includes/conect.php";
class valv{
    function crearVal($bd,$cod_val,$nom_val, $min_stock)
	{
		
        $qry="insert into tapas_val (Cod_tapa, Nom_tapa, stock_tapa) values ($cod_val,'$nom_val', $min_stock)";
        $link=conectarServidor();
        $result=mysql_db_query($bd,$qry);
        mysql_close($link);//Cerrar la conexion
		return $result;
    }
	function deleteVal($bd,$cod_val)
	{
        $bd1=$bd;
		$link=conectarServidor();
		if($cod_val>0)
		{
			$qry="delete from tapas_val where Cod_tapa=$cod_val";
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

	function updateVal($bd,$cod_val,$nom_val, $min_stock)	
	{
        $qry="update tapas_val set Nom_tapa='$nom_val', stock_tapa=$min_stock where Cod_tapa=$cod_val";
        $link=conectarServidor();
        $result=mysql_db_query($bd,$qry);
       	mysql_close($link);//Cerrar la conexion
		return $result;
	
    }
}
?>
