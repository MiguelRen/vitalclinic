<?php 
    include "./controllers/control_privilegios.php";
    $privilegio = "eliminar_fallas_pedido";
    $control_privilegios = new ControlPrivilegios();
    $acceso = $control_privilegios->verificar_privilegios($privilegio);

?> 

<div class="w-full h-screen">
    <?php
        include 'views/modules/header.php';
    ?>

    <div class="w-full flex flex-col items-center justify-center mt-4 gap-y-4">

        <div class="w-96 flex flex-col justify-center items-center gap-y-4">

            <div class="bg-blue-500 border-2 border-white py-2 rounded-md w-full">
                <h1 class="text-2xl font-bold text-white text-center">Eliminar FALLAS</h1>
            </div>

            <form class="flex items-center w-[420px] border-2 border-gray-200 rounded-md bg-blue-500 py-2 mx-auto buscar">
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
        </div>

        <div class="w-[80%] bg-gray-100 h-fit mx-auto">
                <table class="w-full table-auto border-separate border border-slate-400">
                    <thead>
                        <tr>
                            <th class="border-2 border-black-500 text-white bg-gray-400">N° Pedido</th>
                            <th class="border-2 border-black-500 text-white bg-gray-400">N° Parte</th>
                            <th class="border-2 border-black-500 text-white bg-gray-400">Despachador</th>
                            <th class="border-2 border-black-500 text-white bg-gray-400">Motivo</th>
                            <th class="border-2 border-black-500 text-white bg-gray-400">Descripcion</th>
                            <th class="border-2 border-black-500 text-white bg-gray-400">Fecha</th>
                            <th class="border-2 border-black-500 text-white bg-gray-400">Acción</th>
                        </tr>
                    </thead>
                    <tbody id="body_table_pedidos"></tbody>
                </table>
            </div>
    </div>
</div>

<template id="template_body_table_fallas">
    <tr class="tr hover:bg-gray-200">
        <td class="n_pedido border-2 border-black-500 text-black text-center"></td>
        <td class="n_parte border-2 border-black-500 text-black text-center"></td>
        <td class="despachador border-2 border-black-500 text-black text-center"></td>
        <td class="motivo border-2 border-black-500 text-black text-center"></td>
        <td class="descripcion border-2 border-black-500 text-black text-center"></td>
        <td class="fecha border-2 border-black-500 text-black text-center"></td>
        <td class="action border-2 border-black-500 text-black text-center"><button class="delete border-2 border-red-400 px-2 rounded-md bg-red-500 text-white hover:bg-red-600">Eliminar</button></td>
    </tr>
</template>

<script src="http://192.168.0.164/vitalclinic/views/assets/js/api.js"></script>
<script src="http://192.168.0.164/vitalclinic/views/assets/js/almacen/fallas/eliminar_fallas_despachador.js" type="module"></script>
