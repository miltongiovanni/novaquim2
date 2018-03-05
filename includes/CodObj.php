
<?php
include "conect.php";
class codi{
    function crearCod($cod_ant, $producto, $fabrica, $distribuidor, $detal, $mayor, $super)
	{
        $qry="insert into precios (codigo_ant, producto, fabrica, distribuidor, detal, mayor, super)
        values ($cod_ant, '$producto', $fabrica, $distribuidor, $detal, $mayor, $super)";
		//echo $qry;
        $link=conectarServidor();
        $result=mysqli_query($link,$qry);
		return $result;
		mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
    }
	function deleteCod($cod_ant)
	{
		$link=conectarServidor();
		if($cod_ant>0)
		{
			$qry="delete from precios where codigo_ant=$cod_ant";
			//echo $qry;
			$result=mysqli_query($link,$qry);
			if($result==1)
				return 1;
			else
				return 0;
		}
		else{
			return 0;
		}
/* cerrar la conexión */
mysqli_close($link);
      }	

	function updateCod($cod_ant, $producto, $fabrica, $distribuidor, $detal, $mayor, $super, $pres_activa, $pres_lista)	
	{
        $qry="update precios set producto='$producto', fabrica=$fabrica, distribuidor=$distribuidor, detal=$detal, mayor=$mayor, super=$super, pres_activa=$pres_activa, pres_lista=$pres_lista  where codigo_ant=$cod_ant";
        $link=conectarServidor();
        $result=mysqli_query($link, $qry);
		return $result;
mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
    }
}
?>
