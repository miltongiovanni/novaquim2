<?php
include "includes/conect.php";

$q=$_POST['q'];
$link=conectarServidor();
$sql="select nitCliente, nomCliente from clientes where nomCliente like '%".$q."%' order by nomCliente ";
$res=mysqli_query($link, $sql);

if(mysqli_num_rows($res)==0)
{
 echo '<b>No hay sugerencias</b>';
}
else
{
  echo'<br>';
  echo'<select name="cliente" id="combo">';
  //echo '<option selected value="">-----------------------------------------------------------------------------------</option>';
  while($fila=mysqli_fetch_array($res))
  {
    echo '<option value='.$fila['Nit_clien'].'>'.iconv("iso-8859-1", "UTF-8",$fila['Nom_clien']).'</option>';
  }
  echo'</select>';
}
?>


								