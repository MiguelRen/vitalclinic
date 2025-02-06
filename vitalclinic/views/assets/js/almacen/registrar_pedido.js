import app from '../api.js';
import utilidades from "../utilidades.js";
const d = document,
$empleado = d.querySelector("#empleado"),
$ruta = d.querySelector("#ruta");

const { asignar_valores_select } = utilidades();

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

const extraer_data_empleados = async () => {
    try {
        const data_empleados = await app('./controllers/empleados.php?extraer_empleados=1');
        console.log(data_empleados);
        mostrar_empleados(data_empleados)
    } catch (error) {
        console.log(error)
    }
};

const extraer_data_rutas = async () => {
    try {
        const data_rutas = await app('./controllers/almacen/rutas.php?extraer_rutas=1');
        mostrar_rutas(data_rutas)
    } catch (error) {
        console.log(error)
    }
};

const registrar_pedido = async (form_data) => {
    try {
        const res = await app('./controllers/almacen/pedidos.php?registrar_pedido=1','POST', form_data);
        console.log(res)
    } catch (error) {
        console.log(error)
    }
}

d.addEventListener('DOMContentLoaded', e => {
    extraer_data_empleados();
    extraer_data_rutas();
});

d.addEventListener("submit", e => {
    e.preventDefault();

    const cod_pedido = e.target.cod_pedido.value;
    const ruta = e.target.ruta.value;
    const empleado = e.target.empleado.value;
    const cant_unidades = e.target.cant_unidades.value;

    if(cod_pedido === ""){
        alert('Debe Ingresar el numero de pedido');
        return;
    }

    if(ruta === ""){
        alert('Debe seleccionar la ruta del pedido');
        return;
    }

    if(empleado === ""){
        alert('Debe seleccionar el empleado');
        return;
    }

    if(cant_unidades === ""){
        alert('Debe ingresar la cantidad de unidades del pedido');
        return;
    }

    const formData = new FormData();
    formData.append('cod_pedido',cod_pedido);
    formData.append('empleado',empleado);
    formData.append('ruta',ruta);
    formData.append('cant_unidades',cant_unidades);

    registrar_pedido(formData);
});
