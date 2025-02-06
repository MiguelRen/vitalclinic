import app from '../../api.js';
import utilidades from '../../utilidades.js';

const d = document;
const regexCodProfit = /^\d{8}$/
const { prefixUrlBackend } = utilidades();

const saveArt = async (form_data) => {
    try {
        const res = await app(`${prefixUrlBackend}/vitalclinic/controllers/auth.php?auth=1`,'POST',form_data);
        
        
    } catch (error) {
        console.log(error)
    }
}


d.addEventListener('submit', e => {
    e.preventDefault();
    const cod_profit = e.target.cod_profit.value;
    const cod_barra = e.target.cod_profit.value;
    const des_art = e.target.cod_profit.value;

    if(cod_profit === ""){
        return;
    }

    if(!regexCodProfit.test(cod_profit)){
        return;
    }

    if(des_art === ""){
        return;
    }

    const formData = new FormData();
    formData.append('cod_profit', cod_profit);
    formData.append('cod_barra',cod_barra);
    formData.append('des_art', des_art);


});