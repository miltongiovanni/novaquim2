<?php
// Función para cargar las clases
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');

function buscarCatProdForm($action)
{

    $rep = '<form id="form1" name="form1" method="post" action="' . $action . '">
    <div class="form-group row"><label class="col-form-label col-1" for="combo"><strong>Categoría</strong></label>';
    $manager = new CategoriasProdOperaciones();
    $categorias = $manager->getCatsProd();
    $filas = count($categorias);
    $rep .= '<select name="idCatProd" class="form-control col-2">';
    $rep .= '<option selected value="">-----------------------------</option>';
    for ($i = 0; $i < $filas; $i++) {
        $rep .= '<option value="' . $categorias[$i]["idCatProd"] . '">' . $categorias[$i]['catProd'] . '</option>';
    }
    $rep .= '</select>';

    $rep .= '</div>
    <div class="row form-group">
    <div class="col-1"><button class="button"  onclick="return Enviar(this.form)">
            <span>Continuar</span></button></div>
    </div>
    </form>';
    return $rep;
}

function buscarCatMPForm($action)
{

    $rep = '<form id="form1" name="form1" method="post" action="' . $action . '">
    <div class="form-group row"><label class="col-form-label col-1" for="combo"><strong>Categoría</strong></label>';
    $manager = new CategoriasMPOperaciones();
    $categorias = $manager->getCatsMP();
    $filas = count($categorias);
    $rep .= '<select name="idCatMP" class="form-control col-2">';
    $rep .= '<option selected value="">-----------------------------</option>';
    for ($i = 0; $i < $filas; $i++) {
        $rep .= '<option value="' . $categorias[$i]["idCatMP"] . '">' . $categorias[$i]['catMP'] . '</option>';
    }
    $rep .= '</select>';

    $rep .= '</div>
    <div class="row form-group">
    <div class="col-1"><button class="button"  onclick="return Enviar(this.form)">
            <span>Continuar</span></button></div>
    </div>
    </form>';
    return $rep;
}

function buscarCatDisForm($action)
{

    $rep = '<form id="form1" name="form1" method="post" action="' . $action . '">
    <div class="form-group row"><label class="col-form-label col-1" for="combo"><strong>Categoría</strong></label>';
    $manager = new CategoriasDisOperaciones();
    $categorias = $manager->getCatsDis();
    $filas = count($categorias);
    $rep .= '<select name="idCatDis" class="form-control col-2">';
    $rep .= '<option selected value="">-----------------------------</option>';
    for ($i = 0; $i < $filas; $i++) {
        $rep .= '<option value="' . $categorias[$i]["idCatDis"] . '">' . $categorias[$i]['catDis'] . '</option>';
    }
    $rep .= '</select>';

    $rep .= '</div>
    <div class="row form-group">
    <div class="col-1"><button class="button"  onclick="return Enviar(this.form)">
            <span>Continuar</span></button></div>
    </div>
    </form>';
    return $rep;
}

function buscarProductoForm($action, $actif)
{

    $rep = '<form id="form1" name="form1" method="post" action="' . $action . '">
        <div class="form-group row"><label class="col-form-label col-1" for="combo"><strong>Producto</strong></label>';
    $ProductoOperador = new ProductosOperaciones();
    $productos = $ProductoOperador->getProductos($actif);
    $filas = count($productos);
    $rep .= '<select name="codProducto" class="form-control col-2">';
    $rep .= '<option selected value="">-----------------------------</option>';
    for ($i = 0; $i < $filas; $i++) {
        $rep .= '<option value="' . $productos[$i]["codProducto"] . '">' . $productos[$i]['nomProducto'] . '</option>';
    }
    $rep .= '</select>';

    $rep .= '</div>
        <div class="row form-group">
        <div class="col-1"><button class="button"  onclick="return Enviar(this.form)">
                <span>Continuar</span></button></div>
        </div>
        </form>';
    return $rep;
}

function buscarMPrimaForm($action)
{

    $rep = '<form id="form1" name="form1" method="post" action="' . $action . '">
        <div class="form-group row"><label class="col-form-label col-1" for="combo"><strong>Materia Prima</strong></label>';
    $MPrimasOperador = new MPrimasOperaciones();
    $mprimas = $MPrimasOperador->getMPrimas();
    $filas = count($mprimas);
    $rep .= '<select name="codMPrima" class="form-control col-2">';
    $rep .= '<option selected value="">-----------------------------</option>';
    for ($i = 0; $i < $filas; $i++) {
        $rep .= '<option value="' . $mprimas[$i]["codMPrima"] . '">' . $mprimas[$i]['nomMPrima'] . '</option>';
    }
    $rep .= '</select>';

    $rep .= '</div>
        <div class="row form-group">
        <div class="col-1"><button class="button"  onclick="return Enviar(this.form)">
                <span>Continuar</span></button></div>
        </div>
        </form>';
    return $rep;
}

