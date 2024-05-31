<?php
    // Función para cargar las clases
function cargarClases($classname){
    require '../../../clases/'.$classname.'.php';
}

spl_autoload_register('cargarClases');



function buscarUsuarioForm($action, $actif){ 

$rep= '<form id="form1" name="form1" method="post" action="'.$action.'">
<div class="form-group row"><div class="col-1 text-end"><label class="col-form-label " for="combo"><strong>Usuario</strong></label></div>';
$manager = new UsuariosOperaciones();
$users=$manager->getUsers($actif);
$filas=count($users);
$rep .= '<div class="col-2 px-0"> <select name="idUsuario" class="form-select " required>';
$rep .= '<option selected value="">-----------------------------</option>';
for($i=0; $i<$filas; $i++)
    {                            
        $rep .= '<option value="'.$users[$i]["idUsuario"].'">'.$users[$i]['nombre'].'</option>';
    }
    $rep .='</select></div>';

    $rep .=  '</div>
<div class="row form-group">
<div class="col-1"><button class="button" type="button" onclick="return Enviar(this.form)">
        <span>Continuar</span></button></div>
</div>
</form>';
return $rep;
}

function buscarPersonalForm($action, $actif){ 

    $rep= '<form id="form1" name="form1" method="post" action="'.$action.'">
    <div class="form-group row"><div class="col-1 text-end"><label class="col-form-label " for="combo"><strong>Personal</strong></label></div> ';
    $manager = new PersonalOperaciones();
    $personal=$manager->getPersonal($actif);
    $filas=count($personal);
    $rep .= '<div class="col-2 px-0"><select name="idPersonal" class="form-select " required>';
    $rep .= '<option selected value="">-----------------------------</option>';
    for($i=0; $i<$filas; $i++)
        {                            
            $rep .= '<option value="'.$personal[$i]["idPersonal"].'">'.$personal[$i]['nomPersonal'].'</option>';
        }
        $rep .='</select></div>';
    
        $rep .=  '</div>
    <div class="row form-group">
    <div class="col-1"><button class="button"type="button" onclick="return Enviar(this.form)">
            <span>Continuar</span></button></div>
    </div>
    </form>';
    return $rep;
    }
    