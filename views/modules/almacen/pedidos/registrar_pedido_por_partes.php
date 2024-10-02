<?php 
    include "./controllers/control_privilegios.php";
    $privilegio = "registrar_pedido";
    $control_privilegios = new ControlPrivilegios();
    $acceso = $control_privilegios->verificar_privilegios($privilegio);

?> 

<div class="w-full h-screen">
    <?php
        include 'views/modules/header.php';
    ?>
    <div class="w-full mt-4">
        <div class="bg-blue-500 border-2 border-white rounded-md mb-4 w-fit px-4 mx-auto">
            <h1 class="text-2xl font-bold text-white text-center">REGISTRAR PEDIDO</h1>
        </div>

        <div class="w-full flex gap-x-4 justify-center h-fit">
            
            <div class="w-72 flex flex-col gap-y-6">
                <form class="flex flex-col items-center py-4 h-fit border-2 border-gray-200 rounded-md bg-blue-500">
                    <label for="partes" class="w-full relative px-6">
                        <p class="text-white">Ingrese el número de partes:</p>
                        <input 
                            type="number" 
                            name="partes" 
                            id="partes"
                            min=1
                            class="w-full border-2 border-gray-300 rounded-md p-2 pt-2 my-1 font-extralight text-black-500 font-medium text-base focus:outline-none"
                        >
                    </label>
                </form>

                <form class="flex flex-col items-center py-4 h-fit border-2 border-gray-200 rounded-md bg-blue-500">
                    <label for="cod_pedido" class="w-full relative px-6">
                        <p class="text-white">Número de pedido:</p>
                        <input 
                            type="text" 
                            name="cod_pedido" 
                            id="cod_pedido"
                            class="w-full border-2 border-gray-300 rounded-md p-2 pt-2 my-1 font-extralight text-black-500 font-medium text-base focus:outline-none"
                        >
                    </label>
                    <label for="ruta" class="w-full relative px-6">
                        <p class="text-white">Ruta:</p>
                        <select name="ruta" id="ruta" class="w-full border-2 border-gray-300 rounded-md p-2 pt-2 my-1 font-extralight text-black-500 font-medium text-base focus:outline-none"></select>
                    </label>
                    <label for="name" class="w-full relative px-6">
                        <p class="text-white">Cantidad de unidades:</p>
                        <input 
                            type="number" 
                            name="cant_unidades" 
                            id="cant_unidades"
                            min=1
                            class="w-full border-2 border-gray-300 rounded-md p-2 pt-2 my-1 font-extralight text-black-500 font-medium text-base focus:outline-none"
                        >
                    </label>
                </form>

                <form class="flex flex-col items-center py-4 h-fit border-2 border-gray-200 rounded-md bg-blue-500">
                    <label for="lastname" class="w-full relative px-6">
                        <p class="text-white">Empleado</p>
                        <select name="empleado" id="empleado" class="w-full border-2 border-gray-300 rounded-md p-2 px-4 pt-2 my-1 font-extralight text-black-500 font-medium text-base focus:outline-none"></select>
                    </label>
                </form>

                <button 
                    id="registrar_pedido" 
                    type="button"
                    class="registrar_pedido w-full border-2 border-gray-300 rounded-md px-6 py-2 mt-3 mb-2 font-extralight text-white text-sm font-medium focus:outline-none cursor-pointer bg-blue-600 hover:border-purple-500"
                >
                    Registrar
                </button>
            </div>

            <div class="w-[calc(80%-288px)] bg-gray-100 h-fit">
                <table class="w-full table-auto border-separate border border-slate-400">
                    <thead>
                        <tr>
                            <th class="border-2 border-black-500 text-white bg-gray-400">N° Parte</th>
                            <th class="border-2 border-black-500 text-white bg-gray-400">Despachador</th>
                            <th class="border-2 border-black-500 text-white bg-gray-400">Acción</th>
                        </tr>
                    </thead>
                    <tbody id="body_table"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<template id="template_body_table_pedidos">
    <tr class="tr hover:bg-gray-200">
        <td class="part border-2 border-black-500 text-black text-center"></td>
        <td class="despachador border-2 border-black-500 text-black text-center"></td>
        <td class="action border-2 border-black-500 text-black text-center"><button class="delete border-2 border-red-400 px-2 rounded-md bg-red-500 text-white hover:bg-red-600">Eliminar</button></td>
    </tr>
</template>


<script src="./views/assets/js/api.js"></script>
<script src="./views/assets/js/almacen/pedidos/registrar_pedido_por_partes.js" type="module"></script>