function buscarEtiquetaForm($action)
{

    $rep = '<form id="form1" name="form1" method="post" action="' . $action . '">
        <div class="form-group row"><label class="col-form-label col-1" for="combo"><strong>Etiqueta</strong></label>';
    $EtiquetasOperador = new EtiquetasOperaciones();
    $etiquetas = $EtiquetasOperador->getEtiquetas();
    $filas = count($etiquetas);
    $rep .= '<select name="codEtiqueta" class="form-control col-2">';
    $rep .= '<option selected value="">-----------------------------</option>';
    for ($i = 0; $i < $filas; $i++) {
        $rep .= '<option value="' . $etiquetas[$i]["codEtiqueta"] . '">' . $etiquetas[$i]['nomEtiqueta'] . '</option>';
    }
    $rep .= '</select>';

    $rep .= '</div>
        <div class="row form-group">
        <div class="col-1"><button class="button"  onclick="return Enviar(this.form)">
                <span>Continuar</span></button></div>
        </div>
        </form>';
    return $rep;
}

function buscarTapaForm($action)
{

    $rep = '<form id="form1" name="form1" method="post" action="' . $action . '">
        <div class="form-group row"><label class="col-form-label col-1" for="combo"><strong>Tapa</strong></label>';
    $TapasOperador = new TapasOperaciones();
    $tapas = $TapasOperador->getTapas();
    $filas = count($tapas);
    $rep .= '<select name="codTapa" class="form-control col-2">';
    $rep .= '<option selected value="">-----------------------------</option>';
    for ($i = 0; $i < $filas; $i++) {
        $rep .= '<option value="' . $tapas[$i]["codTapa"] . '">' . $tapas[$i]['tapa'] . '</option>';
    }
    $rep .= '</select>';

    $rep .= '</div>
        <div class="row form-group">
        <div class="col-1"><button class="button"  onclick="return Enviar(this.form)">
                <span>Continuar</span></button></div>
        </div>
        </form>';
    return $rep;
}

function buscarEnvaseForm($action)
{

    $rep = '<form id="form1" name="form1" method="post" action="' . $action . '">
        <div class="form-group row"><label class="col-form-label col-1" for="combo"><strong>Envase</strong></label>';
    $EnvasesOperador = new EnvasesOperaciones();
    $envases = $EnvasesOperador->getEnvases();
    $filas = count($envases);
    $rep .= '<select name="codEnvase" class="form-control col-2">';
    $rep .= '<option selected value="">-----------------------------</option>';
    for ($i = 0; $i < $filas; $i++) {
        $rep .= '<option value="' . $envases[$i]["codEnvase"] . '">' . $envases[$i]['nomEnvase'] . '</option>';
    }
    $rep .= '</select>';

    $rep .= '</div>
        <div class="row form-group">
        <div class="col-1"><button class="button"  onclick="return Enviar(this.form)">
                <span>Continuar</span></button></div>
        </div>
        </form>';
    return $rep;
}

function buscarPrecioForm($action, $actif)
{

    $rep = '<form id="form1" name="form1" method="post" action="' . $action . '">
        <div class="form-group row"><label class="col-form-label col-1" for="combo"><strong>Producto</strong></label>';
    $PrecioOperador = new PreciosOperaciones();
    $precios = $PrecioOperador->getPrecios($actif);
    $filas = count($precios);
    $rep .= '<select name="codigoGen" class="form-control col-2">';
    $rep .= '<option selected value="">-----------------------------</option>';
    for ($i = 0; $i < $filas; $i++) {
        $rep .= '<option value="' . $precios[$i]["codigoGen"] . '">' . $precios[$i]['producto'] . '</option>';
    }
    $rep .= '</select>';

    $rep .= '</div>
        <div class="row form-group">
        <div class="col-1"><button class="button"  onclick="return Enviar(this.form)">
                <span>Continuar</span></button></div>
        </div>
        </form>';
    return $rep;
}

function buscarPresentacionForm($action, $actif)
{

    $rep = '<form id="form1" name="form1" method="post" action="' . $action . '">
        <div class="form-group row"><label class="col-form-label col-1" for="combo"><strong>Producto</strong></label>';
    $PresentacionOperador = new PresentacionesOperaciones();
    $presentaciones = $PresentacionOperador->getPresentaciones($actif);
    $filas = count($presentaciones);
    $rep .= '<select name="codPresentacion" class="form-control col-3">';
    $rep .= '<option selected value="">----------------------------------------------------</option>';
    for ($i = 0; $i < $filas; $i++) {
        $rep .= '<option value="' . $presentaciones[$i]["codPresentacion"] . '">' . $presentaciones[$i]['presentacion'] . '</option>';
    }
    $rep .= '</select>';

    $rep .= '</div>
        <div class="row form-group">
        <div class="col-1"><button class="button"  onclick="return Enviar(this.form)">
                <span>Continuar</span></button></div>
        </div>
        </form>';
    return $rep;
}