import app from '../../api.js';
const d = document;

const eliminar_pedido = async(form_data) => {
  try {
    const res = await app('http://192.168.0.164/vitalclinic/controllers/almacen/pedidos/pedidos.php?eliminar_pedido=1','POST',form_data);
    if(res.data.length > 0){
        alert('Eliminación del pedido exitosa');
        d.querySelector('#cod_pedido').value = "";
      }else{
          alert(`${res.error}`)
      }
  } catch (error) {
    console.log(error)
}
}

d.addEventListener('submit', async e => {
  e.preventDefault();

  const cod_pedido = e.target.cod_pedido.value;

  if(cod_pedido.value === ""){
    alert('Ingresar el número de pedido');
    e.target.cod_pedido.focus();
    return;
  }

  const form_data = new FormData();
  form_data.append('cod_pedido', cod_pedido);

 await  eliminar_pedido(form_data);
});
