<?php
    include "../../../models/almacen/pedidos/pedidos.php";
	// Habilitar CORS solo para solicitudes desde http://webvital
    // header("Access-Control-Allow-Origin: http://webvital");
     // Permitir solo solicitudes POST y GET
    // header("Access-Control-Allow-Methods: POST, GET,PUT,DELETE");
     // Permitir ciertos encabezados
    // header("Access-Control-Allow-Headers: Content-Type");
     //Recibir las urls y decidir que accion ejecutar
    class PedidosController{
        public function registrar_pedido($cod_pedido="",$despachadores=[],$ruta="",$cant_unidades=""){
            //VALIDAR DATA
            $model = new PedidosModel();
            $data = $model->registrar_pedido($cod_pedido, $despachadores,$ruta,$cant_unidades);
            return $data;
        }
        
        public function extraer_data_pedido($cod_pedido = ""){
            $model = new PedidosModel();
            $data = $model->extraer_data_pedido($cod_pedido);
            return $data;
        }

        public function modificar_pedido($id_pedido="",$despachadores=[],$id_parte_pedidos=[],$ruta="",$cant_unidades=""){
            $model = new PedidosModel();
            $data = $model->modificar_pedido($id_pedido,$despachadores,$id_parte_pedidos,$ruta,$cant_unidades);
            return $data;
        }

        public function eliminar_pedido($cod_pedido=""){
            $model = new PedidosModel();
            $data = $model->eliminar_pedido($cod_pedido);
            return $data;
        }

        //Funcion usada solo en la vista de consultar pedido
        public function consultar_pedido($numero_pedido = ""){
            $model = new PedidosModel();
            $data = $model->consultar_pedido($numero_pedido);
            return $data;
        }
    }

    if(isset($_GET['registrar_pedido'])){
        $cod_pedido = $_POST['cod_pedido'];
        $ruta = $_POST['ruta'];
        $despachadores = $_POST['despachadores'];
        $cant_unidades = $_POST['cant_unidades'];
    
        $registro = new PedidosController();
        $data = $registro->registrar_pedido($cod_pedido, $despachadores, $ruta, $cant_unidades);
        if($data[0] == true){
            $response = [
                "data" => [$data[0]],
                "error" => [],
            ];
            echo json_encode($response);
        }else{
            $response = [
                "data" => [],
                "error" => [$data[1]],
            ];
            echo json_encode($response);
        }
    }

    if(isset($_GET['modificar_pedido'])){
        /**
         * El id del pedido se refiere a la clave primaria de la tabla pedidos
         * El cod_pedido se refiere al numero de pedido de la tabla pedidos
         * Que porque no use numero de pedido en vez de cod_pedido?, no lo sé, Sorry
         */

        $id_pedido = $_POST['id_pedido']; 
        $ruta = $_POST['ruta'];
        $despachadores = $_POST['despachadores'];
        $id_parte_pedidos = $_POST['id_parte_pedidos'];
        $cant_unidades = $_POST['cant_unidades'];
    
        $controller = new PedidosController();
        $data = $controller->modificar_pedido($id_pedido,$despachadores,$id_parte_pedidos,$ruta,$cant_unidades);
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

    if(isset($_GET['extraer_data_pedido'])){

        $cod_pedido = $_POST['cod_pedido'];
        $registro = new PedidosController();
        $data = $registro->extraer_data_pedido($cod_pedido);

        if(count($data) > 0){
            //Ordenar data

            $dataPedido = new stdClass();
            $array = array();
            foreach($data as $posicion => $dato){
                if($posicion < 1){
                    $dataPedido->cantidad_unidades = $dato['cantidad_unidades'];
                    $dataPedido->distribuidor_pedidos = $dato['distribuidor_pedidos'];
                    $dataPedido->fecha = $dato['fecha'];
                    $dataPedido->numero_pedido = $dato['numero_pedido'];
                    $dataPedido->id_ruta = $dato['id_ruta'];
                    $dataPedido->id_pedido = $dato['id_pedido'];
                }
               
                $parte = new stdClass();
                $parte->id_pedido_d_r_e = $dato['id_pedido_d_r_e'];
                $parte->id_despachador = $dato['id_despachador'];
                $parte->id_rechequeador = $dato['id_rechequeador'];
                $parte->id_embalador = $dato['id_embalador'];
                $parte->fecha_rechequeado = $dato['fecha_rechequeado'];
                $parte->nombre = $dato['nombre'];
                $parte->apellido = $dato['apellido'];

                array_push($array,$parte);
                $dataPedido->partes_pedido = $array;
            }

            $response = [
                "data" => [$dataPedido],
                "error" => [],
            ];
            echo json_encode($response);
        }else{
            $response = [
                "data" => [],
                "error" => ["Pedido no se encuentra registrado"],
            ];
            echo json_encode($response);
        }

    }

    if(isset($_GET['eliminar_pedido'])){
        $cod_pedido = $_POST['cod_pedido'];
        $controller = new PedidosController();
        $data = $controller->eliminar_pedido($cod_pedido);
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

    if(isset($_GET['consultar_pedido'])){
        $numero_pedido = $_POST['numero_pedido'];
        $controller = new PedidosController();
        $data = $controller->consultar_pedido($numero_pedido);
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

