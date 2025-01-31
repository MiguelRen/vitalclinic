<?php

use LDAP\Result;
require_once '../../../connection/connection.php';


class FallasModel extends Connection
{

    private $conn;

    public function __construct()
    {
        $this->conn = self::getInstance()->getConnection();
    }

    public function extraer_motivos_fallas()
    {
        $sql = "SELECT * FROM motivo_fallas";

        $result = $this->conn->query($sql);

        // Devolver los resultados como un array JSON
        $data = array();
        if ($result->num_rows > 0) {
            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }

        // Cerrar conexión
        //$this->conn->close();
        return $data;
    }

    public function verificar_num_pedido($num_pedido)
    {
        $sql = "SELECT id_pedido FROM pedidos WHERE numero_pedido = '$num_pedido'";
        $result = $this->conn->query($sql);

        // Devolver los resultados como un array JSON
        $data = array();
        if ($result->num_rows > 0) {
            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }

        // Cerrar conexión
        //$this->conn->close();
        return $data;
    }

    public function registrar_fallas($id_despachador = "", $motivo = "", $descripcion = "", $id_pedido_d_r_e = "")
    {

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
        $stmt->bind_param("ssss", $id_despachador, $id_pedido_d_r_e, $motivo, $descripcion);

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

    public function extraer_fallas_despachador($numero_pedido)
    {
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
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }

        // Cerrar conexión
        //$this->conn->close();
        return $data;
    }

    public function eliminar_falla_despachador($id_falla)
    {

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


    public function consultar_falla_p($numero_pedido = "")
    {
        if (empty($numero_pedido)) {
            return ["data" => [], "error" => "No se ha ingresado un número de pedido"];
        }

        // $sql = "SELECT 

        //     empleados.nombre,
        //     empleados.apellido,
        //     pedidos.numero_pedido,
        //     pedidos.fecha, 
        //     pedidos_d_r_e.fecha_confirmado,
        //     pedidos_d_r_e.id_despachador,
        //     pedidos_d_r_e.id as id_parte 
        //     FROM pedidos 
        //     INNER JOIN pedidos_d_r_e ON pedidos_d_r_e.id_pedido = pedidos.id_pedido 
        //     INNER JOIN empleados ON empleados.id = pedidos_d_r_e.id_despachador 
        //     WHERE pedidos.numero_pedido = ? 
        //     ORDER BY pedidos_d_r_e.id ASC";


        // $sql = "
        // SELECT
        // empleados.nombre,
        // empleados.apellido,

        // pedidos_d_r_e.fecha_confirmado,

        // pedidos_d_r_e.id as id_parte ,
        // fallas_despachador.motivo,
        // fallas_despachador.descripcion,
        // fallas_despachador.fecha
        // FROM pedidos 
        // INNER JOIN pedidos_d_r_e ON pedidos_d_r_e.id_pedido = pedidos.id_pedido 
        // INNER JOIN empleados ON empleados.id = pedidos_d_r_e.id_despachador
        // INNER JOIN fallas_despachador ON fallas_despachador.id_pedido_d_r_e = pedidos_d_r_e.id_pedido
        // WHERE pedidos.numero_pedido = ? 
        // ORDER BY pedidos_d_r_e.id ASC
        // ;";

        $sql = "
SELECT
    pedidos_d_r_e.id AS id_pedido_d_r_e,
    pedidos_d_r_e.fecha_rechequeado,
    pedidos_d_r_e.fecha_confirmado,
    pedidos_d_r_e.id_despachador,
    despachador.nombre AS nombre_despachador,
    despachador.apellido AS apellido_despachador,
    fallas_despachador.motivo,
    fallas_despachador.descripcion,
    fallas_despachador.fecha AS fecha_falla,
    
    rechequeador.nombre AS nombre_rechequeador,
    rechequeador.apellido AS apellido_rechequeador
FROM
    pedidos
    INNER JOIN pedidos_d_r_e ON pedidos_d_r_e.id_pedido = pedidos.id_pedido
    INNER JOIN empleados AS despachador ON despachador.id = pedidos_d_r_e.id_despachador

    LEFT JOIN fallas_despachador ON fallas_despachador.id_pedido_d_r_e = pedidos_d_r_e.id
    LEFT JOIN accounts ON accounts.id_account = pedidos_d_r_e.id_rechequeador
    LEFT JOIN empleados AS rechequeador ON rechequeador.id = accounts.id_empleado  -- Cambiado aquí
WHERE
    pedidos.numero_pedido = ?
ORDER BY
    pedidos_d_r_e.id ASC;
    ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $numero_pedido);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = [];

        while ($row = $result->fetch_assoc()) {
            $id = $row['id_pedido_d_r_e'];
            $nombre_empleado = $row['nombre_despachador'];
            $apellido_empleado = $row['apellido_despachador'];
            $fecha_confirmado = $row['fecha_confirmado'];
            $fecha_rechequeado = $row['fecha_rechequeado'];
            $despachador = $row['id_despachador'];
            $nombre_rechequeador = $row['nombre_rechequeador'];
            $apellido_rechequeador = $row['apellido_rechequeador'];

            $clave_unica = $despachador.'_'.$id;

            if (!isset($data[$clave_unica]))  {

                $data[$clave_unica] = [

                    'id' => $id,
                    'nombre_despachador' => $nombre_empleado,
                    'apellido_despachador' => $apellido_empleado,
                    'fecha_confirmado' => $fecha_confirmado,
                    'fecha_rechequeado' => $fecha_rechequeado,
                    'nombre_rechequeador' => $nombre_rechequeador,
                    'apellido_rechequeador' => $apellido_rechequeador ,
                    'fallas' => []
                ];
            }
            if ($row['motivo']) {
                $data[$clave_unica]['fallas'][] = [
                    'motivo' => $row['motivo'],
                    'descripcion' => $row['descripcion'],
                    'fecha_falla' => $row['fecha_falla']
                ];
            }
        }


        return $data;
    }
    public function confirmar_falla_p($id_pedido_d_r_e = "", $motivo = "", $descripcion = "")
    {

        $sqL_despachador = " SELECT 
            id_despachador 
            FROM pedidos_d_r_e
            Where id = ? ;";

        $stmt1 = $this->conn->prepare($sqL_despachador);
        $stmt1->bind_param("s", $id_pedido_d_r_e);

        $stmt1->execute();
        $result = $stmt1->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $id_despachador = $row['id_despachador'];
            }

        }



        $sql_registro = "INSERT INTO fallas_despachador
            (despachador,id_pedido_d_r_e,motivo, descripcion,fecha)
            VALUES
            (?,?,?,?,NOW());";

        $stmt2 = $this->conn->prepare($sql_registro);
        $stmt2->bind_param("ssss", $id_despachador, $id_pedido_d_r_e, $motivo, $descripcion);


        $result = $stmt2->execute();
        return $result;
    }
}
