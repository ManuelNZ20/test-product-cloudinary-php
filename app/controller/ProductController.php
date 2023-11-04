<?php
include __DIR__.'../../../app/model/ProductModel.php';
require_once __DIR__.'../../../config/config.php';
require_once __DIR__.'/ImageControllerCloudinary.php';
// Use Composer to manage your PHP library dependency

$productController = new ProductController();
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['btnProvider'])) {
        if($_POST['btnProvider']=='Crear') {
            $fileName = $_FILES['imgProduct']['name']; // nombre del archivo
            $tmpPhoto = $_FILES['imgProduct']['tmp_name']; // ruta temporal
            if ($tmpPhoto != "") { // si existe una imagen
                move_uploaded_file($tmpPhoto, "img/" . $fileName);
            }
            $productController->createProduct($_FILES['imgProduct']['name'],$_SERVER['DOCUMENT_ROOT'].'/test-products/app/controller/img/');
        }elseif($_POST['btnProvider']=='Guardar') {
            if(isset($_GET['id'])) {
                $productController->updateProduct();

            }
        }
    }
    if(isset($_POST['btnDelete'])) {
        $productController->deleteProduct();
    }

}
class ProductController {

    private $productoModel;
    private $imageControllerCloudinary;
    
    public function __construct() {
        $this->productoModel = new ProductModel();
        $this->imageControllerCloudinary = new ImageControllerCloudinary();
    }


    public function createProduct($img,$route) {
        try {
            if( isset($_POST['nameProduct'])
             && isset($_POST['stateProduct'])
              ) {
                $secure_url = $this->imageControllerCloudinary->uploadImage($img,$route);
                $name = $_POST['nameProduct'];
                $state = $_POST['stateProduct'];
                $imgUrl = $secure_url;
                $result = $this->productoModel->createProduct($name,$state,$imgUrl);
                if($result) {
                    echo "Producto creado";
                    header('Location: ../../public/index.php');
                }else {
                    echo "Error al crear el producto";
                }
            }
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
        // eliminar imagen de la carpeta
        if (file_exists('img/' . $img)) {
            unlink('img/' . $img);
        }
    }

    public function getProducts() {
        $products = $this->productoModel->getProducts();
        return $products;
    }

    public function countProducts() {
        $products = $this->productoModel->countProducts();
        return $products;
    }

    public function getProduct() {
        if(isset($_GET['id'])) {
            $id = $_GET['id'];
            $product = $this->productoModel->getProduct($id);
            return $product;
        }
    }

    public function deleteProduct() {
        if(isset($_GET['id'])) {
            $id = $_GET['id']; // obtener el id del producto
            $product = $this->productoModel->getProduct($id); // obtener el producto
            $img = $product['imgProduct']; // obtener la url de la imagen
            $this->imageControllerCloudinary->deleteImage($img); // eliminar de cloudinary
            $result = $this->productoModel->deleteProduct($id); // eliminar de la base de datos
            if($result) {
                echo "Producto eliminado";
                header('Location: ../../public/index.php');
            }else {
                echo "Error al eliminar el producto";
            }
        }
    }

    public function updateProduct() {
        if(isset($_GET['id']) && 
           isset($_POST['nameProduct']) &&
           isset($_POST['stateProduct'])) { 
            $id = $_GET['id'];
            $imgOriginal = $_GET['imgUrl'];
            $name = $_POST['nameProduct'];
            $state = $_POST['stateProduct'];

            $fileName = $_FILES['imgProduct']['name'];// nombre del archivo
            if($fileName!== '') {
                $tmpPhoto = $_FILES['imgProduct']['tmp_name']; // ruta temporal
                if ($tmpPhoto != "") { // si existe una imagen
                    move_uploaded_file($tmpPhoto, "img/" . $fileName); // mover la imagen a la carpeta
                }
                $imgNew = $_FILES['imgProduct']['name']; // nombre de la imagen nueva
                $imgUrl = $this->imageControllerCloudinary->updateImage($imgOriginal,$imgNew,$_SERVER['DOCUMENT_ROOT'].'/test-products/app/controller/img/'); // actualizar la imagen en cloudinary
                $this->imageControllerCloudinary->deleteImage($imgOriginal); // eliminar la imagen de cloudinary
                $result = $this->productoModel->updateProduct($id,$name,$state,$imgUrl); // actualizar la imagen en la base de datos
            }else {
                $result = $this->productoModel->updateProduct($id,$name,$state,$imgOriginal); // actualizar la imagen en la base de datos
            }
            if($result) {
                echo "Producto actualizado";
                header('Location: ../../public/index.php');
            }else {
                echo "Error al actualizar el producto";
            }
            if (file_exists('img/' . $fileName)) {
                unlink('img/' . $fileName);
            }
        }
    }


}

?>