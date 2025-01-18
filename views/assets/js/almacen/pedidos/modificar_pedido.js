import app from '../../api.js';
import common_services from "../../common_services/users.js";
import common_rutas from "../../common_services/rutas.js";
const d = document,
$fragment = d.createDocumentFragment(),
$ruta = d.querySelector("#ruta"),
$body_table = d.querySelector("#body_table");

let data_partes_pedido = [];
let data_empleados = null;

const users = common_services();
const { mostrar_empleados, extraer_data_empleados } = users;

const rutas = common_rutas();
const { mostrar_rutas, extraer_data_rutas } = rutas;

const mostrar_datos_tabla= async(data) => {

    //Enlazamos el template creado en el HTML
    const $template_body_table_pedidos = d.querySelector('#template_body_table_pedidos').content;

    if(data.length > 0){
        
        data.forEach((element,i) => {
            //Insertamos los datos en el template
            $template_body_table_pedidos.querySelector('.part').textContent = `${i+1}`;
            $template_body_table_pedidos.querySelector('.select').dataset.id = i+1;
            //guardamos una copia de la estrutura actual del template en la variable $node
            let $clone = $template_body_table_pedidos.cloneNode(true);
            //Guardamos el nodo en el fragment
            $fragment.append($clone);
        });

        // //Limpiamos la lista
        $body_table.innerHTML = "";
        //Insertamos el fragment en la lista
        $body_table.append($fragment);

        //Llenamos con los datos de los empleados los select impresos en el paso anterior
        const selects = Array.from(d.querySelectorAll('.select'));
        selects.forEach((s,i) => {
            mostrar_empleados({
                data_empleados:data_empleados,
                order:1,
                input:s
            });    
        })

        //Posicionamos cada uno de los select en el valor correspondiente con respecto a los despachadores del pedido
        data.forEach((e,i)=>{
            for (let j = 0; j < selects[i].options.length; j++) {
                if (selects[i].options[j].value == e.id_despachador) {
                    selects[i].selectedIndex = j;
                    break;
                }
            } 
        })
    }else{  
        $body_table.innerHTML = "";
    }
}

const mostrar_data_form = (data) => {
    d.querySelector("#cant_unidades").value = data.cantidad_unidades;
    for(let i = 0; $ruta.options.length; i++){
	if($ruta.options[i].value == data.id_ruta){
	   $ruta.selectedIndex = i;
	   break;
	}
     }
    d.querySelector('#id_pedido').value = data.id_pedido;
}

const format_data = (data) => {

    //Agregamos la informacion de los despachadores al array despachadores
    data.forEach(e => {
        const object = {
            id_despachador : e.id_despachador,
            nombre: `${e.nombre} ${e.apellido}`,
            id_pedido_d_r_e: e.id_pedido_d_r_e
        }
        data_partes_pedido.push(object);
    });
}

const extraer_datos_pedido = async(form_data) => {

    //Limpiamos el array para luego realizar una busqueda
    data_partes_pedido = [];

    try {
        const data_pedido = await app('http://localhost/vitalclinic/controllers/almacen/pedidos/pedidos.php?extraer_data_pedido=1','POST',form_data);
        if(data_pedido.data.length > 0){
            format_data(data_pedido.data[0].partes_pedido);
            mostrar_datos_tabla(data_partes_pedido);
            mostrar_data_form(data_pedido.data[0]);
            //buscado = true;

            //console.log(data_pedido)
        }else{
            alert('El número de pedido no se encuentra registrado')
        }
    } catch (error) {
        console.log(error)
    }
}

const getDataForm = async () => {
    const cod_pedido = d.querySelector('#cod_pedido');
    const ruta = d.querySelector('#ruta');
    const cant_unidades = d.querySelector('#cant_unidades');
    const id_pedido = d.querySelector('#id_pedido').value;
    const ids_despachadores = Array.from(d.querySelectorAll('.select')).map(e => e.value) ;
  
    if(cod_pedido.value === ""){
      alert('Debe indicar el número del pedido');
      cod_pedido.focus();
      return;
    }
  
    if(ruta.value === ""){
      alert('Debe seleccionar la ruta del pedido');
      ruta.focus();
      return;
    }
  
    if(cant_unidades.value === ""){
      alert('Debe indicar la cantidad de unidades del pedido');
      cant_unidades.focus();
      return;
    }

    const formData = new FormData();
    formData.append('id_pedido', id_pedido);
    formData.append('ruta', ruta.value);
    formData.append('cant_unidades', cant_unidades.value);
    data_partes_pedido.forEach(item => {
      formData.append('despachadores[]',item.id_despachador);
      formData.append('id_parte_pedidos[]',item.id_pedido_d_r_e);
    })
    
    await modificar_pedido(formData)
}

const modificar_pedido = async (form_data) => {
    try {
        const res = await app('http://localhost/vitalclinic/controllers/almacen/pedidos/pedidos.php?modificar_pedido=1','POST',form_data);
        if(res.data.length > 0){
            alert('Modificación del pedido exitoso');
            limpiarformmulario();
          }else{
              alert(`${res.error}`)
          }
      } catch (error) {
        console.log(error)
    }
}

const limpiarformmulario = () => {
    $body_table.innerHTML = "";
    d.querySelector('#cod_pedido').value="";
    $ruta.selectedIndex = 0;
    d.querySelector('#cant_unidades').value = "";
    d.querySelector('#cod_pedido').disabled = false;
    buscado = false;
    let data_partes_pedido_copy = [...data_partes_pedido];
    data_partes_pedido_copy = [];
    data_partes_pedido = data_partes_pedido_copy;
}

d.addEventListener('change', e=> {
    if(e.target.classList.contains('select')){
        const dataset = e.target.dataset.id;
        //Obtenemos el item del array que queremos modificar
        const data_parte_pedido_copy = {...data_partes_pedido[(dataset-1)]};

        const nombre = e.target.options[e.target.selectedIndex].text;
        const id_despachador = e.target.value;
        
        //creamos el nuevo item
        const item = {
            id_despachador: id_despachador,
            nombre: nombre,
            id_pedido_d_r_e: data_parte_pedido_copy.id_pedido_d_r_e
        }

        const data_partes_pedido_copy = [...data_partes_pedido];
        data_partes_pedido_copy[dataset-1] = item;

        data_partes_pedido = [...data_partes_pedido_copy];       
    }
})

d.addEventListener('click', async e => {
    
    if(e.target.classList.contains('modificar_pedido')){
      await getDataForm();
    }
});

d.addEventListener('submit', async e=> {
    e.preventDefault();

    const cod_pedido = e.target.cod_pedido.value;

    if(cod_pedido == ""){
        alert('Por favor ingresar el número de pedido');
        e.target.cod_pedido.focus();
        return; 
    }

    const formdata = new FormData();
    formdata.append('cod_pedido',cod_pedido);
    await extraer_datos_pedido(formdata);
})

d.addEventListener('DOMContentLoaded', async e => {
    data_empleados = await extraer_data_empleados({
        order:1,
        departamento:1
    });

    const rutas = await extraer_data_rutas();
    mostrar_rutas({
        data_rutas: rutas,
        input: $ruta
    })
});
