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
    <div class="mb-3 row"><div class="col-2"> <label class="form-label " for="idCatProd"><strong>Categoría</strong></label>';
    $manager = new CategoriasProdOperaciones();
    $categorias = $manager->getCatsProd();
    $filas = count($categorias);
    $rep .= '<select name="idCatProd" id="idCatProd" class="form-select " required>';
    $rep .= '<option selected disabled value="">Seleccione una opción</option>';
    for ($i = 0; $i < $filas; $i++) {
        $rep .= '<option value="' . $categorias[$i]["idCatProd"] . '">' . $categorias[$i]['catProd'] . '</option>';
    }
    $rep .= '</select></div>';

    $rep .= '</div>
    <div class="row mb-3">
    <div class="col-1"><button class="button" type="button" onclick="return Enviar(this.form)">
            <span>Continuar</span></button></div>
    </div>
    </form>';
    return $rep;
}

function buscarCatMPForm($action)
{

    $rep = '<form id="form1" name="form1" method="post" action="' . $action . '">
    <div class="mb-3 row"><div class="col-2"> <label class="form-label " for="idCatMP"><strong>Categoría</strong></label>';
    $manager = new CategoriasMPOperaciones();
    $categorias = $manager->getCatsMP();
    $filas = count($categorias);
    $rep .= '<select name="idCatMP" id="idCatMP" class="form-select " required>';
    $rep .= '<option selected disabled value="">Seleccione una opción</option>';
    for ($i = 0; $i < $filas; $i++) {
        $rep .= '<option value="' . $categorias[$i]["idCatMP"] . '">' . $categorias[$i]['catMP'] . '</option>';
    }
    $rep .= '</select></div>';

    $rep .= '</div>
    <div class="row mb-3">
    <div class="col-1"><button class="button" type="button" onclick="return Enviar(this.form)">
            <span>Continuar</span></button></div>
    </div>
    </form>';
    return $rep;
}

function buscarCatDisForm($action)
{

    $rep = '<form id="form1" name="form1" method="post" action="' . $action . '">
    <div class="mb-3 row"><div class="col-2"><label class="form-label " for="idCatDis"><strong>Categoría</strong></label>';
    $manager = new CategoriasDisOperaciones();
    $categorias = $manager->getCatsDis();
    $filas = count($categorias);
    $rep .= '<select name="idCatDis" id="idCatDis" class="form-select " required>';
    $rep .= '<option selected disabled value="">Seleccione una opción</option>';
    for ($i = 0; $i < $filas; $i++) {
        $rep .= '<option value="' . $categorias[$i]["idCatDis"] . '">' . $categorias[$i]['catDis'] . '</option>';
    }
    $rep .= '</select></div>';

    $rep .= '</div>
    <div class="row mb-3">
    <div class="col-1"><button class="button" type="button" onclick="return Enviar(this.form)">
            <span>Continuar</span></button></div>
    </div>
    </form>';
    return $rep;
}

function buscarProductoForm($action, $actif)
{

    $rep = '<form id="form1" name="form1" method="post" action="' . $action . '">
        <div class="mb-3 row"><div class="col-2"><label class="form-label" for="codProducto"><strong>Producto</strong></label>';
    $ProductoOperador = new ProductosOperaciones();
    $productos = $ProductoOperador->getProductos($actif);
    $filas = count($productos);
    $rep .= '<select name="codProducto"  id="codProducto" class="" required>';
    $rep .= '<option></option>';
    for ($i = 0; $i < $filas; $i++) {
        $rep .= '<option value="' . $productos[$i]["codProducto"] . '">' . $productos[$i]['nomProducto'] . '</option>';
    }
    $rep .= '</select></div>';

    $rep .= '</div>
        <div class="row mb-3">
        <div class="col-1"><button class="button" type="button" onclick="return Enviar(this.form)">
                <span>Continuar</span></button></div>
        </div>
        </form>';
    return $rep;
}

