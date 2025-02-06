<?php 
    include "./controllers/control_privilegios.php";
    $privilegio = "visualizar_total_pedidos";
    $control_privilegios = new ControlPrivilegios();
    $acceso = $control_privilegios->verificar_privilegios($privilegio);

?> 

<div class="w-full h-screen">
    <?php
        include 'views/modules/header.php';
    ?>

    <div class="w-[80%] flex flex-col gap-y-4 mx-auto mt-2">
        
        <div class="flex justify-center items-center gap-x-4 py-2 border-2 border-gray-200 rounded-md bg-blue-500">
            <div class="flex gap-x-2 items-center">
                <p class="font-medium text-white">Fecha Inicio</p> 
                <input 
                    type="datetime-local" 
                    name="fecha_inicio" 
                    id="fecha_inicio"
                    class="border-2 border-gray-200 rounded-sm"
                >
            </div>
            <div class="flex gap-x-2 items-center">
                <input 
                    type="datetime-local" 
                    name="fecha_final" 
                    id="fecha_final"
                    class="border-2 border-gray-200 rounded-sm"
                > 
                <p class="font-medium text-white">Fecha Final</p>
            </div>
            <div class="ml-4">
                <select 
                    name="ruta" 
                    id="ruta" 
                    class="flex w-44 border-2 border-gray-200 rounded-sm">Ruta
                </select>
            </div>
        </div>

        <div class="w-full border-2 border-gray-200 rounded-md bg-blue-500">
            <table class="w-full table-auto border-separate border border-slate-400">
                <thead>
                    <th class="border-2 border-black-500 text-white bg-gray-400">Despachador</th>
                    <th class="border-2 border-black-500 text-white bg-gray-400">C. Pedidos</th>
                    <th class="border-2 border-black-500 text-white bg-gray-400">% Respecto Total Pedidos</th>
                    <th class="border-2 border-black-500 text-white bg-gray-400">C. Unidades</th>
                    <th class="border-2 border-black-500 text-white bg-gray-400">% Respecto Total Unidades</th>
                    <th class="border-2 border-black-500 text-white bg-gray-400">Total Fallas</th>
                    <th class="border-2 border-black-500 text-white bg-gray-400">% Respecto Total Fallas</th>
                </thead>
                <tbody id="body_table_pedidos"></tbody>
            </table>
        </div>

    </div>
</div>


<template id="template_body_table">
    <tr class="tr hover:bg-gray-200">
        <td class="empleado border-2 border-black-500 text-black text-center"></td>
        <td class="cant_pedidos border-2 border-black-500 text-black text-center"></td>
        <td class="porcentaje_pedidos border-2 border-black-500 text-black text-center"></td>
        <td class="cantidad_unidades border-2 border-black-500 text-black text-center"></td>
        <td class="porcentaje_total_unidades border-2 border-black-500 text-black text-center"></td>
    </tr>
</template>