<?php
    include "../../../models/almacen/estadisticas/mejor_rechequeador.php";

    class MejorRechequeador{
        
        private static $instance = null;
        private $model = null;
        // Constructor privado para evitar instanciación externa
        private function __construct() {
            $this->model = new MejorRechequeadorModel();
        }

        // Método para obtener la instancia de la conexión
        public static function getInstance() {
            if (self::$instance == null) {
                self::$instance = new MejorRechequeador();
            }
            return self::$instance;
        }

        private function jsonResponse($data, $error = []) {
            echo json_encode([
                "data" => $data,
                "error" => $error,
            ]);
            exit; // Termina la ejecución después de enviar la respuesta
        }


        public function ordenar_info($data) {
            $grouped_data = [];
        
            foreach ($data as $item) {
                $key = $item['numero_pedido'];
        
                // Verifica si la clave ya existe en el array agrupado
                if (!isset($grouped_data[$key])) {
                    // Si no existe, inicializa con el objeto actual
                    $grouped_data[$key] = [$item];
                } else {
                    // Si existe, agrega el objeto actual al array existente
                    $grouped_data[$key][] = $item; // Agrega directamente
                }
            }
        
            return $grouped_data;
        }

        public function porcentaje_por_pedidos($partes_pedidos = 0){
            return 1 / $partes_pedidos;
        }

        public function contar_pedidos($array_pedidos){
            $array_pedidos_por_rechequeador = [];
            $total_pedidos = count($array_pedidos);

            foreach($array_pedidos as $item){
                //Verificar cuantas partes tiene el pedido
                $count_partes_pedido = count($item);

                //Calcular porcentaje por cada parte
                $porcentaje_pedido_por_rechequeador = $this->porcentaje_por_pedidos($count_partes_pedido);

                //Crear el indice del despachador en el array despachador
                foreach($item as $i){
                    $id_rechequeador = $i['id_rechequeador'];

                    // Verifica si la clave ya existe en el array agrupado
                    if (!isset($array_pedidos_por_rechequeador[$id_rechequeador])) {
                        // Si no existe, inicializa con el objeto actual
                        //Asignar porcentaje del pedido al despachador correspondient
                        $nombre = $i['nombre'] . " " . $i['apellido'];
                        $array_pedidos_por_rechequeador[$id_rechequeador] = [
                            "pedidos"=>round($porcentaje_pedido_por_rechequeador,2), 
                            "nombre_despachador" => $nombre,
                            "porc_pedidos" => round((($porcentaje_pedido_por_rechequeador / $total_pedidos) * 100),2),
                        ];
                    } else {
                        // Si existe, agrega el objeto actual al array existente
                        //Incrementar porcentaje de pedidos al despachador correspondiente
                        $array_pedidos_por_rechequeador[$id_rechequeador]['pedidos'] = round($array_pedidos_por_rechequeador[$id_rechequeador]['pedidos'] + $porcentaje_pedido_por_rechequeador,2);
                        //Incrementar porcentaje de pedidos con respecto al total de pedidos al despachador correspondiente
                        $array_pedidos_por_rechequeador[$id_rechequeador]['porc_pedidos'] = round((($array_pedidos_por_rechequeador[$id_rechequeador]['pedidos'] / $total_pedidos) * 100),2);
                    }
                }
            }

            return $array_pedidos_por_rechequeador;
        }

        public function ordenar_data_mayor_a_menor($array_data){

            $a = [];
            foreach($array_data as $item){
                array_push($a, $item);
            }

            //Algoritmo de ordenamiento burbuja
            for ($i = 0; $i < count($a) - 1; $i++) {
                for ($j = 0; $j < count($a) - 1 - $i; $j++) {
                    // Comparar el elemento actual con el siguiente
                    if ($a[$j]['pedidos'] > $a[$j + 1]['pedidos']) {
                        // Intercambiar elementos
                        $aux = $a[$j + 1];
                        $a[$j + 1] = $a[$j];
                        $a[$j] = $aux;
                    }
                }
            }

            $arrayInvertido = array_reverse($a);
            return $arrayInvertido;
        }

        public function extraer_pedidos( $fechaI="", $fechaF=""){
            $data = $this->model->extraer_estadisticas($fechaI,$fechaF);

            if(count($data) > 0){
                $f = $this->ordenar_data_mayor_a_menor($this->contar_pedidos($this->ordenar_info($data)));
                return $this->jsonResponse($f,[]);
            }else{
                return $this->jsonResponse([],['no hay pedidos']);
            }
            
        }

    }

    // Enrutador
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if (isset($_GET['extraer_pedidos'])) {
      MejorRechequeador::getInstance()->extraer_pedidos($_POST['fechai'], $_POST['fechaf']);
    }

    // Otros endpoints...
}

// Manejo de errores global
set_exception_handler(function ($e) {
    echo json_encode(["error" => ["Ha ocurrido un error: " . $e->getMessage()]]);
    exit;
});