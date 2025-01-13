import app from '../api.js';
import common_services from "../common_services/users.js";
const d = document,
$empleado = d.querySelector("#empleado");

let data_empleados = [];

const users = common_services();
const { mostrar_empleados, extraer_data_empleados } = users;

const modificar_empleado = async(form_data) => {
    try {
      const res = await app('http://192.168.0.164/vitalclinic/controllers/users/empleados.php?modificar_empleado=1','POST', form_data);
        if(res.data.length > 0){
            
            alert('Modificación exitosa');
            limpiarformmulario();
            
            data_empleados =  await extraer_data_empleados({
                order:1,
                departamento:2
            });
            
            mostrar_empleados({
                data_empleados: data_empleados,
                order:1,
                input: $empleado
            })

        }else{
            alert(`${res.error}`)
        }

    } catch (error) {
      console.log(error)
    }
}

const limpiarformmulario = () => {
    d.querySelector('#cedula').value = "";
    d.querySelector('#name').value = "";
    d.querySelector('#lastname').value = "";
    d.querySelector("#status").selectedIndex = 0
    $empleado.selectedIndex = 0;
}

$empleado.addEventListener('change', e => {
    if($empleado.value !== ""){
        const id_empleado = $empleado.value;
        const data_empleado = data_empleados.filter(i => i.id === id_empleado);
        d.querySelector('#cedula').value = data_empleado[0].cedula;
        d.querySelector('#name').value = data_empleado[0].nombre;
        d.querySelector('#lastname').value = data_empleado[0].apellido;
        d.querySelector('#id').value = data_empleado[0].id;
        d.querySelector('#status').selectedIndex = data_empleado[0].status;
    }else{
        limpiarformmulario();
    }

});

d.addEventListener('DOMContentLoaded', async e => {
   
    data_empleados =  await extraer_data_empleados({
     order:1,
     departamento:2
    });

    mostrar_empleados({
     data_empleados: data_empleados,
     order:1,
     input: $empleado
    });

});

d.addEventListener('submit', async e => {
    e.preventDefault();

    const cedula = e.target.cedula.value;
    const name = e.target.name.value;
    const lastname = e.target.lastname.value;
    const id = e.target.id.value; 
    const status = e.target.status.value;
    
    const form_data = new FormData();
    form_data.append('cedula', cedula);
    form_data.append('name', name);
    form_data.append('lastname', lastname);
    form_data.append('id', id);
    form_data.append('status', status);

    await modificar_empleado(form_data);
})