function buscarMPrimaForm($action)
{

    $rep = '<form id="form1" name="form1" method="post" action="' . $action . '">
        <div class="mb-3 row"><div class="col-2"><label class="form-label" for="codMPrima"><strong>Materia Prima</strong></label>';
    $MPrimasOperador = new MPrimasOperaciones();
    $mprimas = $MPrimasOperador->getMPrimas();
    $filas = count($mprimas);
    $rep .= '<select name="codMPrima" id="codMPrima" required>';
    $rep .= '<option></option>';
    for ($i = 0; $i < $filas; $i++) {
        $rep .= '<option value="' . $mprimas[$i]["codMPrima"] . '">' . $mprimas[$i]['nomMPrima'] . '</option>';
    }
    $rep .= '</select></div>';

    $rep .= '</div>
        <div class="row mb-3">
        <div class="col-1"><button class="button" type="button" onclick="return Enviar(this.form)">
                <span>Continuar</span></button></div>
        </div>
        </form>';
    return $rep;
}

function buscarEtiquetaForm($action)
{

    $rep = '<form id="form1" name="form1" method="post" action="' . $action . '">
        <div class="mb-3 row"><div class="col-4"><label class="form-label " for="codEtiqueta"><strong>Etiqueta</strong></label>';
    $EtiquetasOperador = new EtiquetasOperaciones();
    $etiquetas = $EtiquetasOperador->getEtiquetas();
    $filas = count($etiquetas);
    $rep .= '<select name="codEtiqueta" id="codEtiqueta" class="form-control " required>';
    $rep .= '<option selected disabled value="">Seleccione una opción</option>';
    for ($i = 0; $i < $filas; $i++) {
        $rep .= '<option value="' . $etiquetas[$i]["codEtiqueta"] . '">' . $etiquetas[$i]['nomEtiqueta'] . '</option>';
    }
    $rep .= '</select></div>';

    $rep .= '</div>
        <div class="row mb-3">
        <div class="col-1"><button class="button" type="button" onclick="return Enviar(this.form)">
                <span>Continuar</span></button></div>
        </div>
        </form>';
    return $rep;
}

function buscarTapaForm($action)
{

    $rep = '<form id="form1" name="form1" method="post" action="' . $action . '">
        <div class="mb-3 row"><div class="col-3"><label class="form-label " for="codTapa"><strong>Tapa</strong></label>';
    $TapasOperador = new TapasOperaciones();
    $tapas = $TapasOperador->getTapas();
    $filas = count($tapas);
    $rep .= '<select name="codTapa" id="codTapa" class="form-control " required>';
    $rep .= '<option selected disabled value="">Seleccione una opción</option>';
    for ($i = 0; $i < $filas; $i++) {
        $rep .= '<option value="' . $tapas[$i]["codTapa"] . '">' . $tapas[$i]['tapa'] . '</option>';
    }
    $rep .= '</select></div>';

    $rep .= '</div>
        <div class="row mb-3">
        <div class="col-1"><button class="button" type="button" onclick="return Enviar(this.form)">
                <span>Continuar</span></button></div>
        </div>
        </form>';
    return $rep;
}

function buscarEnvaseForm($action)
{

    $rep = '<form id="form1" name="form1" method="post" action="' . $action . '">
        <div class="mb-3 row"><div class="col-3"><label class="form-label " for="codEnvase"><strong>Envase</strong></label>';
    $EnvasesOperador = new EnvasesOperaciones();
    $envases = $EnvasesOperador->getEnvases();
    $filas = count($envases);
    $rep .= '<select name="codEnvase" id="codEnvase" class="form-control " required>';
    $rep .= '<option selected disabled value="">Seleccione una opción</option>';
    for ($i = 0; $i < $filas; $i++) {
        $rep .= '<option value="' . $envases[$i]["codEnvase"] . '">' . $envases[$i]['nomEnvase'] . '</option>';
    }
    $rep .= '</select></div>';

    $rep .= '</div>
        <div class="row mb-3">
        <div class="col-1"><button class="button" type="button" onclick="return Enviar(this.form)">
                <span>Continuar</span></button></div>
        </div>
        </form>';
    return $rep;
}

