<?php
//$err=error_reporting(16);
session_start();
define("BASE_C", "860000");
define("FECHA_C", "2017-01-01");
date_default_timezone_set('AMERICA/Bogota');
if($_SESSION['Autorizado']!=1)
  	 {
     echo'<script language="Javascript">
     alert("Acceso no autorizado, verifique sus datos de acceso")
     self.location="../novaquim/index.php"
     </script>';
	}
?>