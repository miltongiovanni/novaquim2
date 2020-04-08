<?php
include "includes/valAcc.php";
?>
<?php
	echo '<form method="post" action="listarClien.php" name="form3">';
	echo'<input name="Estado" type="hidden" value="A">';
	//echo '<input type="submit" name="Submit" value="Analizar" >'; 
	echo '</form>';
	echo'<script >
		document.form3.submit();
		</script>';	
?>
