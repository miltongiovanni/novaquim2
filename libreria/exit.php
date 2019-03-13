<?php
include "includes/valAcc.php";
session_destroy();
mover_pag("index.php","Gracias por utilizar El Sistema de Información de Industrias Novaquim S.A.S.");
function mover_pag($ruta,$nota){
echo'<script language="Javascript">
   alert("'.$nota.'")
   self.location="'.$ruta.'"
   </script>';
}
?>