function buscarPrecioForm($action, $actif)
{

    $rep = '<form id="form1" name="form1" method="post" action="' . $action . '">
        <div class="mb-3 row"><div class="col-4"><label class="form-label " for="codigoGen"><strong>Producto</strong></label>';
    $PrecioOperador = new PreciosOperaciones();
    $precios = $PrecioOperador->getPrecios($actif);
    $filas = count($precios);
    $rep .= '<select name="codigoGen" id="codigoGen" class="form-control " required>';
    $rep .= '<option selected disabled value="">Seleccione una opción</option>';
    for ($i = 0; $i < $filas; $i++) {
        $rep .= '<option value="' . $precios[$i]["codigoGen"] . '">' . $precios[$i]['producto'] . '</option>';
    }
    $rep .= '</select></div>';

    $rep .= '</div>
        <div class="row mb-3">
        <div class="col-1"><button class="button" type="button" onclick="return Enviar(this.form)">
                <span>Continuar</span></button></div>
        </div>
        </form>';
    return $rep;
}

function buscarPresentacionForm($action, $actif)
{

    $rep = '<form id="form1" name="form1" method="post" action="' . $action . '">
        <div class="mb-3 row"><div class="col-4"><label class="form-label " for="codPresentacion"><strong>Producto</strong></label>';
    $PresentacionOperador = new PresentacionesOperaciones();
    $presentaciones = $PresentacionOperador->getPresentaciones($actif);
    $filas = count($presentaciones);
    $rep .= '<select name="codPresentacion" id="codPresentacion" data-error="Por favor seleccione la presentación"  style="width: 100%" required>';
    $rep .= '<option></option>';
    for ($i = 0; $i < $filas; $i++) {
        $rep .= '<option value="' . $presentaciones[$i]["codPresentacion"] . '">' . $presentaciones[$i]['presentacion'] . '</option>';
    }
    $rep .= '</select></div>';

    $rep .= '</div>
        <div class="row mb-3">
        <div class="col-1"><button class="button" type="button" onclick="return Enviar(this.form)">
                <span>Continuar</span></button></div>
        </div>
        </form>';
    return $rep;
}

function buscarProductoDistribucionForm($action, $actif)
{

    $rep = '<form id="form1" name="form1" method="post" action="' . $action . '">
        <div class="mb-3 row"><div class="col-4"><label class="form-label " for="idDistribucion"><strong>Producto</strong></label>';
    $ProductoDistribucionOperador = new ProductosDistribucionOperaciones();
    $productos = $ProductoDistribucionOperador->getProductosDistribucion($actif);
    $filas = count($productos);
    $rep .= '<select name="idDistribucion" id="idDistribucion" data-error="Por favor seleccione un producto de distribución" class="form-control " required>';
    $rep .= '<option></option>';
    for ($i = 0; $i < $filas; $i++) {
        $rep .= '<option value="' . $productos[$i]["idDistribucion"] . '">' . $productos[$i]['producto'] . '</option>';
    }
    $rep .= '</select></div>';

    $rep .= '</div>
        <div class="row mb-3">
        <div class="col-1"><button class="button" type="button" onclick="return Enviar(this.form)">
                <span>Continuar</span></button></div>
        </div>
        </form>';
    return $rep;
}

function buscarServicioForm($action, $actif)
{

    $rep = '<form id="form1" name="form1" method="post" action="' . $action . '">
        <div class="mb-3 row"><div class="col-2"><label class="form-label " for="idServicio"><strong>Servicio</strong></label>';
    $servicioperador = new ServiciosOperaciones();
    $servicios = $servicioperador->getServicios($actif);
    $filas = count($servicios);
    $rep .= '<select name="idServicio" id="idServicio" class="form-control " required>';
    $rep .= '<option selected disabled value="">Seleccione una opción</option>';
    for ($i = 0; $i < $filas; $i++) {
        $rep .= '<option value="' . $servicios[$i]["idServicio"] . '">' . $servicios[$i]['desServicio'] . '</option>';
    }
    $rep .= '</select></div>';

    $rep .= '</div>
        <div class="row mb-3">
        <div class="col-1"><button class="button" type="button" onclick="return Enviar(this.form)">
                <span>Continuar</span></button></div>
        </div>
        </form>';
    return $rep;
}

