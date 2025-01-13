<?php
    include "../../models/users/empleados.php";
	// Habilitar CORS solo para solicitudes desde http://webvital
    // header("Access-Control-Allow-Origin: http://webvital");
     // Permitir solo solicitudes POST y GET
    // header("Access-Control-Allow-Methods: POST, GET,PUT,DELETE");
     // Permitir ciertos encabezados
    // header("Access-Control-Allow-Headers: Content-Type");
     //Recibir las urls y decidir que accion ejecutar
    class EmpleadosController{

        public function registrar_empleado($cedula="",$name="",$lastname="",$departamento=""){
            //VALIDAR DATA
            $model = new EmpleadosModel();
            $data = $model->registrar_empleado($cedula,$name,$lastname,$departamento);
            return $data;
        }


        public function registrar_usuario($empleado="",$username="",$password="",$role=""){
            //VALIDAR DATA
            $model = new EmpleadosModel();
            $data = $model->registrar_usuario($empleado,$username,$password,$role);
            return $data;
        }

        public function modificar_empleado($id="",$cedula="",$name="",$lastname="",$status=""){
            //VALIDAR DATA
            $model = new EmpleadosModel();
            $data = $model->modificar_empleado($id,$cedula,$name,$lastname,$status);
            return $data;
        }

        public function modificar_account($id="",$username="",$password="",$role="",$status=""){
            //VALIDAR DATA
            $model = new EmpleadosModel();
            $data = $model->modificar_account($id,$username,$password,$role,$status);
            return $data;
        }

        public function buscar_empleado($cedula=""){
            //VALIDAR DATA
            $model = new EmpleadosModel();
            $data = $model->buscar_empleado($cedula);
            return $data;
        }

        public function extraer_data_empleados($order=1,$departamento=1){
            $model = new EmpleadosModel();
            $data = $model->extraer_datos_empleados($order,$departamento);
            return $data;
        }

        public function extraer_data_empleados2($order=1,$departamento=1){
            $model = new EmpleadosModel();
            $data = $model->extraer_datos_empleados2($order,$departamento);
            return $data;
        }

        public function extraer_data_accounts(){
            $model = new EmpleadosModel();
            $data = $model->extraer_datos_accounts();
            return $data;
        }

        public function extraer_datos_roles(){
            $model = new EmpleadosModel();
            $data = $model->extraer_datos_roles();
            return $data;
        }

        public function extraer_departamentos(){
            $model = new EmpleadosModel();
            $data = $model->extraer_departamentos();
            return $data;
        }
    }

    if(isset($_GET['registrar_empleado'])){
        $cedula = $_POST['cedula'];
        $name = $_POST['name'];
        $lastname = $_POST['lastname'];
        $departamento = $_POST['departamento'];
    
        $registro = new EmpleadosController();
        $data = $registro->registrar_empleado($cedula,$name,$lastname,$departamento);
        if($data[0] == true){
            $response = [
                "data" => [$data[0]],
                "error" => [],
            ];
            echo json_encode($response);
        }else{
            $response = [
                "data" => [],
                "error" => [$data[1]],
            ];
            echo json_encode($response);
        }
    }
    
    if(isset($_GET['registrar_usuario'])){
        $empleado = $_POST['empleado'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $role = $_POST['role'];
    
        $registro = new EmpleadosController();
        $data = $registro->registrar_usuario($empleado,$username,$password,$role);
        echo json_encode($data);
    }

    if(isset($_GET['modificar_empleado'])){
        $cedula = $_POST['cedula'];
        $name = $_POST['name'];
        $lastname = $_POST['lastname'];
        $id = $_POST['id'];
        $status = $_POST['status'];
    
        $controller = new EmpleadosController();

        $data = $controller->modificar_empleado($id,$cedula,$name,$lastname,$status);
        if($data){
            $response = [
                "data" => [$data],
                "error" => [],
            ];
            echo json_encode($response);
        }else{
            $response = [
                "data" => [],
                "error" => ["Ha ocurrido un error"],
            ];
            echo json_encode($response);
        }
    }

    if(isset($_GET['modificar_account'])){
        $username = $_POST['username'];
        $password = $_POST['password'];
        $role = $_POST['role'];
        $id = $_POST['id'];
        $status = $_POST['status'];

        $controller = new EmpleadosController();

        $data = $controller->modificar_account($id,$username,$password,$role,$status);
        if($data){
            $response = [
                "data" => [$data],
                "error" => [],
            ];
            echo json_encode($response);
        }else{
            $response = [
                "data" => [],
                "error" => ["Ha ocurrido un error"],
            ];
            echo json_encode($response);
        }
    }

    if(isset($_GET['extraer_empleados'])){
        $order = $_POST['order'];
        // $departamento = $_POST['departamento'];

        $empleados = new EmpleadosController();
        $data = $empleados->extraer_data_empleados($order);
        echo json_encode($data);
    }

    if(isset($_GET['extraer_empleados2'])){
        $order = $_POST['order'];
        $departamento = $_POST['departamento'];

        $empleados = new EmpleadosController();
        $data = $empleados->extraer_data_empleados2($order,$departamento);
        echo json_encode($data);
    }

    if(isset($_GET['extraer_accounts'])){
        $empleados = new EmpleadosController();
        $data = $empleados->extraer_data_accounts();
        echo json_encode($data);
    }

    if(isset($_GET['extraer_roles'])){
        $empleados = new EmpleadosController();
        $data = $empleados->extraer_datos_roles();
        echo json_encode($data);
    }

    if(isset($_GET['extraer_departamentos'])){
        $empleados = new EmpleadosController();
        $data = $empleados->extraer_departamentos();
        echo json_encode($data);
    }


