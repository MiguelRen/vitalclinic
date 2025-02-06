<?php 
    include "./controllers/control_privilegios.php";
    $privilegio = "consultar_pedido";
    $control_privilegios = new ControlPrivilegios();
    $acceso = $control_privilegios->verificar_privilegios($privilegio);
?> 

<div class="w-full h-screen">
    <?php
        include 'views/modules/header.php';
    ?>
    
    <div class="w-full mt-4 flex flex-col gap-y-4">
        <div class="bg-blue-500 border-2 border-white rounded-md mb-4 w-fit px-4 mx-auto">
            <h1 class="text-2xl font-bold text-white text-center">CONSULTAR PEDIDO</h1>
        </div>

        <form class="flex items-center w-[420px] border-2 border-gray-200 rounded-md bg-blue-500 py-2 mx-auto">
            <label for="cedula" class="w-full relative px-6">
                <!-- <p class="text-white text-sm">Consultar Número de Pedido:</p> -->
                <input 
                    type="number" 
                    name="cod_pedido" 
                    id="cod_pedido"
                    placeholder="Ingrese el Número de Pedido:"
                    class="w-full border-2 border-gray-300 rounded-md my-1 font-extralight text-black-500 font-medium text-base focus:outline-none"
                >
            </label>
            <label for="" class="w-fit pr-4">
                <input 
                    type="submit" 
                    value="Consultar" 
                    class="w-fit border-2 border-gray-300 rounded-md px-4 font-extralight text-white text-base font-medium focus:outline-none cursor-pointer bg-blue-600 hover:border-purple-500"
                >
            </label>
        </form>

        <div class="md:w-[90%] lg-[w-80%] xl:w-[60%] bg-gray-100 h-fit mx-auto">
            <table class="w-full table-auto border-separate border border-slate-400">
                <thead>
                    <tr>
                        <th class="border-2 border-black-500 text-white bg-gray-400">N° Pedido</th>
                        <th class="border-2 border-black-500 text-white bg-gray-400">Ruta</th>
                        <th class="border-2 border-black-500 text-white bg-gray-400">C. Unidades</th>
                        <th class="border-2 border-black-500 text-white bg-gray-400">Fecha de entrega</th>
                        <th class="border-2 border-black-500 text-white bg-gray-400">Entregado por</th>
                    </tr>
                </thead>
                <tbody id="body_table_pedidos"></tbody>
            </table>
        </div>

        <div class="md:w-[90%]  xl:w-[60%] bg-gray-100 h-fit mx-auto">
            <table class="w-full table-auto border-separate border border-slate-400">
                <thead>
                    <tr>
                        <th class="border-2 border-black-500 text-white bg-gray-400">N° Parte</th>
                        <th class="border-2 border-black-500 text-white bg-gray-400">Despachador</th>
                        <th class="border-2 border-black-500 text-white bg-gray-400">Rechequeador</th>
                        <th class="border-2 border-black-500 text-white bg-gray-400">Embalador</th>
                        <th class="border-2 border-black-500 text-white bg-gray-400">Fecha Rechequeado</th>
                        <th class="border-2 border-black-500 text-white bg-gray-400">C. de Fallas</th>
                    </tr>
                </thead>
                <tbody id="body_table_pedidos_d_r_e"></tbody>
            </table>
        </div>
    </div>
</div>

<template id="template_body_table_pedidos">
    <tr class="tr hover:bg-gray-200">
        <td class="n_pedido border-2 border-black-500 text-black text-center"></td>
        <td class="ruta border-2 border-black-500 text-black text-center"></td>
        <td class="c_unidades border-2 border-black-500 text-black text-center"></td>
        <td class="fecha_entrega border-2 border-black-500 text-black text-center"></td>
        <td class="entregador_por border-2 border-black-500 text-black text-center"></td>
    </tr>
</template>

<template id="template_body_table_pedidos_d_r_e">
    <tr class="tr hover:bg-gray-200">
        <td class="part border-2 border-black-500 text-black text-center"></td>
        <td class="despachador border-2 border-black-500 text-black text-center"></td>
        <td class="rechequeador border-2 border-black-500 text-black text-center"></td>
        <td class="embalador border-2 border-black-500 text-black text-center"></td>
        <td class="fecha_rechequeado border-2 border-black-500 text-black text-center"></td>
        <td class="fallas border-2 border-black-500 text-black text-center"></td>
    </tr>
</template>



<script src="http://192.168.0.164/vitalclinic/views/assets/js/api.js"></script>
<script src="http://192.168.0.164/vitalclinic/views/assets/js/almacen/pedidos/consultar_pedido.js" type="module"></script>
