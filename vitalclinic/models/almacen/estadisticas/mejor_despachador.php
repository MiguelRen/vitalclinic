<?php
    require_once '../../../connection/connection.php';


    class MejorDespachadorModel extends Connection{

        private $conn;

        public function __construct(){
            $this->conn = self::getInstance()->getConnection();
        }

        public function extraer_pedidos($fechaI="", $fechaF=""):array{
            $sql = "SELECT 
            COUNT(pedidos_d_r_e.id_despachador) AS total_pedidos,
            SUM(pedidos.cantidad_unidades) as total_unidades,
            empleados.nombre, 
            empleados.apellido,
            empleados.cedula
            FROM 
                pedidos_d_r_e 
            INNER JOIN 
                pedidos ON pedidos_d_r_e.id_pedido=pedidos.id_pedido    
            INNER JOIN 
                empleados ON pedidos_d_r_e.id_despachador = empleados.id
            WHERE
                fecha BETWEEN '$fechaI' AND  '$fechaF'     
            GROUP BY 
                empleados.id, empleados.nombre, empleados.apellido, empleados.cedula
            ORDER BY total_pedidos DESC";

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

        public function extraer_pedidos2($fechaI="", $fechaF=""):array{
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
            WHERE fecha BETWEEN '$fechaI' AND  '$fechaF' ORDER BY numero_pedido";

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
