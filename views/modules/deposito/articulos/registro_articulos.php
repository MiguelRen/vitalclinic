<?php 
    include "./controllers/control_privilegios.php";
    $privilegio = "registrar_articulo";
    $control_privilegios = new ControlPrivilegios();
    $acceso = $control_privilegios->verificar_privilegios($privilegio);

?> 

<div class="w-full h-screen">

    <?php
        include 'views/modules/header.php';
    ?>

    <div class="w-full flex items-center justify-center mt-8">
        <div class="w-96 flex flex-col justify-center items-center gap-y-1">
            <div class="bg-blue-500 border-2 border-white py-2 rounded-md w-full">
                <h1 class="text-2xl font-bold text-white text-center">REGISTRAR NUEVO ARTICULO</h1>
            </div>
            
            <div class="w-full h-fit">
                <form class="flex flex-col items-center py-4 h-fit border-2 border-gray-200 rounded-md bg-blue-500">

                    <label for="cedula" class="w-full relative px-6">
                        <p class="text-white">Codigo Profit</p>
                        <input 
                            type="text" 
                            name="cod_profit" 
                            id="cod_profit"
                            class="w-full border-2 border-gray-300 rounded-md p-2 pt-2 my-1 font-extralight text-black-500 font-medium text-base focus:outline-none"
                        >
                    </label>

                    <label for="name" class="w-full relative px-6">
                        <p class="text-white">Codigo Barra (opcional)</p>
                        <input 
                            type="text" 
                            name="cod_barra" 
                            id="cod_barra"
                            class="w-full border-2 border-gray-300 rounded-md p-2 pt-2 my-1 font-extralight text-black-500 font-medium text-base focus:outline-none"
                        >
                    </label>

                    <label for="lastname" class="w-full relative px-6">
                        <p class="text-white">Descripcion</p>
                        <input 
                            type="text" 
                            name="lastname" 
                            id="lastname"
                            class="w-full border-2 border-gray-300 rounded-md p-2 pt-2 my-1 font-extralight text-black-500 font-medium text-base focus:outline-none"
                        >
                    </label>

                    <label for="" class="w-full relative px-6">
                    <input 
                        type="submit" 
                        value="Registrar" 
                        class="w-full border-2 border-gray-300 rounded-md px-6 py-2 mt-3 mb-2 font-extralight text-white text-base font-medium focus:outline-none cursor-pointer bg-blue-600"
                    >
                    </label>
                </form>
            </div>
        </div>
    </div>
</div> 

<script src="http://192.168.0.164/vitalclinic/views/assets/js/api.js"></script>
<script src="http://192.168.0.164/vitalclinic/views/assets/js/deposito/articulos/registrar_articulos.js" type="module"></script>