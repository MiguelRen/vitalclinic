import app from '../api.js';
import utilidades from '../utilidades.js';

const common_users = () => {
    const { asignar_valores_select } = utilidades();
    
    const extraer_data_empleados = async ({
        order = 1,
        departamento = 1
    }) => {
    
        //PARAMETROS VALIDOS PARA EL ORDER 1, 2
        // 1 : extrae los empleados ordenados por nombre
        // 2 : extrae los empleados ordenados por cedula
    
        //PARAMETROS VALIDOS PARA EL DEPARTAMENTO 1, 2
        // 1 : extrae TODOS los empleados sin importar departamento
        // 2 : extrae los empleados que pertenecen al mismo departamento que el usuario que tiene la session iniciada
        
        // Validación de los parámetros
        if (typeof order !== 'number' || order < 1 || order > 2) {
            throw new Error("El parámetro 'order' debe ser un dígito entre 1 y 2.");
        }
    
        if (typeof departamento !== 'number' || departamento < 1 || departamento > 2) {
            throw new Error("El parámetro 'departamento' debe ser un dígito entre 1 y 2.");
        }
    
        const formData = new FormData();
        formData.append('order', order);
        formData.append('departamento', departamento); 

        console.log(order, departamento)
    
        try {
            const data_empleados = await app('http://localhost/vitalclinic/controllers/users/empleados.php?extraer_empleados2=1','POST',formData);
            return data_empleados;
        } catch (error) {
            console.log(error)
        }
    };

    const mostrar_empleados = (
        {
            data_empleados, 
            order = 1,
            input
        }
    ) => {

        if (typeof order !== 'number' || order < 1 || order > 2) {
            order = 1;
        }

        const format_data = data_empleados.map( e => {
           const nombre =  order == 1 ?  `${e.nombre} ${e.apellido} - ${e.cedula}` :  `${e.cedula} - ${e.nombre} ${e.apellido}`
           const data = {
            id: e.id,
            nombre: nombre
           }
    
           return {...data}
        })


        //Mostramos los datos de los empleados
        asignar_valores_select(
            { 
                data: format_data,
                titulo: "Seleccionar Empleado",
                input: input,
                nombre_opciones : {
                    id : "id",
                    nombre: "nombre"  
                }
            }
        );
    };

    return {
        mostrar_empleados,
        extraer_data_empleados
    }
}

export default common_users;


