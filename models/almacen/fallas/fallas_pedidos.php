<?php
    require_once '../../../connection/connection.php';


    class FallasModel extends Connection{

        private $conn;

        public function __construct(){
            $this->conn = self::getInstance()->getConnection();
        }

        public function extraer_motivos_fallas(){
            $sql = "SELECT * FROM motivo_fallas";

            $result = $this->conn->query($sql);

            // Devolver los resultados como un array JSON
            $data = array();
            if ($result->num_rows > 0) {
                // Output data of each row
                while($row = $result->fetch_assoc()) {
                    $data[] = $row;
                }
            }

            // Cerrar conexión
            //$this->conn->close();
            return $data;
        }

        public function verificar_num_pedido($num_pedido){
            $sql = "SELECT id_pedido FROM pedidos WHERE numero_pedido = '$num_pedido'";
            $result = $this->conn->query($sql);
    
            // Devolver los resultados como un array JSON
            $data = array();
            if ($result->num_rows > 0) {
                // Output data of each row
                while($row = $result->fetch_assoc()) {
                    $data[] = $row;
                }
            }
    
            // Cerrar conexión
            //$this->conn->close();
            return $data;
        }

        public function registrar_fallas($id_despachador = "",$motivo = "",$descripcion = "", $id_pedido_d_r_e = ""){
            
            // Consulta SQL
            $sql = "INSERT INTO fallas_despachador (
            despachador,
            id_pedido_d_r_e,
            motivo,
            descripcion,
            fecha
            ) VALUES (?,?,?,?,NOW())";
            
            $is_register = false;
    
            // Preparar la consulta
            $stmt = $this->conn->prepare($sql);
            
            if ($stmt === false) {
                die('Error en la preparación de la consulta: ' . $this->conn->error);
            }
    
            // Vincular parámetros
            $stmt->bind_param("ssss", $id_despachador,$id_pedido_d_r_e,$motivo,$descripcion);
    
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

        public function extraer_fallas_despachador($numero_pedido){
            session_start();
            $user = $_SESSION['user']['id_account'];

            $sql = "SELECT  
            pedidos.id_pedido,
            pedidos.numero_pedido,
            pedidos_d_r_e.id as id_parte_pedido,
            fallas_despachador.id as id_falla_pedido,
            motivo_fallas.descripcion as motivo,
            fallas_despachador.descripcion,
            fallas_despachador.fecha,
            empleados.nombre as nombre_despachador,
            empleados.apellido as apellido_despachador
            from fallas_despachador
            INNER JOIN pedidos_d_r_e on fallas_despachador.id_pedido_d_r_e = pedidos_d_r_e.id
            INNER JOIN pedidos on pedidos_d_r_e.id_pedido = pedidos.id_pedido
            INNER JOIN empleados on fallas_despachador.despachador = empleados.id
            INNER JOIN motivo_fallas  on fallas_despachador.motivo = motivo_fallas.id
            WHERE pedidos.numero_pedido = '$numero_pedido' and pedidos_d_r_e.id_rechequeador = $user
            ORDER BY id_parte_pedido";
            $result = $this->conn->query($sql);
    
            // Devolver los resultados como un array JSON
            $data = array();
            if ($result->num_rows > 0) {
                // Output data of each row
                while($row = $result->fetch_assoc()) {
                    $data[] = $row;
                }
            }
    
            // Cerrar conexión
            //$this->conn->close();
            return $data;
        }

        public function eliminar_falla_despachador($id_falla){

            // Consulta SQL
            $sql = "DELETE FROM fallas_despachador WHERE id = ?";
                
            $is_register = false;
        
            // Preparar la consulta
            $stmt = $this->conn->prepare($sql);
            
            if ($stmt === false) {
                die('Error en la preparación de la consulta: ' . $this->conn->error);
            }
    
            // Vincular parámetros
            $stmt->bind_param("s", $id_falla);
    
            // Ejecutar la consulta
            if ($stmt->execute()) {
                $is_register = true;
            }
    
            // Cerrar la declaración
            $stmt->close();
            // Cerrar la conexión
            // $this->conn->close();
    
            return $is_register;

            //   //Buscamos el id del pedido que acabamos de registrar
            //   $data = $this->verificar_num_pedido($cod_pedido);

            //   $id_pedido = $data[0]['id_pedido'];
 
            //  // Iniciar la transacción
            //   $this->conn->begin_transaction();
 
            //   try {
            //       // Primera operación: INSERT en la tabla pedidos
            //       $sql_tabla_pedidos_d_r_e = "DELETE FROM pedidos_d_r_e WHERE id_pedido = ?";
  
            //       // Preparar la consulta
            //       $stmt = $this->conn->prepare($sql_tabla_pedidos_d_r_e);
  
              
            //       // Verificar si la preparación falló
            //       if ($stmt === false) {
            //           throw new Exception("Error al preparar la consulta: " . $this->conn->error);
            //       }
  
            //       // Vincular parámetros
            //       $stmt->bind_param("s",$id_pedido);
  
            //       // Ejecutar la consulta
            //       if (!$stmt->execute()) {
            //           throw new Exception("Error al registrar en la tabla pedidos: " . $stmt->error);
            //       }
  
            //       // Segunda operación: Insert en tabla pedidos_d_r_e
            //       $sql_tabla_pedidos = "DELETE FROM pedidos WHERE id_pedido = ?";
  
            //       // Preparar la consulta
            //       $stmt2 = $this->conn->prepare($sql_tabla_pedidos);
  
            //       // Verificar si la preparación falló
            //       if ($stmt2 === false) {
            //           throw new Exception("Error al preparar la consulta: " . $this->conn->error);
            //       }
       
            //      // Vincular parámetros
            //      $stmt2->bind_param("s", $id_pedido);
 
            //      // Ejecutar la consulta
            //      if (!$stmt2->execute()) {
            //          throw new Exception("Error al registrar en la tabla pedidos: " . $stmt2->error);
            //      }
                  
  
            //       // Confirmar la transacción
            //       $this->conn->commit();
            //       return true;
            //   } catch (Exception $e) {
            //       // Revertir la transacción en caso de error
            //       $this->conn->rollback();
            //       echo "Transacción fallida: " . $e->getMessage();
            //       return false;
            //   }
        }
    }
