<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<title><?php echo COMPANY; ?></title>

    <?php include "./Views/inc/Link.php"; ?>

</head>
<body>
	<?php
		$peticionAjax = false;
		require_once "./Controllers/vistasController.php";
		$IV = new vistasController();

		//Llamamos a la función del controlador
		$Vistas = $IV->obtener_vistas_controlador();

		//Detectamos si se está usando el login o no
		if ($Vistas=="login" || $Vistas=="404") {
			require_once "./Views/contents/".$Vistas."-view.php";
		} else {
			//Se inicia la sesión
			session_start(['name'=>'SPM']);
	?>
	
	<!-- Main container -->
	<main class="full-box main-container">
		
        <!-- Nav lateral -->
        <?php include "./Views/inc/NavegadorLateral.php"; ?>

		<!-- Page content -->
		<section class="full-box page-content">
			<?php 
				include "./Views/inc/NavBar.php"; 
				
				//Traer el contenido almacenado en $Vistas
				include $Vistas;
			?>
			

		</section>
	</main>
	
    <?php 
		}
		include "./Views/inc/Script.php"; 
	?>
</body>
</html>