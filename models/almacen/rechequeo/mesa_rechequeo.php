<?php

require_once '../../../connection/connection.php';

class MesaRechequeoModel extends Connection{

  private $conn;

  public function __construct(){
      $this->conn = self::getInstance()->getConnection();
  }

  public function consultar_parejas_rechequeadoras($turno=""){
    $sql = "SELECT 
    mesas_rechequeadoras.num_mesa as numero_mesa,
    pareja_rechequeadores_embaladores.turno as turno,
    pareja_rechequeadores_embaladores.id as id_pareja_rechequeadores_embaladores,
    rechequeador.nombre as nombre_rechequeador,
    rechequeador.apellido as apellido_rechequeador,
    rechequeador.cedula as cedula_rechequeador,
    embalador.nombre as nombre_embalador,
    embalador.apellido as apellido_embalador,
    embalador.cedula as cedula_embalador
    FROM mesas_rechequeadoras
    LEFT JOIN pareja_rechequeadores_embaladores on mesas_rechequeadoras.id=pareja_rechequeadores_embaladores.id_mesa
    LEFT JOIN empleados as embalador on pareja_rechequeadores_embaladores.id_embalador=embalador.id
    LEFT JOIN accounts on pareja_rechequeadores_embaladores.id_rechequeador=accounts.id_account
    LEFT JOIN empleados as rechequeador on accounts.id_empleado=rechequeador.id
    LEFT JOIN turnos on pareja_rechequeadores_embaladores.turno = turnos.id
    ORDER BY turnos.hora_inicio,numero_mesa;";
    $result = $this->conn->query($sql);

    // Devolver los resultados como un array JSON
    $dataBusqueda = array();
    if ($result->num_rows > 0) {
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            $dataBusqueda[] = $row;
        }
    }

