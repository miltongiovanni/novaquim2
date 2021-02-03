<?php
include "../includes/valAcc.php";

if (isset($_POST['idFormulaMPrima'])) {
    $idFormulaMPrima = $_POST['idFormulaMPrima'];
}else{
    if (isset($_SESSION['idFormulaMPrima'])) {
        $idFormulaMPrima = $_SESSION['idFormulaMPrima'];
    }
}

function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');

$formulaMPrimaOperador = new FormulasMPrimaOperaciones();
$nomFormula = $formulaMPrimaOperador->getNomFormulaMPrima($idFormulaMPrima);
$DetFormulaMPrimaOperador = new DetFormulaMPrimaOperaciones();
$porcentajeTotal = $DetFormulaMPrimaOperador->getPorcentajeTotal($idFormulaMPrima);
?>
<!DOCTYPE html>
<html lang="es">
<head>
<title>Porcentaje de Materias Primas en la Fórmula</title>
<meta charset="utf-8">
<link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../css/datatables.css">
    <style>
        table.dataTable.compact thead th, table.dataTable.compact thead td {
            padding: 4px 4px 4px 4px;
        }
    </style>
<script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/datatables.js"></script>
    <script src="../js/jszip.js"></script>
    <script src="../js/pdfmake.js"></script>
    <script src="../js/vfs_fonts.js"></script>
    <script>
        $(document).ready(function () {
            let idFormulaMPrima = <?=$idFormulaMPrima?>;
            let ruta = "ajax/listaDetFormulasMPrima.php?idFormulaMPrima=" + idFormulaMPrima;
            $('#example').DataTable({
                "columns": [
                    {
                        "data": function (row) {
                            let rep = '<form action="updateDetFormulaMPrimaForm.php" method="post" name="cambiar">' +
                                '          <input name="idFormulaMPrima" type="hidden" value="' + idFormulaMPrima + '">' +
                                '          <input name="codMPrima" type="hidden" value="' + row.codMPrima + '">' +
                                '          <input type="button" name="Submit" onclick="return Enviar(this.form)" class="formatoBoton"  value="Cambiar">' +
                                '      </form>'
                            return rep;
                        },
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "nomMPrima",
                        "className": 'dt-body-left'
                    },
                    {
                        "data": "porcentaje",
                        "className": 'dt-body-right'
                    },
                    {
                        "data": function (row) {
                            let rep = '<form action="delDetFormulaMPrima.php" method="post" name="elimina">' +
                                '          <input name="idFormulaMPrima" type="hidden" value="' + idFormulaMPrima + '">' +
                                '          <input name="codMPrima" type="hidden" value="' + row.codMPrima + '">' +
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


<?php
/*include "includes/conect.php";
foreach ($_POST as $nombre_campo => $valor) {
    ${$nombre_campo} = $valor;
    if(is_array($valor)){
        //echo $nombre_campo.print_r($valor).'<br>';
    }else{
        //echo $nombre_campo. '=' .${$nombre_campo}.'<br>';
    }
}  
if($CrearFormula==0)
{
   $link=conectarServidor();   
   $bd="novaquim";   
   $qryForm="insert into formula_mp (codMPrima) values ($mprima1)";
   if($resultfact=mysqli_query($link,$qryForm))
   {
		$qry="select max(idFormulaMPrima) as Form from formula_mp";
		$result=mysqli_query($link,$qry);
		$row=mysqli_fetch_array($result);
		$Formula=$row['Form'];
		echo '<form method="post" action="detFormulaMPrima.php" name="form3">';
		echo'<input name="CrearFormula" type="hidden" value="5">'; 
		echo'<input name="Formula" type="hidden" value="'.$Formula.'">'; 
		echo '</form>';
		echo'<script >
		document.form3.submit();
		</script>';	
		mysqli_free_result($result);
mysqli_close($link);
	}
	else
	{
		mover_pag("formula_col.php","Error al ingresar la Formulación");
		mysqli_close($link);
	}
} 

if($CrearFormula==1)
{
 	//AGREGANDO LOS COMPONENTES DE LA FORMULACIÓN
	$percent=$percent/100;
	$link=conectarServidor();   
	$qryFact="insert into det_formula_mp (idFormulaMPrima, codMPrima, porcentaje) values ($Formula, $cod_mprima, $percent)";
	echo $qryFact;
	$resultfact=mysqli_query($link,$qryFact);
	$qry="select sum(porcentaje) as Total from det_formula_mp where idFormulaMPrima=$Formula;";
	$result=mysqli_query($link,$qry);
	$row=mysqli_fetch_array($result);
	$Total=$row['Total'];
	mysqli_free_result($result);
mysqli_close($link);
} 
if($CrearFormula==2)
{
 	//AGREGANDO LOS COMPONENTES DE LA FORMULACIÓN
	$link=conectarServidor();   
	$qry="select sum(porcentaje) as Total from det_formula_mp where idFormulaMPrima=$Formula;";
	$result=mysqli_query($link,$qry);
	$row=mysql_fetch_array($result);
	$Total=$row['Total'];
	mysqli_free_result($result);
mysqli_close($link);
} 

/*	  	$link=conectarServidor();
	  	$qry="select codMPrima, Nom_mprima from formula_mp, mprimas where codMPrima=Cod_mprima and idFormulaMPrima=$Formula";
		$result=mysqli_query($link,$qry);
		$row=mysqli_fetch_array($result);
		mysqli_free_result($result);
mysqli_close($link);*/
	 ?>  
<div id="contenedor">
<div id="saludo1"><strong>DETALLE DE FÓRMULA DE <?= $nomFormula; ?></strong></div>
    <form method="post" action="makeDetFormulaMPrima.php" name="form1">
        <input name="idFormulaMPrima" type="hidden" value="<?= $idFormulaMPrima; ?>">
        <div class="row">
            <label class="col-form-label col-3 text-center" for="codMPrima" style="margin: 0 5px 0 0;"><strong>Materia
                    Prima</strong></label>
            <label class="col-form-label col-1 text-center" for="porcentaje" style="margin: 0 5px;"><strong>% en
                    fórmula</strong></label>
            <div class="col-2 text-center">
            </div>
        </div>
        <div class="form-group row">
            <select name="codMPrima" id="codMPrima" class="form-control col-3" style="margin: 0 5px 0 0;">
                <option disabled selected value="">-----------------------------</option>
                <?php
                $mprimas = $DetFormulaMPrimaOperador->getMPrimasFormula($idFormulaMPrima);
                for ($i = 0; $i < count($mprimas); $i++) {
                    echo '<option value="' . $mprimas[$i]["codMPrima"] . '">' . $mprimas[$i]['nomMPrima'] . '</option>';
                }
                echo '</select>';
                ?>
                <input type="text" style="margin: 0 5px;" class="form-control col-1" name="porcentaje"
                       id="porcentaje" onKeyPress="return aceptaNum(event)">
                <div class="col-2 text-center" style="padding: 0 20px;">
                    <button class="button" onclick="return Enviar(this.form)"><span>Adicionar detalle</span>
                    </button>
                </div>
        </div>
    </form>
    <div class="form-group titulo row">
        <strong>Detalle de la fórmula</strong>
    </div>
    <div class="tabla-50">
        <table id="example" class="display compact">
            <thead>
            <tr>
                <th width="20%"></th>
                <th width="40%">Materia Prima</th>
                <th width="20%">Porcentaje</th>
                <th width="20%"></th>
            </tr>
            </thead>
        </table>
    </div>
    <div class="tabla-50">
        <table width="100%">
            <tr>
                <td width="60%" class="text-right text-bold">Total</td>
                <td width="20%" class="text-right text-bold"><?= $porcentajeTotal ?></td>
                <td width="20%"></td>
            </tr>
        </table>
    </div>
    <div class="row">
        <div class="col-1">
            <button class="button" id="back" onclick="window.location='../menu.php'"><span>Terminar</span>
            </button>
        </div>
    </div>
</div>
</body>
</html>