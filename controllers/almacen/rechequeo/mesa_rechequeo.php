<?php

include "../../../models/almacen/rechequeo/mesa_rechequeo.php";

// Habilitar CORS solo para solicitudes desde http:webvital
//     header("Access-Control-Allow-Origin: http://webvital");
     // Permitir solo solicitudes POST y GET
  //   header("Access-Control-Allow-Methods: POST, GET,PUT,DELETE");
     // Permitir ciertos encabezados
    // header("Access-Control-Allow-Headers: Content-Type");
     //Recibir las urls y decidir que accion ejecutar
class MesaRechequeoController{

    public function registrar_pareja_rechequeadora($id_mesa = "", $id_rechequeador="", $id_embalador=""){
        $model = new MesaRechequeoModel();
        $data = $model->registrar_pareja_rechequeadora($id_mesa, $id_rechequeador, $id_embalador);
        return [$data];
    }
    public function consultar_parejas_rechequeadoras(){
        $model = new MesaRechequeoModel();
        $data = $model->consultar_parejas_rechequeadoras();
        return $data;
    }

    public function consultar_data_rechequeadores_embaladores(){
        $model = new MesaRechequeoModel();
        $data_rechequeadores = $model->consultar_rechequeadores();
        $data_embaladores = $model->consultar_embaladores();
        return ['data_rechequeadores' => $data_rechequeadores, 'data_embaladores' => $data_embaladores];
    }

    public function consultar_turnos(){
        $model = new MesaRechequeoModel();
        $data = $model->consultar_turnos();
        return $data;
    }

    public function crear_turno($hora_inicio = "", $hora_final = ""){
        $model = new MesaRechequeoModel();
        $data = $model->crear_turno($hora_inicio, $hora_final);
        return $data;
    }

    public function eliminar_turno($turno_seleccionado = ""){
        $model = new MesaRechequeoModel();
        $data = $model->eliminar_turno($turno_seleccionado);
        return $data;
    }
}

if(isset($_GET['consultar_data_rechequeadores_embaladores'])){
    $controller = new MesaRechequeoController();
    $data = $controller->consultar_data_rechequeadores_embaladores();
    
    if(count($data)>0){
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

if(isset($_GET['consultar_parejas_rechequeadoras'])){
  
  $controller = new MesaRechequeoController();
  $data = $controller->consultar_parejas_rechequeadoras();
  
  if(count($data)>0){
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

if(isset($_GET['registrar_pareja_rechequeadora'])){

    $id_mesa = $_POST['id_mesa']; 
    $id_rechequeador=$_POST['id_rechequeador'];
    $id_embalador=$_POST['id_embalador'];
  
    $controller = new MesaRechequeoController();
    $data = $controller->registrar_pareja_rechequeadora($id_mesa,$id_rechequeador,$id_embalador);
    
    if(count($data)>0){
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

if(isset($_GET['consultar_turnos'])){

    $controller = new MesaRechequeoController();
    $data = $controller->consultar_turnos();

    if(count($data)>0){
        $response = [
            "data" => [$data],
            "error" => [],
        ];
        echo json_encode($response);
    }else{
        $response = [
            "data" => [],
            "error" => ["No hay turnos registrados"],
        ];
        echo json_encode($response);
    }
}

if(isset($_GET['crear_turno'])){

    $controller = new MesaRechequeoController();
    $data = $controller->crear_turno($_POST['hora_inicio'], $_POST['hora_final']);

    if($data[0]){
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

if(isset($_GET['eliminar_turno'])){

    $controller = new MesaRechequeoController();
    $data = $controller->eliminar_turno($_POST['turno_seleccionado']);

    if($data[0]){
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