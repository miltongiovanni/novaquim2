<?php
function verTabla($sql, $mysqli)
{
	$result = $mysqli->query($sql);
	$campos=$result->field_count; //para saber el numero de campos de un registro
	$filas=$result->num_rows;
	if ($row = $result->fetch_row())
	{
		echo '<table align="center" summary="Tabla"><tr class="formatoEncabezados">';
		for($i=0; $i<$campos; $i++)
		{
			$info_campo = $result->fetch_field_direct($i);
			echo '<td align="center">'.utf8_encode($info_campo->name).'</td>';
		}
		echo '</tr>';
		$a=1;
		do
		{
			echo'<tr class="formatoDatos">';
			for($i=0; $i<$campos; $i++)
			{
				echo '<td align="center">'.utf8_encode($row[$i]).'</td>';
			}
			echo'</tr>';
		}while ($row = $result->fetch_row());
		echo '</table>';
	}
   $result->free();

/* cerrar la conexión */
$mysqli->close();
}
?>
