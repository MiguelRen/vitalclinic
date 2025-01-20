import app from "../../api.js";
const d = document,
  $fragment = d.createDocumentFragment(),
  $body_table_pedidos = d.querySelector("#body_table_pedidos"),
  $body_table_pedidos_d_r_e = d.querySelector("#body_table_pedidos_d_r_e");

const buscar_button = d.getElementById("buscar_b");
const pedido_id_table = d.getElementById("table_1");
const confirm_button_table = d.getElementById("table_2");

const mostrar_datos_tabla_pedidos = async (data) => {
  //Enlazamos el template creado en el HTML
  const $template_body_table_pedidos = d.querySelector(
    "#template_body_table_pedidos"
  ).content;

  if (data.length > 0) {
    data.forEach((element) => {
      //Insertamos los datos en el template
      $template_body_table_pedidos.querySelector(".n_pedido").textContent =
        element.numero_pedido;
      $template_body_table_pedidos.querySelector(".ruta").textContent =
        element.nombre_ruta;
      $template_body_table_pedidos.querySelector(".c_unidades").textContent =
        element.cantidad_unidades;
      $template_body_table_pedidos.querySelector(".fecha_entrega").textContent =
        element.fecha;
      $template_body_table_pedidos.querySelector(
        ".entregador_por"
      ).textContent = `${element.nombre_distribuidor} ${element.apellido_distribuidor}`;
      //guardamos una copia de la estrutura actual del template en la variable $node
      let $clone = $template_body_table_pedidos.cloneNode(true);
      //Guardamos el nodo en el fragment
      $fragment.append($clone);
    });

    // //Limpiamos la lista
    $body_table_pedidos.innerHTML = "";
    //Insertamos el fragment en la lista
    $body_table_pedidos.append($fragment);
  } else {
    $body_table_pedidos.innerHTML = "";
  }
};

const mostrar_datos_tabla_pedidos_d_r_e = async (data) => {
  console.log(data);
  //Enlazamos el template creado en el HTML
  const $template_body_table_pedidos_d_r_e = d.querySelector(
    "#template_body_table_pedidos_d_r_e"
  ).content;

  if (data.length > 0) {
    data.forEach((element, i) => {
      //Insertamos los datos en el template
      $template_body_table_pedidos_d_r_e.querySelector(
        ".part"
      ).textContent = `${i + 1}`;

      $template_body_table_pedidos_d_r_e.querySelector(
        ".despachador"
      ).textContent = `${element.nombre_despachador} ${element.apellido_despachador}`;

      const nombre_rechequeador =
        element.nombre_rechequeador !== null
          ? `${element.nombre_rechequeador} ${element.apellido_rechequeador}`
          : "";
      $template_body_table_pedidos_d_r_e.querySelector(
        ".rechequeador"
      ).textContent = nombre_rechequeador;

      const nombre_embalador =
        element.nombre_embalador !== null
          ? `${element.nombre_embalador} ${element.apellido_embalador}`
          : "";
      $template_body_table_pedidos_d_r_e.querySelector(
        ".embalador"
      ).textContent = nombre_embalador;

      //   $
      $template_body_table_pedidos_d_r_e.querySelector(
        ".fecha_rechequeado"
      ).textContent = element.fecha_rechequeado;
      $template_body_table_pedidos_d_r_e.querySelector(
        ".fallas"
      ).textContent = `${
        element.cantidad_fallas != null ? element.cantidad_fallas : "0"
      }`;
      //guardamos una copia de la $template_body_table_pedidosestrutura actual del template en la variable $node
      let $clone = $template_body_table_pedidos_d_r_e.cloneNode(true);
      //Guardamos el nodo en el fragment
      $fragment.append($clone);
    });

    // //Limpiamos la lista
    $body_table_pedidos_d_r_e.innerHTML = "";
    //Insertamos el fragment en la lista
    $body_table_pedidos_d_r_e.append($fragment);
  } else {
    $body_table_pedidos_d_r_e.innerHTML = "";
  }
};

const extraer_datos_pedido = async (form_data) => {
  try {
    const data_pedido = await app(
      "http://localhost/vitalclinic/controllers/almacen/pedidos/pedidos.php?consultar_pedido=1",
      "POST",
      form_data
    );
    

    if (data_pedido.data.length > 0) {
      mostrar_datos_tabla_pedidos([data_pedido.data[0].tabla_pedidos]);
      mostrar_datos_tabla_pedidos_d_r_e(
        data_pedido.data[0].tabla_pedidos_d_r_e
      );
    } else {
      alert("El número de pedido no se encuentra registrado");
    }
  } catch (error) {
    console.log(error);
  }
};

const extraer_datos_confirmar = async (form_data) => {
  try {
    console.log(form_data.get("numero_pedido"));
    
    const result = await app(
      "http://localhost/vitalclinic/controllers/almacen/pedidos/pedidos.php?consult_confirm_pedido=1",
      "POST",
      form_data
    );
    console.log(form_data);
    
    if (result.ok) {
      const result  = await result.json()
      console.log(result);
    } else {
      alert("Pedido no encontrado");
    }
  } catch (error) {
    console.log(error
      
    );
    
  }
};

buscar_button.addEventListener("click", async (e) => {
  e.preventDefault();

 
  const numero_pedido = d.querySelector("#cod_pedido").value;
console.log(numero_pedido);

  if (numero_pedido === "") {
    alert("Ingrese el número del pedido");
    return;
  }
  const form_data = new FormData()
  form_data.append("numero_pedido" , numero_pedido);
 
  

  await extraer_datos_confirmar(form_data);
});

confirm_button_table.addEventListener("click", (e) => {
  try {
    console.log(e.target);

    if (e.target.matches("button.confirm_b")) {

      const id_pedido = pedido_id_table.querySelector(".n_pedido").textContent;
      
      confirmar_pedido(id_pedido);
    }
  } catch (error) {
    throw new Error("Confirm Problems: ", error.message);
  }
});
