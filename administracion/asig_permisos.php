<?php
include "../includes/valAcc.php";
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
?>
<!DOCTYPE html>
<html lang="es">

<head>
	<title>Detalle de la Cotización</title>
	<meta charset="utf-8">
	<link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
	<script  src="../validar.js"></script>
</head>

<body>
	<div id="contenedor">
		<div id="saludo1"><strong>DETALLE DE LOS PERMISOS</strong></div>
		<?php
		$idPerfil = $_POST['idPerfil'];
		$idUsuario = $_POST['idUsuario'];
		foreach ($_POST['seleccion3'] as $indice1 => $auxiliar) {
			foreach ($auxiliar as $indice2 => $elemento) {
				foreach ($elemento as $clave => $valor) {
					$permisos[] = $valor;
				}
			}
		}
		//print_r($permisos);
		//echo "<br>";
		$menuOperador = new MenusOperaciones();
		$menuItems = $menuOperador->getMenuItems();
		for ($i = 0; $i < count($menuItems); $i++) {
			$id = $menuItems[$i]['id'];
			$title = $menuItems[$i]['title'];
			$parentId = $menuItems[$i]['parentId'];
			$codUser = $menuItems[$i]['codUser'];
			$usuarios_p = explode(",", $codUser);
			$menu_1[0] = "";
			$menu_1_i[0] = "";
			if ($parentId == 0) {
				$menu_1_i[] = $id;
			} else {
				if ($clave = array_search($parentId, $menu_1_i)) {
					$menu_2_i[] = $id;
				} else {
					$menu_3_i[] = $id;
				}
			}
		}
		//echo "menu 1 ";
		//print_r($menu_1_i);
		//echo "<br>";
		//echo "menu 2 ";
		//print_r($menu_2_i);
		//echo "<br>";
		//echo "menu 3 ";
		//print_r($menu_3_i);
		//echo "<br>";

		// arreglo     indice valor
		foreach ($menu_3_i as $j => $id3) {
			$menuItem = $menuOperador->getMenuItem($id3);
			$id = $menuItem['id'];
			$codUser = $menuItem['codUser'];
			$parentId = $menuItem['parentId'];
			$usuarios_p = explode(",", $codUser);
			if (in_array($idPerfil, $usuarios_p)) {
				if (in_array($id, $permisos)) {
					//echo "Tiene permiso y se asigna de nuevo $id <br>";
					$menuItem2 = $menuOperador->getMenuItem($parentId);
					$id2 = $menuItem2['id'];
					$parentid2 = $menuItem2['parentId'];
					$cod_user2 = $menuItem2['codUser'];
					$usuarios_p2 = explode(",", $cod_user2);
					if (in_array($idPerfil, $usuarios_p2)) {

					} else {
						$usuarios_p2[] = $idPerfil;
						$opciones_us2 = implode(",", $usuarios_p2);
						$datos1 = array($opciones_us2, $id2);
						$menuOperador->updateMenuItem($datos1);
					}

				} else {
					//echo "tiene permiso y lo va a revocar  $id <br>";

					foreach ($usuarios_p as $item => $perm_asig) {
						if ($perm_asig != $idPerfil) {
							$nvo_permisos[] = $perm_asig;
						}

					}
					$opciones_us = implode(",", $nvo_permisos);
					$datos2 = array($opciones_us, $id);
					$menuOperador->updateMenuItem($datos2);
					unset($nvo_permisos);
				}

			} else {
				if (in_array($id, $permisos)) {
					//  echo "no tiene permiso y se le va asignar  $id <br>";
					$usuarios_p[] = $idPerfil;
					$opciones_us = implode(",", $usuarios_p);
					$datos3 = array($opciones_us, $id);
					$menuOperador->updateMenuItem($datos3);
				} else {
					//echo "no tiene permiso y no se le va asignar  $id <br>";
					echo "";
				}
			}

		}

		echo '<form name="form3"  method="post" action="permisos.php">';
		echo '<input type="hidden" name="idUsuario" value="' . $idUsuario . '">';
		echo '</form>';
		echo '<script >
			document.form3.submit();
			</script>';

		?>

	</div>
</body>

</html>