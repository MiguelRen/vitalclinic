import app from "./api.js";
import utilidades from "./utilidades.js";

const {asignar_valores_select, formatDate} = utilidades();

const d = document,
$select_rutas = d.querySelector("#select_rutas");

const mostrar_rutas = (data_rutas) => {
    //Mostramos los datos de las categorias
    asignar_valores_select(
        { 
            data: data_rutas.rutas,
            titulo: "Seleccionar Ruta",
            input: $select_rutas,
            nombre_opciones : {
                id : "ID",
                nombre: "RUTA"  
            }
        }
    );
};

const obtener_rutas = async () => {
    try {
        const data = await app('http://192.168.0.164/registrar-pruebas/controllers/pedidos_por_fecha.php?obtener_rutas=1');
        mostrar_rutas(data);
    } catch (error) {
        console.log(error);
    }
};

const consultar_pedidos = async (data_pedidos) => {
    try {
        const data = await app('http://192.168.0.164/registrar-pruebas/controllers/pedidos_por_fecha.php?obtener_pedidos=1','POST',data_pedidos);
        console.log(data)
    } catch (error) {
        console.log(error);
    }
};

d.addEventListener("DOMContentLoaded", e => {
    obtener_rutas();
});

d.addEventListener('submit', e => {
    e.preventDefault();

    const start_date = e.target.start_date.value;
    const final_date = e.target.final_date.value;
    const ruta = $select_rutas.value;

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
      formData.append('ruta', ruta);
      
      consultar_pedidos(formData);
});