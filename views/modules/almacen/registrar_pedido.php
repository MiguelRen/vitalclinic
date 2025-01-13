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

    <div class="w-full flex items-center justify-center mt-6">
        <div class="w-96 flex flex-col justify-center items-center gap-y-1">
            
            <div class="bg-blue-500 border-2 border-white py-2 rounded-md w-full mb-4">
                <h1 class="text-2xl font-bold text-white text-center">REGISTRAR PEDIDO</h1>
            </div>

            <!-- <div class="w-52 h-52 ">
                <img src="views/images/logo.png" alt="logo-vitalclinic">
            </div> -->
            
            <span 
              id="error-login"
              class="w-full bg-white border-2 border-red-400 py-3 px-4 mb-2 text-red-500 rounded-sm text-center hidden"
            >
            </span>
            
            <div class="w-full h-fit">
                <form class="flex flex-col items-center py-4 h-fit border-2 border-gray-200 rounded-md bg-blue-500">
                    <label for="cedula" class="w-full relative px-6">
                        <p class="text-white">Número de pedido:</p>
                        <input 
                            type="text" 
                            name="cod_pedido" 
                            id="cod_pedido"
                            class="w-full border-2 border-gray-300 rounded-md p-2 pt-2 my-1 font-extralight text-black-500 font-medium text-base focus:outline-none"
                        >
                    </label>

                    <label for="lastname" class="w-full relative px-6">
                        <p class="text-white">Empleado</p>
                        <select name="empleado" id="empleado" class="w-full border-2 border-gray-300 rounded-md p-2 pt-2 my-1 font-extralight text-black-500 font-medium text-base focus:outline-none"></select>
                    </label>

                    <label for="lastname" class="w-full relative px-6">
                        <p class="text-white">Ruta:</p>
                        <select name="ruta" id="ruta" class="w-full border-2 border-gray-300 rounded-md p-2 pt-2 my-1 font-extralight text-black-500 font-medium text-base focus:outline-none"></select>
                    </label>


                    <label for="name" class="w-full relative px-6">
                        <p class="text-white">Cantidad de unidades:</p>
                        <input 
                            type="number" 
                            name="cant_unidades" 
                            id="cant_unidades"
                            class="w-full border-2 border-gray-300 rounded-md p-2 pt-2 my-1 font-extralight text-black-500 font-medium text-base focus:outline-none"
                        >
                    </label>

                    

                    <label for="" class="w-full relative px-6">
                        <input 
                            type="submit" 
                            value="Registrar" 
                            class="w-full border-2 border-gray-300 rounded-md px-6 py-2 mt-3 mb-2 font-extralight text-white text-base font-medium focus:outline-none cursor-pointer bg-blue-600 hover:border-purple-500"
                        >
                    </label>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="./views/assets/js/api.js"></script>
<script src="./views/assets/js/almacen/registrar_pedido.js" type="module"></script>