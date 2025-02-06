<?php

    include "./models/control_privilegios.php";

    class ControlPrivilegios{

        public function verificar_privilegios($privilegio){
            $role_user = $_SESSION['user']['role'];
            
            //Extraemos los roles necesarios para acceder al privilegio
            $model = new ControlPrivilegiosModel();
            $roles = $model->verificar_privilegios($privilegio);

            $acceso = false;

            for ($i=0; $i <  count($roles); $i++) { 
                if($role_user == $roles[$i]['id_role']){
                    $acceso = true;
                    break;
                }
            }
            
            if($acceso === false){
                header('Location: inicio');
            }
        }
    }