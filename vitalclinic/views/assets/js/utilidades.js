//Mostrar valores en los selects

const utilidades = () => {

    const asignar_valores_select = (param) => {
    
        let {
            data,
            titulo,
            input,
            nombre_opciones
        } = param;
    
        let {id,nombre} = nombre_opciones;
    
        for(let i = 0; i < data.length+1; i++){
            if(i < 1){
                //Insertamos el titulo, que indicara al usuario que debe seleccionar alguna opcion
                input.options[i] = new Option(titulo,"");
            }else{
                //Insertamos las opciones
                input.options[i] = new Option(
                    `${data[i-1][nombre]}`,
                    `${data[i-1][id]}`,
                );
            }
        }
    }

    // Función para formatear la fecha
    const formatDate = (date) => {
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0'); // Meses son 0-11
        const day = String(date.getDate()).padStart(2, '0');
        const hours = String(date.getHours()).padStart(2, '0');
        const minutes = String(date.getMinutes()).padStart(2, '0');
        const seconds = String(date.getSeconds()).padStart(2, '0');
        return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
    };

    const prefixUrlBackend = 'http://192.168.0.164'


    return {
        asignar_valores_select,
        formatDate,
        prefixUrlBackend

    }
} 

export default utilidades;





