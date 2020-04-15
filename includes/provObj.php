<?php
include "conect.php";
class Prover{        
    function makeProv($nit_prov,$nom_prov, $dir_prov, $nom_contac,$tel1, $fax_prov,$eml_prov,$cat_prov, $autoret, $Tasa_reteica, $regimen)
	{
        $qry="insert into proveedores (nitProv, Nom_provee, Dir_provee, Nom_contac, Tel_provee, Fax_provee, Eml_provee, Id_cat_prov, ret_provee, numtasa_rica, regimen_provee)
        values ('$nit_prov','$nom_prov','$dir_prov', '$nom_contac', $tel1, $fax_prov, '$eml_prov', $cat_prov, $autoret, $Tasa_reteica, $regimen)";
        $link=conectarServidor();
        $result=mysqli_query($link,$qry);
		mysqli_close($link);
        return $result;
    }
	function deleteProv($nit_prov)
	{
		$link=conectarServidor();
		$qry1="delete from det_proveedores where NIT_provee='$nit_prov'";
		$qry="delete from proveedores where nitProv='$nit_prov'";
		$result=mysqli_query($link,$qry1);
		$result=mysqli_query($link,$qry);
		mysqli_close($link);
		return $result;
      }	

	function updateProv($nit_prov, $nom_prov, $dir_prov, $nom_contac, $tel1, $fax_prov, $eml_prov, $cat_prov, $autoret, $Tasa_reteica, $regimen)	
	{
        $qry="update proveedores set 
		Nom_provee='$nom_prov',
		Dir_provee='$dir_prov',
		Nom_contac='$nom_contac',
		Tel_provee=$tel1,
		Fax_provee=$fax_prov,
		Eml_provee='$eml_prov',
		Id_cat_prov=$cat_prov,
		ret_provee=$autoret,
		regimen_provee=$regimen,
		numtasa_rica=$Tasa_reteica
      	where nitProv='$nit_prov'";
        $link=conectarServidor();
        $result=mysqli_query($link,$qry);
		mysqli_close($link);
        return $result;
    }
}
?>
