<?php
include "../../../includes/valAcc.php";
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');

?>
<!DOCTYPE html>
<html lang="es">

<head>
	<title>Cambio de Contrase&ntilde;a</title>
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
	<script  src="../../../js/validar.js"></script>
</head>

<body>
	<div id="contenedor" class="container-fluid">

		<div id="saludo">
        <img src="../../../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2 w-25"><h4>CAMBIO DE CONTRASEÑA</h4></div>
		<?php
		$idUsuario= $_POST['idUsuario'];
		$usuarioOperador = new UsuariosOperaciones();
		$usuario=$usuarioOperador->getUser($idUsuario);
		$nombre= $usuario['nombre'];
		?>

		<form action="change1.php" method="POST" name="Cambio_clave" id="Cambio_clave">
			<div class="form-group row">
				<label class="col-form-label col-2 text-end"  for="nombre"><b>Usuario</b></label>
				<input class="form-control col-2" name="nombre" id="nombre" value="<?= $usuario['usuario'] ?>" readonly
					size="20">
			</div>
			<div class="form-group row">
				<label class="col-form-label col-2 text-end"  for="newPass"><strong>Contraseña
						nueva</strong></label>
				<input class="form-control col-2" type="password" name="newPass" id="newPass" size="20">
			</div>
			<div class="form-group row">
				<label class="col-form-label col-2 text-end"  for="confPass"><strong>Confirmación
						constraseña</strong></label>
				<input class="form-control col-2" type="password" name="confPass" id="confPass" size="20">
			</div>
			<div class="form-group row">
                <div class="col-1 text-center">
                    <button class="button"  type="reset"><span>Reiniciar</span></button>
                </div>
				<div class="col-1 text-center">
					<button class="button"  type="button"
						onclick="return Enviar(this.form)"><span>Cambiar</span></button>
				</div>
			</div>
			

		</form>
		<div class="row">
			<div class="col-1"><button class="button1" id="back" 
					onClick="history.back()">
					<span>VOLVER</span></button></div>
		</div>
	</div>
</body>

</HTML>