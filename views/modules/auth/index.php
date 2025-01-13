<div class="w-full h-screen lg:flex items-center justify-center">
  <div class="w-96 flex flex-col justify-center items-center gap-y-2">
      <div class="bg-blue-500 border-2 border-white py-1 px-2 rounded-md">
        <h1 class="text-2xl font-bold text-white text-center">BIENVENIDO CONTROL DE PROCESOS VITALCLINIC</h1>
      </div>
    <div class="w-52 h-52 ">
      <img src="views/images/logo.png" alt="logo-vitalclinic">
    </div>
    <span 
      id="error-login"
      class="w-full bg-white border-2 border-red-400 py-3 px-4 mb-2 text-red-500 rounded-sm text-center hidden"
    >
    Credenciales Incorrectas
    </span>
    <div class="w-full h-fit">
        <form class="flex flex-col items-center py-4 h-fit border-2 border-gray-200 rounded-md bg-blue-500">
          <label for="" class="w-full relative px-6">
              <p class="text-white">Username:</p>
              <input 
                type="text" 
                name="username" 
                id="username"
                class="w-full border-2 border-gray-300 rounded-md p-2 pt-2 my-1 font-extralight text-black-500 font-medium text-base focus:outline-none"
              >
          </label>

          <label for="" class="w-full relative px-6">
              <p class="text-white">Password:</p>
              <input 
                type="password" 
                name="password" 
                id="password"
                class="w-full border-2 border-gray-300 rounded-md p-2 pt-2 my-1 font-extralight text-black-400 text-base focus:outline-none"
              >
          </label>

          <label for="" class="w-full relative px-6">
          <input 
            type="submit" 
            value="Ingresar" 
            class="w-full border-2 border-gray-300 rounded-md px-6 py-2 mt-3 mb-2 font-extralight text-white text-base font-medium focus:outline-none cursor-pointer bg-blue-600"
          >
          </label>
        </form>
      </div>
  </div>
</div>

<script src="http://192.168.0.164/vitalclinic/views/assets/js/utilidades.js"></script>
<script src="http://192.168.0.164/vitalclinic/views/assets/js/api.js"></script>
<script src="http://192.168.0.164/vitalclinic/views/assets/js/auth.js" type="module"></script>
