<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">

<head>
    <meta charset="utf-8">
    <title>Seleccionar Materia Prima a Consultar Compra</title>
    <script  src="scripts/validar.js"></script>
    <script  src="scripts/block.js"></script>
</head>

<body>
    <div id="contenedor">
        <div id="saludo"><strong>SELECCIONAR MATERIA PRIMA A CONSULTAR COMPRA</strong></div>
        <table width="100%" border="0">
            <tr>
                <td>
                    <form id="form1" name="form1" method="post" action="listacompraxMP.php">
                        <div align="center"><strong>Materia Prima</strong>
                            <?php
                                include "includes/conect.php";
                                $link=conectarServidor();
                                echo'<select name="IdMP">';
                                $result=mysqli_query($link,"select * from mprimas order by Nom_mprima");
                                echo '<option selected value="">-----------------------------------------------------</option>';
                                while($row=mysqli_fetch_array($result))
                                {
                                    echo '<option value='.$row['Cod_mprima'].'>'.$row['Nom_mprima'].'</option>';
                                }
                                echo'</select>';mysqli_free_result($result);
                                mysqli_close($link);
                                ?>
                            <input type="button" value="Continuar" onClick="return Enviar(this.form);">
                        </div>
                    </form>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <div align="center">&nbsp;</div>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <div align="center">&nbsp;</div>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <div align="center"><input type="button" class="resaltado" onClick="history.back()"
                            value="  VOLVER  "></div>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>