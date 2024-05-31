<?php
// Función para cargar las clases
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');

function buscarCatProdForm($action)
{

    $rep = '<form id="form1" name="form1" method="post" action="' . $action . '">
    <div class="form-group row"><div class="col-1 text-end"> <label class="col-form-label " for="idCatProd"><strong>Categoría</strong></label></div>';
    $manager = new CategoriasProdOperaciones();
    $categorias = $manager->getCatsProd();
    $filas = count($categorias);
    $rep .= '<div class="col-2 px-0"><select name="idCatProd" id="idCatProd" class="form-select " required>';
    $rep .= '<option selected value="">-----------------------------</option>';
    for ($i = 0; $i < $filas; $i++) {
        $rep .= '<option value="' . $categorias[$i]["idCatProd"] . '">' . $categorias[$i]['catProd'] . '</option>';
    }
    $rep .= '</select></div>';

    $rep .= '</div>
    <div class="row form-group">
    <div class="col-1"><button class="button" type="button" onclick="return Enviar(this.form)">
            <span>Continuar</span></button></div>
    </div>
    </form>';
    return $rep;
}

function buscarCatMPForm($action)
{

    $rep = '<form id="form1" name="form1" method="post" action="' . $action . '">
    <div class="form-group row"><div class="col-1 text-end"> <label class="col-form-label " for="idCatMP"><strong>Categoría</strong></label></div>';
    $manager = new CategoriasMPOperaciones();
    $categorias = $manager->getCatsMP();
    $filas = count($categorias);
    $rep .= '<div class="col-2 px-0"> <select name="idCatMP" id="idCatMP" class="form-select " required>';
    $rep .= '<option selected value="">-----------------------------</option>';
    for ($i = 0; $i < $filas; $i++) {
        $rep .= '<option value="' . $categorias[$i]["idCatMP"] . '">' . $categorias[$i]['catMP'] . '</option>';
    }
    $rep .= '</select></div>';

    $rep .= '</div>
    <div class="row form-group">
    <div class="col-1"><button class="button" type="button" onclick="return Enviar(this.form)">
            <span>Continuar</span></button></div>
    </div>
    </form>';
    return $rep;
}

function buscarCatDisForm($action)
{

    $rep = '<form id="form1" name="form1" method="post" action="' . $action . '">
    <div class="form-group row"><div class="col-1 text-end"><label class="col-form-label " for="idCatDis"><strong>Categoría</strong></label></div>';
    $manager = new CategoriasDisOperaciones();
    $categorias = $manager->getCatsDis();
    $filas = count($categorias);
    $rep .= '<div class="col-2 px-0"><select name="idCatDis" id="idCatDis" class="form-select " required>';
    $rep .= '<option selected value="">-----------------------------</option>';
    for ($i = 0; $i < $filas; $i++) {
        $rep .= '<option value="' . $categorias[$i]["idCatDis"] . '">' . $categorias[$i]['catDis'] . '</option>';
    }
    $rep .= '</select></div>';

    $rep .= '</div>
    <div class="row form-group">
    <div class="col-1"><button class="button" type="button" onclick="return Enviar(this.form)">
            <span>Continuar</span></button></div>
    </div>
    </form>';
    return $rep;
}

function buscarProductoForm($action, $actif)
{

    $rep = '<form id="form1" name="form1" method="post" action="' . $action . '">
        <div class="form-group row"><label class="col-form-label col-1 text-end" for="codProducto"><strong>Producto</strong></label>';
    $ProductoOperador = new ProductosOperaciones();
    $productos = $ProductoOperador->getProductos($actif);
    $filas = count($productos);
    $rep .= '<div class="col-2"> <select name="codProducto"  id="codProducto" class="" required>';
    $rep .= '<option></option>';
    for ($i = 0; $i < $filas; $i++) {
        $rep .= '<option value="' . $productos[$i]["codProducto"] . '">' . $productos[$i]['nomProducto'] . '</option>';
    }
    $rep .= '</select></div>';

    $rep .= '</div>
        <div class="row form-group">
        <div class="col-1"><button class="button" type="button" onclick="return Enviar(this.form)">
                <span>Continuar</span></button></div>
        </div>
        </form>';
    return $rep;
}

