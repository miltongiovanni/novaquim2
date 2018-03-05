<?php
include "conect.php";
class cate{
    function crearCat($cod_cat,$categoria)
	{
        $qry="insert into cat_prod (Id_cat_prod, Des_cat_prod)
        values ($cod_cat,'$categoria')";
        $link=conectarServidor();
        $result=mysqli_query($link,$qry);
		return $result;
		mysqli_free_result($result);
		/* cerrar la conexión */
		mysqli_close($link);
    }

	function deleteCat($cod_cat)
	{
		$link=conectarServidor();
		if($cod_cat>0)
		{
			$qry="delete from cat_prod  where Id_cat_prod=$cod_cat";
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

	function updateCat($cod_cat,$categoria)	
	{
        $qry="update cat_prod set Des_cat_prod='$categoria' 
		where Id_cat_prod=$cod_cat";
        $link=conectarServidor();
        $result=mysqli_query($link,$qry);
		return $result;
		mysqli_free_result($result);
		/* cerrar la conexión */
		mysqli_close($link);
    }
}
?>
