<?php
    include "../../../models/almacen/rutas/rutas.php";
	// Habilitar CORS solo para solicitudes desde http://webvital
//     header("Access-Control-Allow-Origin: http://webvital");
     // Permitir solo solicitudes POST y GET
  //   header("Access-Control-Allow-Methods: POST, GET,PUT,DELETE");
     // Permitir ciertos encabezados
    // header("Access-Control-Allow-Headers: Content-Type");
     //Recibir las urls y decidir que accion ejecutar
    class RutasController{

        public function registrar_ruta($ruta=""){
            //VALIDAR DATA
            $model = new RutasModel();
            $data = $model->registrar_ruta($ruta);
            return $data;
        }

        public function extraer_data_rutas(){
            $model = new RutasModel();
            $data = $model->extraer_data_rutas();
            return $data;
        }
    }

    if(isset($_GET['registrar_ruta'])){
        $ruta = $_POST['ruta'];
    
        $registro = new RutasController();
        $data = $registro->registrar_ruta($ruta);
        echo json_encode($data);
    }

    if(isset($_GET['extraer_rutas'])){
        $registro = new RutasController();
        $data = $registro->extraer_data_rutas();
        echo json_encode($data);
    }
