<?php
include "../includes/valAcc.php";
if (isset($_SESSION['idRemision'])) {//Si idRemision existe
    $idRemision = $_SESSION['idRemision'];
}
foreach ($_POST as $nombre_campo => $valor) {
    $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
    echo $nombre_campo . " = " . $valor . "<br>";
    eval($asignacion);
}

function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');

$remisionOperador = new RemisionesOperaciones();
$remision = $remisionOperador->getRemisionById($idRemision);
//
?>
<!DOCTYPE html>
<html lang="es">
<head>
<title>Ingreso de Productos a la Remisión</title>
<meta charset="utf-8">
<link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
	<script  src="../js/validar.js"></script>
    <link rel="stylesheet" href="../css/datatables.css">
    <style>
        table {
            table-layout: fixed;
        }

        .width1 {
            width: 10%;
        }

        .width2 {
            width: 15%;
        }

        .width3 {
            width: 50%;
        }

        .width4 {
            width: 15%;
        }

        .width5 {
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
        function redireccion() {
            window.location.href = "../menu.php";
        }

        function eliminarSession() {
            let variable = 'idRemision';
            $.ajax({
                url: '../includes/controladorInventarios.php',
                type: 'POST',
                data: {
                    "action": 'eliminarSession',
                    "variable": variable,
                },
                dataType: 'text',
                success: function (res) {
                    redireccion();
                },
                error: function () {
                    alert("Vous avez un GROS problème");
                }
            });
        }

        $(document).ready(function () {
            let idRemision = <?=$idRemision?>;
            let ruta = "ajax/listaDetRemision.php?idRemision=" + idRemision;
            $('#example').DataTable({
                "columns": [
                    {
                        "data": function (row) {
                            let rep = '<form action="updateDetRemisionForm.php" method="post" name="elimina">' +
                                '          <input name="idRemision" type="hidden" value="' + idRemision + '">' +
                                '          <input name="codProducto" type="hidden" value="' + row.codProducto + '">' +
                                '          <input type="button" name="Submit" onclick="return Enviar(this.form)" class="formatoBoton"  value="Cambiar">' +
                                '      </form>'
                            return rep;
                        },
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "codProducto",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "producto",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "cantProducto",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": function (row) {
                            let rep = '<form action="delDetRemision.php" method="post" name="elimina">' +
                                '          <input name="idRemision" type="hidden" value="' + idRemision + '">' +
                                '          <input name="codProducto" type="hidden" value="' + row.codProducto + '">' +
                                '          <input type="button" name="Submit" onclick="return Enviar(this.form)" class="formatoBoton"  value="Eliminar">' +
                                '      </form>'
                            return rep;
                        },
                        "className": 'dt-body-center'
                    }
                ],
                "paging": false,
                "ordering": false,
                "info": false,
                "searching": false,
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
                "ajax": ruta
            });
        });
    </script>
