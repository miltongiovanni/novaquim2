<?php
function verTabla($sql, $link)
{
	$result=mysql_query($sql, $link);
	$campos=mysql_num_fields($result); //para saber el numero de campos de un registro
	$filas=mysql_num_rows($result);
	if ($row= mysql_fetch_row($result))
	{
		echo '<table align="center" summary="Tabla"><tr class="formatoEncabezados">';
		for($i=0; $i<$campos; $i++)
		{
			echo '<td align="center">'.mysql_field_name($result,$i).'</td>';
		}
		echo '</tr>';
		$a=1;
		do
		{
			echo'<tr class="formatoDatos"';
	  		if (($a++ % 2)==0) echo ' bgcolor="#B4CBEF" ';
	  		echo '>';
			for($i=0; $i<$campos; $i++)
			{
				echo '<td align="center">'.$row[$i].'</td>';
			}
			echo'</tr>';
		}while ($row = mysql_fetch_row($result));
		echo '</table>';
	}
	mysql_close($link);
}
?>
