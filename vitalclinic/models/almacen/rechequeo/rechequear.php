<?php

require_once '../../../connection/connection.php';

class RechequearPedidoModel extends Connection{

    private $conn;

    public function __construct(){
        $this->conn = self::getInstance()->getConnection();
    }

    public function extraer_embalador_asignado(){
        session_start();
        $user = $_SESSION['user']['id_account'];

        $sql = "SELECT 
        id_embalador,
        nombre,
        apellido
        FROM pareja_rechequeadores_embaladores
        inner join empleados on pareja_rechequeadores_embaladores.id_embalador = empleados.id
        WHERE id_rechequeador = '$user'";
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

    public function extraer_partes_pedido($num_pedido){

        //Verificamos que el numero de pedido es correcto
        $data = $this->verificar_num_pedido($num_pedido);

        if(count($data) === 0){
            return [];
        }
        
        $id_pedido = $data[0]['id_pedido'];

        $sql = "SELECT
        nombre,
        apellido,
        pedidos_d_r_e.id,
        pedidos_d_r_e.id_pedido,
        pedidos_d_r_e.id_rechequeador,
        pedidos_d_r_e.id_embalador,
        pedidos_d_r_e.fecha_rechequeado,
        id_despachador
        FROM 
        pedidos_d_r_e 
        inner join empleados
        on pedidos_d_r_e.id_despachador = empleados.id
        WHERE id_pedido = '$id_pedido' 
        ORDER BY pedidos_d_r_e.id";
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

    public function rechequear_pedido($embalador="", $id_pedido_d_r_e=[]){
        session_start();

        if(!isset($_SESSION['user'])){
            return [false,'Tu sesion ha vencido, favor vuelve a iniciar sesion'];
        }

        $user = $_SESSION['user']['id_account'];

        // Iniciar la transacción
        $this->conn->begin_transaction();

        try {
            // Primera operación: INSERT en la tabla pedidos
            $sql = "UPDATE pedidos_d_r_e set 
            id_rechequeador = ?,
            id_embalador = ?,
            fecha_rechequeado = NOW()
            WHERE id = ?";

            // Preparar la consulta
            $stmt = $this->conn->prepare($sql);

            if ($stmt === false) {
                die('Error en la preparación de la consulta: ' . $this->conn->error);
            }

            foreach($id_pedido_d_r_e as $id_pedido){

                // Vincular parámetros
                $stmt->bind_param("sss", $user, $embalador, $id_pedido);

                // Ejecutar la consulta
                if (!$stmt->execute()) {
                    throw new Exception("Error al registrar en la tabla pedidos: " . $stmt->error);
                }
            }

            // Confirmar la transacción
            $this->conn->commit();

            return [true,''];
            //return true;
        } catch (Exception $e) {
            // Revertir la transacción en caso de error
            $this->conn->rollback();
            echo "Transacción fallida: " . $e->getMessage();
            return [false, 'Ha ocurrido un error'];
            //return false;
        }   
    }
    
    public function consultar_pedido($numero_pedido = ""){
        session_start();
        $user = $_SESSION['user']['id_account'];
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
            pedidos_d_r_e.id as id_pedido_d_r_e, 
            fecha_rechequeado,
            despachador.id as id_despachador, 
            despachador.nombre as nombre_despachador, 
            despachador.apellido as apellido_despachador, 
            rechequeador.id as id_rechequeador, 
            rechequeador.nombre as nombre_rechequeador, 
            rechequeador.apellido as apellido_rechequeador,
            embalador.id as id_embalador,  
            embalador.nombre as nombre_embalador, 
            embalador.apellido as apellido_embalador 
            FROM pedidos_d_r_e 
            INNER JOIN empleados as despachador on pedidos_d_r_e.id_despachador=despachador.id 
            INNER JOIN accounts on pedidos_d_r_e.id_rechequeador=accounts.id_account
            INNER JOIN empleados as rechequeador on accounts.id_empleado=rechequeador.id
            INNER JOIN empleados as embalador on pedidos_d_r_e.id_embalador=embalador.id 
            WHERE pedidos_d_r_e.id_pedido = '$id_pedido' AND pedidos_d_r_e.id_rechequeador = '$user'
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
