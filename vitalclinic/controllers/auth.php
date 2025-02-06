<?php

    include "../models/auth_model.php";
    include "./control_de_sessiones.php";
    
   // Hanilitar CORS solo para solicitudes des http://webvital
 //  header("Access-Control-Allow-Origin: http://webvital");
  //Permitir solo solicitudes POST, GET, DELETE, PUT
 // header("Access-Control-Allow-Methods: POST, GET, DELETE, PUT");
  // Permitir ciertos encabezados
 // header("Access-control-Allow-headers: Content-type");
class Auth{

    public function login($username="",$password=""){
        //Validar Data
        //DETENGO EL PROCESO E INFORMO QUE NO SE CUMPLIERON LAS VALIDACIONES
        
        //SI CUMPLE CON LAS VALIDACIONES
        $model = new AuthModel();
        $data = $model->login($username,$password);

        if(count($data) > 0){

            if($data[0]['status'] == 2){
                return [false,"Usuario Inhabilitado"];
            }

            $crear_session = new ControlSesiones();
            $session = $crear_session->generar_sesion($data[0]['username'],$data[0]['nombre'],$data[0]['apellido'],$data[0]['role_id'],$data[0]['id_account'],$data[0]['departamento']);
            return [true,$session];
        }else{
            // En caso contrario indicamos que las credenciales estan erroneas
            return [false,"Credenciales Incorrectas"];
        }
    }
}

if(isset($_GET['auth'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $auth = new Auth();
    $acceso = $auth->login($username,$password);

    if($acceso[0] == true){
        $response = [
            "data" => [$acceso[0]],
            "error" => [],
        ];
        echo json_encode($response);
    }else{
        $response = [
            "data" => [],
            "error" => [$acceso[1]],
        ];
        echo json_encode($response);
    }
}

