//Seleccionamos todos los formularios
const formularios_ajax = document.querySelectorAll('.FormularioAjax');

//Función Enviar formularios vía ajax
function enviar_formulario_ajax(e) {
    //Prevenimos el evento por defecto (Envío del formulario)
    e.preventDefault();
    //Contiene todos los datos del formulario
    let data = new FormData(this);
    //Obtenemos el atributo metodo del formulario que estamos enviando
    let method = this.getAttribute("method");
    //Obtenemos el atributo action
    let action = this.getAttribute("action");
    let tipo = this.getAttribute("data-form");

    //Envíamos los datos vía ajax de forma nativa
    let encabezados = new Headers();
    //Configuración que vamos a enviar con la función de fetch
    let config = {
        method: method,
        headers: encabezados,
        mode: 'cors',
        cache: 'no-cache',
        body: data
    }
    //Contiene el texto de la alerta
    let texto_alerta;

    if (tipo==="save") {
        texto_alerta = "Los datos quedarán guardados en el sistema";

    } else if (tipo==="delete") {
        texto_alerta = "Los datos serán eliminados completamente del sistema";
    
    } else if (tipo==="update") {
        texto_alerta = "Los datos del sistema serán actualizados";
    
    } else if (tipo==="search") {
        texto_alerta = "Se eliminará el termino de búsqueda y tendrás que escribir uno nuevo";
    
    } else if (tipo==="loans") {
        texto_alerta = "¿Desea remover los datos seleccionados para prestamos o reservaciones?";
    
    } else {
        texto_alerta = "Quieres realizar la operación solicitada";
    }

    Swal.fire({
        title: '¿Estás seguro?',
        text: texto_alerta,
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Aceptar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.value) {
            //Envíamos el formulario en formato json
            //1.- URL donde enviaremos los datos
            //2.- Configuraciones de fetch
            fetch(action,config)
            .then(respuesta => respuesta.json())
            .then(respuesta => {
                //Retornamos las alertas
                return alertas_ajax(respuesta);
            });
        }
    });

}

//Detectamos cada vez que enviemos un formulario
formularios_ajax.forEach(formularios => {
    formularios.addEventListener("submit", enviar_formulario_ajax);
});

function alertas_ajax(alerta) {
    if (alerta.Alerta==="simple") {
        Swal.fire({
            title: alerta.Titulo,
            text: alerta.Texto,
            type: alerta.Tipo,
            confirmButtonText: 'Aceptar'
        });

    } 
    else if (alerta.Alerta==="recargar") {
        Swal.fire({
            title: alerta.Titulo,
            text: alerta.Texto,
            type: alerta.Tipo,
            confirmButtonText: 'Aceptar'
        }).then((result) => {
            if (result.value) {
                //Se recarga la página
                location.reload(); 
            }
        })
    }
    else if (alerta.Alerta==="limpiar") {
        Swal.fire({
            title: alerta.Titulo,
            text: alerta.Texto,
            type: alerta.Tipo,
            confirmButtonText: 'Aceptar'
        }).then((result) => {
            if (result.value) {
                //Se limpia el formulario
                document.querySelector('.FormularioAjax').reset(); 
            }
        });
    }
    else if (alerta.Alerta==="redireccionar") {
        window.location.href=alerta.URL;
    }


}