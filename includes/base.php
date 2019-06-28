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
    <div class="col-1"><button class="button" style="vertical-align:middle" onclick="return Enviar(this.form)">
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
    <div class="col-1"><button class="button" style="vertical-align:middle" onclick="return Enviar(this.form)">
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
    <div class="col-1"><button class="button" style="vertical-align:middle" onclick="return Enviar(this.form)">
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
        <div class="col-1"><button class="button" style="vertical-align:middle" onclick="return Enviar(this.form)">
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
        <div class="col-1"><button class="button" style="vertical-align:middle" onclick="return Enviar(this.form)">
                <span>Continuar</span></button></div>
        </div>
        </form>';
    return $rep;
}
