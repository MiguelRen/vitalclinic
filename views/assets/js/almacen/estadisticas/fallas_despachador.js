import app from '../../api.js';
import utilidades from "../../utilidades.js";

const d = document,
$body_table = d.querySelector('#body_table'),
$loader = d.querySelector("#loader"),
$fragment = d.createDocumentFragment();

let is_loader = false;
const { formatDate } = utilidades();

const mostrar_datos_tabla = (datos) => {

    //Enlazamos el template creado en el HTML
    const $template_body_table_pedidos = d.querySelector('#template_body_table_pedidos').content;

    // let c = 0;
    let tf = 0
    // let tpp = 0;
    const data = Object.values(datos);
    if(data.length > 0){
  
      data.forEach((element,i) => {
  
        //Insertamos los datos en el template
        $template_body_table_pedidos.querySelector('.empleado').textContent = `${element.nombre_despachador}`;
        // $template_body_table_pedidos.querySelector('.c_pedidos').textContent = element.pedidos;
        // p = p + Number(element.pedidos)
        // c = c + Number(element.cantidad_unidades);
        tf = tf + Number(element.cantidad_fallas);
        $template_body_table_pedidos.querySelector('.t_fallas').textContent = element.cantidad_fallas;
        $template_body_table_pedidos.querySelector('.porc_f').textContent = `${element.porc_fallas}%`;
        
        //guardamos una copia de la estrutura actual del template en la variable $node
        let $clone = $template_body_table_pedidos.cloneNode(true);
        //Guardamos el nodo en el fragment
        $fragment.append($clone);
      });
      // //Limpiamos la lista
      $body_table.innerHTML = "";
      //Insertamos el fragment en la lista
      $body_table.append($fragment);

    //   d.querySelector('#total_pedidos').innerText = "";
    //   d.querySelector('#total_pedidos').innerText = parseInt(p);
      d.querySelector('#total_fallas').innerText = "";
      d.querySelector('#total_fallas').innerText = parseInt(tf);

      console.log("total unidades = ", parseInt(c));
      console.log("total pedidos", p);
      console.log("total porc pedidos", tpp);
    }else{
      $body_table.innerHTML = "";
    }
}


const extraer_estadisticas = async (form) => {
    is_loader = true;
   if(is_loader) $loader.classList.remove("hidden");
    try {
        const data = await app('http://192.168.0.164/vitalclinic/controllers/almacen/estadisticas/fallas_despachador.php?extraer_pedidos=1','POST',form);
        is_loader= false;
        if(!is_loader) $loader.classList.add("hidden");
       mostrar_datos_tabla(data.data)
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

      await extraer_estadisticas(formData);
})