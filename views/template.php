
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vitalclinic</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="views/assets/js/tailwind.config.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.css" rel="stylesheet" />
	<link rel= "stylesheet" href="views/css/loader.css"/>
</head>
<body>
    <div class="w-full h-screen bg-banner">
        <?php 
            $modules = new ControladorLinks();
            $modules->gestionar_redireccion();
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script>
</body>
</html>
