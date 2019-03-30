<?php
function verTabla($datos)
{
	$encabezados=array_keys($datos[0]);
	$campos=count($encabezados)/2; //para saber el numero de campos de un registro
	$filas=count($datos);
	echo '<table summary="Tabla"><tr class="formatoEncabezados">';
	for($i=0; $i<$campos; $i++)
	{
		echo '<th>'.($encabezados[2*$i]).'</th>';
	}
	echo '</tr>';
	$a=1;
	for($i=0; $i<$filas; $i++)
	{
		echo'<tr class="formatoDatos">';
		for($j=0; $j<$campos; $j++)
		{
			echo '<td>'.($datos[$i][$j]).'</td>';
		}
		echo'</tr>';
	}
	echo '</table>';
}
?>
