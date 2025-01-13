import app from '../api.js';
import utilidades from '../utilidades.js';

const common_rutas = () => {

    const { asignar_valores_select } = utilidades();
    
    const extraer_data_rutas = async () => {
        try {
            const data_rutas = await app('http://192.168.0.164/vitalclinic/controllers/almacen/rutas/rutas.php?extraer_rutas=1');
            return data_rutas;
        } catch (error) {
            console.log(error)
        }
    };

    const mostrar_rutas = ({
        data_rutas, 
        input
    }) => {

        //Mostramos los datos de las rutas
        asignar_valores_select(
            { 
                data: data_rutas,
                titulo: "Seleccionar Ruta",
                input: input,
                nombre_opciones : {
                    id : "id",
                    nombre: "name"  
                }
            }
        );
    };

    return {
        extraer_data_rutas,
        mostrar_rutas
    }

}

export default common_rutas;