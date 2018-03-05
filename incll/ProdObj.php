<?
include "includes/valAcc.php";

?>
<?
include "includes/conect.php";
class produ{
    function crearProd($bd,$cod_prod,$producto, $cod_cat, $cuenta)
	{
		
        $qry="insert into productos (Cod_produc, Nom_produc, Id_cat_prod, Cuenta_cont)
        values ($cod_prod,'$producto', $cod_cat, $cuenta)";
        $link=conectarServidor();
        $result=mysql_db_query($bd,$qry);
        mysql_close($link);//Cerrar la conexion
		return $result;
		
    }
	function validarProd($bd,$cod_prod, &$valida)
	{
		
        $qry="select * from productos where Cod_produc=$cod_prod";
        $link=conectarServidor();
        $result=mysql_db_query($bd,$qry);
		$row=mysql_fetch_array($result);
		if ($row['Cod_produc']>0)
			$valida=1;
        mysql_close($link);//Cerrar la conexion
		return $result;
		
    }

	function deleteProd($bd,$cod_prod)
	{
        $bd1=$bd;
		$link=conectarServidor();
		if($cod_prod>0)
		{
			$qry="delete from productos  where Cod_produc=$cod_prod";
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

	function updateProd($bd, $cod_prod, $producto, $cod_cat, $cuenta)	
	{
        $qry="update productos set Nom_produc='$producto', Id_cat_prod=$cod_cat, Cuenta_cont=$cuenta 
		where Cod_produc=$cod_prod";
        $link=conectarServidor();
        $result=mysql_db_query($bd,$qry);
       	mysql_close($link);//Cerrar la conexion
		return $result;
	
    }
}
?>
