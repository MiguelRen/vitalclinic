<?php
    require_once '../../../connection/connection.php';

    class RutasModel extends Connection{

        private $conn;

        public function __construct(){
            $this->conn = self::getInstance()->getConnection();
        }

        public function registrar_ruta($ruta = "") {
            // Consulta SQL
            $sql = "INSERT INTO rutas (name) VALUES (?)";
            
            $is_register = false;
    
            // Preparar la consulta
            $stmt = $this->conn->prepare($sql);
            
            if ($stmt === false) {
                die('Error en la preparación de la consulta: ' . $this->conn->error);
            }
    
            // Vincular parámetros
            $stmt->bind_param("s", $ruta);
    
            // Ejecutar la consulta
            if ($stmt->execute()) {
                $is_register = true;
            }
    
            // Cerrar la declaración
            $stmt->close();
            // Cerrar la conexión
            // $this->conn->close();
    
            return $is_register;
        }
        
        public function extraer_data_rutas(){
            $sql = "SELECT * FROM rutas";

            $result = $this->conn->query($sql);

            // Devolver los resultados como un array JSON
            $data_rutas = array();
            if ($result->num_rows > 0) {
                // Output data of each row
                while($row = $result->fetch_assoc()) {
                    $data_rutas[] = $row;
                }
            }

            // Cerrar conexión
            //$this->conn->close();
            return $data_rutas;
        }
    }
