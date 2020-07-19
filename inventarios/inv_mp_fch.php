<?php
include "../includes/valAcc.php";
$fecha=$_POST['fecha'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
<title>Inventario de Materia Prima</title>
<meta charset="utf-8">
<link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../css/datatables.css">
    <style>
        table {
            table-layout: fixed;
        }

        .width1 {
            width: 12%;
        }

        .width2 {
            width: 40%;
        }

        .width3 {
            width: 12%;
        }

        .width4 {
            width: 12%;
        }

        .width5 {
            width: 12%;
        }

        .width6 {
            width: 12%;
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
                        "data": "codMP",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "nomMPrima",
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
                "ajax": "ajax/listaInvMPrimaFecha.php?fecha=<?= $fecha; ?>",
                "deferRender": true,  //For speed
            });
        });
    </script>
</head>
<body>
<div id="contenedor">
<div id="saludo1"><strong>INVENTARIO DE MATERIA PRIMA A <?= $fecha; ?></strong></div>
    <div class="row flex-end">
        <div class="col-1">
            <button class="button" onclick="window.location='../menu.php'">
                <span><STRONG>Ir al Menú</STRONG></span></button>
        </div>
    </div>
    <div class="tabla-50">
        <table id="example" class="display compact formatoDatos">
            <thead>
            <tr>
                <th class="width1">Código</th>
                <th class="width2">Materia Prima</th>
                <th class="width3">Cantidad (Kg)</th>
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

 <!--
<table width="713" border="0" align="center">
  <tr>
  	<form action="Inv_MP_fch_Xls.php" method="post" target="_blank"><td width="601" align="right">
    <input name="Submit" type="submit" class="resaltado" value="Exportar a Excel"></td><input name="Fch" type="hidden" value="<?php /*echo $Fch */?>"></form>
      <td width="102"><div align="right"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Menú">
      </div></td>
  </tr>
</table>
<table border="0" align="center" cellspacing="0" width="70%">
<tr>
    <th class="formatoEncabezados">Código</th>
    <th class="formatoEncabezados">Materia Prima</th>
    <th class="formatoEncabezados">Cantidad (Kg)</th>
    <th class="formatoEncabezados">Entrada</th>
    <th class="formatoEncabezados">Salida</th>
    <th class="formatoEncabezados">Inventario</th>
  </tr>   
<?php
/*include "includes/utilTabla.php";
include "includes/conect.php" ;


//parametros iniciales que son los que cambiamos
//conectar con el servidor de BD
$link=conectarServidor();
//conectar con la tabla (ej. use datos;)
//sentencia SQL    tblusuarios.IdUsuario,
$sql="	SELECT inv_mprimas.codMP as Codigo, Nom_mprima as Nombre, sum(inv_mp) as inventario FROM inv_mprimas, mprimas
where inv_mprimas.codMP=mprimas.Cod_mprima group by Codigo order by Nombre;";
$result=mysqli_query($link,$sql);
$a=1;

while($row=mysqli_fetch_array($result, MYSQLI_BOTH))
{
	$salida=0;
	$salida1=0;
	$salida2=0;
	$prod=$row['Codigo'];
	$invt_ini=$row['inventario'];
	echo'<tr';
	if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
	echo '>
	<td class="formatoDatos"><div align="center">'.$row['Codigo'].'</div></td>
	<td class="formatoDatos"><div align="left">'.$row['Nombre'].'</div></td>
	<td class="formatoDatos"><div align="center"><script > document.write(commaSplit('.$invt_ini.'))</script></div></td>';
	//ENTRADA POR COMPRA DE MATERIA PRIMA
	$sqle="select Codigo, sum(Cantidad) as entrada from det_compras, compras where Codigo=$prod and det_compras.idCompra=compras.idCompra and tipoCompra=1 and fechComp>='$Fch' group by Codigo";
	$resulte=mysqli_query($link,$sqle);
	$rowe=mysqli_fetch_array($resulte, MYSQLI_BOTH);
	if($rowe['entrada']==NULL)
		$entrada=0;
	else
		$entrada=$rowe['entrada'];
	echo '<td class="formatoDatos"><div align="center"><script > document.write(commaSplit('.$entrada.'))</script></div></td>';
	//SALIDA POR ORDEN DE PRODUCCION	
	$sqls1="select codMPrima, sum(cantidadMPrima) as salida1 from det_ord_prod, ord_prod where codMPrima=$prod and det_ord_prod.Lote=ord_prod.Lote and fechProd>='$Fch' group by codMPrima;";
	$results1=mysqli_query($link,$sqls1);
	$rows1=mysqli_fetch_array($results1, MYSQLI_BOTH);
	if($rows1['salida1']==NULL)
		$salida1=0;
	else
		$salida1=$rows1['salida1'];
	//SALIDA POR ENVASADO DE PRODUCTOS DE DISTRIBUCION
	$sqls2="select codMPrima, sum(cant_medida*Cantidad*Densidad/1000) as salida2 from rel_dist_mp, mPrimaDist, envasado_dist, medida where codMPrima=$prod and codMPrimaDist=mPrimaDist.codMPrimaDist  and codMedida=Id_medida and rel_dist_mp.codDist=envasado_dist.codDist and fechaEnvDist>='$Fch';";
	$results2=mysqli_query($link,$sqls2);
	$rows2=mysqli_fetch_array($results2, MYSQLI_BOTH);
	if($rows2['salida2']==NULL)
		$salida2=0;
	else
		$salida2=$rows2['salida2'];
	$salida=$salida1+$salida2;
	echo '<td class="formatoDatos"><div align="center"><script > document.write(commaSplit('.$salida.'))</script></div></td>';
	$inventario=$invt_ini-$entrada+$salida;
	echo '<td class="formatoDatos"><div align="center"><script > document.write(commaSplit('.$inventario.'))</script></div></td>';
	echo'</tr>';	
	$a=$a+1;
}
mysqli_free_result($result);
mysqli_free_result($resulte);
mysqli_free_result($results1);
mysqli_free_result($results2);
mysqli_close($link);//Cerrar la conexion
*/?>
</table>
<div align="center"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Menú"></div>-->
</div>
</body>
</html>