import app from '../api.js';
import utilidades from "../utilidades.js";
const d = document,
$account = d.querySelector("#account"),
$role = d.querySelector("#role");

let data_accounts = [];

const { asignar_valores_select } = utilidades();

const mostrar_accounts = (data_accounts) => {
    //Mostramos los datos de los empleados

    const format_data = data_accounts.map( e => {
       const data = {
        id: e.id_account,     
        nombre: `${e.username}`
       }

       return {...data}
    })

    asignar_valores_select(
        { 
            data: format_data,
            titulo: "Seleccionar Cuenta",
            input: $account,
            nombre_opciones : {
                id : "id",
                nombre: "nombre"  
            }
        }
    );
};

const mostrar_roles = (data_roles) => {

    asignar_valores_select(
        { 
            data: data_roles,
            titulo: "Seleccionar Rol",
            input: $role,
            nombre_opciones : {
                id : "id",
                nombre: "role"  
            }
        }
    );
}

const extraer_data_accounts = async () => {
    try {
        data_accounts = await app('http://192.168.0.164/vitalclinic/controllers/users/empleados.php?extraer_accounts=1');
        mostrar_accounts(data_accounts)
    } catch (error) {
        console.log(error)
    }
};

const extraer_roles = async() => {
    try {
        const data_roles = await app('http://192.168.0.164/vitalclinic/controllers/users/empleados.php?extraer_roles=1');
        mostrar_roles(data_roles);
    } catch (error) {
        console.log(error)
    }
}

const limpiarformmulario = () => {
    d.querySelector('#username').value = "";
    d.querySelector('#password').value = "";
    d.querySelector('#id').value = "";
    d.querySelector('#role').selectedIndex = 0;
    d.querySelector('#status').selectedIndex = 0;
}

const modifica_account = async(form_data) => {
    try {
        const res = await app('http://192.168.0.164/vitalclinic/controllers/users/empleados.php?modificar_account=1','POST', form_data);
          if(res.data.length > 0){
              alert('Modificación exitosa');
              limpiarformmulario();
              extraer_data_accounts();
          }else{
              alert(`${res.error}`)
          }
  
      } catch (error) {
        console.log(error)
      }
}

$account.addEventListener('change', e => {
    if($account.value !== ""){
        const id_account = $account.value;
        const data_account = data_accounts.filter(i => i.id_account === id_account);

        d.querySelector('#username').value = data_account[0].username;
        d.querySelector('#password').value = data_account[0].password;
        d.querySelector('#id').value = data_account[0].id_account;
        //Posicionamos cada uno de los select en el valor correspondiente con respecto a los despachadores del pedido
       
        for (let i = 0; i < $role.options.length; i++) {
            if ($role.options[i].value == data_account[0].role_id) {
                $role.selectedIndex = i;
                break;
            }
        } 
       
        d.querySelector('#status').selectedIndex = data_account[0].status;
    }else{
        limpiarformmulario();
    }

});

d.addEventListener('DOMContentLoaded', async e=> {
    await extraer_data_accounts();
    await extraer_roles();
});

d.addEventListener('submit', async e => {
    e.preventDefault();

    const username = d.querySelector('#username').value;
    const password = d.querySelector('#password').value;
    const id = d.querySelector('#id').value;
    const role = d.querySelector('#role').value;
    const status = d.querySelector('#status').value;

    if(id === ""){
        alert('De seleccionar un usuario');
        $account.focus();
        return;
    }

    if(username === ""){
        alert('Debe indicar el username');
        d.querySelector('#username').focus();
        return;
    }

    if(password === ""){
        alert('Debe indicar la contraseña');
        d.querySelector('#password').focus();
        return;
    }

    if(role === ""){
        alert('Debe indicar el role');
        d.querySelector('#role').focus();
        return;
    }

    if(status === ""){
        alert('Debe indicar el status');
        d.querySelector('#status').focus();
        return;
    }
   
    const formdata = new FormData();
    formdata.append('username', username);
    formdata.append('password', password);
    formdata.append('id', id);
    formdata.append('role', role);
    formdata.append('status', status);

    await modifica_account(formdata)
});
