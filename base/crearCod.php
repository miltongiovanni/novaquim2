<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
	<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
	<title>Creaci&oacute;n de C&oacute;digo Gen&eacute;rico</title>
	<meta charset="utf-8">
	<script type="text/javascript" src="scripts/validar.js"></script>
	<script type="text/javascript" src="scripts/block.js"></script>	
    	<script type="text/javascript">
	document.onkeypress = stopRKey; 
	</script>

</head>
<body>
<div id="contenedor">
<div id="saludo"><strong>CREACI&Oacute;N DE C&Oacute;DIGO GEN&Eacute;RICO</strong></div>
<form name="form2" method="POST" action="crearCod2.php">
<table  align="center" border="0" class="table2" width="50%" cellspacing="0">
 <tr> 
    <td>&nbsp; </td>
    </tr>
	<tr> 
        <td><div align="right"><b>Producto</b></div></td>
        <td width="57%">
        <select name="Prod" id="combo">
		<?php
            include "includes/conect.php";
            $link=conectarServidor();
            $qry="select Cod_produc, Nom_produc, Id_cat_prod from productos where prod_activo=0 order by Nom_produc;";	
            $result=mysqli_query($link, $qry);
            echo '<option selected value="">---------------------------------------------------</option>';
            while($row=mysqli_fetch_array($result))
            {
                  echo '<option value="'.$row['Cod_produc'].'">'.$row['Nom_produc'].'</option>';  
                  //echo= $row['Id_cat_prod'];
            }
			mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
        ?>
        </select >	
        </td> 
    </tr>
     <tr> 
    <td>&nbsp; </td>
    </tr>
    <tr> 
        <td colspan="2">
            <div align="center">
              <input type="button" value="Continuar" onClick="return Enviar0(this.form);">
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <input type="reset" value="  Borrar  ">    
            </div></td>
    </tr>
    <tr> 
    <td>&nbsp; </td>
    </tr>
    
    <tr>
        <td colspan="2"><div align="center">&nbsp;</div></td>
    </tr>
    <tr> 
        <td colspan="2"><div align="center"><input type="button" class="resaltado" onClick="history.back()" value="  VOLVER  "></div></td>
    </tr>
</table>
</form>
</div>
</body>
</html>

