export default async function app(url, metodo = 'GET', datos = null) {
    const opciones = {
        method: metodo,
    };
  
    if (datos) {
        opciones.body = datos;
    }
  
    try {
        const respuesta = await fetch(url, opciones);
        
        if (!respuesta.ok) {
            throw new Error(`Error en la petición: ${respuesta.status} ${respuesta.statusText}`);
        }
  
        const resultado = await respuesta.json();
        return resultado;
    } catch (error) {
        console.error('Error:', error);
        throw error; // Lanza el error para manejarlo donde se llame a la función
    }
}