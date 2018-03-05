<?php
function verTabla($sql, $link)
{
	$result=mysqli_query($link, $sql);
	$campos=mysqli_num_fields($result); //para saber el numero de campos de un registro
	$filas=mysqli_num_rows($result);
	if ($row= mysqli_fetch_row($result))
	{
		echo '<table align="center" summary="Tabla"><tr class="formatoEncabezados">';
		for($i=0; $i<$campos; $i++)
		{
			$info_campo = mysqli_fetch_field_direct($result, $i);
			echo '<td align="center">'.utf8_encode($info_campo->name).'</td>';
		}
		echo '</tr>';
		$a=1;
		do
		{
			echo'<tr class="formatoDatos"';
	  		if (($a++ % 2)==0) echo ' bgcolor="#DFE2FD" ';
	  		echo '>';
			for($i=0; $i<$campos; $i++)
			{
				echo '<td align="center">'.utf8_encode($row[$i]).'</td>';
			}
			echo'</tr>';
		}while ($row = mysqli_fetch_row($result));
		echo '</table>';
	}
   mysqli_free_result($result);

/* cerrar la conexión */
mysqli_close($link);
}
?>
