<?php
    //Detectar cuando se realiza una petición ajax o no
    if ($peticionAjax) {
        //Lo ejecutamos en el archivo usuarioAjax.php
        require_once "../Models/usuarioModel.php";
    } else {
        //Lo ejecutamos en el archivo index.php
        require_once "./Models/usuarioModel.php";
    }

    class usuarioController extends usuarioModel {
        
        /*-------- Controlador agregar usuario --------*/
        public function agregar_usuario_controlador() {
            //Guardar en variables los datos enviados del formulario
            //Usamos la función Limpiar cadenas del mainModel
            $dni = mainModel::limpiar_cadena($_POST['usuario_dni_reg']);
            $nombre = mainModel::limpiar_cadena($_POST['usuario_nombre_reg']);
            $apellido = mainModel::limpiar_cadena($_POST['usuario_apellido_reg']);
            $telefono = mainModel::limpiar_cadena($_POST['usuario_telefono_reg']);
            $direccion = mainModel::limpiar_cadena($_POST['usuario_direccion_reg']);

            $usuario = mainModel::limpiar_cadena($_POST['usuario_usuario_reg']);
            $email = mainModel::limpiar_cadena($_POST['usuario_email_reg']);
            $clave1 = mainModel::limpiar_cadena($_POST['usuario_clave_1_reg']);
            $clave2 = mainModel::limpiar_cadena($_POST['usuario_clave_2_reg']);

            $privilegio = mainModel::limpiar_cadena($_POST['usuario_privilegio_reg']);


            //Comprobar que los campos requeridos estén llenos
            if ($dni=="" || $nombre=="" || $apellido=="" || $usuario=="" || $clave1=="" || $clave2=="") {
                $alerta = [
                         "Alerta"=>"simple",
                         "Titulo"=>"Ocurrió un error inesperado",
                         "Texto"=>"No has llenado los campos obligatorios",
                         "Tipo"=>"error"
                        ];
                //Pasamos a json el array para que js lo entienda
                echo json_encode($alerta);
                exit();
            }


            //Verificar integridad de los datos
            if (mainModel::verificar_datos("[0-9-]{10,20}",$dni)) {
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"El DNI no coincide con el formato solicitado",
                    "Tipo"=>"error"
                   ];
           
                echo json_encode($alerta);
                exit();
            }

            if (mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,35}",$nombre)) {
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"El nombre no coincide con el formato solicitado",
                    "Tipo"=>"error"
                   ];
                echo json_encode($alerta);
                exit();
            }

            if (mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,35}",$apellido)) {
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"El apellido no coincide con el formato solicitado",
                    "Tipo"=>"error"
                   ];
                echo json_encode($alerta);
                exit();
            }

            if ($telefono!="") {
                if (mainModel::verificar_datos("[0-9()+]{8,20}",$telefono)) {
                    $alerta = [
                        "Alerta"=>"simple",
                        "Titulo"=>"Ocurrió un error inesperado",
                        "Texto"=>"El teléfono no coincide con el formato solicitado",
                        "Tipo"=>"error"
                       ];
                    echo json_encode($alerta);
                    exit();
                }
            }

            if ($direccion!="") {
                if (mainModel::verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{1,190}",$direccion)) {
                    $alerta = [
                        "Alerta"=>"simple",
                        "Titulo"=>"Ocurrió un error inesperado",
                        "Texto"=>"La dirección no coincide con el formato solicitado",
                        "Tipo"=>"error"
                       ];
                    echo json_encode($alerta);
                    exit();
                }
            }

            if (mainModel::verificar_datos("[a-zA-Z0-9]{1,35}",$usuario)) {
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"El nombre de usuario no coincide con el formato solicitado",
                    "Tipo"=>"error"
                   ];
                echo json_encode($alerta);
                exit();
            }

            if (mainModel::verificar_datos("[a-zA-Z0-9$@.-]{7,100}",$clave1) || mainModel::verificar_datos("[a-zA-Z0-9$@.-]{7,100}",$clave2)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"Las claves no coinciden con el formato solicitado",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

            
            //Comprobando que el DNI no esté registrado en la BD
            //Seleccionamos el DNI registrado siempre y cuando sea el
            //que se está recibiendo en el formulario
            $check_dni = mainModel::ejecutar_consulta_simple("SELECT usuario_dni FROM usuario WHERE usuario_dni='$dni'");
            //rowCount(): Devuelve el número de filas afectadas por 
            //la última sentencia SQL
            if ($check_dni->rowCount()>0) {
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"El DNI ingresado ya se encuentra registrado en el sistema",
                    "Tipo"=>"error"
                   ];
                echo json_encode($alerta);
                exit();
            }


            //Comprobando que el usuario no esté registrado en la BD
            $check_user = mainModel::ejecutar_consulta_simple("SELECT usuario_usuario FROM usuario WHERE usuario_usuario='$usuario'");
            if ($check_user->rowCount()>0) {
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"El nombre de usuario ingresado ya se encuentra registrado en el sistema",
                    "Tipo"=>"error"
                   ];
                echo json_encode($alerta);
                exit();
            }


             //Comprobando que el email no esté registrado en la BD
            if ($email!="") {
                //filter_var: Filtra una variable con el filtro 
                //que se indique
                //Comprobamos si el email ingresado es un email valido
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                     //Comprobamos si existe en la BD
                     $check_email = mainModel::ejecutar_consulta_simple("SELECT usuario_email FROM usuario WHERE usuario_email='$email'");
                     if ($check_email->rowCount()>0) {
                         $alerta = [
                             "Alerta"=>"simple",
                             "Titulo"=>"Ocurrió un error inesperado",
                             "Texto"=>"El correo ingresado ya se encuentra registrado en el sistema",
                             "Tipo"=>"error"
                            ];
                         echo json_encode($alerta);
                         exit();
                     }
                } else {
                    $alerta = [
                        "Alerta"=>"simple",
                        "Titulo"=>"Ocurrió un error inesperado",
                        "Texto"=>"Ha ingresado un correo no válido",
                        "Tipo"=>"error"
                       ];
                    echo json_encode($alerta);
                    exit();
                }
                
            }


            //Comprobando las claves
            if($clave1!=$clave2){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"Las claves que acaba de ingresar no coinciden",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}else{
				$clave=mainModel::encryption($clave1);
			}
            

            //Comprobando el privilegio
            if ($privilegio<1 || $privilegio>3){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El privilegio seleccionado no es válido",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

            $datos_usuario_reg = [
                //Colocamos los índices que están en el modelo
                "DNI"=>$dni,
                "Nombre"=>$nombre,
                "Apellido"=>$apellido,
                "Telefono"=>$telefono,
                "Direccion"=>$direccion,
                "Email"=>$email,
                "Usuario"=>$usuario,
                "Clave"=>$clave,
                "Estado"=>"Activa",
                "Privilegio"=>$privilegio
            ];

            //Llamamos a la función para registrar usuarios
            $agregar_usuario=usuarioModel::agregar_usuario_modelo($datos_usuario_reg);
            //Comprobamos si se ha hecho un registro en la BD
            if ($agregar_usuario->rowCount()==1) {
                $alerta=[
					"Alerta"=>"limpiar",
					"Titulo"=>"Usuario registrado",
					"Texto"=>"Los datos del usuario han sido registrados con éxito",
					"Tipo"=>"success"
				];
            } 
            if($agregar_usuario->rowCount()==1){
				$alerta=[
					"Alerta"=>"limpiar",
					"Titulo"=>"usuario registrado",
					"Texto"=>"Los datos del usuario han sido registrados con exito",
					"Tipo"=>"success"
				];
			}
            else {
                $alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No se pudo registrar el usuario",
					"Tipo"=>"error"
				];
				
            }
            echo json_encode($alerta);
            


        } //Finaliza agregar_usuario_controlador()


        /*-------- Controlador agregar usuario --------*/
        public function paginador_usuario_controlador($pagina,$registros,$privilegio,$id,$url,$busqueda) {
            //Limpiamos las variables
            $pagina = mainModel::limpiar_cadena($pagina);
            $registros = mainModel::limpiar_cadena($registros);
            $privilegio = mainModel::limpiar_cadena($privilegio);
            $id = mainModel::limpiar_cadena($id);

            $url = mainModel::limpiar_cadena($url);
            $url = SERVER_URL.$url."/";

            $busqueda = mainModel::limpiar_cadena($busqueda);
            $tabla = "";

            //1.- Si la pagina esta definida y es mayor a 0
            //2.- Convertimos la variable en entero
            //3.-Si la variable pagina no viene definida o no es un numero
            //se envia al usuario a la página número 1
            $pagina = (isset($pagina) && $pagina>0) ? (int) $pagina : 1 ;

            //Saber desde qué registro se empezará a contar
            $inicio = ($pagina>0) ? (($pagina*$registros)-$registros) : 0 ;

            if (isset($busqueda) && $busqueda!="") {
                $consulta = "SELECT SQL_CALC_FOUND_ROWS * 
                             FROM usuario
                             WHERE ((usuario_id!='$id'
                             AND usuario_id!='1') 
                             AND (usuario_dni LIKE '%$busqueda%'
                             OR usuario_nombre LIKE '%$busqueda%'
                             OR usuario_apellido LIKE '%$busqueda%'
                             OR usuario_telefono LIKE '%$busqueda%'
                             OR usuario_email LIKE '%$busqueda%'
                             OR usuario_usuario LIKE '%$busqueda%'
                             ))
                             ORDER BY usuario_nombre ASC
                             LIMIT $inicio,$registros";
            } else {
                $consulta = "SELECT SQL_CALC_FOUND_ROWS * 
                             FROM usuario
                             WHERE usuario_id!='$id'
                             AND usuario_id!='1'
                             ORDER BY usuario_nombre ASC
                             LIMIT $inicio,$registros";
            }

            $conexion = mainModel::conectar();

            $datos = $conexion->query($consulta);
            //De esta manera tenemos todos los datos
            $datos = $datos->fetchAll();

            //Se cuentan los registros que muestra cualquiera
            //de las 2 consultas anteriores
            $total = $conexion->query("SELECT FOUND_ROWS()");
            //Convertimos la variable a entero y vamos a saber
            //cuántos registros tiene
            $total = (int) $total->fetchColumn();

            //Se redondea el número de páginas en caso de dar un número decimal
            $N_paginas = ceil($total/$registros);
            
            $tabla.='<div class="table-responsive">
            <table class="table table-dark table-sm">
                <thead>
                    <tr class="text-center roboto-medium">
                        <th>#</th>
                        <th>DNI</th>
                        <th>NOMBRE</th>
                        <th>TELÉFONO</th>
                        <th>USUARIO</th>
                        <th>EMAIL</th>
                        <th>ACTUALIZAR</th>
                        <th>ELIMINAR</th>
                    </tr>
                </thead>
                <tbody>';
            
            if ($total>=1 && $pagina<=$N_paginas) {
                //Se muestran los registros dentro de la tabla
                $contador = $inicio+1;
                //Nos mostrará desde que registro se está mostrando
                $reg_inicio = $inicio+1;
                foreach ($datos as $rows) {
                    $tabla.='<tr class="text-center">
                        <td>'.$contador.'</td>
                        <td>'.$rows['usuario_dni'].'</td>
                        <td>'.$rows['usuario_nombre'].' '.$rows['usuario_apellido'].'</td>
                        <td>'.$rows['usuario_telefono'].'</td>
                        <td>'.$rows['usuario_usuario'].'</td>
                        <td>'.$rows['usuario_email'].'</td>
                        <td>
                            <a href="'.SERVER_URL.'user-update/'.mainModel::encryption($rows['usuario_id']).'/" class="btn btn-success">
                                <i class="fas fa-sync-alt"></i>	
                            </a>
                        </td>
                        <td>
                            <form class="FormularioAjax" action="'.SERVER_URL.'ajax/usuarioAjax.php" method="POST" data-form="delete" autocomplete="off">
                                <input type="hidden" name="usuario_id_del" value="'.mainModel::encryption($rows['usuario_id']).'">
                                <button type="submit" class="btn btn-warning">
                                    <i class="far fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>';
                    $contador++;
                }
                $reg_final = $contador-1;

            } else {
                //Comprobamos si hay registros
                if ($total>=1) {
                    $tabla.='<tr class="text-center" ><td colspan="9">
                    <a href="'.$url.'" class="btn btn-raised btn-primary btn-sm">Haga click aca para recargar el listado</a></td></tr>';
                } else{
                $tabla.='<tr class="text-center" ><td colspan="9">No hay registros en el sistema</td></tr>';
                }
            }
            $tabla.='</tbody></table></div>';

            //Mostramos la longitud de usuarios(id-id) por pagina 
            //y el total de registrados
            if ($total>=1) {
                $tabla.='<p class="text-right">Mostrando usuario '.$reg_inicio.' al '.$reg_final.' de un total de '.$total.'</p>';
            }

            //Comprobamos si hay registros y si estamos en una página correcta
            if($total>=1 && $pagina<=$N_paginas) {
                $tabla.=mainModel::paginador_tablas($pagina,$N_paginas,$url,7);
            }

            return $tabla;

            
        } //Finaliza paginador_usuario_controlador()


    } //FINALIZA CONTROLADOR