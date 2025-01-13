<?php
    require_once '../../../connection/connection.php';


    class FallasDespachadorModel extends Connection{

        private $conn;

        public function __construct(){
            $this->conn = self::getInstance()->getConnection();
        }

        public function extraer_fallas($fechaI="", $fechaF=""):array{
            $sql = "SELECT COUNT(fallas_despachador.id) as cantidad_fallas,
            empleados.nombre as nombre,
            empleados.apellido as apellido,
            empleados.id as id_despachador
            FROM 
                fallas_despachador
            INNER JOIN
                empleados on fallas_despachador.despachador=empleados.id
            WHERE 
                fecha BETWEEN '$fechaI' AND  '$fechaF'
            GROUP BY 
                empleados.id, empleados.nombre, empleados.apellido
            ORDER BY 
                cantidad_fallas DESC;";

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

        public function extraer_total_fallas($fechaI="", $fechaF=""):array{
            $sql = "SELECT COUNT(fallas_despachador.id) as cantidad_total_fallas
            WHERE fecha BETWEEN '$fechaI' AND  '$fechaF'
            ORDER BY cantidad_fallas DESC";

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
    