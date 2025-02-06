import app from '../../api.js';
import utilidades from "../../utilidades.js";
const d = document,
$fragment = d.createDocumentFragment(),
$loader = d.querySelector("#loader"),
$panel_turnos = d.querySelector('#panel_turnos'),
$body_table_mesa = d.querySelector('#body_table_mesa');
let is_loader = false;

const { asignar_valores_select } = utilidades();

let mesas_turno;
let id_mesa;
let data_rechequeadores = [];
let data_embaladores = [];

let turnos = [];
let turno_seleccionado = undefined;

const limpiar_tabla = (inputs) => {
  inputs.forEach((element,i) => {
    inputs[i].querySelector('.rechequeador').innerHTML = '';    
    inputs[i].querySelector('.embalador').innerHTML = '';
  })
}

const registrar_pareja_rechequeadora = async (form_data) => {

  console.log('kak')
  try {
    const res = await app('http://192.168.0.164/vitalclinic/controllers/almacen/rechequeo/mesa_rechequeo.php?registrar_pareja_rechequeadora=1','POST',form_data);
    if(res.data.length > 0){
        const d =  await extraer_data_mesa_rechequeo();
        alert('Modificación exitosa');
        ordenar_data_mesas_rechequeo(d);
        mostrar_data();
      }else{
          alert(`${res.error}`)
          return;
      }
  } catch (error) {
    console.log(error)
  }
}

const mostrar_data = () => {
  //Enlazamos el template creado en el HTML
  const $tr = Array.from($body_table_mesa.querySelectorAll('tr'));
  const data = mesas_turno.filter((e,i) => e[0].turno == turno_seleccionado);
  limpiar_tabla($tr);

  if(data.length > 0){
      data[0].forEach((element,i) => {
          //Insertamos los datos en el template
          $tr[i].querySelector('.n_mesa').innerHTML = Number(i+1);
          const nombre_rechequeador = element.nombre_rechequeador !== null ? `${element.nombre_rechequeador} ${element.apellido_rechequeador} - ${element.cedula_rechequeador}` : '';
          $tr[i].querySelector('.rechequeador').innerHTML = nombre_rechequeador;
          const nombre_embalador = element.nombre_embalador !== null ? `${element.nombre_embalador} ${element.apellido_embalador} - ${element.cedula_embalador}` : '';
          $tr[i].querySelector('.embalador').innerHTML = nombre_embalador;
          $tr[i].querySelector('.edit').dataset.id = element.id_pareja_rechequeadores_embaladores;
      });

  }else{  
      limpiar_tabla($tr);
  }
}

const mostrar_rechequeadores = (data_rechequeadores) => {
  //Mostramos los datos de los empleados

  const format_data = data_rechequeadores.map( e => {
     const data = {
      id: e.id_cuenta,
      nombre: `${e.nombre_rechequeador} ${e.apellido_rechequeador} - ${e.cedula_rechequeador}`
     }

     return {...data}
  })

  const $requeador = d.querySelector('#rechequeador');

  asignar_valores_select(
      { 
          data: format_data,
          titulo: "Seleccionar Rechequeador",
          input: $requeador,
          nombre_opciones : {
              id : "id",
              nombre: "nombre"  
          }
      }
  );
};

const mostrar_embaladores = (data_embaladores) => {
  //Mostramos los datos de los empleados

  const format_data = data_embaladores.map( e => {
     const data = {
      id: e.id_embalador,
      nombre: `${e.nombre_embalador} ${e.apellido_embalador} - ${e.cedula_embalador}`
     }

     return {...data}
  })

  const $embalador = d.querySelector('#embalador');

  asignar_valores_select(
      { 
          data: format_data,
          titulo: "Seleccionar Embalador",
          input: $embalador,
          nombre_opciones : {
              id : "id",
              nombre: "nombre"  
          }
      }
  );
};

function obtenerValoresRepetidos(array) {
  return array.filter((item, index) => array.indexOf(item.turno) !== index.turno)
              .filter((item, index, self) => self.indexOf(item.turno) === index.turno);
}

