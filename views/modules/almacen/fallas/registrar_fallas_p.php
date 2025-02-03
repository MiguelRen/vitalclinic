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
            <h1 class="text-2xl font-bold text-white text-center">REGISTRAR FALLA P</h1>
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
                    <!-- <th  class="border-2 border-black-500 text-white bg-gray-400">Pedido</th>
                <th  class="border-2 border-black-500 text-white bg-gray-400">id_despachador</th> -->
                    <th class="border-2 border-black-500 text-white bg-gray-400">N° Parte</th>
                    <th class="border-2 border-black-500 text-white bg-gray-400">Fecha Confirmado</th>
                    <th class="border-2 border-black-500 text-white bg-gray-400">Despachador</th>
                    <th class="border-2 border-black-500 text-white bg-gray-400">Fecha Rechequeado</th>
                    <th class="border-2 border-black-500 text-white bg-gray-400">Rechequeador</th>
                    <th class="border-2 border-black-500 text-white bg-gray-400">Cant Fallas</th>
                    <th class="border-2 border-black-500 text-white bg-gray-400"></th>

                </tr>
            </thead>
            <tbody id="body_table_partes"></tbody>
        </table>
    </div>
</div>
</div>


<template id="template_body_table_partes">
    <tr class="tr hover:bg-gray-200 py-0">
        <!-- <td class="num_pedido border-2 border-black-500 text-black text-center " ></td>

        <td class="id_despachador    border-2 border-black-500 text-black text-center " ></td> -->
        <td class="num_parte border-2 border-black-500 text-black text-center   py-0"></td>
        <td class="fecha_confirmado border-2 border-black-500 text-black text-center py-0"></td>
        <td class="despachador border-2 border-black-500 text-black text-center py-0"></td>
        <td class="fecha_rechequeado border-2 border-black-500 text-black text-center py-0"></td>
        <td class="rechequeador border-2 border-black-500 text-black text-center py-0"></td>
        
            <td class="cantidad_fallas border-2 border-black-500 text-black text-center py-0"></td>

       
        <td class="py-0">
            <button id="agregar_falla_b"
                class="agregar_falla_b w-full border-2 border-gray-300 rounded-md px-2 py-2 mt-0 mb-0
                font-extralight text-white text-base font-medium focus:outline-none cursor-pointer bg-blue-600">Agregar</button>
        </td>
    </tr>

</template>


<div style="display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    border-radius: 10px ;
    width: 100%;
    height: 100%; 
    overflow: auto;
    background-color: rgb(0,0,0);
    background-color: rgba(0,0,0,0.4) " class="modal" id="modal">
    <div style="background-color: #fefefe;
    margin: 15% auto; 
    padding: 20px;
    border-radius: 10px ;
    border: 1px solid #888;
    width: 50%; " class="modal">
        <div class="">
            <button id="close-modal-button" type="button"
                class=" focus:outline-none text-white bg-gray-400 hover:bg-gray-300
     focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2 me-2  dark:bg-gray-600 dark:hover:bg-gray-200 dark:focus:ring-gray-900">x</button>

        </div>
        <div class="modal-header flex flex-col items-center">
            <h1 class=" text-2xl my-2">AGREGAR FALLA</h1>

        </div>
        <form class="flex flex-col items-center py-4 h-fit border-2 border-gray-200 rounded-md bg-blue-500">
            <label for="empleado" class="w-full relative px-6">
                <p class="text-white">Motivo:</p>
                <select name="motivo" id="motivo"
                    class="w-full border-2 border-gray-300 rounded-md p-2 pt-2 my-1 font-extralight text-black-500 font-medium text-base focus:outline-none"></select>
            </label>

            <label for="descripcion" class="w-full relative px-6">
                <p class="text-white">Descripción</p>
                <textarea name="descripcion" id="descripcion"
                    class="w-full border-2 border-gray-300 rounded-md p-2 pt-2 my-1 font-extralight text-black-500 font-medium text-base focus:outline-none"></textarea>
            </label>

            <label for="confirmar_falla" value="Agregar" class="rounded-md p-2 bg-blue-600 ">
                <input type="button" name="confirmar_falla" value="Agregar"
                    class="confirmar_falla rounded-md p-2 bg-blue-600 mx-auto text-white" id="confirmar_falla"
                    style="cursor: pointer;">

            </label>

        </form>
    </div>
</div>




<div style="display : none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    border-radius: 10px ;
    width: 100%;
    height: 100%; 
    overflow: auto;
    background-color: rgb(0,0,0);
    background-color: rgba(0,0,0,0.4) " class="falla_modal" id="falla_modal">
    <div style="background-color: #fefefe;
    margin: 15% auto; 
    padding: 20px;
    border-radius: 10px ;
    border: 1px solid #888;
    width: 50%; " class="falla_modal">
        <div class="">
            <button id="close-modal-button" type="button"
                class=" focus:outline-none text-white bg-gray-400 hover:bg-gray-300
     focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2 me-2  dark:bg-gray-600 dark:hover:bg-gray-200 dark:focus:ring-gray-900">x</button>

        </div>
        <table>
            <thead>
                <tr>
                    <th>Motivo</th>
                    <th>Descripción</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>acepan</td>
                    <td>bactron</td>
                </tr>
            </tbody>
        </table>


    </div>
</div>



</div>
</div>
<div>

    <script type="module" src="http://localhost/vitalclinic/views/assets/js/api.js"></script>
    <script type="module" src="http://localhost/vitalclinic/views/assets/js/almacen/fallas/fallas_pedidos_p.js"
        type="module"></script>