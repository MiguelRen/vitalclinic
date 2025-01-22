import app from "../../api.js";
const d = document,
  $fragment = d.createDocumentFragment(),
  $body_table_partes = d.querySelector("#body_table_partes");

const buscar_button = d.getElementById("buscar_b");

const mostrar_datos_tabla_partes = async (data) => {
  //Enlazamos el template creado en el HTML
  const $template_body_table_partes = d.querySelector(
    "#template_body_table_partes"
  ).content;

  if (data[0].length > 0) {
    data[0].forEach((element, i) => {
      //Insertamos los datos en el template
      $template_body_table_partes.querySelector(".num_pedido").textContent =
        element.numero_pedido;
      $template_body_table_partes.querySelector(".id_despachador").textContent =
        element.id_despachador;

      $template_body_table_partes.querySelector(".num_parte").textContent = `${
        i + 1
      }`;

      $template_body_table_partes.querySelector(".nombre").textContent =
        element.nombre;
      $template_body_table_partes.querySelector(".apellido").textContent =
        element.apellido;
      $template_body_table_partes.querySelector(
        ".fecha_entregado"
      ).textContent = element.fecha;
      $template_body_table_partes.querySelector(
        ".fecha_terminado"
      ).textContent = element.fecha_confirmado;

      $template_body_table_partes.querySelector(".confirm_b").dataset.id =
        element.id_parte;

      if (element.fecha_confirmado != null && element.fecha_confirmado != "") {
        $template_body_table_partes.querySelector(".confirm_b").disabled = true;
        $template_body_table_partes.querySelector(
          ".confirm_b"
        ).style.opacity = 0.5;
        $template_body_table_partes.querySelector(".confirm_b").innerText =
          "Listo";
      } else {
        $template_body_table_partes.querySelector(
          ".confirm_b"
        ).disabled = false;
        $template_body_table_partes.querySelector(
          ".confirm_b"
        ).style.opacity = 1;
        $template_body_table_partes.querySelector(".confirm_b").innerText =
          "Confirmar";
      }

      //guardamos una copia de la estrutura actual del template en la variable $node
      let $clone = $template_body_table_partes.cloneNode(true);

      //Guardamos el nodo en el fragment
      $fragment.append($clone);
    });

    // //Limpiamos la lista
    $body_table_partes.innerHTML = "";
    //Insertamos el fragment en la lista
    $body_table_partes.append($fragment);
  } else {
    $body_table_partes.innerHTML = "";
  }
};

const extraer_datos_confirmar = async (form_data) => {
  try {
    const response = await app(
      "http://localhost/vitalclinic/controllers/almacen/pedidos/pedidos.php?consult_confirm_pedido=1",
      "POST",
      form_data
    );

    if (response.data.length > 0) {
      mostrar_datos_tabla_partes([response.data[0]]);
    } else {
      alert("El número de pedido no se encuentra registrado");
    }

    return response.data;
  } catch (error) {
    console.log(error);
  }
};

const confirmar_pedido = async (form_data) => {
  try {
    const response = await app(
      "http://localhost/vitalclinic/controllers/almacen/pedidos/pedidos.php?confirmar_pedido=1",
      "POST",
      form_data
    );

    if (response.data[0].data == true) {
      const numero_pedido = d.querySelector("#cod_pedido").value;
      const pedido = new FormData();
      pedido.append("numero_pedido", numero_pedido);
      await extraer_datos_confirmar(pedido);

      return alert("Pedido Confirmado");
    } else {
      alert(response.error);
    }
  } catch (error) {
    console.log(error);
  }
};

buscar_button.addEventListener("click", async (e) => {
  e.preventDefault();

  const numero_pedido = d.querySelector("#cod_pedido").value;

  if (numero_pedido === "") {
    alert("Ingrese el número del pedido");
    return;
  }
  const form_data = new FormData();
  form_data.append("numero_pedido", numero_pedido);
  await extraer_datos_confirmar(form_data);
});

// confirm_button_table.addEventListener("click", (e) => {
//   try {
//     console.log(e.target);

//     if (e.target.matches("button.confirm_b")) {
//       const id_pedido = pedido_id_table.querySelector(".num_pedido").textContent;
//       const id_despachador =
//       confirmar_pedido(id_pedido ,id_);
//     }
//   } catch (error) {
//     throw new Error("Confirm Problems: ", error.message);
//   }
// });

d.addEventListener("click", async (e) => {
  if (e.target.classList.contains("confirm_b")) {
    const id_parte = e.target.dataset.id;

    const form_data = new FormData();
    form_data.append("id_parte", id_parte);

    await confirmar_pedido(form_data);
  }
});

// $body_table_partes.addEventListener("click",(e) =>{
//   try {
//     if(e.target.matches(".confirm_b")){
//       const id_pedido = e.target.parentElement.parentElement.querySelector(".num_pedido").textContent;
//       const id_despachador = e.target.parentElement.parentElement.querySelector(".id_despachador").textContent;
//       confirmar_pedido(id_pedido,id_despachador);

//     }
//   }catch(error) {
//     console.log("Problemas en el evento  de confirmar pedido" , error.message);

//   }

// });
