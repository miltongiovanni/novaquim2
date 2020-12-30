<?php
include "../includes/valAcc.php";

// On enregistre notre autoload.
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$idNotaC = $_POST['idNotaC'];
$notaCrOperador = new NotasCreditoOperaciones();
if (!$notaCrOperador->isValidIdNotaC($idNotaC)) {
    echo ' <script >
				alert("El número de la nota de crédito no es válido, vuelva a intentar de nuevo");
				history.back();
			</script>';
    exit();
} else {
    $notaC = $notaCrOperador->getNotaC($idNotaC);
    $facturaOperador = new FacturasOperaciones();
    $facturas = $facturaOperador->getFacturasClienteForNotas($notaC['idCliente']);
}


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Modificación Nota Crédito</title>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../js/validar.js"></script>
</head>
<body>

<div id="contenedor">
    <div id="saludo"><strong> NOTA CRÉDITO PARA <?= $notaC['nomCliente'] ?></strong></div>
    <form name="form2" method="POST" action="updateNotaC.php">
        <div class="form-group row">
            <label class="col-form-label col-2" for="idNotaC"><strong>Nota Crédito</strong></label>
            <input name="idNotaC" id="idNotaC" class="form-control col-2" value="<?= $notaC['idNotaC'] ?>" readonly>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-2" for="motivo"><strong>Razón de la Nota</strong></label>
            <select name="motivo" size="1" id="motivo" class="form-control col-2">
                <option value="0" <?= $notaC['motivo'] == 0 ? 'selected' : '' ?>>Devolución de Productos</option>
                <option value="1"<?= $notaC['motivo'] == 1 ? 'selected' : '' ?>>Descuento no aplicado</option>
            </select>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-2" for="facturaOrigen"><strong>Factura origen de la
                    Nota</strong></label>
            <select name="facturaOrigen" id="facturaOrigen" class="form-control col-2" required>
                <option value="<?= $notaC['facturaOrigen'] ?>" selected><?= $notaC['facturaOrigen'] ?></option>
                <?php
                for ($i = 0; $i < count($facturas); $i++):
                    if ($facturas[$i] != $notaC['facturaOrigen']):
                        ?>
                        <option value="<?= $facturas[$i]['idFactura'] ?>"><?= $facturas[$i]['idFactura'] ?></option>
                    <?php
                    endif;
                endfor;
                ?>
            </select>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-2" for="facturaDestino"><strong>Factura destino de la
                    Nota</strong></label>
            <select name="facturaDestino" id="facturaDestino" class="form-control col-2" required>
                <option value="<?= $notaC['facturaDestino'] ?>" selected><?= $notaC['facturaDestino'] ?></option>
                <?php
                for ($i = 0; $i < count($facturas); $i++):
                    if ($facturas[$i] != $notaC['facturaDestino']):
                        ?>
                        <option value="<?= $facturas[$i]['idFactura'] ?>"><?= $facturas[$i]['idFactura'] ?></option>
                    <?php
                    endif;
                endfor;
                ?>
            </select>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-2 text-right" for="fechaNotaC"><strong>Fecha Nota Crédito</strong></label>
            <input type="date" class="form-control col-2" name="fechaNotaC" id="fechaNotaC"
                   value="<?= $notaC['fechaNotaC'] ?>" required>
        </div>
        <div class="row form-group">
            <div class="col-1">
                <button class="button" onclick="return Enviar(this.form)">
                    <span>Continuar</span></button>
            </div>
        </div>
    </form>
    <div class="row form-group">
        <div class="col-1">
            <button class="button1" onclick="history.back()">
                <span>VOLVER</span></button>
        </div>
    </div>
    <!--  <table align="center" border="0" summary="cuerpo">
            <tr>

                <td width="170">
                    <div align="right"><strong>Razón de la Nota</strong></div>
                </td>
                <td colspan="2">
                    <?php /*if ($motivo == 0)
                        echo '<select name="razon" size="1">
              <option value="0" selected>Devolución de Productos</option>
              <option value="1">Descuento no aplicado</option>
        		</select>';
                    else
                        echo '<select name="razon" size="1">
              <option value="1" selected>Descuento no aplicado</option>
              <option value="0">Devolución de Productos</option>
        		</select>'
                    */ ?>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <div align="right"><strong>Factura por la cual se origina la Nota</strong></div>
                </td>
                <td width="89"><?php
    /*                    echo '<select name="fact_ori" id="fact_origen">';
                        $result = mysqli_query($link, "select idFactura from factura where Nit_cliente='$cliente' and Estado<>'A' order by idFactura DESC");
                        echo '<option selected value="' . $Fac_orig . '">' . $Fac_orig . '</option>';
                        while ($row = mysqli_fetch_array($result)) {
                            if ($row['Factura'] != $Fac_orig)
                                echo '<option value=' . $row['Factura'] . '>' . $row['Factura'] . '</option>';
                        }
                        echo '</select>';
                        */ ?>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <div align="right"><strong>Factura a la cual afecta la Nota</strong></div>
                </td>
                <td><?php
    /*                    echo '<select name="fact_des" id="fact_destino">';
                        $result = mysqli_query($link, "select idFactura from factura where Nit_cliente='$cliente' order by idFactura DESC");
                        echo '<option selected value="' . $Fac_dest . '">' . $Fac_dest . '</option>';
                        while ($row = mysqli_fetch_array($result)) {
                            if ($row['Factura'] != $Fac_dest)
                                echo '<option value=' . $row['Factura'] . '>' . $row['Factura'] . '</option>';
                        }
                        echo '</select>';
                        mysqli_free_result($result);
                        /* cerrar la conexi�n */
    ?>
                </td>
            </tr>
            <tr>
                <td align="right"><strong>Fecha Nota Crédito</strong></td>
                <td colspan="2"><input type="text" name="Fecha" id="sel1" readonly size=17
                                       value="<?php /*echo $Fecha; */ ?>"><input type="reset" value=" ... "
                                                                            onclick="return showCalendar('sel1', '%Y-%m-%d', '12', true);">
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <div align="center">&nbsp;</div>
                </td>
            </tr>
            <tr>
                <td><input name="nota" type="hidden" value="<?php /*echo $mensaje; */ ?>"><input name="crear" type="hidden"
                                                                                            value="6"></td>
                <td width="110" colspan="1">
                    <div align="right">
                        <input type="reset" value="   Reiniciar   ">
                    </div>
                </td>
                <td colspan="1" align="center"><input type="button" value="Continuar"
                                                      onClick="return Enviar(this.form);"></td>
            </tr>
            <tr>
                <td colspan="3">
                    <div align="center">&nbsp;</div>
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <div align="center">&nbsp;</div>
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <div align="center"><input type="button" class="resaltado" onClick="history.back()"
                                               value="  VOLVER  "></div>
                </td>
            </tr>
        </table>
    </form>-->
</div>
</body>
</html>

