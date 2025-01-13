<?php
    include "../../../models/almacen/estadisticas/fallas_detectadas_rechequeador.php";

    class FallasDetectadasRechequeador{
        
        private static $instance = null;
        private $model = null;
        // Constructor privado para evitar instanciación externa
        private function __construct() {
            $this->model = new FallasDetectadasRechequeadorModel();
        }

        // Método para obtener la instancia de la conexión
        public static function getInstance() {
            if (self::$instance == null) {
                self::$instance = new FallasDetectadasRechequeador();
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

        public function calcular_total_fallas_detectadas($array){
            $total_fallas = 0;
            foreach($array as $item){
                $total_fallas = $total_fallas + (int) $item['fallas_detectadas'];
            }
            return $total_fallas;
        }

        public function calcular_porc_fallas($array_fallas_detectadas){
            $array_fallas_detectadas_por_rechequeador = [];
            $total_fallas = $this->calcular_total_fallas_detectadas($array_fallas_detectadas);

            foreach($array_fallas_detectadas as $item){
                $id_rechequeador = $item['id_rechequeador'];
                // Verifica si la clave ya existe en el array agrupado
                if (!isset($array_fallas_detectadas_por_rechequeador[$id_rechequeador])) {
                    // Si no existe, inicializa con el objeto actual
                    //Asignar porcentaje del pedido al despachador correspondient
                    $nombre = $item['nombre'] . " " . $item['apellido'];
                    $array_fallas_detectadas_por_rechequeador[$id_rechequeador] = [
                        "nombre_rechequeador" => $nombre,
                        "fallas_detectadas" => $item['fallas_detectadas'],
                        "porc_fallas" => round((($item['fallas_detectadas'] / $total_fallas) * 100),2), 
                    ];
                }
            }
            return  $array_fallas_detectadas_por_rechequeador;
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
                    if ($a[$j]['fallas_detectadas'] > $a[$j + 1]['fallas_detectadas']) {
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

        public function extraer_estadisticas( $fechaI="", $fechaF=""){
            $data = $this->model->extraer_estadisticas($fechaI,$fechaF);
            
            if(count($data) > 0){
                $f = $this->ordenar_data_mayor_a_menor($this->calcular_porc_fallas($data));
                return $this->jsonResponse($f,[]);
            }else{
                return $this->jsonResponse([],['no hay pedidos']);
            }
            
        }
    }

    // Enrutador
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if (isset($_GET['extraer_pedidos'])) {
      FallasDetectadasRechequeador::getInstance()->extraer_estadisticas($_POST['fechai'], $_POST['fechaf']);
    }

    // Otros endpoints...
}

// Manejo de errores global
set_exception_handler(function ($e) {
    echo json_encode(["error" => ["Ha ocurrido un error: " . $e->getMessage()]]);
    exit;
});