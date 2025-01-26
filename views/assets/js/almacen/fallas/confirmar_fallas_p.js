import app from "../../api.js";
import utilidades from "../../utilidades.js";
const { asignar_valores_select } = utilidades();

const d = document,
  $fragment = d.createDocumentFragment(),
  $body_table_partes = d.querySelector("#body_table_partes");
const $motivo = d.querySelector("#motivo");

const modal = d.querySelector("#modal");

const buscar_button = d.getElementById("buscar_b");

const mostrar_datos_tabla_partes = async (data) => {
  //Enlazamos el template creado en el HTML
  const $template_body_table_partes = d.querySelector(
    "#template_body_table_partes"
  ).content;

  if (data[0].length > 0) {
    data[0].forEach((element, i) => {
      //Insertamos los datos en el template

      //   $template_body_table_partes.querySelector(".num_pedido").textContent =
      //     element.numero_pedido;
      //   $template_body_table_partes.querySelector(".id_despachador").textContent =
      //     element.id_despachador;

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

      $template_body_table_partes.querySelector(".agregar_falla_b").dataset.id =
        element.id_parte;

      if (element.fecha_confirmado != null && element.fecha_confirmado != "") {
        $template_body_table_partes.querySelector(
          ".agregar_falla_b"
        ).disabled = true;
        $template_body_table_partes.querySelector(
          ".agregar_falla_b"
        ).style.opacity = 0.5;
        $template_body_table_partes.querySelector(
          ".agregar_falla_b"
        ).innerText = "Listo";
      } else {
        $template_body_table_partes.querySelector(
          ".agregar_falla_b"
        ).disabled = false;
        $template_body_table_partes.querySelector(
          ".agregar_falla_b"
        ).style.opacity = 1;
        $template_body_table_partes.querySelector(
          ".agregar_falla_b"
        ).innerText = "Agregar";
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

const extraer_datos_fallas = async (form_data) => {
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


    
    if (response.data[0]== true) {
      
      alert("Pedido Confirmado");

      modal.style.display = "none";
      return 
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

d.addEventListener("click",(e)=>{
  try {
    if(e.target.matches("#close-modal-button")){
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

      if (motivo == "" ) {
        alert ('Por favor, rellene el campo "Motivo"');
        return ;
      }else if(descripcion == ""){
        alert ('Por favor, rellene el campo "Descripción"');
        return;
      }else{

        
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
