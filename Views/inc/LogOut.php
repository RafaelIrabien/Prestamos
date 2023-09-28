<script>
    //Detectar cuando se haga click en cerrar sesión
    let btn_salir = document.querySelector(".btn-exit-system");

    btn_salir.addEventListener('click', function(e) {
        //Prevenimos el evento por defecto
        e.preventDefault();
        Swal.fire({
			title: '¿Quieres salir del sistema?',
			text: "La sesión actual se cerrará y saldrás del sistema",
			type: 'question',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Si, salir!',
			cancelButtonText: 'No, cancelar'
		}).then((result) => {
			if (result.value) {
                //En loginAjax.php mandaremos los datos
				let url='<?php echo SERVER_URL; ?>ajax/loginAjax.php';
                //El valor que tenemos de token en loginController.php
                //Instaciamos la variable que está en plantilla.php
                //Podemos usar la funcion de mainModel encryption()
                let token='<?php echo $lc->encryption($_SESSION['token_spm']); ?>';
                let usuario='<?php echo $lc->encryption($_SESSION['usuario_spm']); ?>';

                let datos= new FormData();
                datos.append("token",token);
                datos.append("usuario",usuario);
                 //Envíamos el formulario en formato json
                //1.- URL donde enviaremos los datos
                fetch(url, {
                    method: 'POST',
                    body: datos
                })
                .then(respuesta => respuesta.json())
                .then(respuesta => {
                    //Retornamos las alertas
                    return alertas_ajax(respuesta);
                });
			}
		});
    });
</script>