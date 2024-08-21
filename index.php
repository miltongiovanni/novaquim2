<?php
session_start();
if(isset($_SESSION['UsuarioAutorizado']) && $_SESSION['UsuarioAutorizado']==true){
    header('Location: ../menu.php');
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
    <link rel="icon" href="images/favicon.ico" type="image/ico" sizes="16x16">
    <title>Sistema de Información de Industrias Novaquim S.A.S.</title>

    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="js/validar.js"></script>

</head>

<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo">
        <img src="images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2 w-25">
        <h4>BIENVENIDO AL SISTEMA DE INFORMACIÓN DE INDUSTRIAS NOVAQUIM S.A.S.</h4>
    </div>
    <?php
    if (isset($_SESSION['flash_message'])) {
        $message = $_SESSION['flash_message'];
        unset($_SESSION['flash_message']);
        echo '<div class="w-25 m-auto alert alert-danger alert-dismissible fade show mb-3" role="alert">
                      <strong>'.$message.'</strong>
                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
    }
    ?>
    <form method="POST" action="login/index.php">
        <div class="mb-3 row">
            <div class="col-2">
                <label class="form-label" for="username">Usuario</label>
                <input type="text" class="form-control" name="username" id="username" maxlength="10" required autofocus>
            </div>
        </div>
        <div class="mb-3 row">
            <div class="col-2">
                <label class="form-label" for="password">Contraseña</label>
                <input type="password" class="form-control" name="password" id="password" maxlength="15" required >
            </div>
        </div>
        <div class="mb-3 row">
            <div class="col-1 text-center">
                <button class="button" type="reset"><span>Reiniciar</span></button>
            </div>
            <div class="col-1 text-center">
                <button class="button" type="button" onclick="return Enviar(this.form)"><span>Continuar</span></button>
            </div>
        </div>

    </form>

</div>
</body>

</html>