<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Login</title>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
</head>

<body>
<?php

function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
function mover_pag($ruta, $mensaje, $icon, $formElement = '')
{
    echo '<script >
   	alerta("' . $mensaje . '","' . $icon . '","' . $ruta . '","' . $formElement . '" );
   	</script>';
}

$usuarioOperador = new UsuariosOperaciones();
//include "includes/conect.php";
include "../includes/calcularDias.php";
foreach ($_POST as $nombre_campo => $valor) {
    ${$nombre_campo} = $valor;
    if (is_array($valor)) {
        //echo $nombre_campo.print_r($valor).'<br>';
    } else {
        //echo $nombre_campo. '=' .${$nombre_campo}.'<br>';
    }
}
$mensaje = "";


if ((strlen($_POST['username'])) <= 16)    //El nombre de usuario no debe superar la longitud de 16
{
    $username = strtoupper($_POST['username']);
    $password = md5(strtoupper($_POST['password']));
} else {
    mover_pag("../index.php", "El nombre del usuario es muy grande", "warning");
}
//Validacion de nombre y usuario
$usuario = $usuarioOperador->validarUsuario($username, $password);
if (!$usuario) {//si existen datos pero la clave esta errada
    $user = $usuarioOperador->getUserByUsername($username);
    if ($user) {
        //si el usuario existe se le adiciona 1 intento a los 4 intentos se debe bloquear el usuario
        $intentos = $user['intentos'] + 1;
        $datos = array($intentos, $user['idUsuario']);
        $usuarioOperador->updateIntentos($datos);
        $ruta = "../index.php";
        $mensaje = "Password incorrecto, por favor verifique la información";
        mover_pag($ruta, $mensaje, 'error');
    } else {
        $ruta = "../index.php";
        $mensaje = "El usuario no existe, por favor verifique la información";
        mover_pag($ruta, $mensaje, 'error');
    }
} else    //si se superan los controles iniciales
{
    $fechaFinal = $usuario['fecCambio'];
    $Fecha = Hoy();
    $dias = Calc_Dias($Fecha, $fechaFinal);//calculo de dias para validar la antiguedad del ultimo cambio
    $op = $usuario['estadoUsuario'];
    $perfil_admin = $usuario['idPerfil'];
    $Id = $usuario['idUsuario'];
    $intentos = $usuario['intentos'];
    if ($op == 3) {//Si el usuario está bloqueado no se le deja continuar
        $ruta = "../index.php";
        $mensaje = "Usuario bloqueado, consulte al administrador del sistema";
        mover_pag($ruta, $mensaje, 'warning');
    } elseif ($op == 2) {//Cuando el usuario es 2 esta activo de lo contrario se toma como nuevo
        if ($intentos <= 3)//Numero de intentos
        {
            if ($dias <= 90)//Numero de dias
            {
                $datos = array(0, $usuario['idUsuario']);
                $usuarioOperador->updateIntentos($datos);
                $_SESSION['UsuarioAutorizado'] = true;
                $_SESSION['Username'] = $username;
                $_SESSION['userId'] = $usuario['idUsuario'];
                $_SESSION['perfilUsuario'] = $perfil_admin;
                $perfil = $usuario['idPerfil'];
                //echo $perfil.'<br>';
                $ruta = "../menu.php";
                mover_pag($ruta, $usuario['nombre'] . " bienvenid@ al Sistema de Información de Industrias Novaquim S.A.S.", 'success');
            } else {

                $ruta = "../administracion/usuario/cambiar-clave";
                $mensaje = "Su último cambio fue hace mas de 90 días, por favor cambie su contraseña";
                //$mensaje=utf8_encode($mensaje);
                $datos = array(0, $usuario['idUsuario']);
                $usuarioOperador->updateIntentos($datos);
                $_SESSION['UsuarioAutorizado'] = true;
                $_SESSION['Username'] = $username;
                $_SESSION['userId'] = $usuario['idUsuario'];
                $_SESSION['perfilUsuario'] = $perfil_admin;
                $perfil = $usuario['idPerfil'];
                mover_pag($ruta, $mensaje, 'warning');
            }
        } else {
            $ruta = "../index.php";
            $mensaje = "La clave se encuentra bloqueada por favor contacte al administrador";
            mover_pag($ruta, $mensaje, 'warning');
        }
    } else {//Primer ingreso
        $ruta = "cambio.php";
        $mensaje = "Primer Ingreso cambie su contraseña";
        $mensaje = utf8_encode($mensaje);
        $_SESSION['UsuarioAutorizado'] = true;
        $_SESSION['Username'] = $username;
        $_SESSION['userId'] = $usuario['idUsuario'];
        $_SESSION['perfilUsuario'] = $perfil_admin;
        mover_pag($ruta, $mensaje, 'info');
    }
}


?>
</body>

</html>
