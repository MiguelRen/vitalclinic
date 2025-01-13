<?php
    require_once '../../../connection/connection.php';

    class PedidosModel extends Connection{

        private $conn;

        public function __construct(){
           $this->conn = self::getInstance()->getConnection();
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

        public function extraer_data_pedido($num_pedido){
            $sql = "SELECT 
            pedidos.id_pedido,
            numero_pedido,
            id_ruta,
            fecha,
            cantidad_unidades,
            distribuidor_pedidos,
            pedidos_d_r_e.id AS id_pedido_d_r_e,
            id_despachador,
            id_rechequeador,
            id_embalador,
            fecha_rechequeado,
            nombre,
            apellido
            FROM pedidos_d_r_e
            INNER JOIN pedidos on pedidos_d_r_e.id_pedido=pedidos.id_pedido
            INNER JOIN empleados on pedidos_d_r_e.id_despachador=empleados.id
            WHERE numero_pedido = '$num_pedido'
            ORDER BY id_pedido_d_r_e";

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
        
        public function registrar_pedido($cod_pedido="",$despachadores = [],$ruta="",$cant_unidades="") {
            

            $id_pedido = $this->verificar_num_pedido($cod_pedido);

            if(count($id_pedido) > 0){
                return [false,"Pedido ya se encuentra registrado"]; 
            }
            session_start();
            $user = $_SESSION['user']['id_account'];

            // Iniciar la transacción
            $this->conn->begin_transaction();

            try {
                // Primera operación: INSERT en la tabla pedidos
                $sql_tabla_pedidos = "INSERT INTO pedidos (
                numero_pedido,
                id_ruta,
                fecha,
                cantidad_unidades,
                distribuidor_pedidos
                ) VALUES (?,?,NOW(),?,?)";

                  
                // Preparar la consulta
                $stmt = $this->conn->prepare($sql_tabla_pedidos);

                // Verificar si la preparación falló
                if ($stmt === false) {
                    throw new Exception("Error al preparar la consulta: " . $this->conn->error);
                }

                // Vincular parámetros
                $stmt->bind_param("ssss", $cod_pedido,$ruta,$cant_unidades,$user);

                // Ejecutar la consulta
                if (!$stmt->execute()) {
                    throw new Exception("Error al registrar en la tabla pedidos: " . $stmt->error);
                }

                //Buscamos el id del pedido que acabamos de registrar
                $data = $this->verificar_num_pedido($cod_pedido);

                $id_pedido = $data[0]['id_pedido'];

                // Segunda operación: Insert en tabla pedidos_d_r_e
                $sql_tabla_pedidos_d_r_e = "INSERT INTO pedidos_d_r_e (
                id_pedido,
                id_despachador
                ) VALUES (?,?)";

                // Preparar la consulta
                $stmt2 = $this->conn->prepare($sql_tabla_pedidos_d_r_e);

                // Verificar si la preparación falló
                if ($stmt2 === false) {
                    throw new Exception("Error al preparar la consulta: " . $this->conn->error);
                }

                foreach($despachadores as $despachador){
                    
                    // Vincular parámetros
                    $stmt2->bind_param("ss", $id_pedido,$despachador);

                    // Ejecutar la consulta
                    if (!$stmt2->execute()) {
                        throw new Exception("Error al registrar en la tabla pedidos: " . $stmt2->error);
                    }
                } 

                // Confirmar la transacción
                $this->conn->commit();
                return [true,''];
            } catch (Exception $e) {
                // Revertir la transacción en caso de error
                $this->conn->rollback();
                echo "Transacción fallida: " . $e->getMessage();
                return [false,'Ocurrio un error al registrar pedido'];
            }
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

        public function modificar_pedido($id_pedido="",$despachadores=[],$id_partes_pedido,$ruta="",$cant_unidades=""){
        
            // Iniciar la transacción
            $this->conn->begin_transaction();

            try {
                // Primera operación: INSERT en la tabla pedidos
                $sql_tabla_pedidos = "UPDATE pedidos SET
                id_ruta = ?,
                cantidad_unidades = ?
                WHERE id_pedido = ?";

                // Preparar la consulta
                $stmt = $this->conn->prepare($sql_tabla_pedidos);

            
                // Verificar si la preparación falló
                if ($stmt === false) {
                    throw new Exception("Error al preparar la consulta: " . $this->conn->error);
                }

                // Vincular parámetros
                $stmt->bind_param("sss", $ruta,$cant_unidades,$id_pedido);

                // Ejecutar la consulta
                if (!$stmt->execute()) {
                    throw new Exception("Error al registrar en la tabla pedidos: " . $stmt->error);
                }

                // Segunda operación: Insert en tabla pedidos_d_r_e
                $sql_tabla_pedidos_d_r_e = "UPDATE pedidos_d_r_e SET  
                id_despachador =?
                WHERE id = ?";

                // Preparar la consulta
                $stmt2 = $this->conn->prepare($sql_tabla_pedidos_d_r_e);

                // Verificar si la preparación falló
                if ($stmt2 === false) {
                    throw new Exception("Error al preparar la consulta: " . $this->conn->error);
                }

                foreach($despachadores as $key => $despachador){
                    
                    // Vincular parámetros
                    $stmt2->bind_param("ss", $despachadores[$key],$id_partes_pedido[$key]);

                    // Ejecutar la consulta
                    if (!$stmt2->execute()) {
                        throw new Exception("Error al registrar en la tabla pedidos: " . $stmt2->error);
                    }
                } 

                // Confirmar la transacción
                $this->conn->commit();
                return true;
            } catch (Exception $e) {
                // Revertir la transacción en caso de error
                $this->conn->rollback();
                echo "Transacción fallida: " . $e->getMessage();
                return false;
            }   
        }
        
        public function eliminar_pedido($cod_pedido=""){
            
             //Buscamos el id del pedido que acabamos de registrar
             $data = $this->verificar_num_pedido($cod_pedido);

             $id_pedido = $data[0]['id_pedido'];

            // Iniciar la transacción
             $this->conn->begin_transaction();

             try {
                 // Primera operación: INSERT en la tabla pedidos
                 $sql_tabla_pedidos_d_r_e = "DELETE FROM pedidos_d_r_e WHERE id_pedido = ?";
 
                 // Preparar la consulta
                 $stmt = $this->conn->prepare($sql_tabla_pedidos_d_r_e);
 
             
                 // Verificar si la preparación falló
                 if ($stmt === false) {
                     throw new Exception("Error al preparar la consulta: " . $this->conn->error);
                 }
 
                 // Vincular parámetros
                 $stmt->bind_param("s",$id_pedido);
 
                 // Ejecutar la consulta
                 if (!$stmt->execute()) {
                     throw new Exception("Error al registrar en la tabla pedidos: " . $stmt->error);
                 }
 
                 // Segunda operación: Insert en tabla pedidos_d_r_e
                 $sql_tabla_pedidos = "DELETE FROM pedidos WHERE id_pedido = ?";
 
                 // Preparar la consulta
                 $stmt2 = $this->conn->prepare($sql_tabla_pedidos);
 
                 // Verificar si la preparación falló
                 if ($stmt2 === false) {
                     throw new Exception("Error al preparar la consulta: " . $this->conn->error);
                 }
      
                // Vincular parámetros
                $stmt2->bind_param("s", $id_pedido);

                // Ejecutar la consulta
                if (!$stmt2->execute()) {
                    throw new Exception("Error al registrar en la tabla pedidos: " . $stmt2->error);
                }
                 
 
                 // Confirmar la transacción
                 $this->conn->commit();
                 return true;
             } catch (Exception $e) {
                 // Revertir la transacción en caso de error
                 $this->conn->rollback();
                 echo "Transacción fallida: " . $e->getMessage();
                 return false;
             }   
        }

        public function consultar_pedido($numero_pedido = ""){
            
            $data_tabla_pedidos = array();
            $data_tabla_pedidos_d_r_e = array();

            $sql = "SELECT
            numero_pedido, 
            id_pedido,
            rutas.name as nombre_ruta,
            fecha,
            cantidad_unidades,
            distribuidor_pedidos,
            nombre as nombre_distribuidor,
            apellido as apellido_distribuidor
            FROM pedidos
            INNER JOIN accounts on pedidos.distribuidor_pedidos=accounts.id_account
            INNER JOIN rutas on pedidos.id_ruta=rutas.id
            INNER JOIN empleados on accounts.id_empleado=empleados.id
            WHERE numero_pedido = '$numero_pedido'";

            $result = $this->conn->query($sql);
            // Devolver los resultados como un array JSON
            
            if ($result->num_rows > 0) {
                // Output data of each row
                while($row = $result->fetch_assoc()) {
                    $data_tabla_pedidos[] = $row;
                }
            }
    
            // Cerrar conexión
            //$this->conn->close();
            if(count($data_tabla_pedidos) > 0){

                $id_pedido = $data_tabla_pedidos[0]['id_pedido'];
                
                $sql2 = "SELECT 
                pedidos_d_r_e.id AS id_pedido_d_r_e, 
                fecha_rechequeado,
                despachador.id AS id_despachador, 
                despachador.nombre AS nombre_despachador, 
                despachador.apellido AS apellido_despachador,
                rechequeador.id AS id_rechequeador, 
                rechequeador.nombre AS nombre_rechequeador, 
                rechequeador.apellido AS apellido_rechequeador,
                embalador.id AS id_embalador,  
                embalador.nombre AS nombre_embalador, 
                embalador.apellido AS apellido_embalador,
                COUNT(fallas_despachador.id) AS cantidad_fallas
                FROM pedidos_d_r_e 
                LEFT JOIN empleados AS despachador ON pedidos_d_r_e.id_despachador = despachador.id 
                LEFT JOIN accounts ON pedidos_d_r_e.id_rechequeador = accounts.id_account
                LEFT JOIN empleados AS rechequeador ON accounts.id_empleado = rechequeador.id
                LEFT JOIN empleados AS embalador ON pedidos_d_r_e.id_embalador = embalador.id
                LEFT JOIN fallas_despachador ON pedidos_d_r_e.id = fallas_despachador.id_pedido_d_r_e
                WHERE pedidos_d_r_e.id_pedido = '$id_pedido'
                GROUP BY 
                    pedidos_d_r_e.id, 
                    fecha_rechequeado,
                    despachador.id, 
                    despachador.nombre, 
                    despachador.apellido,
                    rechequeador.id, 
                    rechequeador.nombre, 
                    rechequeador.apellido,
                    embalador.id,  
                    embalador.nombre, 
                    embalador.apellido
                ORDER BY id_pedido_d_r_e";

                $result2 = $this->conn->query($sql2);
                // Devolver los resultados como un array JSON

                if ($result2->num_rows > 0) {
                    // Output data of each row
                    while($row = $result2->fetch_assoc()) {
                        $data_tabla_pedidos_d_r_e[] = $row;
                    }
                }

                return ['tabla_pedidos' => $data_tabla_pedidos[0],'tabla_pedidos_d_r_e' => $data_tabla_pedidos_d_r_e];
            }else{
                return [];
            }
        }
    }
