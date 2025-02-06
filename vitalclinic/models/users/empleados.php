<?php
    require_once '../../connection/connection.php';

    class EmpleadosModel extends Connection{

        private $conn;

        public function __construct(){
            $this->conn = self::getInstance()->getConnection();
        }

        public function registrar_empleado($cedula = "", $name = "", $lastname = "",$departamento="1") {

            $empleado = $this->buscar_empleado($cedula);

            if(count($empleado) > 0){
                return [false,'Empleado ya se encuentra registrado'];
            }

            try {
                // Consulta SQL
                $sql = "INSERT INTO empleados (cedula, nombre, apellido,status,departamento,fecha_ingreso) VALUES (?, ?, ?,1,?,NOW())";
    
                // Preparar la consulta
                $stmt = $this->conn->prepare($sql);
            
                if ($stmt === false) {
                    die('Error en la preparación de la consulta: ' . $this->conn->error);
                }
    
                // Vincular parámetros
                $stmt->bind_param("ssss", $cedula, $name, $lastname,$departamento);
    
                // Ejecutar la consulta
                if (!$stmt->execute()) {
                    throw new Exception("Error al preparar la consulta: " . $this->conn->error);
                }
    
                // Cerrar la declaración
                $stmt->close();
                // Cerrar la conexión
                // $this->conn->close();
    
                return [true,''];
            } catch (Exception $e) {
                return [false,'Ocurrio un error al registrar empleado'];
            }
           
        }

        public function extraer_datos_empleados($order=1, $departamento=1){

            $ord = ""; 
            if($order == 1){
                $ord = ' order by nombre ASC';
            }else if($order == 2){
                $ord = ' order by cedula';
            }

            // session_start();
            // $departamento = $_SESSION['user']['departamento'];

            // $dep = " ";

            // if($dep == 2){
            //     $dep = " AND departamento = '$departamento' ";
            // }

            $sql = "SELECT * FROM empleados WHERE status=1  " . $ord;

            $result = $this->conn->query($sql);

            // Devolver los resultados como un array JSON
            $data_users = array();
            if ($result->num_rows > 0) {
                // Output data of each row
                while($row = $result->fetch_assoc()) {
                    $data_users[] = $row;
                }
            }

            // Cerrar conexión
            //$this->conn->close();
            return $data_users;
        }
        
        public function extraer_datos_empleados2($order=1, $selec_dep=1){

            $ord = ""; 
            if($order == 1){
                $ord = ' order by nombre ASC';
            }else if($order == 2){
                $ord = ' order by cedula';
            }

            session_start();
            $departamento = $_SESSION['user']['departamento'];

            $dep = " ";

            if($selec_dep == 2){
                $dep = " AND departamento = '$departamento' ";
            }

            //PARAMETROS VALIDOS PARA EL ORDER 1, 2
            // 1 : extrae los empleados ordenados por nombre
            // 2 : extrae los empleados ordenados por cedula
        
            //PARAMETROS VALIDOS PARA EL DEPARTAMENTO 1, 2
            // 1 : extrae TODOS los empleados sin importar departamento
            // 2 : extrae los empleados que pertenecen al mismo departamento que el usuario que tiene la session iniciada

            $sql = "SELECT * FROM empleados WHERE status=1  " . $dep . " " . $ord;

            $result = $this->conn->query($sql);

            // Devolver los resultados como un array JSON
            $data_users = array();
            if ($result->num_rows > 0) {
                // Output data of each row
                while($row = $result->fetch_assoc()) {
                    $data_users[] = $row;
                }
            }

            // Cerrar conexión
            //$this->conn->close();
            return $data_users;
        }

        public function extraer_departamentos(){

            $sql = "SELECT * FROM departamento";

            $result = $this->conn->query($sql);

            // Devolver los resultados como un array JSON
            $data_users = array();
            if ($result->num_rows > 0) {
                // Output data of each row
                while($row = $result->fetch_assoc()) {
                    $data_users[] = $row;
                }
            }

            // Cerrar conexión
            //$this->conn->close();
            return $data_users;
        }


        public function extraer_datos_accounts(){
            $sql = "SELECT * FROM accounts 
            WHERE status = 1 
            AND role_id != 1 order by username ASC";

            $result = $this->conn->query($sql);

            // Devolver los resultados como un array JSON
            $data_users = array();
            if ($result->num_rows > 0) {
                // Output data of each row
                while($row = $result->fetch_assoc()) {
                    $data_users[] = $row;
                }
            }

            // Cerrar conexión
            //$this->conn->close();
            return $data_users;
        }

        public function extraer_datos_roles(){
            $sql = "SELECT * FROM roles WHERE roles.id != 1 order by id";

            $result = $this->conn->query($sql);

            // Devolver los resultados como un array JSON
            $data_roles = array();
            if ($result->num_rows > 0) {
                // Output data of each row
                while($row = $result->fetch_assoc()) {
                    $data_roles[] = $row;
                }
            }

            // Cerrar conexión
            //$this->conn->close();
            return $data_roles;
        }

        public function registrar_usuario($empleado = "", $username = "", $password = "", $role = "") {
            // Consulta SQL
            $sql = "INSERT INTO accounts (id_empleado, username, password, role_id) VALUES (?, ?, ?, ?)";
            
            $is_register = false;
    
            // Preparar la consulta
            $stmt = $this->conn->prepare($sql);
            
            if ($stmt === false) {
                die('Error en la preparación de la consulta: ' . $this->conn->error);
            }
    
            // Vincular parámetros
            $stmt->bind_param("ssss", $empleado, $username, $password, $role);
    
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

        public function buscar_empleado($cedula=""){
            $sql = "SELECT * FROM empleados WHERE cedula = '$cedula'";

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

        public function modificar_empleado($id="",$cedula="",$name="",$lastname="",$status=""){
              // Consulta SQL
              $sql = "UPDATE empleados SET
              cedula = ?,
              nombre = ?, 
              apellido = ?,
              status = ?
              WHERE id = ?";
            
              $is_register = false;
      
              // Preparar la consulta
              $stmt = $this->conn->prepare($sql);
              
              if ($stmt === false) {
                  die('Error en la preparación de la consulta: ' . $this->conn->error);
              }
      
              // Vincular parámetros
              $stmt->bind_param("sssss",$cedula,$name,$lastname,$status,$id);
      
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

        public function modificar_account($id="",$username="",$password="",$role="",$status=""){
            // Consulta SQL
            $sql = "UPDATE accounts SET
            username = ?,
            password = ?, 
            role_id = ?,
            status = ?
            WHERE id_account = ?";
          
            $is_register = false;
    
            // Preparar la consulta
            $stmt = $this->conn->prepare($sql);
            
            if ($stmt === false) {
                die('Error en la preparación de la consulta: ' . $this->conn->error);
            }
    
            // Vincular parámetros
            $stmt->bind_param("sssss",$username,$password,$role,$status,$id);
    
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
    }
