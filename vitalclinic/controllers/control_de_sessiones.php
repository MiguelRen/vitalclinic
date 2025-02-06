<?php

    class ControlSesiones{

        public function generar_sesion($username,$name,$lastname,$role,$id_account,$departamento){
            session_start();
            // Autenticación exitosa
            session_regenerate_id(true); // Regenera el ID de sesión

            //Verificar si la session exite
            $_SESSION['user'] = [
                "username" => $username,
                "name" => $name,
                "lastname" => $lastname,
                "role" => $role,
                "id_account" => $id_account,
                "departamento" => $departamento
            ];

            return $_SESSION["user"];
        }

        public function cerrar_session($username){
            session_start();
            //Verificar si la session existe
            unset($_SESSION[$username]);
        }

        public function verificar_session(){
            if (!isset($_SESSION['user'])) {
                header('Location: inicio'); // Redirige si no está autenticado
                die();
            }
        }

    }