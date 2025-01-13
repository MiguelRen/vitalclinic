<?php 
    include "./controllers/control_privilegios.php";
    $privilegio = "modificar_cuenta_sistema";
    $control_privilegios = new ControlPrivilegios();
    $acceso = $control_privilegios->verificar_privilegios($privilegio);
	
?> 

<div class="w-full h-screen">

    <?php
        include 'views/modules/header.php';
    ?>

    <div class="w-full flex items-center justify-center mt-6">
        <div class="w-96 flex flex-col justify-center items-center gap-y-2">
            
            <div class="bg-blue-500 border-2 border-white py-2 rounded-md w-full shadow-md">
                <h1 class="text-2xl font-bold text-white text-center">MODIFICAR USUARIO</h1>
            </div>

            <div class="w-full h-fit shadow-md">
                <form class="flex flex-col items-center py-2 h-fit border-2 border-gray-200 rounded-md bg-blue-500">
                    <label for="account" class="w-full relative px-6">
                        <p class="text-white">Cuenta Usuario</p>
                        <select 
                            name="account" 
                            id="account" 
                            class="w-full border-2 border-gray-300 rounded-md p-2 pt-2 my-1 font-extralight text-black-500 font-medium text-base focus:outline-none"></select>
                    </label>
                </form>
            </div>
            
            <div class="w-full h-fit shadow-md">
                <form class="flex flex-col items-center py-4 h-fit border-2 border-gray-200 rounded-md bg-blue-500">

                <input type="text" id="id" name="id" class="hidden">
                    <label for="username" class="w-full relative px-6">
                        <p class="text-white">Nombre de Usuario:</p>
                        <input 
                            type="text" 
                            name="username" 
                            id="username"
                            class="w-full border-2 border-gray-300 rounded-md p-2 pt-2 my-1 font-extralight text-black-500 font-medium text-base focus:outline-none"
                        >
                    </label>

                    <label for="password" class="w-full relative px-6">
                        <p class="text-white">Contraseña:</p>
                        <input 
                            type="password" 
                            name="password" 
                            id="password"
                            class="w-full border-2 border-gray-300 rounded-md p-2 pt-2 my-1 font-extralight text-black-500 font-medium text-base focus:outline-none"
                        >
                    </label>

                    <label for="role" class="w-full relative px-6">
                        <p class="text-white">Rol:</p>
                        <select name="role" id="role" class="w-full border-2 border-gray-300 rounded-md p-2 pt-2 my-1 font-extralight text-black-500 font-medium text-base focus:outline-none"></select>
                    </label>

                    <label for="status" class="w-full relative px-6">
                        <p class="text-white">Status:</p>
                        <select 
                            name="status" 
                            id="status" 
                            class="w-full border-2 border-gray-300 rounded-md p-2 pt-2 my-1 font-extralight text-black-500 font-medium text-base focus:outline-none"
                        >
                        <option value="">Seleccionar status</option>
                        <option value="1">Habilitado</option>
                        <option value="0">Inhabilitado</option>
                        </select>
                    </label>

                    <label for="" class="w-full relative px-6">
                        <input 
                            type="submit" 
                            value="Modificar" 
                            class="w-full border-2 border-gray-300 rounded-md px-6 py-2 mt-3 mb-2 font-extralight text-white text-base font-medium focus:outline-none cursor-pointer bg-blue-600"
                        >
                    </label>
                </form>
            </div>
        </div>
    </div>
</div>


<script src="http://192.168.0.164/vitalclinic/views/assets/js/api.js"></script>
<script src="http://192.168.0.164/vitalclinic/views/assets/js/utilidades.js"></script>
<script src="http://192.168.0.164/vitalclinic/views/assets/js/users/modificar_cuenta.js" type="module"></script> 

