<?php
include "./controllers/control_privilegios.php";
$privilegio = "modificar_pedido";
$control_privilegios = new ControlPrivilegios();
$acceso = $control_privilegios->verificar_privilegios($privilegio);

?>

<div class="w-full h-screen">
    <?php
    include 'views/modules/header.php';
    ?>
    <div class="w-full mt-4">
        <div class="bg-blue-500 border-2 border-white rounded-md mb-4 w-fit px-4 mx-auto">
            <h1 class="text-2xl font-bold text-white text-center">TERMINAR PEDIDO</h1>
        </div>

        <div class="w-96 flex flex-col justify-center items-center gap-y-1 w-full h-fit">
            <form class="flex flex-col items-center py-4 h-fit border-2 border-gray-200 rounded-md bg-blue-500">

                <label for="cod_pedido" class="w-full relative px-6">
                    <p class="text-white">Numero de Pedido</p>
                    <input type="text" name="cod_pedido" id="cod_pedido"
                        class="w-full border-2 border-gray-300 rounded-md p-2 pt-2 my-1 font-extralight text-black-500 font-medium text-base focus:outline-none">
                </label>

                <label for="" class="w-full relative px-6">
                    <input type="submit" value="Buscar" id="buscar_b"
                        class="w-full border-2 border-gray-300 rounded-md px-6 py-2 mt-3 mb-2 font-extralight text-white text-base font-medium focus:outline-none cursor-pointer bg-blue-600">
                </label>
            </form>
        </div>

    </div>


    <div class="md:w-[90%]  xl:w-[60%] bg-gray-100 h-fit mx-auto mt-2">
        <table id="table_2" class="w-full table-auto border-separate border border-slate-400">
            <thead>
                <tr>
                <th  class="border-2 border-black-500 text-white bg-gray-400">Pedido</th>
                <th  class="border-2 border-black-500 text-white bg-gray-400">id_despachador</th>
                    <th class="border-2 border-black-500 text-white bg-gray-400">N° Parte</th>
                    <th class="border-2 border-black-500 text-white bg-gray-400">Nombre</th>
                    <th class="border-2 border-black-500 text-white bg-gray-400">Apellido</th>
                    <th class="border-2 border-black-500 text-white bg-gray-400">Fecha Entregado</th>
                    <th class="border-2 border-black-500 text-white bg-gray-400">Fecha Terminado</th>
                    <th class="border-2 border-black-500 text-white bg-gray-400"></th>
                  
                </tr>
            </thead>
            <tbody id="body_table_partes"></tbody>
        </table>
    </div>
</div>
</div>


<template id="template_body_table_partes">
    <tr class="tr hover:bg-gray-200">
        <td class="num_pedido border-2 border-black-500 text-black text-center " ></td>

        <td class="id_despachador    border-2 border-black-500 text-black text-center " ></td>
        <td class="num_parte border-2 border-black-500 text-black text-center"></td>
        <td class="nombre border-2 border-black-500 text-black text-center"></td>
        <td class="apellido border-2 border-black-500 text-black text-center"></td>
        <td class="fecha_entregado border-2 border-black-500 text-black text-center"></td>
        <td class="fecha_terminado border-2 border-black-500 text-black text-center"></td>
        <td>
            <button id="confirm_b"
                class="confirm_b w-full border-2 border-gray-300 rounded-md px-6 py-2 mt-3 mb-2 font-extralight text-white text-base font-medium focus:outline-none cursor-pointer bg-blue-600">Confirmar</button>
        </td>
    </tr>

</template>

</div>
</div>
<div>

    <script type="module" src="http://localhost/vitalclinic/views/assets/js/api.js"></script>
    <script type="module" src="http://localhost/vitalclinic/views/assets/js/almacen/pedidos/confirmar_pedidos.js"
        type="module"></script>