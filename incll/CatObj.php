<?
include "includes/valAcc.php";
?>
<?
include "includes/conect.php";
class cate{
    function crearCat($bd,$cod_cat,$categoria)
	{
        $qry="insert into cat_prod (Id_cat_prod, Des_cat_prod)
        values ($cod_cat,'$categoria')";
        $link=conectarServidor();
        $result=mysql_db_query($bd,$qry);
        mysql_close($link);//Cerrar la conexion
		return $result;
    }

	function deleteCat($bd,$cod_cat)
	{
        $bd1=$bd;
		$link=conectarServidor();
		if($cod_cat>0)
		{
			$qry="delete from cat_prod  where Id_cat_prod=$cod_cat";
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

	function updateCat($bd,$cod_cat,$categoria)	
	{
        $qry="update cat_prod set Des_cat_prod='$categoria' 
		where Id_cat_prod=$cod_cat";
        $link=conectarServidor();
        $result=mysql_db_query($bd,$qry);
       	mysql_close($link);//Cerrar la conexion
		return $result;
	
    }
}
?>
