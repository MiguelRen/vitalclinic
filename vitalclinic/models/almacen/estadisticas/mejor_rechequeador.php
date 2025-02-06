<?php
    require_once '../../../connection/connection.php';


    class MejorRechequeadorModel extends Connection{

        private $conn;

        public function __construct(){
            $this->conn = self::getInstance()->getConnection();
        }

        public function extraer_estadisticas($fechaI="", $fechaF=""):array{
            $sql = "SELECT
            numero_pedido,   
            pedidos_d_r_e.id as parte_pedido,
            pedidos_d_r_e.id_rechequeador as id_rechequeador, 
            empleados.nombre, 
            empleados.apellido 
            FROM 
                `pedidos`
            LEFT JOIN 
                pedidos_d_r_e on pedidos.id_pedido=pedidos_d_r_e.id_pedido
            LEFT JOIN 
                accounts on pedidos_d_r_e.id_rechequeador=accounts.id_account
            INNER JOIN 
                empleados on accounts.id_empleado =empleados.id
            WHERE 
                fecha BETWEEN '$fechaI' AND  '$fechaF' ORDER BY numero_pedido";

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