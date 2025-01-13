<?php 
    include "controllers/control_privilegios.php";
    $privilegio = "estadisticas";
    $control_privilegios = new ControlPrivilegios();
    $acceso = $control_privilegios->verificar_privilegios($privilegio);

?> 

<div class="w-full h-screen">
    <?php
        include 'views/modules/header.php';
    ?>

    <div class="lg:w-[90%] mx-auto mt-12">
        
        <div class="w-[90%] flex justify-center items-center gap-x-8">
            <form action="" class="flex gap-x-4">
                <div class="flex gap-x-4">
                    <div><input type="datetime-local" name="" id="fechai"></div>
                    <div><input type="datetime-local" name="" id="fechaf"></div>
                </div>
                <div><select name="ruta" id="ruta" autocomplete="on"><option value="">Seleccione la ruta</option></select></div>
                <div><input type="submit" value="Buscar" class="border-2 border-gray-200 bg-gray-200 px-4 rounded-md cursor-pointer"></div>
            </form>
        </div>

        <div class="lg:w-[70%] h-[300px] border-2 border-gray-300 rounded-md bg-gray-100 overflow-y-auto relative mt-8 mx-auto">
            <table class="w-full h-600 table-auto border-separate border border-slate-400 rounded-md">
                <thead class="sticky top-0 z-10">
                    <th class="border-2 border-black-500 text-white bg-gray-400 w-36">N° pedido</th>
                    <th class="border-2 border-black-500 text-white bg-gray-400">Ruta</th>
                    <th class="border-2 border-black-500 text-white bg-gray-400">C. unidades</th>
                    <th class="border-2 border-black-500 text-white bg-gray-400 w-32">Fecha</th>
                    <th class="border-2 border-black-500 text-white bg-gray-400 w-32">Distribuidor</th>
                    <th class="border-2 border-black-500 text-white bg-gray-400 w-32">Ver detalles</th>
                </thead>
                <tbody id="body_table"></tbody>
            </table>
        </div>
	<div class="flex justify-center border-2 border-gray-400 bg-gray-200 md:[90%] lg:w-[70%] mx-auto mt-4 py-2 rounded-md">
            <div class="w-[50%] text-center font-medium border-r-2 border-gray-400">Total Pedidos: <p class="block" id="total_pedidos">0</p></div>
            <div class="w-[50%] text-center font-medium">Total Unidades: <p id="total_unidades">0</p></div>
        </div>
    </div>
    <div id="loader" class="w-full h-screen bg-transparent fixed top-0 hidden">
        <div class="w-full h-screen flex flex-col justify-center items-center border-2 border-blue-500">
                <span class="loader"></span>
        </div>        
    </div>
</div>

<template id="template_body_table_pedidos">
    <tr class="tr hover:bg-gray-200">
        <td class="n_pedido border-2 border-black-500 text-black text-center"></td>
        <td class="ruta border-2 border-black-500 text-black text-center"></td>
        <td class="unidades border-2 border-black-500 text-black text-center"></td>
        <td class="fecha border-2 border-black-500 text-black text-center"></td>
        <td class="distribuidor border-2 border-black-500 text-black text-center"></td>
        <td class="action border-2 border-black-500 text-black text-center"><button class="delete border-2 border-blue-400 px-2 rounded-md bg-blue-500 text-white hover:bg-blue-600">Ver info</button></td>
    </tr>
</template>

<script src="http://192.168.0.164/vitalclinic/views/assets/js/api.js"></script>
<script src="http://192.168.0.164/vitalclinic/views/assets/js/almacen/estadisticas/pedidos_por_fecha.js" type="module"></script>
