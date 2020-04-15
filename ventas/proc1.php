<?php
include "includes/conect.php";

$q=$_POST['q'];
$link=conectarServidor();
$sql="select nitProv, Nom_provee from proveedores where Nom_provee like '%".$q."%' order by Nom_provee";
$res=mysqli_query($link, $sql);

if(mysqli_num_rows($res)==0)
{
 echo '<b>No hay sugerencias</b>';
}
else
{
  echo'<br>';
  echo'<select name="idProv" id="idProv" class="form-control col-2">';
  //echo '<option selected value="">-----------------------------------------------------------------------------------</option>';
  while($fila=mysqli_fetch_array($res))
  {
    echo '<option value='.$fila['NIT_provee'].'>'.iconv("iso-8859-1", "UTF-8",$fila['Nom_provee']).'</option>';
  }
  echo'</select>';
}
?>


