<?php

    require_once './connection/connection.php';

    class ControlPrivilegiosModel extends Connection{
        private $conn;

        public function __construct(){
            $this->conn =  $this->conn = self::getInstance()->getConnection();
        }

        public function verificar_privilegios($privilegio){
            $sql = "SELECT 
            roles_privilegios.id_role 
            from privilegios 
            inner join roles_privilegios 
            on privilegios.id = roles_privilegios.id_privilegio 
            where accion = '$privilegio'";

            $result = $this->conn->query($sql);
                
            // Devolver los resultados como un array JSON
            $roles = array();
            if ($result->num_rows > 0) {
                // Output data of each row
                while($row = $result->fetch_assoc()) {
                    $roles[] = $row;
                }
            }

            return $roles;
        }
    }