function buscarMPrimaForm($action)
{

    $rep = '<form id="form1" name="form1" method="post" action="' . $action . '">
        <div class="form-group row"><label class="col-form-label col-1 text-end" for="codMPrima"><strong>Materia Prima</strong></label>';
    $MPrimasOperador = new MPrimasOperaciones();
    $mprimas = $MPrimasOperador->getMPrimas();
    $filas = count($mprimas);
    $rep .= '<div class="col-2"><select name="codMPrima" id="codMPrima" required>';
    $rep .= '<option></option>';
    for ($i = 0; $i < $filas; $i++) {
        $rep .= '<option value="' . $mprimas[$i]["codMPrima"] . '">' . $mprimas[$i]['nomMPrima'] . '</option>';
    }
    $rep .= '</select></div>';

    $rep .= '</div>
        <div class="row form-group">
        <div class="col-1"><button class="button" type="button" onclick="return Enviar(this.form)">
                <span>Continuar</span></button></div>
        </div>
        </form>';
    return $rep;
}

function buscarEtiquetaForm($action)
{

    $rep = '<form id="form1" name="form1" method="post" action="' . $action . '">
        <div class="form-group row"><div class="col-1 text-end"><label class="col-form-label " for="codEtiqueta"><strong>Etiqueta</strong></label></div>';
    $EtiquetasOperador = new EtiquetasOperaciones();
    $etiquetas = $EtiquetasOperador->getEtiquetas();
    $filas = count($etiquetas);
    $rep .= '<div class="col-2 px-0"><select name="codEtiqueta" id="codEtiqueta" class="form-control " required>';
    $rep .= '<option selected value="">-----------------------------</option>';
    for ($i = 0; $i < $filas; $i++) {
        $rep .= '<option value="' . $etiquetas[$i]["codEtiqueta"] . '">' . $etiquetas[$i]['nomEtiqueta'] . '</option>';
    }
    $rep .= '</select></div>';

    $rep .= '</div>
        <div class="row form-group">
        <div class="col-1"><button class="button" type="button" onclick="return Enviar(this.form)">
                <span>Continuar</span></button></div>
        </div>
        </form>';
    return $rep;
}

function buscarTapaForm($action)
{

    $rep = '<form id="form1" name="form1" method="post" action="' . $action . '">
        <div class="form-group row"><div class="col-1 text-end"><label class="col-form-label " for="codTapa"><strong>Tapa</strong></label></div>';
    $TapasOperador = new TapasOperaciones();
    $tapas = $TapasOperador->getTapas();
    $filas = count($tapas);
    $rep .= '<div class="col-2 px-0"><select name="codTapa" id="codTapa" class="form-control " required>';
    $rep .= '<option selected value="">-----------------------------</option>';
    for ($i = 0; $i < $filas; $i++) {
        $rep .= '<option value="' . $tapas[$i]["codTapa"] . '">' . $tapas[$i]['tapa'] . '</option>';
    }
    $rep .= '</select></div>';

    $rep .= '</div>
        <div class="row form-group">
        <div class="col-1"><button class="button" type="button" onclick="return Enviar(this.form)">
                <span>Continuar</span></button></div>
        </div>
        </form>';
    return $rep;
}

function buscarEnvaseForm($action)
{

    $rep = '<form id="form1" name="form1" method="post" action="' . $action . '">
        <div class="form-group row"><div class="col-1 text-end"><label class="col-form-label " for="codEnvase"><strong>Envase</strong></label></div>';
    $EnvasesOperador = new EnvasesOperaciones();
    $envases = $EnvasesOperador->getEnvases();
    $filas = count($envases);
    $rep .= '<div class="col-2 px-0"><select name="codEnvase" id="codEnvase" class="form-control " required>';
    $rep .= '<option selected value="">-----------------------------</option>';
    for ($i = 0; $i < $filas; $i++) {
        $rep .= '<option value="' . $envases[$i]["codEnvase"] . '">' . $envases[$i]['nomEnvase'] . '</option>';
    }
    $rep .= '</select></div>';

    $rep .= '</div>
        <div class="row form-group">
        <div class="col-1"><button class="button" type="button" onclick="return Enviar(this.form)">
                <span>Continuar</span></button></div>
        </div>
        </form>';
    return $rep;
}

