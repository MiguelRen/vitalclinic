import app from '../../api.js';
import utilidades from "../../utilidades.js";
const { asignar_valores_select } = utilidades();
const d = document,
$motivo = d.querySelector('#motivo'),
$despachador = d.querySelector('#despachador');

let dataFallas = [];

const mostrar_despachadores = (data_despachadores) => {
    //Mostramos los datos de los empleados
    asignar_valores_select(
        { 
            data: data_despachadores,
            titulo: "Seleccionar Despachador",
            input: $despachador,
            nombre_opciones : {
                id : "id",
                nombre: "nombre"  
            }
        }
    );
};

const mostrar_motivos = (data_motivos) => {
    asignar_valores_select({ 
        data: data_motivos,
        titulo: "Seleccionar Motivo",
        input: $motivo,
        nombre_opciones : {
            id : "id",
            nombre: "descripcion"  
        }
    })
}

const registrar_fallas = async(form_data) => {
    try {
        const data = await app('http://192.168.0.164/vitalclinic/controllers/almacen/fallas/fallas_pedidos.php?registrar_fallas=1','POST',form_data);
        if(data.data.length > 0){  
            alert('Registro de falla exitoso');
            $despachador.selectedIndex = 0;
            $motivo.selectedIndex = 0;
            d.querySelector('#descripcion').value = '';
        }else{
            alert(`${data.error}`)
        }
    } catch (error) {
        console.log(error)
    }
}

const extraer_data_motivo_fallas = async () => {
    try {
        const data_motivo_fallas = await app('http://192.168.0.164/vitalclinic/controllers/almacen/fallas/fallas_pedidos.php?extraer_motivos=1');
        mostrar_motivos(data_motivo_fallas)
    } catch (error) {
        console.log(error)
    }
};

const formatDataSelect = (data) => {

    if(data.length > 0){
        data.forEach((e,i)=> {
            const object = {
                id : e.id_despachador,
                nombre: `Parte N°${i+1} ${e.nombre_despachador} ${e.apellido_despachador}`,
                id_pedido_d_r_e : e.id_pedido_d_r_e
            }

            dataFallas.push(object);
        })    
    }

    mostrar_despachadores(dataFallas);
}

const extraer_datos_pedido = async(form_data) => {

    try {
        const data_pedido = await app('http://192.168.0.164/vitalclinic/controllers/almacen/rechequeo/rechequear.php?consultar_pedido=1','POST',form_data);
        if(data_pedido.data.length > 0){  
         // console.log(data_pedido.data[0].tabla_pedidos_d_r_e)
          dataFallas = [];
          formatDataSelect(data_pedido.data[0].tabla_pedidos_d_r_e);
        }else{
            alert('El número de pedido no se encuentra registrado')
        }
    } catch (error) {
        console.log(error)
    }
  }
  
d.addEventListener('DOMContentLoaded', async e => {
    await extraer_data_motivo_fallas();
});


d.addEventListener('submit', async e => {
    e.preventDefault();

    if(e.target.classList.contains('buscar')){
        const numero_pedido = e.target.cod_pedido.value;

        if(numero_pedido === ""){
            alert('Ingrese el número del pedido');
            return;
        }

        const form_data = new FormData();
        form_data.append('numero_pedido', numero_pedido);

        await extraer_datos_pedido(form_data);
    }

    if(e.target.classList.contains('registrar')){

        const id_despachador = $despachador.value;
        const motivo = $motivo.value;
        const descripcion = e.target.descripcion.value;

        if(id_despachador == ""){
            alert('Debe seleccionar un despachador');
            return;
        }

        if(motivo == ""){
            alert('Debe seleccionar el motivo de la falla');
            return;
        }

        if(descripcion == ""){
            alert('Debe ingresar la descripcion');
            return;
        }

        const id_pedido_d_r_e = dataFallas[$despachador.selectedIndex - 1].id_pedido_d_r_e;

        const form_data = new FormData();
        form_data.append('id_despachador', id_despachador);
        form_data.append('motivo', motivo);
        form_data.append('descripcion', descripcion);
        form_data.append('id_pedido_d_r_e', id_pedido_d_r_e);

        await registrar_fallas(form_data);
    }
})
