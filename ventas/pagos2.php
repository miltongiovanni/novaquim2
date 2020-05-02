<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Ingreso de pagos parciales</title>
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css" />
<script  src="scripts/validar.js"></script>
<script  src="scripts/block.js"></script>	
	<script >
	document.onkeypress = stopRKey; 
	</script>
</head>
<body>
<div align="center"><img src="images/LogoNova1.JPG"/></div>
<form action="aplicaPago.php" method="post" name="aplicapagos">
<table width="65%" border="0" align="center">
    <tr>
    	<td colspan="4"><strong><span class="titulo">Aplicaci&oacute;n de Pagos </span></strong></td>
    </tr>
	<?php
	include "includes/conect.php" ;
    foreach ($_POST as $nombre_campo => $valor) 
    { 
		$asignacion = "\$".$nombre_campo."='".$valor."';"; 
		echo $nombre_campo." = ".$valor."<br>";  
		eval($asignacion); 
    }      
	$link=conectarServidor();   
	$bd="novaquim";  
 	$qry3="select sum(pago) as Parcial from pagos where Id=$id_compra and compra=$compra";
	$result3=mysql_db_query($bd,$qry3);
	$row3=mysql_fetch_array($result3);
	if($row3['Parcial'])
		$parcial=$row3['Parcial'];
	else
		$parcial=0;
	echo $parcial;
  	$saldo=$valTot-$parcial;
	mysql_close($link);
    ?> 
    <tr>
   	  <td width=""><strong>Factura</strong></td>
      <td width=""><?php  echo $factura; ?></td>
      <td width=""><strong>Valor Total Factura </strong></td>
      <td width=""><?php  echo '$ <script > document.write(commaSplit('.$ValTot.'))</script>'; ?></td>
    </tr>
    <tr>
      <td><strong>Fecha Vencimiento</strong></td>
      <td><?php echo $fecVen; ?></td>
      <td><strong>Saldo Pendiente </strong></td>
      <td><?php echo '$ <script > document.write(commaSplit('.$saldo.'))</script>'; ?></td>
    </tr>
    <tr>
		  <th>Factura</th>
          <th>Fecha de Pago </th>
          <th>Valor Pagado </th>
          <th>Usuario</th>
	</tr>
	 <?php
	if($total>0)
        {
            while($row=mysql_fetch_array($result))
            {
            
                     echo '
                        <tr>
                        <td><div align="center">'.$row['No_factura'].'</div></td>
                        <td><div align="center">'.$row['Fch_pago'].'</div></td>
                        <td><div align="center"> $ <script > document.write(commaSplit('.$row['pago'].'))</script></div></td>
                        <td><div align="center">'.$row['Usuario'].'</div></td>
                        </tr>';
                     echo '<input name="factura" type="hidden" value="'.$factura.'" />';
            }
                     $qry1="select sum(pago) as a from pagos where No_factura=$factura";
         
                     $result2=mysql_db_query($bd,$qry1);
         
                    if($result2)
                    {
                        $row1=mysql_fetch_array($result2);
                        $valor=$row1['a'];	
                         echo '
                         <tr>
                        <td></td>
                        <td></td>
                        <td><div align="center">Abono a la Fecha</div></td>
                        <td><div align="center">$ <script > document.write(commaSplit('.$valor.'))</script></div></td>
                        </tr>';
                        
                        echo '<input name="valTotal" type="hidden" value="'.$valor.'" />';
                    }
            else
            {
    
                $valor=0;
                echo '<input name="valTotal" type="hidden" value="'.$valor.'" />';
                }			
            
        
    }
    else
    {
    
                $valor=0;
                echo '<input name="valTotal" type="hidden" value="'.$valor.'" />';
                echo '<input name="factura" type="hidden" value="'.$factura.'" />';	
    }
    
        
    
    ?>
      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>

    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><strong>Valor Cobrado </strong></td>
      <td>&nbsp;</td>
      <td><div align="right">
        <input name="Valor" type="text" id="Valor" size="30" onkeypress="return aceptaNum(event)"/>
      </div></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><strong>Usuario </strong></td>
      <td>&nbsp;</td>
      <td><div align="right">
        <input name="User" type="text" id="User" size="30" readonly="true" value="<?=$_SESSION['User'];?>" />
      </div></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><label></label></td>
      <td>&nbsp;</td>
      <td><div align="right">
        <input name="IdUser" type="hidden" value="<?=$_SESSION['IdUsuario'];?>" />		
        <input type="submit" name="Submit" value="Grabar Pago" />
      </div></td>
    </tr>
	<tr>
        <td colspan="8"><p align="center"><img src="temporal/Volver.png" width="178" height="23" border="0" usemap="#Map" />
                <map name="Map" id="Map">
                  <area shape="rect" coords="2,2,184,20" href="indexpagos.php" />
                </map>
        </p></td>
      </tr>
  </table>
   
  
</form>


</body>
</html>

