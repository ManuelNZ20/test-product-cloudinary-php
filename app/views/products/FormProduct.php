<?php

?>
<?php

if(isset($_GET['id'])){
  include_once '../../../app/controller/ProductController.php';
   $controller = new ProviderController();
   $id = $_GET['id'];
 }else {
   $id = 0;
   $dateRegister = date('Y-m-d');
   $state = 'all';
   $categories = 'all';
   $providers = 'all';
 }
?>

<!doctype html>
<html lang="en">

<head>
<title>Roberto Cotlear</title>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<!-- Bootstrap CSS v5.2.1 -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
 integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>


<body>
<!-- header -->

<!-- main -->
<main class="container pt-4 mb-4">
 <div class="container pt-5">
   <div class="row align-items-center">
     <div class="col mb-2">
         <div class="row align-items-center">
             <div class="col-auto"> <i class="bi bi-pencil" >
           </i></div>
             <h4 class="col-6 col-sm-3">Productos</h4>
         </div>
     </div>
     <div class="col-md-auto mb-2">
         <div class="row">
             <h4 class="col-auto">ID:</h4>
             <h4 class="col-auto"><?php
                 if($id!=0) {
                     echo $id;
                 }else {
                     echo "Nuevo";
                 }
                 ?>
             </h4>
         </div>
     </div>
     <div class="col-md-auto mb-2">
         <div class="row">
             <h4 class="col-auto">Fecha de registro:</h4>
             <h4 class="col-auto"><?php
                 echo $dateRegister;
                 ?> <?php
                 ?>
             </h4>
         </div>
     </div>
</div>
<hr>
</div>
<form class="row" action="../../../app/controller/ProductController.php<?= ($id!=0)?'?id='.$id:''; ?>" method="POST" enctype="multipart/form-data" >
<!--  Nombre -->
<div class="col-md-6">
   <label for="nameProduct" class="form-label">Nombre</label>
   <input type="text" class="form-control" id="nameProduct" name="nameProduct" value="<?= ($id>0)?$name:'';?>" required>
 </div>
 <!--  Estado -->
 <div class="col">
     <label for="stateProvider" class="form-label">Estado</label>
     <select class="form-select" aria-label="Default select example" name="stateProduct" id="stateProvider" required>
         <option value="all" <?php if($state=='all') echo 'selected';?>>Seleccionar</option>
         <option value="activo" <?php if($state=='activo') echo 'selected';?>>Activo</option>
         <option value="inactivo" <?php if($state=='inactivo') echo 'selected';?>>Inactivo</option>
     </select>
 </div>
 <!-- Cargar imagen -->
 <div class="col-md-12" style="height:400px;">
    <h4 class="text-center pt-2">Solo se debe subir una imagen</h4>
    <hr>
    <input class="form-control mb-2" type="file" id="imageInput" name="imgProduct" accept="image/*"  multiple>
    <div class="container mt-2 pt-2 pb-2" style="height:260px; background-color:var(--bs-tertiary-bg);">
        <div class="card" style="width: 16rem; display:none;">
            <img id="imgShow" class="mx-auto d-block card-img-top" src="" alt="">
          <div class="card-body text-center">
            <a id="eliminarBtn" href="#" class="btn btn-outline-danger">Eliminar</a>
          </div>
        </div>
    </div>
    <hr>
 </div>

<!-- buttons -->
<div class="col-12 text-end">
 <button id="btnProvider" class="col-3 btn btn-outline-secondary"  name="btnProvider" value="<?= ($id!=0)?'Guardar':'Crear'; ?>">
 <i class="bi bi-floppy"></i> <?php
         if($id!=0) {
             echo "Guardar";
         }else {
             echo "Crear";
         }
         ?>
 </button>
 <a class="col-3 btn btn-outline-secondary"  href="../../../public/index.php">
 <i class="bi bi-arrow-left-circle"></i> Cerrar
 </a>
</div>
</form>

</main>
<!-- Script -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    const imagenInput = document.getElementById('imageInput'); // Seleccione el campo de entrada de archivos
    const imagenMostrada = document.getElementById('imgShow');// Seleccione la imagen mostrada
    const tarjeta = document.querySelector('.card'); // Seleccione la tarjeta completa

    imagenInput.addEventListener('change', function() { // Escuche los cambios en el campo de entrada de archivos
        const file = imagenInput.files[0]; // Obtenga el archivo seleccionado en el campo de entrada de archivos
        if (file) {
            const reader = new FileReader(); // Inicializar FileReader API
            reader.onload = function(e) { // Cuando se cargue el archivo, se ejecutará esta función
                imagenMostrada.src = e.target.result; // Establece el atributo src de la imagen en la ruta del archivo
                console.log(imagenMostrada.src)
                tarjeta.style.display = 'block'; // Muestra la tarjeta cuando se carga una imagen
            };

            reader.readAsDataURL(file);
        }
    });

    $(document).ready(function() {
        $("#eliminarBtn").click(function(e) {
            e.preventDefault(); // Evita el comportamiento predeterminado del enlace
            imagenMostrada.src = ''; // Establece el atributo src en blanco para eliminar la imagen
            imageInput.value = ''; // Establece el valor del campo de entrada de archivos en blanco para que no se envíe ningún archivo
            tarjeta.style.display = 'none'; // Oculta la tarjeta al hacer clic en el botón "Eliminar"
        });
    });
</script>

<!-- Bootstrap JavaScript Libraries -->  
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>


