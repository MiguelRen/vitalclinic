<?php
    require_once '../../../connection/connection.php';


    class PedidosPorDespachadorModel extends Connection{

        private $conn;

        public function __construct(){
            $this->conn = self::getInstance()->getConnection();
        }

        public function extraer_pedidos2($fechaI="", $fechaF="",$empleado=""):array{
            $sql = "SELECT
            numero_pedido,   
            cantidad_unidades,
            pedidos_d_r_e.id as parte_pedido,
            pedidos_d_r_e.id_despachador as id_despachador, 
            empleados.nombre, 
            empleados.apellido 
            FROM `pedidos`
            LEFT JOIN pedidos_d_r_e on pedidos.id_pedido=pedidos_d_r_e.id_pedido 
            INNER JOIN empleados on pedidos_d_r_e.id_despachador=empleados.id 
            WHERE fecha BETWEEN '$fechaI' AND  '$fechaF' and pedidos_d_r_e.id_despachador = '$empleado' ORDER BY numero_pedido";

            $result = $this->conn->query($sql);
            // Devolver los resultados como un array JSON
            $data = array();
            if ($result->num_rows > 0) {
                // Output data of each row
                while($row = $result->fetch_assoc()) {
                    $data[] = $row;
                }
            }
    
            return $data;
        }

        public function extraer_info_pedidos($fechaI="", $fechaF="",$empleado=""):array{
            $sql = "SELECT *
            FROM `pedidos`
            INNER JOIN pedidos_d_r_e on pedidos.id_pedido=pedidos_d_r_e.id_pedido
            INNER JOIN rutas on pedidos.id_ruta=rutas.id  
            WHERE fecha BETWEEN '$fechaI' AND  '$fechaF' and pedidos_d_r_e.id_despachador = '$empleado' ORDER BY numero_pedido DESC";

            $result = $this->conn->query($sql);
            // Devolver los resultados como un array JSON
            $data = array();
            if ($result->num_rows > 0) {
                // Output data of each row
                while($row = $result->fetch_assoc()) {
                    $data[] = $row;
                }
            }
    
            return $data;
        }

        // public function extraer_pedidos($fechaI="", $fechaF="", $empleado=""):array{

        //     $sql = "SELECT 
        //     COUNT(pedidos_d_r_e.id_despachador) as cantidad_pedidos, 
        //     SUM(pedidos.cantidad_unidades) as cantidad_unidades, 
        //     COUNT(fallas_despachador.id) as cantidad_fallas, 
        //     nombre as nombre_despachador, 
        //     apellido as apellido_despachador 
        //     FROM `pedidos_d_r_e` 
        //     INNER JOIN pedidos on pedidos_d_r_e.id_pedido=pedidos.id_pedido 
        //     LEFT JOIN fallas_despachador on pedidos_d_r_e.id=fallas_despachador.id_pedido_d_r_e 
        //     INNER JOIN empleados on pedidos_d_r_e.id_despachador=empleados.id  
        //     WHERE pedidos.fecha BETWEEN '$fechaI' AND  '$fechaF' AND pedidos_d_r_e.id_despachador = '$empleado'";

        //     $result = $this->conn->query($sql);
        //     // Devolver los resultados como un array JSON
        //     $data = array();
        //     if ($result->num_rows > 0) {
        //         // Output data of each row
        //         while($row = $result->fetch_assoc()) {
        //             $data[] = $row;
        //         }
        //     }
    
        //     return $data;
        // }
    }