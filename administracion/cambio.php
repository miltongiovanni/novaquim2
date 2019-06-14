<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<HTML>

<head>
	<link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
	<meta charset="utf-8">
	<title>Cambio de Contraseña</title>
	<script type="text/javascript" src="../js/validar.js"></script>
</head>

<body>
	<div id="contenedor">
		<div id="saludo"><strong>CAMBIO DE CONTRASEÑA</strong></div>
		<?php
			$nombre= $_SESSION['User'];
		?>
		<form action="change.php" method="POST" name="Cambio_clave" id="Cambio_clave">
			<div class="form-group row">
				<label class="col-form-label col-2" style="text-align: right;" for="nombre"><b>Nombre de usuario</b></label>
				<input  class="form-control col-2" name="nombre" id="nombre" value="<?php echo $nombre ?>" readonly size="20">
			</div>
			<div class="form-group row">
				<label class="col-form-label col-2" style="text-align: right;" for="password"><strong>Contraseña actual</strong></label>
				<input  class="form-control col-2" type="password" name="password" id="password" size="20">
			</div>
			<div class="form-group row">
				<label class="col-form-label col-2" style="text-align: right;" for="newPass"><strong>Contraseña nueva</strong></label>
				<input  class="form-control col-2" type="password" name="newPass" id="newPass" size="20">
			</div>
			<div class="form-group row">
				<label class="col-form-label col-2" style="text-align: right;" for="confPass"><strong>Confirmación constraseña</strong></label>
				<input  class="form-control col-2" type="password" name="confPass" id="confPass" size="20">
			</div>
			<div class="form-group row">
				<div class="col-1" style="text-align: center;">
					<button class="button" style="vertical-align:middle" onclick="return Enviar(this.form)"><span>Cambiar</span></button>
				</div>
				<div class="col-1" style="text-align: center;">
					<button class="button" style="vertical-align:middle" type="reset"><span>Borrar</span></button>
				</div>
			</div>
		</form>
		<div class="row">
			<div class="col-1"><button class="button1" id="back" style="vertical-align:middle" onClick="history.back()">
					<span>VOLVER</span></button></div>
		</div>
	</div>
</body>

</HTML>