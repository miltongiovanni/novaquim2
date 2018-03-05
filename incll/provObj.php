<?
include "includes/valAcc.php";
?>

<?
include "includes/conect.php";
class Prover{        
    function makeProv($bd,$nit_prov,$nom_prov, $dir_prov, $nom_contac,$tel1, $fax_prov,$eml_prov,$cat_prov, $autoret)
	{
        $qry="insert into proveedores (NIT_provee, Nom_provee, Dir_provee, Nom_contac, Tel_provee, Fax_provee, Eml_provee, Id_cat_prov, ret_provee)
        values ('$nit_prov','$nom_prov','$dir_prov', '$nom_contac', $tel1, $fax_prov, '$eml_prov', $cat_prov, $autoret)";
		echo $qry;
        $link=conectarServidor();
        $result=mysql_db_query($bd,$qry);
		mysql_close($link);
        return $result;
    }
	function deleteProv($bd,$nit_prov)
	{
        $bd1=$bd;
		$link=conectarServidor();
		$qry="delete from proveedores where NIT_provee='$nit_prov'";
		$result=mysql_db_query($bd1,$qry);
		mysql_close($link);
		if($result==1)
			return 1;
		else
			return 0;
      }	

	function updateProv($bd, $nit_prov, $nom_prov, $dir_prov, $nom_contac, $tel1, $fax_prov, $eml_prov, $cat_prov, $autoret)	
	{
        $qry="update proveedores set 
		Nom_provee='$nom_prov',
		Dir_provee='$dir_prov',
		Nom_contac='$nom_contac',
		Tel_provee=$tel1,
		Fax_provee=$fax_prov,
		Eml_provee='$eml_prov',
		Id_cat_prov=$cat_prov,
		ret_provee=$autoret
      	where NIT_provee='$nit_prov'";
        $link=conectarServidor();
        $result=mysql_db_query($bd,$qry);
		mysql_close($link);
        return $result;
    }
}
?>
