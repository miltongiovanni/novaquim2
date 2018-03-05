<?
include "includes/valAcc.php";

?>
<?
include "includes/conect.php";
class codi{
    function crearCod($bd, $cod_ant, $producto, $fabrica, $distribuidor, $detal, $mayor, $super)
	{
        $qry="insert into precios (codigo_ant, producto, fabrica, distribuidor, detal, mayor, super)
        values ($cod_ant, '$producto', $fabrica, $distribuidor, $detal, $mayor, $super)";
		echo $qry;
        $link=conectarServidor();
        $result=mysql_db_query($bd,$qry);
        mysql_close($link);//Cerrar la conexion
		return $result;
    }
	function deleteCod($bd,$cod_ant)
	{
        $bd1=$bd;
		$link=conectarServidor();
		if($cod_ant>0)
		{
			$qry="delete from precios where codigo_ant=$cod_ant";
			echo $qry;
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

	function updateCod($bd, $cod_ant, $producto, $fabrica, $distribuidor, $detal, $mayor, $super)	
	{
        $qry="update precios set producto='$producto', fabrica=$fabrica, distribuidor=$distribuidor, detal=$detal, mayor=$mayor, super=$super where codigo_ant=$cod_ant";
        $link=conectarServidor();
        $result=mysql_db_query($bd,$qry);
       	mysql_close($link);//Cerrar la conexion
		return $result;
	
    }
}
?>
