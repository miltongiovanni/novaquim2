<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
	<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
	<title>Creaci&oacute;n de Productos de Distribuci&oacute;n</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<script type="text/javascript" src="scripts/validar.js"></script>
	<script type="text/javascript" src="scripts/block.js"></script>	
    	<script type="text/javascript">
	document.onkeypress = stopRKey; 
	</script>

</head>
<body>
<div id="contenedor">
<div id="saludo"><strong>CREACI&Oacute;N DE PRODUCTOS&nbsp;DE DISTRIBUCI&Oacute;N</strong></div>
<form name="form2" method="POST" action="makeDis.php">
<table width="410" border="0"  align="center" cellspacing="0" class="table2">
<tr> 
    <td width="162"><div align="right"><b>Categor&iacute;a</b></div></td>
    <td colspan="2"><select name="Cat_Dist" id="combo">
            <?php
                include "includes/conect.php";
                $link=conectarServidor();
                $qry="select * from cat_dist order by Des_cat_dist";	
                $result=mysqli_query($link,$qry);
                echo '<option selected value="1">Implementos de Aseo</option>';
                while($row=mysqli_fetch_array($result))
                {
					if($row['Id_cat_dist']!=1)
                      echo '<option value="'.$row['Id_cat_dist'].'">'.$row['Des_cat_dist'].'</option>';  
                      //echo= $row['Id_cat_prod'];
                }
				mysqli_free_result($result);
/* cerrar la conexi�n */
mysqli_close($link);
            ?>
      </select >	</td> 
</tr>
<tr> 
    <td><div align="right"><strong>Tasa de IVA</strong></div></td>
    <td colspan="2"><select name="tasa_iva" id="combo">
            <?php
                $link=conectarServidor();
                $qry="select * from tasa_iva";	
                $result=mysqli_query($link,$qry);
                echo '<option selected value="3">0.19</option>';
                while($row=mysqli_fetch_array($result))
                {
					if ($row['Id_tasa']!=3)
                      echo '<option value="'.$row['Id_tasa'].'">'.$row['tasa'].'</option>';  
                      //echo= $row['Id_cat_prod'];
                }
				mysqli_free_result($result);
/* cerrar la conexi�n */
mysqli_close($link);
            ?>
      </select >	</td> 
</tr>
<tr> 
    <td><div align="right"><b>Descripci&oacute;n</b></div></td>
    <td colspan="2"><input type="text" name="producto_dist" size=34   value=""></td>
</tr>
<tr> 
    <td><div align="right"><b>Stock M&iacute;nimo</b></div></td>
    <td colspan="2"><input type="text" name="stock_dis" size=10 onKeyPress="return aceptaNum(event)"  value="0"></td>
</tr>
<tr> 
    <td><div align="right"><b>Precio de Venta</b></div></td>
    <td colspan="2"><input type="text" name="precio_vta" size=10 onKeyPress="return aceptaNum(event)"  value=""></td>
</tr>

<tr><td><div align="right"><strong>Cotizar</strong></div></td>
            <td colspan="2"><select name="Cotiza" >
        <option value="1" selected>No</option>
        <option value="0">Si</option>
      </select></td>
    </tr>
<tr> <td></td>
    <td width="121"><div align="center"><input type="button" value=" Crear " onClick="return Enviar(this.form);"></div></td>
    <td width="121"><div align="center"><input type="reset" value="Reiniciar"></div></td>
</tr>

<tr>
        <td colspan="3"><div align="center">&nbsp;</div></td>
    </tr>
    <tr>
        <td colspan="3"><div align="center">&nbsp;</div></td>
    </tr>
    <tr> 
        <td colspan="3">
        <div align="center"><input type="button" class="resaltado" onClick="history.back()" value="  VOLVER  "></div>        </td>
    </tr>
</table>
</form>
</div>
</body>
</html>

