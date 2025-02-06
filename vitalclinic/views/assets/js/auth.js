import app from './api.js';
const d = document;

const mostrar_error_login = (error) => {
    d.querySelector('#error-login').textContent = "";
    d.querySelector('#error-login').textContent = error;
    d.querySelector('#error-login').classList.remove('hidden');
} 

const login = async(form_data) => {
    try {
        const res = await app('http://192.168.0.164/vitalclinic/controllers/auth.php?auth=1','POST',form_data);
        if(res.data.length > 0){
           window.location = "inicio"
      }else{
        mostrar_error_login(`${res.error}`);
      }
        
    } catch (error) {
        console.log(error)
    }
}

d.addEventListener('submit', async e => {
    e.preventDefault();

    const username = e.target.username.value;
    const password = e.target.password.value;

    const formdata = new FormData();
    formdata.append('username', username);
    formdata.append('password', password);

    await login(formdata);
});
