<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
	<title>Creación de Nota Crédito</title>
	<meta charset="utf-8">
	<script  src="../js/validar.js"></script>


</head>
<body>
<div id="contenedor">
<div id="saludo"><strong> NOTA CRÉDITO PARA
<?php
foreach ($_POST as $nombre_campo => $valor) {
    ${$nombre_campo} = $valor;
    if(is_array($valor)){
        //echo $nombre_campo.print_r($valor).'<br>';
    }else{
        //echo $nombre_campo. '=' .${$nombre_campo}.'<br>';
    }
}	
	include "includes/conect.php";
	$link=conectarServidor();
	$qry="select nomCliente from clientes where nitCliente='$cliente'";
	$result=mysqli_query($link,$qry);
	$row=mysqli_fetch_array($result);
	echo mb_strtoupper($row['Nom_clien']);
?> 
</strong></div>
<form name="form2" method="POST" action="makeNota.php">
<table  align="center" border="0" summary="cuerpo">
    <tr> 
        
        <td width="170"><div align="right"><strong>Razón de la Nota</strong></div></td>
        <td colspan="2">
      	<select name="razon" size="1" >
              <option value="0" selected>Devolución de Productos</option>
              <option value="1">Descuento no aplicado</option>
        </select></td>
    </tr>
    <tr> 
        <td colspan="2"><div align="right"><strong>Factura por la cual se origina la Nota</strong></div></td>
        <td width="89"><?php 
				echo'<select name="fact_ori" id="fact_origen">';
				$result=mysqli_query($link,"select Factura from factura where Nit_cliente='$cliente' and Estado<>'A' order by Factura DESC");
				echo '<option selected value="">---------</option>';
				while($row=mysqli_fetch_array($result)){
					echo '<option value='.$row['Factura'].'>'.$row['Factura'].'</option>';
				}
				echo'</select>';
			?>
       </td>
    </tr>
    <tr> 
        <td colspan="2"><div align="right"><strong>Factura a la cual afecta la Nota</strong></div></td>
        <td><?php 
				echo'<select name="fact_des" id="fact_destino">';
				$result=mysqli_query($link,"select Factura from factura where Nit_cliente='$cliente' order by Factura DESC");
				echo '<option selected value="">---------</option>';
				while($row=mysqli_fetch_array($result)){
					echo '<option value='.$row['Factura'].'>'.$row['Factura'].'</option>';
				}
				echo'</select>';
				mysqli_free_result($result);
/* cerrar la conexi�n */
mysqli_close($link);
			?>
       </td>
    </tr>
    <tr>
      <td align="right"><strong>Fecha Nota Crédito</strong></td>
      <td colspan="2"><input type="text" name="Fecha" id="sel1" readonly size=17><input type="reset" value=" ... "
		onclick="return showCalendar('sel1', '%Y-%m-%d', '12', true);"></td>
    </tr>
    <tr>
        <td colspan="3"><div align="center">&nbsp;</div></td>
    </tr>
    <tr><td><input name="cliente" type="hidden" value="<?php echo $cliente; ?>"><input name="crear" type="hidden" value="1"></td>
        <td width="110" colspan="1"><div align="right">
          <input type="reset" value="   Reiniciar   ">
        </div></td>
        <td colspan="1" align="center"><input type="button" value="Continuar" onClick="return Enviar(this.form);"></td>
    </tr>
    <tr>
        <td colspan="3"><div align="center">&nbsp;</div></td>
    </tr>
    <tr>
        <td colspan="3"><div align="center">&nbsp;</div></td>
    </tr>
    <tr> 
        <td colspan="3"><div align="center"><input type="button" class="resaltado" onClick="history.back()" value="  VOLVER  "></div></td>
    </tr>
</table>
</form>
</div>
</body>
</html>

