<?php 
    include "./controllers/control_privilegios.php";
    $privilegio = "registrar_fallas_pedido";
    $control_privilegios = new ControlPrivilegios();
    $acceso = $control_privilegios->verificar_privilegios($privilegio);

?> 

<div class="w-full h-screen">
    <?php
        include 'views/modules/header.php';
    ?>

<div class="w-full flex items-center justify-center mt-8">
        <div class="w-96 flex flex-col justify-center items-center gap-y-2">
            <div class="bg-blue-500 border-2 border-white py-2 rounded-md w-full">
                <h1 class="text-2xl font-bold text-white text-center">REGISTRAR FALLAS</h1>
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
            
        
            <div class="w-full h-fit">
                <form class="flex flex-col items-center py-4 h-fit border-2 border-gray-200 rounded-md bg-blue-500 registrar">

                    <label for="despachador" class="w-full relative px-6">
                        <p class="text-white">Despachador:</p>
                        <select name="despachador" id="despachador" class="w-full border-2 border-gray-300 rounded-md p-2 pt-2 my-1 font-extralight text-black-500 font-medium text-base focus:outline-none"></select>
                    </label>

                    <label for="empleado" class="w-full relative px-6">
                        <p class="text-white">Motivo:</p>
                        <select name="motivo" id="motivo" class="w-full border-2 border-gray-300 rounded-md p-2 pt-2 my-1 font-extralight text-black-500 font-medium text-base focus:outline-none"></select>
                    </label>

                    <label for="descripcion" class="w-full relative px-6">
                        <p class="text-white">Descripción</p>
                        <textarea name="descripcion" id="descripcion" class="w-full border-2 border-gray-300 rounded-md p-2 pt-2 my-1 font-extralight text-black-500 font-medium text-base focus:outline-none"></textarea>
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
    </div>
</div>

<script src="http://192.168.0.164/vitalclinic/views/assets/js/api.js"></script>
<script src="http://192.168.0.164/vitalclinic/views/assets/js/almacen/fallas/fallas_pedidos.js" type="module"></script>
