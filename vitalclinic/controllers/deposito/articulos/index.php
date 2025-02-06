<?php

    class ArticulosController{
        
        private $patternCodBarra = "/^[a-zA-Z0-9]+$/";
        private $patternCodProfit = "/^[0-9]+$/";

        public function registrar_articulos($cod_profit = '', $cod_barra = '', $des_art = ''){

            $fallo_validacion = false;
            $message_validacion = '';

            if(!strlen($des_art) > 0){
                $fallo_validacion = true;
                $message_validacion = 'La descripción del articulo es requerida';
            }

            if(!strlen($cod_profit) > 0){
                $fallo_validacion = true;
                $message_validacion = 'El código profit del articulo es requerido';
            }

            if (!preg_match($this->patternCodProfit, $cod_profit)){
                $fallo_validacion = true;
                $message_validacion = 'El código de profit no cumple con el formato requerido';
            }

            if(strlen($cod_barra) > 0){
                if (!preg_match($this->patternCodBarra, $cod_barra)){
                    $fallo_validacion = true;
                    $message_validacion = 'El código de barra no cumple con el formato requerido';
                }
            }

            if($fallo_validacion){
                return [false,$message_validacion];
            }

            

        }

    }
