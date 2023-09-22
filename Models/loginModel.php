<?php 

    require_once "mainModel.php";

    class loginModel extends mainModel {

        /*-------- Modelo iniciar sesión --------*/
        protected static function iniciar_sesion_modelo($datos) {
            $conexion = mainModel::conectar();

            $sql = "SELECT * FROM usuario 
                    WHERE usuario_usuario=:Usuario 
                    AND usuario_clave=:Clave 
                    AND usuario_estado='Activa'";

            $query = $conexion->prepare($sql);

            $query->bindParam(":Usuario",$datos['Usuario']);
            $query->bindParam(":Clave",$datos['Clave']);

            $query->execute();
            return $query;
        }
    }