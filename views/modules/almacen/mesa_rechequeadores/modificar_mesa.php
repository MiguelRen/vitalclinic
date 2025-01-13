<?php 
    include "./controllers/control_privilegios.php";
    $privilegio = "asignar_mesa";
    $control_privilegios = new ControlPrivilegios();
    $acceso = $control_privilegios->verificar_privilegios($privilegio);
?> 

<div class="w-full">
    <?php
        include 'views/modules/header.php';
    ?>

    <div class="md:w-[70%] flex flex-col gap-y-4 mx-auto mt-4 lg:w-[80%]">

        <div class="flex"> 
            <div class="w-fit flex gap-x-2 rounded-md items-center">
                <button 
                    data-modal-target="agregar_turno" 
                    data-modal-toggle="agregar_turno" 
                    class="border-2 border-gray-200 bg-blue-400 px-6 hover:bg-blue-500 rounded-md text-white font-medium h-12"
                    type="button">
                    Agregar turno
                </button>

                <button 
                    data-modal-target="eliminar_turno" 
                    data-modal-toggle="eliminar_turno" 
                    class="border-2 border-gray-200 bg-red-400 px-6 hover:bg-red-500 rounded-md text-white font-medium eliminar h-12"
                    type="button">
                    Eliminar turno
                </button>
            </div>

            <div class="mx-auto w-fit border-2 border-gray-300 bg-blue-500 flex rounded-md" id="panel_turnos">
                <!-- <div class="py-2 w-full text-center border-r-2 border-gray-400 bg-gray-200 hover:bg-gray-300 font-medium cursor-pointer" id="t_d">Turno Mañana</div>
                    <div class="py-2 w-full text-center bg-gray-200 hover:bg-gray-300 font-medium cursor-pointer" id="t_t">Turno Tarde</div> -->
            </div>
        </div>

        <div class="w-full h-[500px] border-2 border-gray-300 rounded-md bg-gray-100 overflow-y-auto relative">
            <table class="w-full h-600 table-auto border-separate border border-slate-400 rounded-md">
                <thead class="sticky top-0 z-10">
                    <th class="border-2 border-black-500 text-white bg-gray-400 w-24">N° Mesa</th>
                    <th class="border-2 border-black-500 text-white bg-gray-400">Rechequeador</th>
                    <th class="border-2 border-black-500 text-white bg-gray-400">Embalador</th>
                    <th class="border-2 border-black-500 text-white bg-gray-400 w-32">Modificar</th>
                </thead>
                <tbody id="body_table_mesa">
                    <tr class="hover:bg-gray-200">
                        <td class="n_mesa border-2 border-black-500 text-black text-center font-medium">1</td>
                        <td class="rechequeador border-2 border-black-500 text-black text-center"></td>
                        <td class="embalador border-2 border-black-500 text-black text-center"></td>
                        <!-- <td class="embalador border-2 border-black-500 text-black text-center"><button class="border-2 border-gray-200 bg-blue-400 px-6 py-[1px] hover:bg-blue-500 rounded-md text-white font-medium">Editar</button></td> -->
                        <td class="border-2 border-black-500 text-black text-center">
                            <button 
                                data-modal-target="authentication-modal" 
                                data-modal-toggle="authentication-modal" 
                                class="border-2 border-gray-200 bg-blue-400 px-6 py-[1px] hover:bg-blue-500 rounded-md text-white font-medium edit"
                                type="button">
                                Editar
                            </button>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-200">
                        <td class="n_mesa border-2 border-black-500 text-black text-center font-medium">2</td>
                        <td class="rechequeador border-2 border-black-500 text-black text-center"></td>
                        <td class="embalador border-2 border-black-500 text-black text-center"></td>
                        <!-- <td class="embalador border-2 border-black-500 text-black text-center"><button class="border-2 border-gray-200 bg-blue-400 px-6 py-[1px] hover:bg-blue-500 rounded-md text-white font-medium">Editar</button></td> -->
                        <td class="border-2 border-black-500 text-black text-center">
                            <button 
                                data-modal-target="authentication-modal" 
                                data-modal-toggle="authentication-modal" 
                                class="border-2 border-gray-200 bg-blue-400 px-6 py-[1px] hover:bg-blue-500 rounded-md text-white font-medium edit"
                                type="button">
                                Editar
                            </button>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-200">
                        <td class="n_mesa border-2 border-black-500 text-black text-center font-medium">3</td>
                        <td class="rechequeador border-2 border-black-500 text-black text-center"></td>
                        <td class="embalador border-2 border-black-500 text-black text-center"></td>
                        <!-- <td class="embalador border-2 border-black-500 text-black text-center"><button class="border-2 border-gray-200 bg-blue-400 px-6 py-[1px] hover:bg-blue-500 rounded-md text-white font-medium">Editar</button></td> -->
                        <td class="border-2 border-black-500 text-black text-center">
                            <button 
                                data-modal-target="authentication-modal" 
                                data-modal-toggle="authentication-modal" 
                                class="border-2 border-gray-200 bg-blue-400 px-6 py-[1px] hover:bg-blue-500 rounded-md text-white font-medium edit"
                                type="button">
                                Editar
                            </button>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-200">
                        <td class="n_mesa border-2 border-black-500 text-black text-center font-medium">4</td>
                        <td class="rechequeador border-2 border-black-500 text-black text-center"></td>
                        <td class="embalador border-2 border-black-500 text-black text-center"></td>
                        <!-- <td class="embalador border-2 border-black-500 text-black text-center"><button class="border-2 border-gray-200 bg-blue-400 px-6 py-[1px] hover:bg-blue-500 rounded-md text-white font-medium">Editar</button></td> -->
                        <td class="border-2 border-black-500 text-black text-center">
                            <button 
                                data-modal-target="authentication-modal" 
                                data-modal-toggle="authentication-modal" 
                                class="border-2 border-gray-200 bg-blue-400 px-6 py-[1px] hover:bg-blue-500 rounded-md text-white font-medium edit"
                                type="button">
                                Editar
                            </button>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-200">
                        <td class="n_mesa border-2 border-black-500 text-black text-center font-medium">5</td>
                        <td class="rechequeador border-2 border-black-500 text-black text-center"></td>
                        <td class="embalador border-2 border-black-500 text-black text-center"></td>
                        <!-- <td class="embalador border-2 border-black-500 text-black text-center"><button class="border-2 border-gray-200 bg-blue-400 px-6 py-[1px] hover:bg-blue-500 rounded-md text-white font-medium">Editar</button></td> -->
                        <td class="border-2 border-black-500 text-black text-center">
                            <button 
                                data-modal-target="authentication-modal" 
                                data-modal-toggle="authentication-modal" 
                                class="border-2 border-gray-200 bg-blue-400 px-6 py-[1px] hover:bg-blue-500 rounded-md text-white font-medium edit"
                                type="button">
                                Editar
                            </button>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-200">
                        <td class="n_mesa border-2 border-black-500 text-black text-center font-medium">6</td>
                        <td class="rechequeador border-2 border-black-500 text-black text-center"></td>
                        <td class="embalador border-2 border-black-500 text-black text-center"></td>
                        <!-- <td class="embalador border-2 border-black-500 text-black text-center"><button class="border-2 border-gray-200 bg-blue-400 px-6 py-[1px] hover:bg-blue-500 rounded-md text-white font-medium">Editar</button></td> -->
                        <td class="border-2 border-black-500 text-black text-center">
                            <button 
                                data-modal-target="authentication-modal" 
                                data-modal-toggle="authentication-modal" 
                                class="border-2 border-gray-200 bg-blue-400 px-6 py-[1px] hover:bg-blue-500 rounded-md text-white font-medium edit"
                                type="button">
                                Editar
                            </button>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-200">
                        <td class="n_mesa border-2 border-black-500 text-black text-center font-medium">7</td>
                        <td class="rechequeador border-2 border-black-500 text-black text-center"></td>
                        <td class="embalador border-2 border-black-500 text-black text-center"></td>
                        <!-- <td class="embalador border-2 border-black-500 text-black text-center"><button class="border-2 border-gray-200 bg-blue-400 px-6 py-[1px] hover:bg-blue-500 rounded-md text-white font-medium">Editar</button></td> -->
                        <td class="border-2 border-black-500 text-black text-center">
                            <button 
                                data-modal-target="authentication-modal" 
                                data-modal-toggle="authentication-modal" 
                                class="border-2 border-gray-200 bg-blue-400 px-6 py-[1px] hover:bg-blue-500 rounded-md text-white font-medium edit"
                                type="button">
                                Editar
                            </button>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-200">
                        <td class="n_mesa border-2 border-black-500 text-black text-center font-medium">8</td>
                        <td class="rechequeador border-2 border-black-500 text-black text-center"></td>
                        <td class="embalador border-2 border-black-500 text-black text-center"></td>
                        <!-- <td class="embalador border-2 border-black-500 text-black text-center"><button class="border-2 border-gray-200 bg-blue-400 px-6 py-[1px] hover:bg-blue-500 rounded-md text-white font-medium">Editar</button></td> -->
                        <td class="border-2 border-black-500 text-black text-center">
                            <button 
                                data-modal-target="authentication-modal" 
                                data-modal-toggle="authentication-modal" 
                                class="border-2 border-gray-200 bg-blue-400 px-6 py-[1px] hover:bg-blue-500 rounded-md text-white font-medium edit"
                                type="button">
                                Editar
                            </button>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-200">
                        <td class="n_mesa border-2 border-black-500 text-black text-center font-medium">9</td>
                        <td class="rechequeador border-2 border-black-500 text-black text-center"></td>
                        <td class="embalador border-2 border-black-500 text-black text-center"></td>
                        <!-- <td class="embalador border-2 border-black-500 text-black text-center"><button class="border-2 border-gray-200 bg-blue-400 px-6 py-[1px] hover:bg-blue-500 rounded-md text-white font-medium">Editar</button></td> -->
                        <td class="border-2 border-black-500 text-black text-center">
                            <button 
                                data-modal-target="authentication-modal" 
                                data-modal-toggle="authentication-modal" 
                                class="border-2 border-gray-200 bg-blue-400 px-6 py-[1px] hover:bg-blue-500 rounded-md text-white font-medium edit"
                                type="button">
                                Editar
                            </button>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-200">
                        <td class="n_mesa border-2 border-black-500 text-black text-center font-medium">10</td>
                        <td class="rechequeador border-2 border-black-500 text-black text-center"></td>
                        <td class="embalador border-2 border-black-500 text-black text-center"></td>
                        <!-- <td class="embalador border-2 border-black-500 text-black text-center"><button class="border-2 border-gray-200 bg-blue-400 px-6 py-[1px] hover:bg-blue-500 rounded-md text-white font-medium">Editar</button></td> -->
                        <td class="border-2 border-black-500 text-black text-center">
                            <button 
                                data-modal-target="authentication-modal" 
                                data-modal-toggle="authentication-modal" 
                                class="border-2 border-gray-200 bg-blue-400 px-6 py-[1px] hover:bg-blue-500 rounded-md text-white font-medium edit"
                                type="button">
                                Editar
                            </button>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-200">
                        <td class="n_mesa border-2 border-black-500 text-black text-center font-medium">11</td>
                        <td class="rechequeador border-2 border-black-500 text-black text-center"></td>
                        <td class="embalador border-2 border-black-500 text-black text-center"></td>
                        <!-- <td class="embalador border-2 border-black-500 text-black text-center"><button class="border-2 border-gray-200 bg-blue-400 px-6 py-[1px] hover:bg-blue-500 rounded-md text-white font-medium">Editar</button></td> -->
                        <td class="border-2 border-black-500 text-black text-center">
                            <button 
                                data-modal-target="authentication-modal" 
                                data-modal-toggle="authentication-modal" 
                                class="border-2 border-gray-200 bg-blue-400 px-6 py-[1px] hover:bg-blue-500 rounded-md text-white font-medium edit"
                                type="button">
                                Editar
                            </button>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-200">
                        <td class="n_mesa border-2 border-black-500 text-black text-center font-medium">12</td>
                        <td class="rechequeador border-2 border-black-500 text-black text-center"></td>
                        <td class="embalador border-2 border-black-500 text-black text-center"></td>
                        <!-- <td class="embalador border-2 border-black-500 text-black text-center"><button class="border-2 border-gray-200 bg-blue-400 px-6 py-[1px] hover:bg-blue-500 rounded-md text-white font-medium">Editar</button></td> -->
                        <td class="border-2 border-black-500 text-black text-center">
                            <button 
                                data-modal-target="authentication-modal" 
                                data-modal-toggle="authentication-modal" 
                                class="border-2 border-gray-200 bg-blue-400 px-6 py-[1px] hover:bg-blue-500 rounded-md text-white font-medium edit"
                                type="button">
                                Editar
                            </button>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-200">
                        <td class="n_mesa border-2 border-black-500 text-black text-center font-medium">13</td>
                        <td class="rechequeador border-2 border-black-500 text-black text-center"></td>
                        <td class="embalador border-2 border-black-500 text-black text-center"></td>
                        <!-- <td class="embalador border-2 border-black-500 text-black text-center"><button class="border-2 border-gray-200 bg-blue-400 px-6 py-[1px] hover:bg-blue-500 rounded-md text-white font-medium">Editar</button></td> -->
                        <td class="border-2 border-black-500 text-black text-center">
                            <button 
                                data-modal-target="authentication-modal" 
                                data-modal-toggle="authentication-modal" 
                                class="border-2 border-gray-200 bg-blue-400 px-6 py-[1px] hover:bg-blue-500 rounded-md text-white font-medium edit"
                                type="button">
                                Editar
                            </button>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-200">
                        <td class="n_mesa border-2 border-black-500 text-black text-center font-medium">14</td>
                        <td class="rechequeador border-2 border-black-500 text-black text-center"></td>
                        <td class="embalador border-2 border-black-500 text-black text-center"></td>
                        <!-- <td class="embalador border-2 border-black-500 text-black text-center"><button class="border-2 border-gray-200 bg-blue-400 px-6 py-[1px] hover:bg-blue-500 rounded-md text-white font-medium">Editar</button></td> -->
                        <td class="border-2 border-black-500 text-black text-center">
                            <button 
                                data-modal-target="authentication-modal" 
                                data-modal-toggle="authentication-modal" 
                                class="border-2 border-gray-200 bg-blue-400 px-6 py-[1px] hover:bg-blue-500 rounded-md text-white font-medium edit"
                                type="button">
                                Editar
                            </button>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-200">
                        <td class="n_mesa border-2 border-black-500 text-black text-center font-medium">15</td>
                        <td class="rechequeador border-2 border-black-500 text-black text-center"></td>
                        <td class="embalador border-2 border-black-500 text-black text-center"></td>
                        <!-- <td class="embalador border-2 border-black-500 text-black text-center"><button class="border-2 border-gray-200 bg-blue-400 px-6 py-[1px] hover:bg-blue-500 rounded-md text-white font-medium">Editar</button></td> -->
                        <td class="border-2 border-black-500 text-black text-center">
                            <button 
                                data-modal-target="authentication-modal" 
                                data-modal-toggle="authentication-modal" 
                                class="border-2 border-gray-200 bg-blue-400 px-6 py-[1px] hover:bg-blue-500 rounded-md text-white font-medium edit"
                                type="button">
                                Editar
                            </button>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-200">
                        <td class="n_mesa border-2 border-black-500 text-black text-center font-medium">16</td>
                        <td class="rechequeador border-2 border-black-500 text-black text-center"></td>
                        <td class="embalador border-2 border-black-500 text-black text-center"></td>
                        <!-- <td class="embalador border-2 border-black-500 text-black text-center"><button class="border-2 border-gray-200 bg-blue-400 px-6 py-[1px] hover:bg-blue-500 rounded-md text-white font-medium">Editar</button></td> -->
                        <td class="border-2 border-black-500 text-black text-center">
                            <button 
                                data-modal-target="authentication-modal" 
                                data-modal-toggle="authentication-modal" 
                                class="border-2 border-gray-200 bg-blue-400 px-6 py-[1px] hover:bg-blue-500 rounded-md text-white font-medium edit"
                                type="button">
                                Editar
                            </button>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-200">
                        <td class="n_mesa border-2 border-black-500 text-black text-center font-medium">17</td>
                        <td class="rechequeador border-2 border-black-500 text-black text-center"></td>
                        <td class="embalador border-2 border-black-500 text-black text-center"></td>
                        <!-- <td class="embalador border-2 border-black-500 text-black text-center"><button class="border-2 border-gray-200 bg-blue-400 px-6 py-[1px] hover:bg-blue-500 rounded-md text-white font-medium">Editar</button></td> -->
                        <td class="border-2 border-black-500 text-black text-center">
                            <button 
                                data-modal-target="authentication-modal" 
                                data-modal-toggle="authentication-modal" 
                                class="border-2 border-gray-200 bg-blue-400 px-6 py-[1px] hover:bg-blue-500 rounded-md text-white font-medium edit"
                                type="button">
                                Editar
                            </button>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-200">
                        <td class="n_mesa border-2 border-black-500 text-black text-center font-medium">18</td>
                        <td class="rechequeador border-2 border-black-500 text-black text-center"></td>
                        <td class="embalador border-2 border-black-500 text-black text-center"></td>
                        <!-- <td class="embalador border-2 border-black-500 text-black text-center"><button class="border-2 border-gray-200 bg-blue-400 px-6 py-[1px] hover:bg-blue-500 rounded-md text-white font-medium">Editar</button></td> -->
                        <td class="border-2 border-black-500 text-black text-center">
                            <button 
                                data-modal-target="authentication-modal" 
                                data-modal-toggle="authentication-modal" 
                                class="border-2 border-gray-200 bg-blue-400 px-6 py-[1px] hover:bg-blue-500 rounded-md text-white font-medium edit"
                                type="button">
                                Editar
                            </button>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-200">
                        <td class="n_mesa border-2 border-black-500 text-black text-center font-medium">19</td>
                        <td class="rechequeador border-2 border-black-500 text-black text-center"></td>
                        <td class="embalador border-2 border-black-500 text-black text-center"></td>
                        <!-- <td class="embalador border-2 border-black-500 text-black text-center"><button class="border-2 border-gray-200 bg-blue-400 px-6 py-[1px] hover:bg-blue-500 rounded-md text-white font-medium">Editar</button></td> -->
                        <td class="border-2 border-black-500 text-black text-center">
                            <button 
                                data-modal-target="authentication-modal" 
                                data-modal-toggle="authentication-modal" 
                                class="border-2 border-gray-200 bg-blue-400 px-6 py-[1px] hover:bg-blue-500 rounded-md text-white font-medium edit"
                                type="button">
                                Editar
                            </button>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-200">
                        <td class="n_mesa border-2 border-black-500 text-black text-center font-medium">20</td>
                        <td class="rechequeador border-2 border-black-500 text-black text-center"></td>
                        <td class="embalador border-2 border-black-500 text-black text-center"></td>
                        <!-- <td class="embalador border-2 border-black-500 text-black text-center"><button class="border-2 border-gray-200 bg-blue-400 px-6 py-[1px] hover:bg-blue-500 rounded-md text-white font-medium">Editar</button></td> -->
                        <td class="border-2 border-black-500 text-black text-center">
                            <button 
                                data-modal-target="authentication-modal" 
                                data-modal-toggle="authentication-modal" 
                                class="border-2 border-gray-200 bg-blue-400 px-6 py-[1px] hover:bg-blue-500 rounded-md text-white font-medium edit"
                                type="button">
                                Editar
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div id="loader" class="w-full h-screen bg-transparent fixed top-0 hidden">
        <div class="w-full h-screen flex flex-col justify-center items-center border-2 border-blue-500">
            <span class="loader"></span>
        </div>        
    </div>
