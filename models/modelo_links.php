<?php 

    class ModeloLinks {

       private $lista_links_permitidos = [
            "inicio" => "inicio",
            "login" => "auth/index",
            "cerrar_session" => "auth/cerrar_session",
            "registrar_empleado" => "users/registrar_empleado",
            "modificar_empleado" => "users/modificar_empleado",
            "registrar_cuenta" => "users/registrar_cuenta",
            "modificar_cuenta" => "users/modificar_cuenta",
            "registrar_producto" => "inventario/registrar_producto",
            "registrar_ruta" => "almacen/rutas/registrar_ruta",
            "registrar_pedido" => "almacen/registrar_pedido",
            "registrar_pedido_por_partes" => "almacen/pedidos/registrar_pedido_por_partes",
            "modificar_pedido" => "almacen/pedidos/modificar_pedido",
            "eliminar_pedido" => "almacen/pedidos/eliminar_pedido",
            "consultar_pedido" => "almacen/pedidos/consultar_pedido",
            "rechequear_pedido" => "almacen/rechequeo/rechequear",
            "registrar_fallas" => "almacen/fallas/registrar_fallas",
            "eliminar_fallas" => "almacen/fallas/eliminar_fallas",
            "total_pedidos" => "almacen/estadisticas/total_pedidos",
            "asignar_mesa" => "almacen/mesa_rechequeadores/modificar_mesa",
	        "pedidos_por_fecha" => "almacen/estadisticas/pedidos_por_fecha",
	        "mejor_despachador" => "almacen/estadisticas/mejor_despachador",
            "fallas_despachador" => "almacen/estadisticas/fallas_despachador",
            "fallas_detectadas_rechequeador" => "almacen/estadisticas/fallas_detectadas_rechequeador",
            "mejor_rechequeador" => "almacen/estadisticas/mejor_rechequeador",
            "pedidos_por_despachador" => "almacen/estadisticas/pedidos_por_despachador",
            "registrar_articulos" => "deposito/articulos/registro_articulos",    
            "confirmar_pedido"    => "almacen/pedidos/confirmar_pedido" , 
 ];

        public function checkLinkExistence($name_link){
            $exist_link = array_key_exists($name_link, $this->lista_links_permitidos) 
                ? $this->lista_links_permitidos[$name_link] 
                : "" ;
            return $exist_link;      
         }

        public function gestionar_redireccion($link = ""){
            $link_lower_case = strtolower($link);
            //Verificamos que el link exista
            $direccion = $this->checkLinkExistence($link_lower_case);
            //Verificamos si tiene session activa
            
            if($direccion == ""){
                $direccion = "inicio";
            }
            //redireccionamos
            $module = "views/modules/".$direccion.".php";
            return $module;
        }
    }
