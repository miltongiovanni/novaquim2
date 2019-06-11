<?php
    // Función para cargar las clases
function cargarClases($classname){
    require '../clases/'.$classname.'.php';
}

spl_autoload_register('cargarClases');



function buscarUsuarioForm($action){ 

$rep= '<form id="form1" name="form1" method="post" action="'.$action.'">
<div class="form-group row"><label class="col-form-label col-1" for="combo"><strong>Usuario</strong></label>';
$manager = new UsuariosOperaciones();
$users=$manager->getUsers();
$filas=count($users);
$rep .= '<select name="idUsuario" id="combo" class="form-control col-2">';
$rep .= '<option selected value="">-----------------------------</option>';
for($i=0; $i<$filas; $i++)
    {                            
        $rep .= '<option value="'.$users[$i]["idUsuario"].'">'.$users[$i]['nombre'].'</option>';
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