    // Cerrar conexión
    //$this->conn->close();
    return $dataBusqueda;
  }

  public function consultar_rechequeadores(){
    $sql = "SELECT 
    accounts.id_account as id_cuenta,
    rechequeador.nombre as nombre_rechequeador,
    rechequeador.apellido as apellido_rechequeador,
    rechequeador.cedula as cedula_rechequeador
    FROM accounts
    INNER JOIN empleados as rechequeador on accounts.id_empleado=rechequeador.id
    WHERE accounts.status = 1 and accounts.role_id= 4 order by nombre";
    $result = $this->conn->query($sql);

    // Devolver los resultados como un array JSON
    $dataBusqueda = array();
    if ($result->num_rows > 0) {
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            $dataBusqueda[] = $row;
        }
    }

    // Cerrar conexión
    //$this->conn->close();
    return $dataBusqueda;
  }

  public function consultar_embaladores(){
    $sql = "SELECT 
    id as id_embalador,
    cedula as cedula_embalador,
    nombre as nombre_embalador,
    apellido as apellido_embalador
    FROM empleados
    WHERE status = 1 ORDER BY nombre
    ";
    $result = $this->conn->query($sql);

    // Devolver los resultados como un array JSON
    $dataBusqueda = array();
    if ($result->num_rows > 0) {
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            $dataBusqueda[] = $row;
        }
    }

    // Cerrar conexión
    //$this->conn->close();
    return $dataBusqueda;
  }

  public function registrar_pareja_rechequeadora($id_mesa = "", $id_rechequeador="", $id_embalador=""){
        
    try {
      // Primera operación: INSERT en la tabla pedidos
      $sql_tabla_pedidos = "UPDATE pareja_rechequeadores_embaladores SET
      id_rechequeador = ?,
      id_embalador = ?
      WHERE id = ?";

      // Preparar la consulta
      $stmt = $this->conn->prepare($sql_tabla_pedidos);

  
      // Verificar si la preparación falló
      if ($stmt === false) {
          throw new Exception("Error al preparar la consulta: " . $this->conn->error);
      }

      // Vincular parámetros
      $stmt->bind_param("sss", $id_rechequeador,$id_embalador,$id_mesa);

      // Ejecutar la consulta
      if (!$stmt->execute()) {
          throw new Exception("Error al registrar pareja rechequeadora: " . $stmt->error);
      }
      return true;
    } catch (Exception $e) {
        // Revertir la transacción en caso de error
        echo "Transacción fallida: " . $e->getMessage();
        return false;
    }
  }
  
  
  public function consultar_turnos(){
    $sql = "SELECT *
    FROM turnos order by turnos.hora_inicio";
    
    $result = $this->conn->query($sql);

    // Devolver los resultados como un array JSON
    $dataBusqueda = array();
    if ($result->num_rows > 0) {
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            $dataBusqueda[] = $row;
        }
    }

    // Cerrar conexión
    //$this->conn->close();
    return $dataBusqueda;
  }

  public function extraer_mesas_rechequeadoras(){
    $sql = "SELECT *
    FROM mesas_rechequeadoras ORDER BY mesas_rechequeadoras.num_mesa";
    
    $result = $this->conn->query($sql);

    // Devolver los resultados como un array JSON
    $dataBusqueda = array();
    if ($result->num_rows > 0) {
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            $dataBusqueda[] = $row;
        }
    }

    // Cerrar conexión
    //$this->conn->close();
    return $dataBusqueda;
  }

  public function buscar_turno($hora_inicio = "", $hora_final = ""){
    $sql = "SELECT *
    FROM 
      turnos 
    WHERE 
      turnos.hora_inicio = '$hora_inicio' 
    AND 
      turnos.hora_final = '$hora_final'";
    
    $result = $this->conn->query($sql);

    // Devolver los resultados como un array JSON
    $dataBusqueda = array();
    if ($result->num_rows > 0) {
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            $dataBusqueda[] = $row;
        }
    }

    // Cerrar conexión
    //$this->conn->close();
    return $dataBusqueda;
  }

  public function crear_turno($hora_inicio = "", $hora_final = ""){
            
    // Iniciar la transacción
    $this->conn->begin_transaction();

    try {
      // Consulta SQL
      $sql = "INSERT INTO turnos (
        hora_inicio,
        hora_final
        ) VALUES (?,?)";
        
        $is_register = false;
    
        // Preparar la consulta
        $stmt = $this->conn->prepare($sql);
        
        if ($stmt === false) {
            die('Error en la preparación de la consulta: ' . $this->conn->error);
        }
    
        // Vincular parámetros
        $stmt->bind_param("ss", $hora_inicio,$hora_final);
    
        // Ejecutar la consulta
        if ($stmt->execute()) {
            $is_register = true;
        }
    
        $data_turno = $this->buscar_turno($hora_inicio,$hora_final);

        if($data_turno != null){
          // Segunda operación: Insert en tabla pareja_rechequeadores_embaladores

          $data_mesas = $this->extraer_mesas_rechequeadoras();


          $sql_pareja_rechequeadores_embaladores = "INSERT INTO pareja_rechequeadores_embaladores (
            id_mesa,
            turno
          ) VALUES (?,?)";

          // Preparar la consulta
          $stmt2 = $this->conn->prepare($sql_pareja_rechequeadores_embaladores);

          // Verificar si la preparación falló
          if ($stmt2 === false) {
              throw new Exception("Error al preparar la consulta: " . $this->conn->error);
          }

          for ($i=0; $i < 20; $i++) { 
             // Vincular parámetros
             $stmt2->bind_param("ss", $data_mesas[$i]['id'],$data_turno[0]['id']);

             // Ejecutar la consulta
             if (!$stmt2->execute()) {
                 throw new Exception("Error al registrar en la tabla pareja_rechequeadores_embaladores: " . $stmt2->error);
             }
          }
        } 

        // Confirmar la transacción
        $this->conn->commit();
        return [true,''];
    } catch (Exception $e) {
        // Revertir la transacción en caso de error
        $this->conn->rollback();
        echo "Transacción fallida: " . $e->getMessage();
        return [false,'Ocurrio un error al registrar en pareja_rechequeadores_embaladores'];
    }
  }

  public function eliminar_turno($turno_seleccionado = ""){
            
    // Iniciar la transacción
    $this->conn->begin_transaction();

    try {
      // Consulta SQL
      $sql = "DELETE FROM pareja_rechequeadores_embaladores WHERE pareja_rechequeadores_embaladores.turno = ?";
      // Preparar la consulta
      $stmt = $this->conn->prepare($sql);

      $isDelete = false;

      if ($stmt === false) {
          die('Error en la preparación de la consulta: ' . $this->conn->error);
      }
  
      // Vincular parámetros
      $stmt->bind_param("s", $turno_seleccionado);
  
      // Ejecutar la consulta
      if ($stmt->execute()) {
          $isDelete = true;
      }else{
        throw new Exception("Error al eliminar en la tabla pareja_rechequeadores_embaladores: " . $stmt->error);
      }

      if($isDelete){
        // Segunda operación: DELETE en tabla turnos
        $sql_delete_turno = "DELETE FROM turnos WHERE turnos.id = ?";

        // Preparar la consulta
        $stmt2 = $this->conn->prepare($sql_delete_turno);

        // Verificar si la preparación falló
        if ($stmt2 === false) {
            throw new Exception("Error al preparar la consulta: " . $this->conn->error);
        }

        $stmt2->bind_param("s",$turno_seleccionado);

         // Ejecutar la consulta
         if (!$stmt2->execute()) {
          throw new Exception("Error al eliminar en la turnos: " . $stmt2->error);
        }
      } 

        // Confirmar la transacción
        $this->conn->commit();
        return [true,''];
      } catch (Exception $e) {
        // Revertir la transacción en caso de error
        $this->conn->rollback();
        echo "Transacción fallida: " . $e->getMessage();
        return [false,'Ocurrio un error al registrar en pareja_rechequeadores_embaladores'];
    }
  }
}