<div>

<?php
    include "./views/modules/almacen/mesa_rechequeadores/modal_modificar_mesa.php";
    include "./views/modules/almacen/mesa_rechequeadores/modal_agregar_turno.php";
    include "./views/modules/almacen/mesa_rechequeadores/modal_eliminar_turno.php";
?>

<template id="item_turno">
    <div class="py-2 px-2  text-center bg-gray-200 hover:bg-gray-300 font-medium cursor-pointer turno flex flex-col border-r-2 border-gray-300">
        <p class="name_t"></p>
        <p class="t"></p>
    </div>
</template>

<!-- <template id="template_body_table_mesa">
    <tr class="hover:bg-gray-200">
        <td class="n_mesa border-2 border-black-500 text-black text-center font-medium">1</td>
        <td class="rechequeador border-2 border-black-500 text-black text-center"></td>
        <td class="embalador border-2 border-black-500 text-black text-center"></td>
        <td class="border-2 border-black-500 text-black text-center"><button type="button" data-modal-target="authentication-modal" data-modal-toggle="authentication-modal" >Editar</button></td> 
        <td class="border-2 border-black-500 text-black text-center">
            <button 
                data-modal-target="authentication-modal" 
                data-modal-toggle="authentication-modal" 
                class="border-2 border-gray-200 bg-blue-400 px-6 py-[1px] hover:bg-blue-500 rounded-md text-white font-medium edit"
                type="button">
                Editar
            </button>
        </td>
        <td>
            <button 
                data-modal-target="authentication-modal" 
                data-modal-toggle="authentication-modal" 
                class="edit block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                Toggle modal
            </button>
        </td>
    </tr>
</template> -->

<script src="http://192.168.0.164/vitalclinic/views/assets/js/api.js"></script>
<script src="http://192.168.0.164/vitalclinic/views/assets/js/almacen/rechequeo/mesa_rechequeo.js" type="module"></script>
