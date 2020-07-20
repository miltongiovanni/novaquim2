<?php
include "../includes/valAcc.php";
$fecha = $_POST['fecha'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
<title>Inventario de Producto Terminado</title>
<meta charset="utf-8">
<link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../css/datatables.css">
    <style>
        table {
            table-layout: fixed;
        }

        .width1 {
            width: 10%;
        }

        .width2 {
            width: 50%;
        }

        .width3 {
            width: 10%;
        }

        .width4 {
            width: 10%;
        }

        .width5 {
            width: 10%;
        }

        .width6 {
            width: 10%;
        }

    </style>
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/datatables.js"></script>
    <script src="../js/dataTables.buttons.js"></script>
    <script src="../js/jszip.js"></script> <!--Para exportar Excel-->
    <!--<script src="../js/pdfmake.js"></script>-->  <!--Para exportar PDF-->
    <!--<script src="../js/vfs_fonts.js"></script>--> <!--Para exportar PDF-->
    <script src="../js/buttons.html5.js"></script>

    <script>
        jQuery.extend(jQuery.fn.dataTableExt.oSort, {
            "chinese-string-asc": function (s1, s2) {
                if (s1 != null && s1 != undefined && s2 != null && s2 != undefined) {
                    return s1.localeCompare(s2);
                } else if (s2 == null || s2 == undefined) {
                    return s1;
                } else if (s1 == null || s1 == undefined) {
                    return s2;
                }
            },

            "chinese-string-desc": function (s1, s2) {
                if (s1 != null && s1 != undefined && s2 != null && s2 != undefined) {
                    return s2.localeCompare(s1);
                } else if (s2 == null || s2 == undefined) {
                    return s1;
                } else if (s1 == null || s1 == undefined) {
                    return s2;
                }
            }
        });
        $(document).ready(function () {
            var table = $('#example').DataTable({
                "columns": [
                    {
                        "data": "codPresentacion",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "presentacion",
                        "className": 'dt-body-left'
                    },
                    {
                        "data": "invtotal",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "entrada",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "salida",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "inventario",
                        "className": 'dt-body-center'
                    },
                ],
                "columnDefs": [
                    {type: 'chinese-string', targets: 1}
                ],
                "order": [[1, 'asc']],
                "dom": 'Blfrtip',
                "paging": true,
                "buttons": [
                    'copyHtml5',
                    'excelHtml5'
                ],
                "lengthMenu": [[20, 50, 100, -1], [20, 50, 100, "All"]],
                "language": {
                    "lengthMenu": "Mostrando _MENU_ datos por página",
                    "zeroRecords": "Lo siento no encontró nada",
                    "info": "Mostrando página _PAGE_ de _PAGES_",
                    "infoEmpty": "No hay datos disponibles",
                    "search": "Búsqueda:",
                    "paginate": {
                        "first": "Primero",
                        "last": "Último",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    },
                    "infoFiltered": "(Filtrado de _MAX_ en total)"

                },
                "ajax": "ajax/listaInvProdTerminadoFecha.php?fecha=<?= $fecha; ?>",
                "deferRender": true,  //For speed
            });
        });
    </script>
</head>
<body>
<div id="contenedor">
<div id="saludo1"><strong>INVENTARIO DE PRODUCTO TERMINADO A <?= $fecha; ?></strong></div>
    <div class="row flex-end">
        <div class="col-1">
            <button class="button" onclick="window.location='../menu.php'">
                <span><STRONG>Ir al Menú</STRONG></span></button>
        </div>
    </div>
    <div class="tabla-60">
        <table id="example" class="display compact formatoDatos">
            <thead>
            <tr>
                <th class="width1">Código</th>
                <th class="width2">Producto</th>
                <th class="width3">Cantidad</th>
                <th class="width4">Entrada</th>
                <th class="width5">Salida</th>
                <th class="width6">Inventario</th>
            </tr>
            </thead>
        </table>
    </div>
    <div class="row">
        <div class="col-1">
            <button class="button" onclick="window.location='../menu.php'">
                <span><STRONG>Ir al Menú</STRONG></span>
            </button>
        </div>
    </div>
<!--<table  align="center" width="700" border="0" summary="encabezado">
  <tr> <td width="594" align="right"><form action="Inv_Prod_fch_Xls.php" method="post" target="_blank">
    <input name="Submit" type="submit" class="resaltado" value="Exportar a Excel"><input name="Fch" type="hidden" value="<?php /*echo $Fch */?>"></form></td>
      <td width="96"><div align="right"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Menú">
      </div></td>
  </tr>
</table>
<table border="0" align="center" cellspacing="0" summary="cuerpo">
<tr>
    <th width="60" class="formatoEncabezados">Código</th>
    <th width="422" class="formatoEncabezados">Producto</th>
    <th width="70" class="formatoEncabezados">Cantidad</th>
    <th width="70" class="formatoEncabezados">Entrada</th>
    <th width="70" class="formatoEncabezados">Salida</th>
    <th width="70" class="formatoEncabezados">Inventario</th>
  </tr>   
<?php
/*include "includes/utilTabla.php";
include "includes/conect.php" ;
$link=conectarServidor();
//INVENTARIO ACTUAL
$sql="	SELECT inv_prod.codPresentacion as Codigo, Nombre, sum(inv_prod) as inventario 
FROM inv_prod, prodpre, productos, medida
where inv_prod.codPresentacion=prodpre.Cod_prese AND medida.Id_medida=prodpre.Cod_umedid and productos.Cod_produc=prodpre.Cod_produc and prod_activo=0 
group by Codigo ORDER BY Nom_produc, cant_medida;";
$result=mysqli_query($link,$sql);
$a=1;
while($row=mysqli_fetch_array($result, MYSQLI_BOTH))
{
$entrada1=0;$entrada2=0;$entrada3=0;
$salida1=0;$salida2=0;$salida3=0;$salida4=0;
  $prod=$row['Codigo'];
  echo'<tr';
  if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
  echo '>
  <td class="formatoDatos"><div align="center">'.$row['Codigo'].'</div></td>
  <td class="formatoDatos"><div align="left">'.$row['Nombre'].'</div></td>
  <td class="formatoDatos"><div align="center"><script   > document.write(commaSplit('.$row['inventario'].'))</script></div></td>';
  //ENTRADA POR PRODUCCIÓN
  $sqle1="select SUM(cantPresentacion) as entrada1 from envasado, ord_prod where envasado.Lote=ord_prod.Lote and fechProd>'$Fch' and Con_prese=$prod;";
  $resulte1=mysqli_query($link,$sqle1);
  $rowe1=mysqli_fetch_array($resulte1, MYSQLI_BOTH);
  if($rowe1['entrada1']==NULL)
	  $entrada1=0;
  else
	  $entrada1=$rowe1['entrada1'];
  //ENTRADA POR CAMBIOS
  $sqle2="select Sum(cantPresentacionNvo) as entrada2 from cambios, det_cambios2 where cambios.idCambio=det_cambios2.idCambio and fechaCambio>'$Fch' and codPresentacionNvo=$prod;";
  $resulte2=mysqli_query($link,$sqle2);
  $rowe2=mysqli_fetch_array($resulte2, MYSQLI_BOTH);
  if($rowe2['entrada2']==NULL)
	  $entrada2=0;
  else
	  $entrada2=$rowe2['entrada2'];
  // ENTRADA POR KITS
  $sqle3="select sum(cantArmado) as entrada3 from arm_kit, kit where codKit=Id_kit and fechArmado>'$Fch' AND Codigo=$prod;";
  $resulte3=mysqli_query($link,$sqle3);
  $rowe3=mysqli_fetch_array($resulte3, MYSQLI_BOTH);
  if($rowe3['entrada3']==NULL)
	  $entrada3=0;
  else
	  $entrada3=$rowe3['entrada3'];
  $entrada=$entrada1 + $entrada2 + $entrada3;	

  echo '<td class="formatoDatos"><div align="center"><script   > document.write(commaSplit('.$entrada.'))</script></div></td>';
  //SALIDA POR VENTAS
  $sqls1="select sum(Can_producto) as salida1 from det_remision, remision 
where remision.Id_remision=det_remision.Id_remision and Fech_remision>'$Fch' and Cod_producto=$prod;";
	$results1=mysqli_query($link,$sqls1);
	$rows1=mysqli_fetch_array($results1, MYSQLI_BOTH);
	if($rows1['salida1']==NULL)
		$salida1=0;
	else
		$salida1=$rows1['salida1'];
	//SALIDA POR CAMBIOS
	$sqls2="select SUM(cantPresentacionAnt) as salida2 from cambios, det_cambios where cambios.idCambio=det_cambios.idCambio and fechaCambio>'$Fch' and codPresentacionAnt=$prod";
	$results2=mysqli_query($link,$sqls2);
	$rows2=mysqli_fetch_array($results2, MYSQLI_BOTH);
	if($rows2['salida2']==NULL)
		$salida2=0;
	else
		$salida2=$rows2['salida2'];
	//SALIDA POR ARMADO DE KITS
    $sqls3="select sum(cantArmado) as salida3 from arm_kit, kit, det_kit where codKit=kit.Id_kit and kit.Id_kit=det_kit.idKit and fechArmado>'$Fch' and codProducto=$prod";
	$results3=mysqli_query($link,$sqls3);
	$rows3=mysqli_fetch_array($results3, MYSQLI_BOTH);
	if($rows3['salida3']==NULL)
		$salida3=0;
	else
		$salida3=$rows3['salida3'];
	 //SALIDA POR VENTAS
    $sqls4="select sum(Can_producto) as salida4 from det_remision1, remision1 where remision1.Id_remision=det_remision1.Id_remision and Fech_remision>'$Fch' and Cod_producto=$prod;";
	$results4=mysqli_query($link,$sqls4);
	$rows4=mysqli_fetch_array($results4, MYSQLI_BOTH);
	if($rows4['salida4']==NULL)
		$salida4=0;
	else
		$salida4=$rows4['salida4'];
	$salida=$salida1 + $salida2 + $salida3+$salida4;
	echo '<td class="formatoDatos"><div align="center"><script   > document.write(commaSplit('.$salida.'))</script></div></td>';
  $inv=$row['inventario']+$salida-$entrada;
  echo '<td class="formatoDatos"><div align="center"><script   > document.write(commaSplit('.$inv.'))</script></div></td>';
  echo '</tr>';
  $a=$a+1;
}
mysqli_free_result($result);
mysqli_free_result($resulte1);
mysqli_free_result($resulte2);
mysqli_free_result($resulte3);
mysqli_free_result($results1);
mysqli_free_result($results2);
mysqli_free_result($results3);
mysqli_free_result($results4);

mysqli_close($link);
*/?>

</table>
<div align="center"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Menú"></div>
--></div>
</body>
</html>