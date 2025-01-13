<?php 
    include "./controllers/control_privilegios.php";
    $privilegio = "registrar_empleado";
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
                <h1 class="text-2xl font-bold text-white text-center">REGISTRAR NUEVO EMPLEADO</h1>
            </div>
            
            <div class="w-full h-fit">
                <form class="flex flex-col items-center py-4 h-fit border-2 border-gray-200 rounded-md bg-blue-500">

                    <label for="cedula" class="w-full relative px-6">
                        <p class="text-white">Cédula:</p>
                        <input 
                            type="text" 
                            name="cedula" 
                            id="cedula"
                            class="w-full border-2 border-gray-300 rounded-md p-2 pt-2 my-1 font-extralight text-black-500 font-medium text-base focus:outline-none"
                        >
                    </label>

                    <label for="name" class="w-full relative px-6">
                        <p class="text-white">Nombre:</p>
                        <input 
                            type="text" 
                            name="name" 
                            id="name"
                            class="w-full border-2 border-gray-300 rounded-md p-2 pt-2 my-1 font-extralight text-black-500 font-medium text-base focus:outline-none"
                        >
                    </label>

                    <label for="lastname" class="w-full relative px-6">
                        <p class="text-white">Apellido:</p>
                        <input 
                            type="text" 
                            name="lastname" 
                            id="lastname"
                            class="w-full border-2 border-gray-300 rounded-md p-2 pt-2 my-1 font-extralight text-black-500 font-medium text-base focus:outline-none"
                        >
                    </label>

                    <label for="lastname" class="w-full relative px-6">
                        <p class="text-white">Departamento:</p>
                        <select 
                            name="departamento" 
                            id="departamento" 
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
        <div id="loader" class="w-full h-screen bg-transparent fixed top-0 hidden">
            <div class="w-full h-screen flex flex-col justify-center items-center border-2 border-blue-500">
                    <span class="loader"></span>
            </div>        
        </div>
    </div>
</div> 

<script src="http://192.168.0.164/vitalclinic/views/assets/js/api.js"></script>
<script src="http://192.168.0.164/vitalclinic/views/assets/js/utilidades.js"></script>
<script src="http://192.168.0.164/vitalclinic/views/assets/js/users/registrar_empleado.js" type="module"></script>



    
