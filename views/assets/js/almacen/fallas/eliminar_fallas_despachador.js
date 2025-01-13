import app from '../../api.js';
const d = document,
$body_table_pedidos = d.querySelector('#body_table_pedidos'),
$fragment = d.createDocumentFragment();

let data_table_fallas;
let data_table_pedidos_d_r_e;

const mostrar_datos_tabla_fallas = async(data) => {

    console.log(data)
    //Enlazamos el template creado en el HTML
    const $template_body_table_fallas = d.querySelector('#template_body_table_fallas').content;
  
    if(data.length > 0){
        
        data.forEach(element => {
            //Insertamos los datos en el template
            $template_body_table_fallas.querySelector('.n_pedido').textContent = element.numero_pedido;
            $template_body_table_fallas.querySelector('.n_parte').textContent = element.num_parte;
            $template_body_table_fallas.querySelector('.despachador').textContent = `${element.nombre_despachador} ${element.apellido_despachador}`;
            $template_body_table_fallas.querySelector('.motivo').textContent = element.motivo;
            $template_body_table_fallas.querySelector('.descripcion').textContent = element.descripcion;
            $template_body_table_fallas.querySelector('.fecha').textContent = element.fecha;
            $template_body_table_fallas.querySelector('.delete').dataset.id = element.id_falla_pedido;
            
            //guardamos una copia de la $template_body_table_pedidosestrutura actual del template en la variable $node
            let $clone = $template_body_table_fallas.cloneNode(true);
            //Guardamos el nodo en el fragment
            $fragment.append($clone);
        });
  
        // //Limpiamos la lista
        $body_table_pedidos.innerHTML = "";
        //Insertamos el fragment en la lista
        $body_table_pedidos.append($fragment);
    }else{  
        $body_table_pedidos.innerHTML = "";
    }
}

const extraer_fallas = async (form_data) => {
    try {
        const data_motivo_fallas = await app('http://192.168.0.164/vitalclinic/controllers/almacen/fallas/fallas_pedidos.php?extraer_fallas_despachador=1','POST', form_data);
        return data_motivo_fallas
    } catch (error) {
        throw error
    }
};

const extraer_datos_pedido = async(form_data) => {
    try {
        const data_pedido = await app('http://192.168.0.164/vitalclinic/controllers/almacen/pedidos/pedidos.php?consultar_pedido=1','POST',form_data);
        return data_pedido
    } catch (error) {
        throw error;
    }
}

const ejecutar_peticiones = async(form_data) => {
    const promises = await Promise.allSettled([extraer_fallas(form_data),extraer_datos_pedido(form_data)])

    let consulta_rejected = false;
    for (let i = 0; i < promises.length; i++) {
        if(promises[i].status != 'fulfilled'){
            consulta_rejected =true;
            alert('Ha ocurrido un error, por favor intente nuevamente');
            break;
        }
    }

    if(consulta_rejected) return;

    data_table_fallas = promises[0].value;
    data_table_pedidos_d_r_e = promises[1].value;

    console.log(data_table_fallas)

    if(data_table_pedidos_d_r_e.data.length > 0){  
        
        if(data_table_fallas.data.length > 0){
            data_table_pedidos_d_r_e.data[0].tabla_pedidos_d_r_e.forEach((data_pedido,i) => {
                data_table_fallas.data[0].forEach(data_falla => {
                    if(data_falla.id_parte_pedido ==  data_pedido.id_pedido_d_r_e){
                        data_falla.num_parte = i+1;
                    }
                })
            });
    
            mostrar_datos_tabla_fallas(data_table_fallas.data[0]);
        }else{
            alert('No haz registrado fallas en este pedido');
        }

       
    }else{
        alert('El número de pedido no se encuentra registrado')
        return;
    }
}

const eliminar_falla = async(form_data,id_falla) => {
    try {
        const res = await app('http://192.168.0.164/vitalclinic/controllers/almacen/fallas/fallas_pedidos.php?eliminar_falla_despachador=1','POST', form_data);
        if(res.data.length > 0){
            const data_table_fallas_copy = [...data_table_fallas.data[0]];

            let index = null;
  
            for (let i = 0; i < data_table_fallas_copy.length; i++) {
                if(data_table_fallas_copy.id_falla_pedido === id_falla){
                    index = i;
                    break;
                }
            }

            data_table_fallas_copy.splice(index,1);
            data_table_fallas.data[0] = [...data_table_fallas_copy];
            mostrar_datos_tabla_fallas(data_table_fallas.data[0]);

          }else{
              alert(`${res.error}`)
          }
    } catch (error) {
        console.log(error)
    }
}

d.addEventListener('click', async e => {

    if(e.target.classList.contains('delete')){
        const id_falla = e.target.dataset.id;
        
        const form_data = new FormData();
        form_data.append('id_falla', id_falla);

        await eliminar_falla(form_data,id_falla);
    }
});

d.addEventListener('submit', async e => {
    e.preventDefault();

    const numero_pedido = e.target.cod_pedido.value;

    if(numero_pedido === ""){
        alert('Debe ingresar el número de pedido');
        e.target.cod_pedido.focus();
        return
    }

    const formData = new FormData();
    formData.append('numero_pedido', numero_pedido);
    
    await ejecutar_peticiones(formData);
})
