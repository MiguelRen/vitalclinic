<?php
    require_once '../../../connection/connection.php';


    class FallasDetectadasRechequeadorModel extends Connection{

        private $conn;

        public function __construct(){
            $this->conn = self::getInstance()->getConnection();
        }

        public function extraer_estadisticas($fechaI="", $fechaF=""):array{
            $sql = "SELECT  
                count(pedidos_d_r_e.id_rechequeador) as fallas_detectadas,
                accounts.id_account as id_rechequeador, 
                empleados.nombre as nombre,
                empleados.apellido as apellido
            FROM 
                fallas_despachador 
            INNER JOIN 
                pedidos_d_r_e ON fallas_despachador.id_pedido_d_r_e=pedidos_d_r_e.id
            INNER JOIN 
                accounts ON pedidos_d_r_e.id_rechequeador=accounts.id_account
            INNER JOIN 
                empleados ON accounts.id_empleado=empleados.id
            WHERE
                fecha BETWEEN '$fechaI' AND  '$fechaF'
            GROUP BY
                empleados.nombre,empleados.apellido
            ORDER BY 
                fallas_detectadas DESC;";

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
    