function buscarRelEnvDisForm($action)
{

    $rep = '<form id="form1" name="form1" method="post" action="' . $action . '">
        <div class="mb-3 row"><div class="col-3"><label class="form-label " for="idEnvDis"><strong>Relación</strong></label>';
    $relEnvDisOperador = new RelEnvDisOperaciones();
    $relaciones = $relEnvDisOperador->getRelsEnvDis();
    $filas = count($relaciones);
    $rep .= '<select name="idEnvDis" id="idEnvDis" class="form-control " required>';
    $rep .= '<option selected disabled value="">Seleccione una opción</option>';
    for ($i = 0; $i < $filas; $i++) {
        $rep .= '<option value="' . $relaciones[$i]["idEnvDis"] . '">' . $relaciones[$i]['producto'] . '</option>';
    }
    $rep .= '</select></div>';

    $rep .= '</div>
        <div class="row mb-3">
        <div class="col-1"><button class="button" type="button"  onclick="return Enviar(this.form)">
                <span>Continuar</span></button></div>
        </div>
        </form>';
    return $rep;
}

function buscarRelPacProdForm($action)
{

    $rep = '<form id="form1" name="form1" method="post" action="' . $action . '">
        <div class="mb-3 row"><div class="col-4"><label class="form-label " for="idPacUn"><strong>Relación</strong></label>';
    $relDisEmpOperador = new RelDisEmpOperaciones();
    $relaciones = $relDisEmpOperador->getRelsDisEmp();
    $filas = count($relaciones);
    $rep .= '<select name="idPacUn" id="idPacUn" class="form-control " required>';
    $rep .= '<option selected disabled value="">Seleccione una opción</option>';
    for ($i = 0; $i < $filas; $i++) {
        $rep .= '<option value="' . $relaciones[$i]["idPacUn"] . '">' . $relaciones[$i]['producto'] . '</option>';
    }
    $rep .= '</select></div>';

    $rep .= '</div>
        <div class="row mb-3">
        <div class="col-1"><button class="button" type="button" onclick="return Enviar(this.form)">
                <span>Continuar</span></button></div>
        </div>
        </form>';
    return $rep;
}

function buscarCatProvForm($action)
{

    $rep = '<form id="form1" name="form1" method="post" action="' . $action . '">
    <div class="mb-3 row"><div class="col-2"><label class="form-label " for="idCatProv"><strong>Categoría</strong></label>';
    $manager = new CategoriasProvOperaciones();
    $categorias = $manager->getCatsProv();
    $filas = count($categorias);
    $rep .= '<select name="idCatProv" id="idCatProv" class="form-control " required>';
    $rep .= '<option selected disabled value="">Seleccione una opción</option>';
    for ($i = 0; $i < $filas; $i++) {
        $rep .= '<option value="' . $categorias[$i]["idCatProv"] . '">' . $categorias[$i]['desCatProv'] . '</option>';
    }
    $rep .= '</select></div>';

    $rep .= '</div>
    <div class="row mb-3">
    <div class="col-1"><button class="button" type="button" onclick="return Enviar(this.form)">
            <span>Continuar</span></button></div>
    </div>
    </form>';
    return $rep;
}
function buscarCatCliForm($action)
{

    $rep = '<form id="form1" name="form1" method="post" action="' . $action . '">
    <div class="mb-3 row"><div class="col-3"><label class="form-label " for="idCatClien"><strong>Categoría</strong></label>';
    $manager = new CategoriasCliOperaciones();
    $categorias = $manager->getCatsCli();
    $filas = count($categorias);
    $rep .= '<select name="idCatClien" id="idCatClien" class="form-control " required>';
    $rep .= '<option selected disabled value="">Seleccione una opción</option>';
    for ($i = 0; $i < $filas; $i++) {
        $rep .= '<option value="' . $categorias[$i]["idCatClien"] . '">' . $categorias[$i]['desCatClien'] . '</option>';
    }
    $rep .= '</select></div>';

    $rep .= '</div>
    <div class="row mb-3">
    <div class="col-1"><button class="button" type="button" onclick="return Enviar(this.form)">
            <span>Continuar</span></button></div>
    </div>
    </form>';
    return $rep;
}