const ordenar_data_mesas_rechequeo = (data) => {

  const turnos = []
  let turno = undefined;
  data.forEach(element => {
    turno = element.turno;
    if(turnos.length === 0){
      turnos.push(element.turno);
    }else{
      let bool = turnos.includes(element.turno);
      if(!bool) turnos.push(element.turno);
    }
  })

  mesas_turno = turnos.map((e,i) => {
    return data.filter(el => el.turno == e)
  });

}


const mostrar_turnos = (data) => {
  //Enlazamos el template creado en el HTML
  const $template_item_turnos = d.querySelector('#item_turno').content;
  
  if(data.length > 0){

    data[0].forEach((element,i) => {
      //Insertamos los datos en el template
      $template_item_turnos.querySelector('.t').textContent = `${element.hora_inicio} a ${element.hora_final}`;    
      $template_item_turnos.querySelector('.turno').dataset.id = element.id;
      $template_item_turnos.querySelector('.name_t').innerText = `Turno ${i+1}`;
      //guardamos una copia de la estrutura actual del template en la variable $node
      let $clone = $template_item_turnos.cloneNode(true);
      //Guardamos el nodo en el fragment
      $fragment.append($clone);
    });

    // //Limpiamos la lista
    $panel_turnos.innerHTML = "";
    //Insertamos el fragment en la lista
    $panel_turnos.append($fragment);
  }else{
    $panel_turnos.innerHTML = "";
  }
}

const consultar_turnos = async () => {
 
  try {
    const res = await app('http://192.168.0.164/vitalclinic/controllers/almacen/rechequeo/mesa_rechequeo.php?consultar_turnos=1');
    if(res.data.length > 0){
      turnos = res.data; 
      return turnos
      }else{
        alert(`${res.error}`)
        return;
      }
  } catch (error) {
    console.log(error)
  }
}

const consultar_data_rechequeadores_embaladores = async () => {
  try {
    const res = await app('http://192.168.0.164/vitalclinic/controllers/almacen/rechequeo/mesa_rechequeo.php?consultar_data_rechequeadores_embaladores=1');
    if(res.data.length > 0){
       data_embaladores = res.data[0].data_embaladores;
       data_rechequeadores = res.data[0].data_rechequeadores;

       console.log(data_embaladores)
       console.log(data_rechequeadores)
      }else{
          alert(`${res.error}`)
          return;
      }
  } catch (error) {
    console.log(error)
  }
}

const extraer_data_mesa_rechequeo = async () => {
  try {
    const res = await app('http://192.168.0.164/vitalclinic/controllers/almacen/rechequeo/mesa_rechequeo.php?consultar_parejas_rechequeadoras=1');
    if(res.data.length > 0){
       //ordenar_data_mesas_rechequeo(res.data[0])
       return res.data[0]
      }else{
          alert(`${res.error}`)
          return;
      }
  } catch (error) {
    console.log(error)
  }
}

const seleccionar_turno_al_iniciar_ventana = () => {
  let elementsHTML = Array.from(d.querySelectorAll('.turno'));
  let id = elementsHTML[0].dataset.id;
  elementsHTML.forEach(e => {
    if(e.dataset.id == id){
      e.classList.add('bg-gray-300');
      turno_seleccionado = id;
    }else{
      if(e.classList.contains('bg-gray-300')){
        e.classList.remove('bg-gray-300');
      }
    }
  })
}

const ejecutar_peticiones = async(form_data) => {

  is_loader = true;
  if(is_loader) $loader.classList.remove("hidden");

  const promises = await Promise.allSettled([consultar_turnos(),extraer_data_mesa_rechequeo()])

  let consulta_rejected = false;
  for (let i = 0; i < promises.length; i++) {
      if(promises[i].status != 'fulfilled'){
          consulta_rejected =true;
          alert('Ha ocurrido un error, por favor recargue la pagina');
          break;
      }
  }

  if(consulta_rejected){
    is_loader=false;
    $loader.classList.add("hidden"); 
    return 
  }

  is_loader = false;
  if(!is_loader) $loader.classList.add("hidden");

  turnos = promises[0].value;
  let data_mesa_rechequeo = promises[1].value;

  mostrar_turnos(turnos)
  seleccionar_turno_al_iniciar_ventana();
  ordenar_data_mesas_rechequeo(data_mesa_rechequeo)
  mostrar_data();
}

