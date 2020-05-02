<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">

<head>
	<link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
	<meta charset="utf-8">
	<title>Cambio de Contraseña</title>
	<script  src="../js/validar.js"></script>
</head>

<body>
	<div id="contenedor">
		<div id="saludo"><strong>CAMBIO DE CONTRASEÑA</strong></div>
		<?php
			$nombre= $_SESSION['User'];
		?>
		<form action="change.php" method="POST" name="Cambio_clave" id="Cambio_clave">
			<div class="form-group row">
				<label class="col-form-label col-2 text-right"  for="nombre"><b>Nombre de usuario</b></label>
				<input  class="form-control col-2" name="nombre" id="nombre" value="<?php echo $nombre ?>" readonly size="20">
			</div>
			<div class="form-group row">
				<label class="col-form-label col-2 text-right"  for="password"><strong>Contraseña actual</strong></label>
				<input  class="form-control col-2" type="password" name="password" id="password" size="20">
			</div>
			<div class="form-group row">
				<label class="col-form-label col-2 text-right"  for="newPass"><strong>Contraseña nueva</strong></label>
				<input  class="form-control col-2" type="password" name="newPass" id="newPass" size="20">
			</div>
			<div class="form-group row">
				<label class="col-form-label col-2 text-right"  for="confPass"><strong>Confirmación contraseña</strong></label>
				<input  class="form-control col-2" type="password" name="confPass" id="confPass" size="20">
			</div>
			<div class="form-group row">
				<div class="col-1 text-center">
					<button class="button"  onclick="return Enviar(this.form)"><span>Cambiar</span></button>
				</div>
				<div class="col-1 text-center">
					<button class="button"  type="reset"><span>Reiniciar</span></button>
				</div>
			</div>
		</form>
		<div class="row">
			<div class="col-1"><button class="button1" id="back"  onClick="history.back()">
					<span>VOLVER</span></button></div>
		</div>
	</div>
</body>

</HTML>