</head>
<body> 
<div id="contenedor">
<div id="saludo1"><strong>DETALLE DE LA REMISIÓN</strong></div>
    <div class="form-group row">
        <div class="col-2 text-right"><strong>No. de Remisión</strong></div>
        <div class="col-1 bg-blue"><?= $idRemision; ?></div>
        <div class="col-1 text-right"><strong>Cliente</strong></strong></div>
        <div class="col-3" style="background-color: #dfe2fd;"><?= $remision['cliente'] ?></div>
        <div class="col-1 text-right"><strong>Fecha</strong></div>
        <div class="col-1 bg-blue"><?= $remision['fechaRemision'] ?></div>
        <div class="col-1 text-right"><strong>Valor</strong></div>
        <div class="col-1 bg-blue">$ <?= number_format($remision['valor']) ?></div>
    </div>
    <div class="form-group titulo row">
        <strong>Adicionar Detalle</strong>
    </div>
    <form method="post" action="makeDetRemision.php" name="form1">
        <input name="idRemision" type="hidden" value="<?= $idRemision; ?>">
        <div class="row">
            <div class="col-4 text-center" style="margin: 0 5px;"><strong>Productos Novaquim</strong></div>
            <div class="col-1 text-center" style="margin: 0 5px;"><strong>Unidades</strong></div>
            <div class="col-2 text-center"></div>
        </div>
        <div class="form-group row">
            <select name="codProducto" id="codProducto" class="form-control col-4 mr-3" >
                <option selected disabled value="">Escoja un producto Novaquim</option>
                <?php
                $productos = $remisionOperador->getProdTerminadosByIdRemision($idRemision);
                $filas = count($productos);
                for ($i = 0; $i < $filas; $i++) {
                    echo '<option value="' . $productos[$i]["codPresentacion"] . '">' . $productos[$i]['presentacion'] . '</option>';
                }
                ?>
            </select>
            <input type="text" style="margin: 0 5px 0 0;" class="form-control col-1" name="cantProducto"
                   id="cantProducto" onKeyPress="return aceptaNum(event)">
            <div class="col-2 text-center" style="padding: 0 20px;">
                <button class="button" onclick="return Enviar(this.form)"><span>Adicionar detalle</span>
                </button>
            </div>
        </div>
    </form>
    <form method="post" action="makeDetRemision.php" name="form1">
        <input name="idRemision" type="hidden" value="<?= $idRemision; ?>">
        <div class="row">
            <div class="col-4 text-center" style="margin: 0 5px;"><strong>Productos Distribucion</strong></div>
            <div class="col-1 text-center" style="margin: 0 5px;"><strong>Unidades</strong></div>
            <div class="col-2 text-center"></div>
        </div>
        <div class="form-group row">
            <select name="codProducto" id="codProducto" class="form-control col-4 mr-3" >
                <option selected disabled value="">Escoja un producto de distribución</option>
                <?php
                $productos = $remisionOperador->getProdDistribucionByIdRemision($idRemision);
                $filas = count($productos);
                for ($i = 0; $i < $filas; $i++) {
                    echo '<option value="' . $productos[$i]["codDistribucion"] . '">' . $productos[$i]['producto'] . '</option>';
                }
                ?>
            </select>
            <input type="text" style="margin: 0 5px 0 0;" class="form-control col-1" name="cantProducto"
                   id="cantProducto" onKeyPress="return aceptaNum(event)">
            <div class="col-2 text-center" style="padding: 0 20px;">
                <button class="button" onclick="return Enviar(this.form)"><span>Adicionar detalle</span>
                </button>
            </div>
        </div>
    </form>
    <div class="form-group titulo row">
        <strong>Detalle de la remisión</strong>
    </div>
    <div class="tabla-50">
        <table id="example" class="display compact formatoDatos" >
            <thead>
            <tr>
                <th class="width1"></th>
                <th class="width2">Código</th>
                <th class="width3">Producto</th>
                <th class="width4">Cantidad</th>
                <th class="width5"></th>
            </tr>
            </thead>
        </table>
    </div>

    <div class="row">
        <div class="col-1">
            <button class="button" id="back" onClick="eliminarSession()"><span>Terminar</span>
            </button>
        </div>
    </div>
<!--<table  align="center" border="0">
    <tr>
      <td width="124" align="right" ><strong>No. de Remisión</strong></td>
      <td width="53" align="left"><?php /*echo $remision;*/?></td>
      <td width="53" align="right" ><strong>Cliente</strong></td>
      <td width="243" align="left"><?php /*echo $row['cliente']; */?></td>
      <td width="44" align="right"><strong>Fecha </strong></td>
      <td width="100" align="left"><?php /*echo $row['Fech_remision']; */?></td>
    </tr>
    <?php /*
		$link=conectarServidor();
		echo '<form method="post" action="det_remision.php" name="form1">
		<tr><td colspan="4"><div align="center"><strong>Productos Novaquim</strong></div></td>
		<td colspan="2"><div align="center"><strong>Unidades</strong></div></td></tr>
		<tr><td colspan="4"><div align="center">';
		echo'<select name="cod_producto">';
		$result=mysqli_query($link,"select inv_prod.codPresentacion as Codigo, Nombre FROM inv_prod, prodpre WHERE inv_prod.codPresentacion=prodpre.Cod_prese and inv_prod>0 group by inv_prod.codPresentacion order by Nombre;");
        while($row=mysqli_fetch_array($result))
		{
			echo '<option value='.$row['Codigo'].'>'.$row['Nombre'].'</option>';
        }
		echo'</select>';
		echo '</div></td>';
		echo '<input name="Crear" type="hidden" value="1">'; 
		echo '<input name="remision" type="hidden" value="'.$remision.'">'; 		
		echo '<td colspan="2"><div align="center"><input name="cantidad" type="text" size=10 onKeyPress="return aceptaNum(event)" ></div></td>';
		echo '<td colspan="2" align="left"><input name="nova" onclick="return Enviar(this.form)" type="button"  value="Continuar"></td></tr>
		 </form>
		 <form method="post" action="det_remision.php" name="form2">
		<tr>
			<td colspan="4"><div align="center"><strong>Productos Distribución</strong></div></td>
			<td colspan="2"><div align="center"><strong>Unidades</strong></div></td>
		</tr>
		<tr>
			<td colspan="4"><div align="center">';
		echo'<select name="cod_producto">';
		$result=mysqli_query($link,"select inv_distribucion.Id_distribucion as Codigo, Producto from inv_distribucion, distribucion where inv_distribucion.Id_distribucion=distribucion.Id_distribucion AND invDistribucion>0 and Activo=0 order by Producto ");
		while($row=mysqli_fetch_array($result))
		{
			echo '<option value='.$row['Codigo'].'>'.$row['Producto'].'</option>';
		}
		echo '</select>';
		echo '</div></td>
			<td colspan="2"><div align="center"><input name="cantidad" type="text" size=10 onKeyPress="return aceptaNum(event)"></div></td>';
		echo '<input name="Crear" type="hidden" value="2">'; 
		echo '<input name="remision" type="hidden" value="'.$remision.'">'; 
		echo '<td colspan="2" align="left"><input name="cont" onclick="return Enviar(this.form)" type="button"  value="Continuar" ></td></tr>
		</form>';
		mysqli_close($link);
	*/?>
  <tr>
    <td  colspan="8" class="titulo">Productos de la Remisión : </td>    
  </tr>  