const crear_turno = async (data_form) => {
  is_loader = true;
  if(is_loader) $loader.classList.remove("hidden");

  try {
    const res = await app('http://192.168.0.164/vitalclinic/controllers/almacen/rechequeo/mesa_rechequeo.php?crear_turno=1','POST',data_form);
    if(res.data.length > 0){
      is_loader = false; 
      if(!is_loader)$loader.classList.add("hidden");   
      window.location.reload();

    }else{
        if(!is_loader) $loader.classList.add("hidden");
        alert(`${res.error}`)
        return;
    }
  } catch (error) {
    is_loader=false
    if(!is_loader)$loader.classList.add("hidden");
    console.log(error)
  }
}

const eliminar_turno = async (data_form) => {
  is_loader = true;
  if(is_loader) $loader.classList.remove("hidden");

  try {
    const res = await app('http://192.168.0.164/vitalclinic/controllers/almacen/rechequeo/mesa_rechequeo.php?eliminar_turno=1','POST',data_form);
    if(res.data.length > 0){
      is_loader = false; 
      if(!is_loader)$loader.classList.add("hidden");   
      window.location.reload();

    }else{
        if(!is_loader) $loader.classList.add("hidden");
        alert(`${res.error}`)
        return;
    }
  } catch (error) {
    is_loader=false
    if(!is_loader)$loader.classList.add("hidden");
    console.log(error)
  }
}

d.addEventListener('click', async e=> {
  if(e.target.parentElement.classList.contains('turno') || e.target.classList.contains('turno')){
    let id = e.target.parentElement.classList.contains('turno') ? e.target.parentElement.dataset.id : e.target.dataset.id;
    let elementsHTML = Array.from(d.querySelectorAll('.turno'));

    elementsHTML.forEach(e => {
      if(e.dataset.id == id){
        e.classList.add('bg-gray-300');
        turno_seleccionado = id;
        mostrar_data()
      }else{
        if(e.classList.contains('bg-gray-300')){
          e.classList.remove('bg-gray-300');
        }
      }
    })
  }

  if(e.target.classList.contains('edit')){
    await consultar_data_rechequeadores_embaladores();
    mostrar_rechequeadores(data_rechequeadores);
    mostrar_embaladores(data_embaladores);
    id_mesa = e.target.dataset.id;
  }
});


d.addEventListener('submit', async e => {
  e.preventDefault();
  
  if(e.target.classList.contains('agregar_turno')){
    
    const hora_inicio = e.target.hora_inicio.value;
    const hora_final = e.target.hora_final.value;
    
    if(hora_inicio == ""){
      alert('Debe indicar la hora de inicio del turno');
      return;
    }
    
    if(hora_final == ""){
      alert('Debe indicar la hora final del turno');
      return;
    }
    
    const form_data = new FormData();
    form_data.append('hora_inicio', hora_inicio);
    form_data.append('hora_final', hora_final);
    
    await crear_turno(form_data);   
  }
  
  if(e.target.classList.contains('eliminar_turno')){
    const form_data = new FormData();
    form_data.append('turno_seleccionado', turno_seleccionado);
    await eliminar_turno(form_data);   
  }

  if(e.target.classList.contains('editar_mesa')){    
    const rechequeador = e.target.rechequeador.value;
    const embalador = e.target.embalador.value;

    if(rechequeador === ""){
      alert('Debe seleccionar un rechequeador');
      e.target.rechequeador.focus();
      return;
    }

    if(embalador === ""){
      alert('Debe seleccionar un embalador');
      e.target.embalador.focus();
      return;
    }

    const form_data = new FormData();
    form_data.append('id_mesa', id_mesa);
    form_data.append('id_rechequeador', rechequeador);
    form_data.append('id_embalador', embalador);

    await registrar_pareja_rechequeadora(form_data);
  }

})

d.addEventListener('DOMContentLoaded', async e => {
  await ejecutar_peticiones();
  
  // mostrar_data();
});