function buscarPrecioForm($action, $actif)
{

    $rep = '<form id="form1" name="form1" method="post" action="' . $action . '">
        <div class="form-group row"><div class="col-1 text-end"><label class="col-form-label " for="codigoGen"><strong>Producto</strong></label></div>';
    $PrecioOperador = new PreciosOperaciones();
    $precios = $PrecioOperador->getPrecios($actif);
    $filas = count($precios);
    $rep .= '<div class="col-3 px-0"><select name="codigoGen" id="codigoGen" class="form-control " required>';
    $rep .= '<option selected value="">-----------------------------</option>';
    for ($i = 0; $i < $filas; $i++) {
        $rep .= '<option value="' . $precios[$i]["codigoGen"] . '">' . $precios[$i]['producto'] . '</option>';
    }
    $rep .= '</select></div>';

    $rep .= '</div>
        <div class="row form-group">
        <div class="col-1"><button class="button" type="button" onclick="return Enviar(this.form)">
                <span>Continuar</span></button></div>
        </div>
        </form>';
    return $rep;
}

function buscarPresentacionForm($action, $actif)
{

    $rep = '<form id="form1" name="form1" method="post" action="' . $action . '">
        <div class="form-group row"><div class="col-1 text-end"><label class="col-form-label " for="codPresentacion"><strong>Producto</strong></label></div>';
    $PresentacionOperador = new PresentacionesOperaciones();
    $presentaciones = $PresentacionOperador->getPresentaciones($actif);
    $filas = count($presentaciones);
    $rep .= '<div class="col-4 px-0"> <select name="codPresentacion" id="codPresentacion" data-error="Por favor seleccione la presentación"  style="width: 100%" required>';
    $rep .= '<option></option>';
    for ($i = 0; $i < $filas; $i++) {
        $rep .= '<option value="' . $presentaciones[$i]["codPresentacion"] . '">' . $presentaciones[$i]['presentacion'] . '</option>';
    }
    $rep .= '</select></div>';

    $rep .= '</div>
        <div class="row form-group">
        <div class="col-1"><button class="button" type="button" onclick="return Enviar(this.form)">
                <span>Continuar</span></button></div>
        </div>
        </form>';
    return $rep;
}

function buscarProductoDistribucionForm($action, $actif)
{

    $rep = '<form id="form1" name="form1" method="post" action="' . $action . '">
        <div class="form-group row"><div class="col-1 text-end"><label class="col-form-label " for="idDistribucion"><strong>Producto</strong></label></div>';
    $ProductoDistribucionOperador = new ProductosDistribucionOperaciones();
    $productos = $ProductoDistribucionOperador->getProductosDistribucion($actif);
    $filas = count($productos);
    $rep .= '<div class="col-4 px-0"><select name="idDistribucion" id="idDistribucion" data-error="Por favor seleccione un producto de distribución" class="form-control " required>';
    $rep .= '<option></option>';
    for ($i = 0; $i < $filas; $i++) {
        $rep .= '<option value="' . $productos[$i]["idDistribucion"] . '">' . $productos[$i]['producto'] . '</option>';
    }
    $rep .= '</select></div>';

    $rep .= '</div>
        <div class="row form-group">
        <div class="col-1"><button class="button" type="button" onclick="return Enviar(this.form)">
                <span>Continuar</span></button></div>
        </div>
        </form>';
    return $rep;
}

function buscarServicioForm($action, $actif)
{

    $rep = '<form id="form1" name="form1" method="post" action="' . $action . '">
        <div class="form-group row"><div class="col-1 text-end"><label class="col-form-label " for="idServicio"><strong>Servicio</strong></label></div>';
    $servicioperador = new ServiciosOperaciones();
    $servicios = $servicioperador->getServicios($actif);
    $filas = count($servicios);
    $rep .= '<div class="col-2"><select name="idServicio" id="idServicio" class="form-control " required>';
    $rep .= '<option selected value="">-----------------------------</option>';
    for ($i = 0; $i < $filas; $i++) {
        $rep .= '<option value="' . $servicios[$i]["idServicio"] . '">' . $servicios[$i]['desServicio'] . '</option>';
    }
    $rep .= '</select></div>';

    $rep .= '</div>
        <div class="row form-group">
        <div class="col-1"><button class="button" type="button" onclick="return Enviar(this.form)">
                <span>Continuar</span></button></div>
        </div>
        </form>';
    return $rep;
}

