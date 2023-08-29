<?php
    require_once "mainModel.php";

    class usuarioModel extends mainModel {

        /*-------- Modelo agregar usuario --------*/
        protected static function agregar_usuario_modelo($datos) {
            //Usamos la función conectar() del modelo principal
            $conexion = mainModel::conectar();

            $sql = "INSERT INTO usuario(usuario_dni,usuario_nombre,usuario_apellido,usuario_telefono,usuario_direccion,usuario_email,usuario_usuario,usuario_clave,usuario_estado,usuario_privilegio) 
                    VALUES(:DNI,:Nombre,:Apellido,:Telefono,:Direccion,:Email,:Usuario,:Clave,:Estado,:Privilegio)";

            $query = $conexion->prepare($sql);
                    
            $query->bindParam(":DNI",$datos['DNI']);
            $query->bindParam(":Nombre",$datos['Nombre']);
            $query->bindParam(":Apellido",$datos['Apellido']);
            $query->bindParam(":Telefono",$datos['Telefono']);
            $query->bindParam(":Direccion",$datos['Direccion']);
            $query->bindParam(":Email",$datos['Email']);
            $query->bindParam(":Usuario",$datos['Usuario']);
            $query->bindParam(":Clave",$datos['Clave']);
            $query->bindParam(":Estado",$datos['Estado']);
            $query->bindParam(":Privilegio",$datos['Privilegio']);

            $respuesta = $query->execute();
            return $respuesta;
        }

    }