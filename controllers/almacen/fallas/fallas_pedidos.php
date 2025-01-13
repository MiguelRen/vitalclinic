<?php
    include "../../../models/almacen/fallas/fallas_pedidos.php";
	// Habilitar CORS solo para solicitudes desde http://webvital
    // header("Access-Control-Allow-Origin: http://webvital");
     // Permitir solo solicitudes POST y GET
    // header("Access-Control-Allow-Methods: POST, GET,PUT,DELETE");
     // Permitir ciertos encabezados
    // header("Access-Control-Allow-Headers: Content-Type");
     //Recibir las urls y decidir que accion ejecutar
    class FallasController{

        public function extraer_motivos_fallas(){
            $motivos = new FallasModel();
            $data = $motivos->extraer_motivos_fallas();
            return $data;
        }

        public function registrar_fallas($id_despachador = "",$motivo = "",$descripcion = "", $id_pedido_d_r_e = ""){
            $motivos = new FallasModel();
            $data = $motivos->registrar_fallas($id_despachador,$motivo,$descripcion,$id_pedido_d_r_e);
            return $data;
        }

        public function extraer_fallas_despachador($numero_pedido = ""){
            $motivos = new FallasModel();
            $data = $motivos->extraer_fallas_despachador($numero_pedido);
            return $data;
        }

        public function eliminar_falla_despachador($id_falla = ""){
            $motivos = new FallasModel();
            $data = $motivos->eliminar_falla_despachador($id_falla);
            return $data;
        }
    }

    if(isset($_GET['extraer_motivos'])){
        $controller = new FallasController();
        $data = $controller->extraer_motivos_fallas();
        echo json_encode($data);
    }


    if(isset($_GET['registrar_fallas'])){

        $id_despachador = $_POST['id_despachador'];
        $motivo = $_POST['motivo'];
        $descripcion = $_POST['descripcion'];
        $id_pedido_d_r_e = $_POST['id_pedido_d_r_e'];

        $controller = new FallasController();
        $data = $controller->registrar_fallas($id_despachador,$motivo,$descripcion,$id_pedido_d_r_e);
        if($data){
            $response = [
                "data" => [$data],
                "error" => [],
            ];
            echo json_encode($response);
        }else{
            $response = [
                "data" => [],
                "error" => ["Ha ocurrido un error"],
            ];
            echo json_encode($response);
        }
    }

    if(isset($_GET['extraer_fallas_despachador'])){
        $numero_pedido = $_POST['numero_pedido'];

        $controller = new FallasController();
        $data = $controller->extraer_fallas_despachador($numero_pedido);
        if(count($data)>0){
            $response = [
                "data" => [$data],
                "error" => [],
            ];
            echo json_encode($response);
        }else{
            $response = [
                "data" => [],
                "error" => ["Ha ocurrido un error"],
            ];
            echo json_encode($response);
        }
    }

    if(isset($_GET['eliminar_falla_despachador'])){
        $id_falla = $_POST['id_falla'];

        $controller = new FallasController();
        $data = $controller->eliminar_falla_despachador($id_falla);

        if($data){
            $response = [
                "data" => [$data],
                "error" => [],
            ];
            echo json_encode($response);
        }else{
            $response = [
                "data" => [],
                "error" => ["Ha ocurrido un error"],
            ];
            echo json_encode($response);
        }
    }

    
