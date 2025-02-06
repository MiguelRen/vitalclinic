<?php
    require_once '../../../connection/connection.php';


    class PedidosPorFechaModel extends Connection{

        private $conn;

        public function __construct(){
            $this->conn = self::getInstance()->getConnection();
        }

        public function extraer_pedidos($fechaI="", $fechaF="", $ruta=""):array{
            $query_extraer_pedidos = "SELECT 
            id_pedido,
            numero_pedido, 
            rutas.name as ruta, 
            fecha, 
            cantidad_unidades, 
            empleados.nombre, 
            empleados.apellido FROM `pedidos` 
            INNER JOIN rutas on pedidos.id_ruta=rutas.id 
            INNER JOIN accounts on pedidos.distribuidor_pedidos=accounts.id_account 
            INNER JOIN empleados on accounts.id_empleado=empleados.id 
            WHERE fecha BETWEEN '$fechaI' AND  '$fechaF'";
            
            $query_extraer_pedidos_por_ruta = "SELECT 
            numero_pedido, 
            rutas.name as ruta, 
            fecha, 
            cantidad_unidades, 
            empleados.nombre, 
            empleados.apellido FROM `pedidos` 
            INNER JOIN rutas on pedidos.id_ruta=rutas.id 
            INNER JOIN accounts on pedidos.distribuidor_pedidos=accounts.id_account 
            INNER JOIN empleados on accounts.id_empleado=empleados.id 
            WHERE fecha BETWEEN '$fechaI' AND  '$fechaF' AND rutas.id = '$ruta'";

            $sql = (strlen($ruta) > 0) ? $query_extraer_pedidos_por_ruta : $query_extraer_pedidos;

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
    }
