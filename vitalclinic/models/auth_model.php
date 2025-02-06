<?php

    require_once '../connection/connection.php';

    class AuthModel extends Connection{
        private $conn;

        public function __construct(){
            $this->conn = self::getInstance()->getConnection();
        }

        public function login($username="",$password=""){
            $sql = "SELECT 
            id_account, 
            role_id,
            username,
            nombre,
            apellido,
            departamento,
            accounts.status
            FROM accounts
            inner join empleados
            on accounts.id_empleado = empleados.id
            WHERE username = '$username' AND password = '$password'";

            $result = $this->conn->query($sql);

            // Devolver los resultados como un array JSON
            $data_user = array();
            if ($result->num_rows > 0) {
                // Output data of each row
                while($row = $result->fetch_assoc()) {
                    $data_user[] = $row;
                }
            }

            // Cerrar conexión
            //$this->conn->close();
            return $data_user;
        }
    }
