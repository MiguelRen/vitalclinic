<?php 
    include "./controllers/control_privilegios.php";
    $privilegio = "eliminar_pedido";
    $control_privilegios = new ControlPrivilegios();
    $acceso = $control_privilegios->verificar_privilegios($privilegio);

?> 

<div class="w-full h-screen">
    <?php
        include 'views/modules/header.php';
    ?>
    <div class="w-full h-full">
      <div class="mt-12">
        <div class="bg-blue-500 border-2 border-white rounded-md mb-4 w-fit px-4 mx-auto">
            <h1 class="text-2xl font-bold text-white text-center">ELIMINAR PEDIDO</h1>
        </div>
    
        <div class="w-full flex gap-x-4 justify-center h-fit">
          <div class="w-72 flex flex-col gap-y-2">
              <form class="flex flex-col items-center py-4 h-fit border-2 border-gray-200 rounded-md bg-blue-500">
                  <input type="text" name="id_pedido" id="id_pedido" class="hidden">
                  <label for="partes" class="w-full relative px-6">
                      <p class="text-white">Ingrese número de pedido:</p>
                      <input 
                          type="number" 
                          name="cod_pedido" 
                          id="cod_pedido"
                          min=1
                          class="w-full border-2 border-gray-300 rounded-md p-2 pt-2 my-1 font-extralight text-black-500 font-medium text-base focus:outline-none"
                      >
                  </label>

                  <label for="" class="w-full relative px-6">
                      <input 
                          type="submit"
                          value="Eliminar Pedido" 
                          class="eliminar_pedido w-full border-2 border-gray-300 rounded-md p-2 pt-2 my-1 font-extralight text-black-500 font-medium text-base text-white focus:outline-none cursor-pointer hover:border-purple-600"
                      >
                  </label>
              </form>
        </div>
      </div>
    </div>
</div>

<script src="http://192.168.0.164/vitalclinic/views/assets/js/api.js"></script>
<script src="http://192.168.0.164/vitalclinic/views/assets/js/almacen/pedidos/eliminar_pedido.js" type="module"></script>
