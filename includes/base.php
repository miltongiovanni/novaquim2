<?php
    // Función para cargar las clases
function cargarClases($classname){
    require '../clases/'.$classname.'.php';
}

spl_autoload_register('cargarClases');



function buscarCatProdForm($action){ 

$rep= '<form id="form1" name="form1" method="post" action="'.$action.'">
<div class="form-group row"><label class="col-form-label col-1" for="combo"><strong>Categoría</strong></label>';
$manager = new CategoriasProdOperaciones();
$categorias=$manager->getCatsProd();
$filas=count($categorias);
$rep .= '<select name="idCatProd" id="combo" class="form-control col-2">';
$rep .= '<option selected value="">-----------------------------</option>';
for($i=0; $i<$filas; $i++)
    {                            
        $rep .= '<option value="'.$categorias[$i]["idCatProd"].'">'.$categorias[$i]['catProd'].'</option>';
    }
    $rep .='</select>';

    $rep .=  '</div>
<div class="row form-group">
<div class="col-1"><button class="button" style="vertical-align:middle" onclick="return Enviar2(this.form)">
        <span>Continuar</span></button></div>
</div>
</form>';
return $rep;
}

function buscarPersonalForm($action, $actif){ 

    $rep= '<form id="form1" name="form1" method="post" action="'.$action.'">
    <div class="form-group row"><label class="col-form-label col-1" for="combo"><strong>Personal</strong></label>';
    $manager = new PersonalOperaciones();
    $personal=$manager->getPersonal($actif);
    $filas=count($personal);
    $rep .= '<select name="idPersonal" id="combo" class="form-control col-2">';
    $rep .= '<option selected value="">-----------------------------</option>';
    for($i=0; $i<$filas; $i++)
        {                            
            $rep .= '<option value="'.$personal[$i]["idPersonal"].'">'.$personal[$i]['nomPersonal'].'</option>';
        }
        $rep .='</select>';
    
        $rep .=  '</div>
    <div class="row form-group">
    <div class="col-1"><button class="button" style="vertical-align:middle" onclick="return Enviar2(this.form)">
            <span>Continuar</span></button></div>
    </div>
    </form>';
    return $rep;
    }
    