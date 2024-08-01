<?php
// Función para cargar las clases
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');

function buscarProveedorForm($action)
{

    $rep = '<form id="form1" name="form1" method="post" action="' . $action . '">
        <div class="mb-3 row">
            <div class="col-2">
                <label class="form-label " for="busProv"><strong>Proveedor</strong></label>
                <input type="text" class="form-control " id="busProv" name="busProv" onkeyup="findProveedor()"
                   required/>
            </div>
        </div>
        <div class="mb-3 row" id="myDiv">
        
        </div>
        <div class="row mb-3">
            <div class="col-1">
                <button class="button" type="button" onclick="return Enviar(this.form)">
                    <span>Continuar</span></button>
            </div>
        </div>
    </form>';
    return $rep;
}

function buscarMPrimaForm($action)
{

    $rep = '<form id="form1" name="form1" method="post" action="' . $action . '">
        <div class="mb-3 row"><label class="form-label col-1" for="codMPrima"><strong>Materia Prima</strong></label>';
    $MPrimasOperador = new MPrimasOperaciones();
    $mprimas = $MPrimasOperador->getMPrimas();
    $filas = count($mprimas);
    $rep .= '<select name="codMPrima" id="codMPrima" class="form-select col-2">';
    $rep .= '<option selected disabled value="">Seleccione una opción</option>';
    for ($i = 0; $i < $filas; $i++) {
        $rep .= '<option value="' . $mprimas[$i]["codMPrima"] . '">' . $mprimas[$i]['nomMPrima'] . '</option>';
    }
    $rep .= '</select>';

    $rep .= '</div>
        <div class="row mb-3">
        <div class="col-1"><button class="button" type="button" onclick="return Enviar(this.form)">
                <span>Continuar</span></button></div>
        </div>
        </form>';
    return $rep;
}

function buscarProorForm($action, $actif)
{

    $rep = '<form id="form1" name="form1" method="post" action="' . $action . '">
        <div class="mb-3 row"><label class="form-label col-1" for="idProv"><strong>Proveedor</strong></label>';
    $ProveedorOperador = new ProveedoresOperaciones();
    $proveedores = $ProveedorOperador->getProveedores($actif);
    $filas = count($proveedores);
    $rep .= '<select name="idProv"  id="idProv" class="form-select col-2">';
    $rep .= '<option selected disabled value="">Seleccione una opción</option>';
    for ($i = 0; $i < $filas; $i++) {
        $rep .= '<option value="' . $proveedores[$i]["idProv"] . '">' . $proveedores[$i]['nomProv'] . '</option>';
    }
    $rep .= '</select>';

    $rep .= '</div>
        <div class="row mb-3">
        <div class="col-1"><button class="button" type="button" onclick="return Enviar(this.form)">
                <span>Continuar</span></button></div>
        </div>
        </form>';
    return $rep;
}