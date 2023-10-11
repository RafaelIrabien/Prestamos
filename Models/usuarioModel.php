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
            
            //Cambiamos los marcadores por los valores reales
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

            $query->execute();
            return $query;
        }

        /*-------- Modelo eliminar usuario --------*/
        protected static function eliminar_usuario_modelo($id) {
            $conexion = mainModel::conectar();

            $sql = "DELETE FROM usuario WHERE usuario_id=:ID";
            $query = $conexion->prepare($sql);

            //Agregamos el marcador
            $query->bindParam(":ID",$id);
            $query->execute();

            return $query;
        }

        /*-------- Modelo datos usuario --------*/
        protected static function datos_usuario_modelo($tipo,$id) {
            if ($tipo=="Unico") {
                $conexion = mainModel::conectar();
                $sql = "SELECT * FROM usuario WHERE usuario_id=:ID";
                $query = $conexion->prepare($sql);

                $query->bindParam(":ID",$id);

            } elseif ($tipo=="Conteo") {
                $conexion = mainModel::conectar();
                //Contamos los demás usuarios menos el primero o principal
                $sql = "SELECT usuario_id FROM usuario WHERE usuario_id!='1'";
                $query = $conexion->prepare($sql);
            }
            $query->execute();
            return $query;
            
        }

        /*-------- Modelo actualizar usuario --------*/
        protected static function actualizar_usuario_modelo($datos) {
            $conexion = mainModel::conectar();
            $sql = "UPDATE usuario SET 
                    usuario_dni=:DNI,
                    usuario_nombre=:Nombre,
                    usuario_apellido=:Apellido,
                    usuario_telefono=:Telefono,
                    usuario_direccion=:Direccion,
                    usuario_email=:Email,
                    usuario_usuario=:Usuario,
                    usuario_clave=:Clave,
                    usuario_estado=:Estado,
                    usuario_privilegio=:Privilegio
                    WHERE usuario_id=:ID";

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
            $query->bindParam(":ID",$datos['ID']);

            $query->execute();
            return $query;
            
        }

    }