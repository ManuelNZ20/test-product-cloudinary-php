<?php
include __DIR__.'../../../app/model/ProductModel.php';
require_once __DIR__.'../../../config/config.php';

// Use Composer to manage your PHP library dependency
require __DIR__ . '../../../vendor/autoload.php';

use Cloudinary\Configuration\Configuration;
// Use the SearchApi class for searching assets
use Cloudinary\Api\Search\SearchApi;
// Use the AdminApi class for managing assets
use Cloudinary\Api\Admin\AdminApi;
// Use the UploadApi class for uploading assets
use Cloudinary\Api\Upload\UploadApi;

Configuration::instance('cloudinary://218575917988582:uSEuwLNqIrCGJLGHwpRtbM4VWNA@dqpzipc8i?secure=true');

$productController = new ProductController();
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['btnProvider'])) {
        if($_POST['btnProvider']=='Crear') {
            echo $_POST['nameProduct'].'<br>';
            echo $_POST['stateProduct'].'<br>';
            $productController->createProduct();
            header('Location: ../../public/index.php');
        }elseif($_POST['btnProvider']=='Guardar') {
            $id = $_GET['id'];
            $controllerProvider -> updateProvider($id);
            header('Location: '.'../../app/views/admin/providers.php');
        }
    } 

}

class ProductController {
    private $productoModel;

    public function __construct() {
        $this->productoModel = new ProductModel();
    }

    public function createProduct() {
        Configuration::instance([
                'cloud' => [
                  'cloud_name' => CLOUDINARY_NAME, 
                  'api_key' => CLOUDINARY_API_KEY, 
                  'api_secret' => CLOUDINARY_API_SECRET],
                'url' => [
                  'secure' => true]]);
        if(isset($_POST['nameProduct']) &&
           isset($_POST['stateProduct']) && 
           isset($_FILES['imgProduct'])) {
               // subir la imagen a cloudinary
                try {
                    if($_FILES['imgProduct']['error'] === UPLOAD_ERR_OK ) {
                        $img = $_FILES['imgProduct']['name'];
                        $txtPhoto = (isset($_FILES['imgProduct']['name'])) ? $_FILES['imgProduct']['name'] : '';
                        print $txtPhoto.'<br>';
                        $upload = (new UploadApi())->upload($txtPhoto);
                        $img2 = $upload['secure_url'];
                        echo $img2;
                    }
                    // $name = $_POST['nameProduct'];
                    // $state = $_POST['stateProduct'];
                    // $imgUrl = $img2;
                    // $result = $this->productoModel->createProduct($name,$state,$imgUrl);
                    // if($result) {
                    //     echo "Producto creado";
                    // }else {
                    //     echo "Error al crear el producto";
                    // }
                } catch (\Throwable $th) {
                    echo $th->getMessage();
                }
                
            }
    }

    public function getProducts() {
        $products = $this->productoModel->getProducts();
        return $products;
    }
}

?>