function buscarRelEnvDisForm($action)
{

    $rep = '<form id="form1" name="form1" method="post" action="' . $action . '">
        <div class="form-group row"><div class="col-1 text-end"><label class="col-form-label " for="idEnvDis"><strong>Relación</strong></label></div>';
    $relEnvDisOperador = new RelEnvDisOperaciones();
    $relaciones = $relEnvDisOperador->getRelsEnvDis();
    $filas = count($relaciones);
    $rep .= '<div class="col-2 px-0"><select name="idEnvDis" id="idEnvDis" class="form-control " required>';
    $rep .= '<option selected value="">-----------------------------</option>';
    for ($i = 0; $i < $filas; $i++) {
        $rep .= '<option value="' . $relaciones[$i]["idEnvDis"] . '">' . $relaciones[$i]['producto'] . '</option>';
    }
    $rep .= '</select></div>';

    $rep .= '</div>
        <div class="row form-group">
        <div class="col-1"><button class="button" type="button"  onclick="return Enviar(this.form)">
                <span>Continuar</span></button></div>
        </div>
        </form>';
    return $rep;
}

function buscarRelPacProdForm($action)
{

    $rep = '<form id="form1" name="form1" method="post" action="' . $action . '">
        <div class="form-group row"><div class="col-1 text-end"><label class="col-form-label " for="idPacUn"><strong>Relación</strong></label></div>';
    $relDisEmpOperador = new RelDisEmpOperaciones();
    $relaciones = $relDisEmpOperador->getRelsDisEmp();
    $filas = count($relaciones);
    $rep .= '<div class="col-3 px-0"><select name="idPacUn" id="idPacUn" class="form-control " required>';
    $rep .= '<option selected value="">-----------------------------</option>';
    for ($i = 0; $i < $filas; $i++) {
        $rep .= '<option value="' . $relaciones[$i]["idPacUn"] . '">' . $relaciones[$i]['producto'] . '</option>';
    }
    $rep .= '</select></div>';

    $rep .= '</div>
        <div class="row form-group">
        <div class="col-1"><button class="button" type="button" onclick="return Enviar(this.form)">
                <span>Continuar</span></button></div>
        </div>
        </form>';
    return $rep;
}

function buscarCatProvForm($action)
{

    $rep = '<form id="form1" name="form1" method="post" action="' . $action . '">
    <div class="form-group row"><div class="col-1 text-end"><label class="col-form-label " for="idCatProv"><strong>Categoría</strong></label></div>';
    $manager = new CategoriasProvOperaciones();
    $categorias = $manager->getCatsProv();
    $filas = count($categorias);
    $rep .= '<div class="col-2 px-0"><select name="idCatProv" id="idCatProv" class="form-control " required>';
    $rep .= '<option selected value="">-----------------------------</option>';
    for ($i = 0; $i < $filas; $i++) {
        $rep .= '<option value="' . $categorias[$i]["idCatProv"] . '">' . $categorias[$i]['desCatProv'] . '</option>';
    }
    $rep .= '</select></div>';

    $rep .= '</div>
    <div class="row form-group">
    <div class="col-1"><button class="button" type="button" onclick="return Enviar(this.form)">
            <span>Continuar</span></button></div>
    </div>
    </form>';
    return $rep;
}
function buscarCatCliForm($action)
{

    $rep = '<form id="form1" name="form1" method="post" action="' . $action . '">
    <div class="form-group row"><div class="col-1 text-end"><label class="col-form-label " for="idCatClien"><strong>Categoría</strong></label></div>';
    $manager = new CategoriasCliOperaciones();
    $categorias = $manager->getCatsCli();
    $filas = count($categorias);
    $rep .= '<div class="col-2 px-0"><select name="idCatClien" id="idCatClien" class="form-control " required>';
    $rep .= '<option selected value="">-----------------------------</option>';
    for ($i = 0; $i < $filas; $i++) {
        $rep .= '<option value="' . $categorias[$i]["idCatClien"] . '">' . $categorias[$i]['desCatClien'] . '</option>';
    }
    $rep .= '</select></div>';

    $rep .= '</div>
    <div class="row form-group">
    <div class="col-1"><button class="button" type="button" onclick="return Enviar(this.form)">
            <span>Continuar</span></button></div>
    </div>
    </form>';
    return $rep;
}