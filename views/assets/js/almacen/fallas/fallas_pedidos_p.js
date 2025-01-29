import app from "../../api.js";
import utilidades from "../../utilidades.js";
const { asignar_valores_select } = utilidades();

const d = document,
  $fragment = d.createDocumentFragment(),
  $body_table_partes = d.querySelector("#body_table_partes");
const $motivo = d.querySelector("#motivo");

const modal = d.querySelector("#modal");

const buscar_button = d.getElementById("buscar_b");

// const mostrar_datos_tabla_partes = async (data) => {
//   //tratamos los datos acá

//   const fila_pedidos = data[0];

//   //Enlazamos el template creado en el HTML
//   const $template_body_table_partes = d.querySelector(
//     "#template_body_table_partes"
//   ).content;

//   if (Object.keys(data[0]).length) {
//     Object.keys(fila_pedidos).forEach((key) => {
//       const elemento = fila_pedidos[key];

      

//       $template_body_table_partes.querySelector(".num_parte").textContent = `${
//         key + 1
//       }`;

//       $template_body_table_partes.querySelector(".nombre").textContent =
//         elemento.nombre;

//       $template_body_table_partes.querySelector(".apellido").textContent =
//         elemento.apellido;

//       $template_body_table_partes.querySelector(
//         ".fecha_confirmado"
//       ).textContent = elemento.fecha_confirmado;

//       $template_body_table_partes.querySelector(
//         ".fecha_rechequeado"
//       ).textContent = elemento.fecha_rechequeado;

//       const falla_combo = elemento.fallas;

//       let aux = 0;
//       Object.keys(falla_combo).forEach((e) => {
//         aux = aux + 1;
//       });

//       $template_body_table_partes.querySelector(
//         ".cantidad_fallas"
//       ).textContent = aux;
      
      
//       if (elemento.fecha_confirmado === null) {
//         $template_body_table_partes.querySelector(
//           ".agregar_falla_b"
//         ).textContent = "No Confirmado";
//         $template_body_table_partes.querySelector(
//           ".agregar_falla_b"
//         ).disabled = true;
//         $template_body_table_partes.querySelector(
//           ".agregar_falla_b"
//         ).style.opacity = 0.5;
//       } 
//       if (elemento.fecha_rechequeado === null) {
//          console.log(`${elemento.fecha_confirmado}  ${elemento.fecha_rechequeado}`);
//         $template_body_table_partes.querySelector(
//           ".agregar_falla_b"
//         ).textContent = "No Rechequeado";
//         $template_body_table_partes.querySelector(
//           ".agregar_falla_b"
//         ).disabled = true;
//         $template_body_table_partes.querySelector(
//           ".agregar_falla_b"
//         ).style.opacity = 0.5;
//       }

//       $template_body_table_partes.querySelector(".agregar_falla_b").dataset.id =
//         elemento.id;

//       //guardamos una copia de la estrutura actual del template en la variable $node
//       let $clone = $template_body_table_partes.cloneNode(true);

//       //Guardamos el nodo en el fragment
//       $fragment.append($clone);
//     });

    
//     // //Limpiamos la lista
//     $body_table_partes.innerHTML = "";
//     //Insertamos el fragment en la lista
//     $body_table_partes.append($fragment);
//   } else {
//     $body_table_partes.innerHTML = "";
//   }
// };


const mostrar_datos_tabla_partes = async (data) => {
  // Tratamos los datos acá
  const fila_pedidos = data[0];

  // Enlazamos el template creado en el HTML
  const $template_body_table_partes = d.querySelector(
    "#template_body_table_partes"
  ).content;

  // Limpiamos la lista antes de agregar nuevos datos
  $body_table_partes.innerHTML = "";
  if (Object.keys(data[0]).length) {
    
    
    Object.keys(fila_pedidos).forEach((key , i) => {
      const elemento = fila_pedidos[key];
      
      // Clonamos el template antes de modificarlo
      const $clonado = document.importNode($template_body_table_partes, true);
      
      $clonado.querySelector(".num_parte").textContent = `${i +1}`;
      const despachador = elemento.nombre_despachador ? `${elemento.nombre_despachador} ${elemento.apellido_despachador}`: "" 
      $clonado.querySelector(".despachador").textContent = despachador;
      const rechequeador = elemento.nombre_rechequeador ? `${elemento.nombre_rechequeador} ${elemento.apellido_rechequeador}`: "" 
      $clonado.querySelector(".rechequeador").textContent = rechequeador;
      $clonado.querySelector(".fecha_confirmado").textContent = elemento.fecha_confirmado;
      $clonado.querySelector(".fecha_rechequeado").textContent = elemento.fecha_rechequeado;
      
      const falla_combo = elemento.fallas;
      const cantidadFallas = falla_combo.length; // Contar directamente la longitud del array
      
      $clonado.querySelector(".cantidad_fallas").textContent = cantidadFallas;
      
      // Lógica para habilitar/deshabilitar el botón
      const botonAgregarFalla = $clonado.querySelector(".agregar_falla_b");
      botonAgregarFalla.disabled = false; // Inicialmente habilitado
      
      if (elemento.fecha_rechequeado === null) {
        
        botonAgregarFalla.textContent = "No Rechequeado";
        botonAgregarFalla.disabled = true;
        botonAgregarFalla.style.opacity = 0.5;
      }
      if (elemento.fecha_confirmado === null) {
        botonAgregarFalla.textContent = "No Confirmado";
        botonAgregarFalla.disabled = true;
        botonAgregarFalla.style.opacity = 0.5;
      } 
      
      // Asignar el ID al dataset del botón
      botonAgregarFalla.dataset.id = elemento.id;
      
      // Guardamos el nodo clonado en el fragment
      $fragment.append($clonado);
          });
    
    // Insertamos el fragment en la lista
    $body_table_partes.append($fragment);
  }
};

