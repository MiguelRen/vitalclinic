<?php
    include "../../../models/almacen/estadisticas/fallas_despachador.php";

    class FallasDespachador{
        
        private static $instance = null;
        private $model = null;
        // Constructor privado para evitar instanciación externa
        private function __construct() {
            $this->model = new FallasDespachadorModel();
        }

        // Método para obtener la instancia de la conexión
        public static function getInstance() {
            if (self::$instance == null) {
                self::$instance = new FallasDespachador();
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

        public function obtener_total_fallas($array_data){
            $cantidad = 0;

            foreach($array_data as $item){
               
                    $cantidad = $item['cantidad_fallas'] + $cantidad;
                
            }

            return $cantidad;
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
                    if ($a[$j]['cantidad_fallas'] > $a[$j + 1]['cantidad_fallas']) {
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

        public function calcular_porcentaje_fallas_despachador($array_fallas){
            $array_fallas_por_despachador = [];
            $total_fallas = $this->obtener_total_fallas($array_fallas);

            foreach($array_fallas as $item){
                
                //Crear el indice del despachador en el array despachador
               
                    $id_despachador = $item['id_despachador'];

                    // Verifica si la clave ya existe en el array agrupado
                    if (!isset($array_fallas_por_despachador[$id_despachador])) {
                        // Si no existe, inicializa con el objeto actual
                        //Asignar porcentaje del pedido al despachador correspondient
                        $nombre = $item['nombre'] . " " . $item['apellido'];
                        $array_pedidos_por_despachador[$id_despachador] = [
                            "cantidad_fallas" => $item['cantidad_fallas'],
                            "nombre_despachador" => $nombre,
                            "porc_fallas" => round((($item['cantidad_fallas'] / $total_fallas) * 100),2)
                        ];
                    }
                
            }

            return $array_pedidos_por_despachador;
        }

        

        public function extraer_fallas( $fechaI="", $fechaF=""){
            $data = $this->model->extraer_fallas($fechaI,$fechaF);

            if(count($data) > 0){
                $f = $this->ordenar_data_mayor_a_menor($this->calcular_porcentaje_fallas_despachador($data));
                return $this->jsonResponse($f,[]);
            }else{
                return $this->jsonResponse([],['no hay pedidos']);
            }
            
        }

    }

    // Enrutador
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if (isset($_GET['extraer_pedidos'])) {
      FallasDespachador::getInstance()->extraer_fallas($_POST['fechai'], $_POST['fechaf']);
    }

    // Otros endpoints...
}

// Manejo de errores global
set_exception_handler(function ($e) {
    echo json_encode(["error" => ["Ha ocurrido un error: " . $e->getMessage()]]);
    exit;
});