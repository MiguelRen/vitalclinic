import app from "./api.js";
import utilidades from "./utilidades.js";

const { formatDate } = utilidades();

const d = document,
$fragment = d.createDocumentFragment(),
$body_table_mejor_despachador = d.querySelector("#body_table_mejor_despachador"),
$body_table_fallas_despachador = d.querySelector("#body_table_fallas_despachador"),
$body_table_fallas_encontradas_rechequeadores = d.querySelector("#body_table_fallas_encontradas_rechequeadores");
let data_estadisticas;

const mostrarFallasDespachador = (data_fallas, total_fallas) => {

  //Enlazamos el template creado en el HTML
  const $template_table_body_fallas_despachador = d.querySelector('#template_table_body_fallas_despachador').content;

  if(data_fallas.length > 0){

    data_fallas.forEach(element => {
      //Insertamos los datos en el template
      $template_table_body_fallas_despachador.querySelector('.name').textContent = element.NOMB_EMPLEADO;
      $template_table_body_fallas_despachador.querySelector('.errors').textContent = element.MAYOR_VOTADO;
      $template_table_body_fallas_despachador.querySelector('.porc_errors').textContent = `${((Number(element.MAYOR_VOTADO) / Number(total_fallas[0].TOTAL_PED) * 100)).toFixed(2)} `;
      
        //guardamos una copia de la estrutura actual del template en la variable $node
      let $clone = $template_table_body_fallas_despachador.cloneNode(true);
      //Guardamos el nodo en el fragment
      $fragment.append($clone);
    });
    // //Limpiamos la lista
    $body_table_fallas_despachador.innerHTML = "";
    //Insertamos el fragment en la lista
    $body_table_fallas_despachador.append($fragment);
  }
}

const mostrarMejorDespachador = (data_despachadores,total_pedidos) => {

  //Enlazamos el template creado en el HTML
  const $template_table_body_mejor_despachador = d.querySelector('#template_table_body_mejor_despachador').content;

  if(data_despachadores.length > 0){

      data_despachadores.forEach(element => {
          //Insertamos los datos en el template
          $template_table_body_mejor_despachador.querySelector('.name').textContent = element.NOMB_EMPLEADO;
          $template_table_body_mejor_despachador.querySelector('.cant_pedidos').textContent = element.MAYOR_VOTADO;
          $template_table_body_mejor_despachador.querySelector('.porc_total_pedidos').textContent = `${((element.MAYOR_VOTADO / total_pedidos[0].TODOS_PED) * 100).toFixed(2)} `;
          $template_table_body_mejor_despachador.querySelector('.cantidad_unidades').textContent = element.UNIDADES_T;
          $template_table_body_mejor_despachador.querySelector('.porc_total_unidades').textContent = `${((element.UNIDADES_T / total_pedidos[0].UNIDADES_T) * 100).toFixed(2)}`;
          
           //guardamos una copia de la estrutura actual del template en la variable $node
          let $clone = $template_table_body_mejor_despachador.cloneNode(true);
          //Guardamos el nodo en el fragment
          $fragment.append($clone);

      });
      // //Limpiamos la lista
      $body_table_mejor_despachador.innerHTML = "";
      //Insertamos el fragment en la lista
      $body_table_mejor_despachador.append($fragment);

  }
}

const mostarFallasEncontradasRechequeador = (data_rechequeadores,total_fallas) => {
  const $template_table_body_fallas_encontradas_rechequeador = d.querySelector('#template_table_body_fallas_encontradas_rechequeador').content;

  if(data_rechequeadores.length > 0){
    data_rechequeadores.forEach(element => {
        //Insertamos los datos en el template
        $template_table_body_fallas_encontradas_rechequeador.querySelector('.name').textContent = element.NOMB_RECHEQUEADOR;
        $template_table_body_fallas_encontradas_rechequeador.querySelector('.errors').textContent = element.MAYOR_RECH;
        $template_table_body_fallas_encontradas_rechequeador.querySelector('.porc_errors').textContent = `${((element.MAYOR_RECH / total_fallas[0].TOTAL_PED) * 100).toFixed(2)} `;
        
         //guardamos una copia de la estrutura actual del template en la variable $node
        let $clone = $template_table_body_fallas_encontradas_rechequeador.cloneNode(true);
        //Guardamos el nodo en el fragment
        $fragment.append($clone);
      });
    }

    //Limpiamos la lista
    $body_table_fallas_encontradas_rechequeadores.innerHTML = "";
    //Insertamos el fragment en la lista
    $body_table_fallas_encontradas_rechequeadores.append($fragment);
}

const extract_statistic = async (form_data) => {
    try {
        data_estadisticas = await app('http://192.168.0.164/registrar-pruebas/controllers/general_statistic.php?extract_statistic=1','POST',form_data);
        mostrarMejorDespachador(data_estadisticas.estadisticas_despachador,data_estadisticas.total_cantidad_pedidos);
        mostrarFallasDespachador(data_estadisticas.fallas_despachador, data_estadisticas.total_fallas);
        mostarFallasEncontradasRechequeador(data_estadisticas.fallas_encontradas_rechequeador, data_estadisticas.total_fallas)
      } catch (error) {
        console.log(error);
      }
};

//Capturamos el evento submit y ejecutamos logica para realizar peticiones a backend
d.addEventListener("submit", e => {
    e.preventDefault();

    const start_date = e.target.start_date.value;
    const final_date = e.target.final_date.value;

    if(start_date.length === 0){
      alert('Por favor ingresar fecha inicial');
      return;
    }
  
    if(final_date.length === 0){
      alert('Por favor ingresar fecha final');
      return;
    }

    // Convertimos las fechas a objetos Date
    const startDateObj = new Date(start_date);
    const finalDateObj = new Date(final_date);

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
    formData.append('start_date', formatDate(startDateObj)); // Formato deseado
    formData.append('final_date', formatDate(finalDateObj)); 

    //Ejecutamos consultas
    extract_statistic(formData);
});