const extraer_datos_fallas = async (form_data) => {
  try {
    const response = await app(
      "http://localhost/vitalclinic/controllers/almacen/fallas/fallas_pedidos.php?extraer_fallas_despachador_p=1",
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

const mostrar_motivos = (data_motivos) => {
  asignar_valores_select({
    data: data_motivos,
    titulo: "Seleccionar Motivo",
    input: $motivo,
    nombre_opciones: {
      id: "id",
      nombre: "descripcion",
    },
  });
};

const extraer_data_motivo_fallas = async () => {
  try {
    const data_motivo_fallas = await app(
      "http://localhost/vitalclinic/controllers/almacen/fallas/fallas_pedidos.php?extraer_motivos=1"
    );

    mostrar_motivos(data_motivo_fallas);
  } catch (error) {
    console.log(error);
  }
};

const confirmar_falla_p = async (form_data) => {
  try {
    const response = await app(
      "http://localhost/vitalclinic/controllers/almacen/fallas/fallas_pedidos.php?confirmar_falla_p=1",
      "POST",
      form_data
    );

    if (response.data[0] == true) {
      const numero_pedido = localStorage.getItem("numero_pedido");
      
      alert("Falla Confirmada");

      // d.querySelector("#motivo").textContent = "";
      // d.querySelector("#descripcion").textContent = "";
      
      modal.style.display = "none";
      const form_data = new FormData();
      form_data.append("numero_pedido", numero_pedido);
      await extraer_datos_fallas(form_data);

      

      return;
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
  //guardamos pedido para luego usar en la recarga despues de  guardar
  localStorage.setItem("numero_pedido",numero_pedido);

  if (numero_pedido === "") {
    alert("Ingrese el número del pedido");
    return;
  }
  const form_data = new FormData();
  form_data.append("numero_pedido", numero_pedido);
  await extraer_datos_fallas(form_data);
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

d.addEventListener("DOMContentLoaded", async (e) => {
  try {
    await extraer_data_motivo_fallas();
  } catch (error) {
    console.log(error);
  }
});

d.addEventListener("click", async (e) => {
  if (e.target.classList.contains("agregar_falla_b")) {
    // const id_parte = e.target.dataset.id;

    localStorage.setItem("id_pedido_d_r_e", e.target.dataset.id);

    modal.style.display = "block";

    d.querySelector(".confirmar_falla").dataset.id = localStorage.getItem("id");
  }
});

d.addEventListener("click", (e) => {
  try {
    if (e.target.matches("#close-modal-button")) {
      modal.style.display = "none";
    }
  } catch (error) {
    console.log(error);
  }
});

d.addEventListener("click", async (e) => {
  try {
    if (e.target.matches(".confirmar_falla")) {
      const id_pedido_d_r_e = localStorage.getItem("id_pedido_d_r_e");
      const motivo = d.querySelector("#motivo").value;
      const descripcion = d.querySelector("#descripcion").value;

      if (motivo == "") {
        alert('Por favor, rellene el campo "Motivo"');
        return;
      } else if (descripcion == "") {
        alert('Por favor, rellene el campo "Descripción"');
        return;
      } else {
        const form_data = new FormData();

        form_data.append("id_pedido_d_r_e", id_pedido_d_r_e);
        form_data.append("motivo", motivo);
        form_data.append("descripcion", descripcion);

        await confirmar_falla_p(form_data);
      }
    }
  } catch (error) {
    console.log("Problemas en el evento  de confirmar pedido p", error.message);
  }
});
