import app from "../api.js";
import utilidades from "../utilidades.js";
 
const d = document,
$departamento = d.querySelector('#departamento'),
$loader = d.querySelector("#loader");
let is_loader = false;

const { asignar_valores_select } = utilidades();

const limpiar_formulario = () => {
  d.querySelector('#name').value = "";
  d.querySelector('#lastname').value = "";
  d.querySelector('#cedula').value = "";
  $departamento.selectedIndex = 0;
}

const mostrar_rutas = (data_departamento) => {
  //Mostramos los datos de las rutas
  asignar_valores_select(
      { 
          data: data_departamento,
          titulo: "Seleccionar Departamento",
          input: $departamento,
          nombre_opciones : {
              id : "id",
              nombre: "departamento"  
          }
      }
  );
};

const registrar_empleado = async(form_data) => {

  is_loader = true;
  if(is_loader) $loader.classList.remove("hidden");


  try {
    const res = await app('http://192.168.0.164/vitalclinic/controllers/users/empleados.php?registrar_empleado=1','POST', form_data);
    if(res.data.length > 0){
      is_loader = false;
      if(!is_loader) $loader.classList.add("hidden");
      alert('Registro exitoso');
      limpiar_formulario();
    }else{
      is_loader = false;
      if(!is_loader) $loader.classList.add("hidden");
      alert(res.error);
    }
  } catch (error) {
    is_loader = false;
    if(!is_loader) $loader.classList.add("hidden");
    console.log(error)
  }
}

const extraer_departamentos = async () => {

  is_loader = true;
  if(is_loader) $loader.classList.remove("hidden");

  try {
    const data_departamentos = await app('http://192.168.0.164/vitalclinic/controllers/users/empleados.php?extraer_departamentos=1');
    is_loader = false;
    if(!is_loader) $loader.classList.add("hidden");
    mostrar_rutas(data_departamentos)
  } catch (error) {
    console.log(error)
    is_loader = false;
    if(!is_loader) $loader.classList.add("hidden");
  }

};

d.addEventListener('submit', async e => {
  e.preventDefault();

  const name = e.target.name.value;
  const lastname = e.target.lastname.value;
  const cedula = e.target.cedula.value;
  const departamento = e.target.departamento.value;

  if(cedula === ''){
    alert('Debe ingresar la cedula');
    d.querySelector('#cedula').focus();
    return;
  }

  if(name === ''){
    alert('Debe ingresar el nombre');
    d.querySelector('#name').focus();
    return;
  }

  if(lastname === ''){
    alert('Debe ingresar el apellido');
    d.querySelector('#lastname').focus();
    return;
  }

  if(departamento === ''){
    alert('Debe ingresar el departamento');
    d.querySelector('#departamento').focus();
    return;
  }

  //Validar Datos
  const formData = new FormData();
  formData.append('name', name);
  formData.append('lastname',lastname);
  formData.append('cedula', cedula);
  formData.append('departamento', departamento);

  await registrar_empleado(formData);
});

d.addEventListener('DOMContentLoaded', async e => {
  await extraer_departamentos();
})
