<?php
//$err=error_reporting(16);
session_start();
define("BASE_C", "703000");
if($_SESSION['Autorizado']!=1)
  	 {
     echo'<script language="Javascript">
     alert("Acceso no autorizado, verifique sus datos de acceso")
     self.location="../novaquim/index.php"
     </script>';
	}
?>