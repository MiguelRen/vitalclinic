import app from '../../api.js';
import utilidades from "../../utilidades.js";

const d = document,
$empleado = d.querySelector('#empleado'),
$body_table = d.querySelector('#body_table'),
$loader = d.querySelector("#loader"),
$fragment = d.createDocumentFragment();

let is_loader = false;
const { asignar_valores_select, formatDate } = utilidades();

const mostrar_datos_tabla = (datos) => {

    //Enlazamos el template creado en el HTML
    const $template_body_table_pedidos = d.querySelector('#template_body_table_pedidos').content;
    if(datos.data.length > 0){
    
      datos.data[1].forEach((element,i) => {
  
        //Insertamos los datos en el template
        // const nombre = element.nombre_despachador != null ? `${element.nombre_despachador} ${element.apellido_despachador}` : "";
        $template_body_table_pedidos.querySelector('.n_pedido').textContent = element.numero_pedido;
        // const c_pedidos = element.cantidad_pedidos > 0 ? element.cantidad_pedidos : "";
        $template_body_table_pedidos.querySelector('.ruta').textContent = element.name;
        $template_body_table_pedidos.querySelector('.unidades').textContent = element.cantidad_unidades;
        // const c_fallas = element.cantidad_fallas > 0 ? element.cantidad_fallas : "";
        $template_body_table_pedidos.querySelector('.fecha').textContent = element.fecha;
        //guardamos una copia de la estrutura actual del template en la variable $node
        let $clone = $template_body_table_pedidos.cloneNode(true);
        //Guardamos el nodo en el fragment
        $fragment.append($clone);
      });
      // //Limpiamos la lista
      $body_table.innerHTML = "";
      //Insertamos el fragment en la lista
      $body_table.append($fragment);
    }else{
      $body_table.innerHTML = "";
    }
}

const mostrar_empleados = (data_empleados) => {
    //Mostramos los datos de los empleados

    const format_data = data_empleados.map( e => {
       const data = {
        id: e.id,
        nombre: `${e.nombre} ${e.apellido} - ${e.cedula}`
       }

       return {...data}
    })

    asignar_valores_select(
        { 
            data: format_data,
            titulo: "Seleccionar Empleado",
            input: $empleado,
            nombre_opciones : {
                id : "id",
                nombre: "nombre"  
            }
        }
    );
};

const extraer_data_empleados = async () => {

    const formData = new FormData();
    formData.append('order',2);
    is_loader = true;
    if(is_loader) $loader.classList.remove("hidden");
    try {
        const data_empleados = await app('http://192.168.0.164/vitalclinic/controllers/users/empleados.php?extraer_empleados=1','POST',formData);
        is_loader = false;
        if(!is_loader) $loader.classList.add("hidden");
        mostrar_empleados(data_empleados)
    } catch (error) {
        console.log(error)
        is_loader = false;
        if(!is_loader) $loader.classList.add("hidden");
    }
};

const extraer_estadisticas_pedidos_por_despachador = async (form) => {
    is_loader = true;
   if(is_loader) $loader.classList.remove("hidden");
    try {
        const data = await app('http://192.168.0.164/vitalclinic/controllers/almacen/estadisticas/pedidos_por_despachador.php?extraer_pedidos=1','POST',form);
        is_loader = false;
        if(!is_loader) $loader.classList.add("hidden");
        //console.log(data)
        mostrar_datos_tabla(data)
    } catch (error) {
        console.log(error)
    }
}

$empleado.addEventListener('change',  async e => {
    
    if(e.target.value != ""){

        const fechai = d.querySelector('#fechai').value;
        const fechaf = d.querySelector('#fechaf').value;
        const empleado = e.target.value;

        if(fechai.length === 0){
            alert('Por favor ingresar fecha inicial');
            e.target.selectedIndex = 0;
            return;
        }
        
        if(fechaf.length === 0){
            alert('Por favor ingresar fecha final');
            e.target.selectedIndex = 0;
            return;
        }

        // Convertimos las fechas a objetos Date
        const startDateObj = new Date(fechai);
        const finalDateObj = new Date(fechaf);

        //Validamos que el periodo seleccionado sea correcto
        if (isNaN(startDateObj.getTime()) || isNaN(finalDateObj.getTime())) {
            alert('Por favor ingresar fechas validas');
            return;
        }

        if (startDateObj > finalDateObj) {
            alert('La fecha de inicio debe ser anterior a la fecha final.');
            return;
        }

        console.log(formatDate(startDateObj),formatDate(finalDateObj),empleado)
    
        // Creamos formdata
        const formData = new FormData();
        formData.append('fechai', formatDate(startDateObj)); // Formato deseado
        formData.append('fechaf', formatDate(finalDateObj));
        formData.append('empleado', empleado);

        await extraer_estadisticas_pedidos_por_despachador(formData);
   }
})

d.addEventListener('DOMContentLoaded', async e => {
    await extraer_data_empleados();
})