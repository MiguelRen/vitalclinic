<?php

    class ControladorLinks {

        public function gestionar_redireccion(){

            // Verificamos si hay una acción en la URL
            $links = isset($_GET["action"]) ? $_GET["action"] : "";

            session_start();

            $is_active_session = isset($_SESSION['user']);

            if($is_active_session){
                
                if(strlen($links) === 0){
                    $links = "inicio";
                }

                // Redirigimos a "inicio" si se intenta acceder a "login"
                if ($links === 'login') {
                    header("Location: inicio");
                    exit();
                }

                //Creamos una instacia de la clase links que se encuentra en el paquete models
                $modelo_links = new ModeloLinks();
                $answer = $modelo_links->gestionar_redireccion($links);
                include $answer;

            }else{
                // Si no hay sesión activa y se intenta acceder a "login", no hacemos nada
                if ($links !== 'login') {
                    header("Location: login");
                    exit();
                }

                // Si está en la página de login, podrías incluir el formulario de login aquí
                $modelo_links = new ModeloLinks();
                $answer = $modelo_links->gestionar_redireccion('login');
                include $answer;
            }
        }
    } 