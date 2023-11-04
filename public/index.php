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
    <!-- <link rel="stylesheet" href="../../../public/css/main.css"> -->
</head>


<body>
 
<!-- main -->
<main class="container pt-4">
    <?php
      require '../app/controller/ProductController.php';
      $productController = new ProductController();

    ?>
<div class="row ">
        <div class="col-md-2 mb-2">
            <a class="btn btn-outline-secondary w-100"  href="../app/views/products/FormProduct.php">
                    Crear Producto
            </a>
        </div>
    </div>
  <div class="row justify-content-between">
    <h4 class="col"><span class="">Productos</span></h4>
    <h4 class="col text-end"><i class="bi bi-box"></i> N° <?= $productController->countProducts(); ?></h4>
  </div>
  <hr>
  <!-- table products -->
  <div class="table-responsive mb-5"  style="">
    <table class="table table-sm table-hover">
      <thead class="table-dark">
      <tr>
        <th scope="col">ID</th>
        <th scope="col">Nombre</th>
        <th scope="col">Imagen</th>
        <th scope="col">Estado</th>
        <th class="text-center"colspan="2" scope="col">Acción</th>
      </tr>
    </thead>
    <tbody id="content" name="content" class="">
        <?php
          foreach($productController->getProducts() as $product) {
        ?>
        <tr class=" ">
          <th class="align-middle" scope="row"><?=$product['idProduct']?></th>
          <td class="text-truncate align-middle">
            <span class="d-inline-block text-truncate"  style="max-width: 150px;">
            <?= $product['nameProduct']; ?>
            </span>
          </td>
          <td class="align-middle">
            <img class="rounded max-auto d-block" src="<?= $product['imgProduct'] ?>" alt="imagen" style="border-radius:10px; width:120px; height:120px;">
          </td>
          
          <td  class="align-middle" >
            <span class="d-inline-block text-truncate"  style="max-width: 150px;">
              <?= $product['statusProduct']; ?>
            </span>
          </td>
          <td class="align-middle">
              <a href="../app/controller/ProductController.php?" class="col me-2 btn btn-outline-secondary"><i class="bi bi-pencil" >
              </i> Editar</a>
            </td>
          <td class="align-middle">
            <form action="../app/controller/ProductController.php?id=<?=$product['idProduct']?>" method="POST">
             <button class="col me-2 btn btn-outline-secondary" name="btnDelete" ><i class="bi bi-trash3"></i> Eliminar
            </button>
            </form>
          </td>
        </tr>
        <?php
          }
        ?>
        
    </tbody>
  </table>
  </div>
  
</main>
<!-- footer -->
<!-- include('../../../presentation/templates/footer.php'); -->
  <!-- Bootstrap JavaScript Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>

