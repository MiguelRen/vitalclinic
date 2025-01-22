<?php 
    include "./controllers/control_privilegios.php";
    $privilegio = "rechequear";
    $control_privilegios = new ControlPrivilegios();
    $acceso = $control_privilegios->verificar_privilegios($privilegio);

?> 

<div class="w-full h-screen">
    <?php
        include 'views/modules/header.php';
    ?>


    <div class="w-full flex justify-center mt-8 gap-x-4">
        <div class="w-96 flex flex-col gap-y-2">
            <div class="bg-blue-500 border-2 border-white py-2 rounded-md w-full">
                <h1 class="text-2xl font-bold text-white text-center">RECHEQUEAR PEDIDO</h1>
            </div>

            <div class="w-full h-fit flex flex-col gap-y-4">
                <form class="flex flex-col items-center py-4 h-fit border-2 border-gray-200 rounded-md bg-blue-500 registrar_pedido">
                    <label for="cod_pedido" class="w-full relative px-6">
                        <p class="text-white">Número de pedido:</p>
                        <input 
                            type="text" 
                            name="cod_pedido" 
                            id="cod_pedido"
                            class="w-full border-2 border-gray-300 rounded-md p-2 pt-2 my-1 font-extralight text-black-500 font-medium text-base focus:outline-none"
                        >
                    </label>

                    <label class="w-full relative px-6">
                        <button 
                            id="embalador_asignado" 
                            type="button" 
                            class="w-full border-2 border-gray-300 rounded-md px-6 py-2 mt-3 mb-2 font-extralight text-white text-sm font-medium focus:outline-none cursor-pointer bg-blue-600 hover:border-purple-500"
                        >
                            Seleccionar Embalador Asignado
                        </button>
                    </label>

                    <label for="empleado" class="w-full relative px-6">
                        <p class="text-white">Otro embalador:</p>
                        <select 
                            name="empleado" 
                            id="empleado"
                            autocomplete="on" 
                            class="w-full border-2 border-gray-300 rounded-md p-2 pt-2 my-1 font-extralight text-black-500 font-medium text-base focus:outline-none"></select>
                    </label>

                    <label for="cedula" class="w-full relative px-6">
                        <p class="text-white">Embalador Seleccionado</p>
                        <input 
                            type="text" 
                            name="embalador_seleccionado" 
                            id="embalador_seleccionado"
                            class="w-full border-2 border-gray-300 rounded-md p-2 pt-2 my-1 font-extralight text-black-500 font-medium text-base focus:outline-none"
                            disabled
                        >
                    </label>
                    <label for="" class="w-full relative px-6">
                        <input 
                            type="submit" 
                            value="Guardar" 
                            class="w-full border-2 border-gray-300 rounded-md px-6 py-2 mt-3 mb-2 font-extralight text-white text-base font-medium focus:outline-none cursor-pointer bg-blue-600 hover:border-purple-500"
                        >
                    </label>
                </form>
            </div>
        </div>

        <div id="container_parts" class="md:w-[calc(80%-384px)] lg:w-[calc(70%-384px)]  xl:w-[calc(50%-384px)] h-fit rounded-md flex flex-col gap-y-4 hidden">
            <div class="border-2 border-white bg-blue-500 rounded-md">
                <div class="my-2">
                    <h2 class="text-center text-white font-medium">Seleccionar Partes del pedido a rechequear</h2>
                </div>
                <form action="" class="flex flex-col gap-y-2 px-2 mb-2 registrar_partes_pedido">
                    <div id="form_parts"></div>
                    <input type="submit" value="registrar" class="border-2 border-gray-200 bg-blue-500 text-white rounded-md  hover:cursor-pointer hover:border-purple-500 ">
                </form>
            </div>
        </div>
    </div>
	<div id="loader" class="w-full h-screen bg-transparent fixed top-0 hidden">
         <div class="w-full h-screen flex flex-col justify-center items-center border-2 border-blue-500">
                <span class="loader"></span>
         </div>        
     </div>
</div>

<template id="template-item_form">
    <label for="" class="w-full border-2 border-gray-200 rounded-md flex items-center gap-x-4 py-2 px-2 my-2 text-white">
        <div class="flex gap-x-2"><p class="part"></p><p class="name"></p></div>
        <input type="checkbox" name="part" class="check">
    </label>
</template>

<script type="module" src="http://localhost/vitalclinic/views/assets/js/api.js"></script>
<script type="module" src="http://localhost/vitalclinic/views/assets/js/almacen/rechequeo/rechequear.js" ></script>
