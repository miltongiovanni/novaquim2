<?php
include "includes/conect.php";
//PROCEDIMIENTO PARA BLOQUEAR LA NOTA CRÉDITO
$q=$_POST['q'];
//echo "el valor de q es ".$q;
$valor=explode(",", $q);
$cod=$valor[0];
$not=$valor[1];
$link=conectarServidor(); 
$sql="select tabla.Producto, tabla.Can_producto from (select Cod_producto, Nombre as Producto, Can_producto, Nota from det_factura, prodpre, nota_c where Id_fact=Fac_orig and Cod_producto=Cod_prese and Nota=$not
union select Cod_producto, Producto, Can_producto, Nota from det_factura, distribucion, nota_c where Id_fact=Fac_orig and Cod_producto=Id_distribucion and Nota=$not) as tabla WHERE tabla.Cod_producto=$cod;";
$res=mysqli_query($link, $sql);
$fila=mysqli_fetch_array($res);
$can=$fila['Can_producto'];
if(mysqli_num_rows($res)==0)
{
  echo '<b>No hay sugerencias</b>';
}
else
{
  echo'<select name="cantidad" id="combo">';
  
  for ($i = 1; $i <= $can; $i++) 
  {
	echo '<option value='.$i.'>'.$i.'</option>';
  }
  echo'</select>';
}
?>