</table>
<table border="0" align="center">
          <tr>
          	<th width="56" align="center"></th>
            <th width="84" align="center">Código</th>
            <th width="437" align="center">Producto</th>
			<th width="127" align="center">Cantidad</th>
            <th width="68" align="center"></th>
  </tr>
          <?php
/*			$link=conectarServidor();
			$qry="select idRemision, codProducto, loteProducto, Nombre, SUM(cantProducto) as Cantidad from det_remision1, prodpre where idRemision=$remision AND codProducto=Cod_prese group by codProducto;";
			$result=mysqli_query($link,$qry);
			while($row=mysqli_fetch_array($result))
			{
				$cod=$row['Cod_producto'];
				$cantidad=$row['Cantidad'];
				echo'<tr><td align="center" valign="middle">';
				echo '<form action="updateRemision.php" method="post" name="actualiza">
					<input type="submit" name="Submit" value="Cambiar" >
					<input name="remision" type="hidden" value="'.$remision.'">
					<input name="producto" type="hidden" value="'.$cod.'">
					<input name="cantidad" type="hidden" value="'.$cantidad.'">
					</form>';
				echo '</td><td><div align="center">'.$row['Cod_producto'].'</div></td>
				  <td><div align="center">'.$row['Nombre'].'</div></td>
				  <td><div align="center">'.$row['Cantidad'].'</div></td>
				  <td align="center" valign="middle">';
				echo '<form action="delDetRemision.php" method="post" name="elimina">
					<input type="submit" name="Submit" value="Eliminar" >
					<input name="remision" type="hidden" value="'.$remision.'">
					<input name="producto" type="hidden" value="'.$cod.'">
					<input name="cantidad" type="hidden" value="'.$cantidad.'">
					</form>';
				echo '</td></tr>';
			}
			mysqli_close($link);
			*/?>
		<?php
/*			$link=conectarServidor();
			$qry="select idRemision, codProducto, Producto, cantProducto from det_remision1, distribucion where idRemision=$remision AND codProducto=Id_distribucion;";
			$result=mysqli_query($link,$qry);
			while($row=mysqli_fetch_array($result))
			{
				$cod=$row['Cod_producto'];
				$cantidad=$row['Can_producto'];
				echo'<tr>
				<td align="center" valign="middle">';
				echo '<form action="updateRemision.php" method="post" name="actualiza">
					<input type="submit" name="Submit" value="Cambiar" >
					<input name="remision" type="hidden" value="'.$remision.'">
					<input name="producto" type="hidden" value="'.$cod.'">
					<input name="cantidad" type="hidden" value="'.$cantidad.'">
				</form>';
				echo '</td>
			  <td><div align="center">'.$row['Cod_producto'].'</div></td>
			  <td><div align="center">'.$row['Producto'].'</div></td>
			  <td><div align="center">'.$row['Can_producto'].'</div></td>
			  <td align="center" valign="middle">';
				echo '<form action="delDetRemision.php" method="post" name="elimina">
				<input type="submit" name="Submit" value="Eliminar" >
				<input name="remision" type="hidden" value="'.$remision.'">
				<input name="producto" type="hidden" value="'.$cod.'">
				<input name="cantidad" type="hidden" value="'.$cantidad.'">
				</form>';
				echo '</td></tr>';
			}
			mysqli_close($link);
			*/?>
            
            <tr>
                <td colspan="5">
                    <form action="Imp_Remision1.php" method="post" target="_blank">
                    <div align="center">
                    <input name="remision" type="hidden" value="<?php /*echo $remision; */?> ">
                    <input type="submit" name="Submit" value="Imprimir Remisión" >
                    </div>
                    </form>  
                </td> 
                
            </tr>           
      </table>
      <?php /*
		  echo'<input name="Crear" type="hidden" value="0">'; 
		  echo'<input name="remision" type="hidden" value="'.$remision.'">'; 
	  */?>

<table width="27%" border="0" align="center">
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr> 
        <td><div align="center"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Menú">
        </div></td>
    </tr>
</table>-->
</div> 
</body>
</html>
	   