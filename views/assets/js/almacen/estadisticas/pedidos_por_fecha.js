import app from '../../api.js';
import utilidades from "../../utilidades.js";

const d = document,
$ruta = d.querySelector('#ruta'),
$body_table = d.querySelector('#body_table'),
$loader = d.querySelector("#loader"),
$fragment = d.createDocumentFragment();

let is_loader = false;
const { asignar_valores_select, formatDate } = utilidades();

const mostrar_rutas = (data_rutas) => {
    //Mostramos los datos de las rutas
    asignar_valores_select(
        { 
            data: data_rutas,
            titulo: "Seleccionar Ruta",
            input: $ruta,
            nombre_opciones : {
                id : "id",
                nombre: "name"  
            }
        }
    );
};

const mostrar_datos_tabla = (datos) => {

    //Enlazamos el template creado en el HTML
    const $template_body_table_pedidos = d.querySelector('#template_body_table_pedidos').content;
	let total_pedidos = datos.length;
    let total_unidades = 0;  
    if(datos.length > 0){
  
      datos.forEach((element,i) => {
  
        //Insertamos los datos en el template
        $template_body_table_pedidos.querySelector('.n_pedido').textContent = element.numero_pedido;
        $template_body_table_pedidos.querySelector('.ruta').textContent = element.ruta;
        $template_body_table_pedidos.querySelector('.unidades').textContent = element.cantidad_unidades;
	total_unidades = total_unidades + Number(element.cantidad_unidades);       
 $template_body_table_pedidos.querySelector('.fecha').textContent = element.fecha;
        $template_body_table_pedidos.querySelector('.distribuidor').textContent = `${element.nombre} ${element.apellido}`;
        $template_body_table_pedidos.querySelector('.action').dataset.id = element.id_pedido;
        
        //guardamos una copia de la estrutura actual del template en la variable $node
        let $clone = $template_body_table_pedidos.cloneNode(true);
        //Guardamos el nodo en el fragment
        $fragment.append($clone);
      });
      // //Limpiamos la lista
      $body_table.innerHTML = "";
      //Insertamos el fragment en la lista
      $body_table.append($fragment);
	
     console.log(total_pedidos);
      console.log(total_unidades)
      d.querySelector('#total_pedidos').innerText = "";
      d.querySelector('#total_pedidos').innerText = total_pedidos;

      d.querySelector('#total_unidades').innerText = "";
      d.querySelector('#total_unidades').innerText = total_unidades;

    }else{
      $body_table.innerHTML = "";
    }
  }

const extraer_data_rutas = async () => {
    is_loader = true;
    if(is_loader) $loader.classList.remove("hidden");
    try {
        const data_rutas = await app('http://192.168.0.164/vitalclinic/controllers/almacen/rutas/rutas.php?extraer_rutas=1');
        is_loader = false;
        if(!is_loader) $loader.classList.add("hidden");
        mostrar_rutas(data_rutas)
    } catch (error) {
        console.log(error)
        is_loader = false;
            if(!is_loader) $loader.classList.add("hidden");
    }
};

const extraer_estadisticas_pedidos_por_fecha = async (form) => {
    is_loader = true;
   if(is_loader) $loader.classList.remove("hidden");
    try {
        const data = await app('http://192.168.0.164/vitalclinic/controllers/almacen/estadisticas/pedidos_por_fecha.php?extraer_pedidos=1','POST',form);
        if(data.data.length > 0){
            is_loader = false;
            if(!is_loader) $loader.classList.add("hidden");
            mostrar_datos_tabla(data.data)
        }else{
            is_loader=false;
            $loader.classList.add("hidden"); 
            alert('No hay pedidos registrados en esta fecha');
        }
        
    } catch (error) {
        console.log(error)
        is_loader = false;
        if(!is_loader) $loader.classList.add("hidden")
    }
}


d.addEventListener('submit',  async e => {
    e.preventDefault();

    const fechai = e.target.fechai.value;
    const fechaf = e.target.fechaf.value;
    const ruta = e.target.ruta.value;

    if(fechai.length === 0){
        alert('Por favor ingresar fecha inicial');
        return;
      }
    
      if(fechaf.length === 0){
        alert('Por favor ingresar fecha final');
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
  
      // Creamos formdata
      const formData = new FormData();
      formData.append('fechai', formatDate(startDateObj)); // Formato deseado
      formData.append('fechaf', formatDate(finalDateObj));
      formData.append('ruta', ruta);

      await extraer_estadisticas_pedidos_por_fecha(formData);
})

d.addEventListener('DOMContentLoaded', async e => {
    await extraer_data_rutas();
})
