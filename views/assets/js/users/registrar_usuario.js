import app from '../api.js';
import utilidades from "../utilidades.js";
import common_services from "../common_services/users.js";
const d = document,
$empleado = d.querySelector("#empleado"),
$role = d.querySelector("#role");

const { asignar_valores_select } = utilidades();
const { extraer_data_empleados, mostrar_empleados } = common_services();

const mostrar_roles = (data_roles) => {

    asignar_valores_select(
        { 
            data: data_roles,
            titulo: "Seleccionar Rol",
            input: $role,
            nombre_opciones : {
                id : "id",
                nombre: "role"  
            }
        }
    );
}

const extraer_roles = async() => {
    try {
        const data_roles = await app('http://192.168.0.164/vitalclinic/controllers/users/empleados.php?extraer_roles=1');
        mostrar_roles(data_roles);
    } catch (error) {
        console.log(error)
    }
}

const registrar_usuario = async(form_data) => {
    try {
        const res = await app('http://192.168.0.164/vitalclinic/controllers/users/empleados.php?registrar_usuario=1','POST', form_data);
	if(res){alert("Registro existoso")}
      } catch (error) {
        console.log(error)
      }
};  
 
d.addEventListener('DOMContentLoaded', async e => {
   const empleados =  await extraer_data_empleados({
        order:1,
        departamento:1
    });

    mostrar_empleados({
        data_empleados:empleados,
        order:1,
        input: $empleado
    })

    await extraer_roles();
});

d.addEventListener('submit', async e => {
    e.preventDefault();

    const empleado = e.target.empleado.value;
    const username = e.target.username.value;
    const password = e.target.password.value;
    const role = e.target.role.value;

    //Validar Informacion

    const formData = new FormData();
    formData.append('empleado', empleado);
    formData.append('username', username);
    formData.append('password', password);
    formData.append('role', role);

    await registrar_usuario(formData);
});
