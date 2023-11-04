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
echo "Hola";
if(isset($_GET['id'])) {
    $id = $_GET['id'];
    echo $id;
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['btnProvider'])) {
        if($_POST['btnProvider']=='Crear') {
            $fileName = $_FILES['imgProduct']['name']; // nombre del archivo
            $tmpPhoto = $_FILES['imgProduct']['tmp_name']; // ruta temporal
            if ($tmpPhoto != "") { // si existe una imagen
                move_uploaded_file($tmpPhoto, "img/" . $fileName);
            }
            $productController->createProduct($_FILES['imgProduct']['name']);
            
        }elseif($_POST['btnProvider']=='Guardar') {
            $id = $_GET['id'];
            $controllerProvider -> updateProvider($id);
            header('Location: '.'../../app/views/admin/providers.php');
        }
    }
    if(isset($_POST['btnDelete'])) {
        $productController->deleteProduct();
    }

}
class ProductController {
    private $productoModel;

    public function __construct() {
        $this->productoModel = new ProductModel();
    }

    public function createProduct($img) {
        Configuration::instance([
            'cloud' => [
                'cloud_name' => CLOUDINARY_NAME, 
                'api_key' => CLOUDINARY_API_KEY, 
                'api_secret' => CLOUDINARY_API_SECRET],
            'url' => [
                'secure' => true]]);
            try {
                $upload = (new UploadApi())->upload($_SERVER['DOCUMENT_ROOT'].'/test-products/app/controller/img/'.$img, [
                    'folder' => 'products',
                    'resource_type' => 'auto',
                ]);
                $secure_url = $upload['secure_url'];
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
            $id = $_GET['id'];
            $product = $this->productoModel->getProduct($id);
            $img = $product['imgProduct'];
            $id_public = explode('/', $img);// separar la url de la imagen
            echo $id_public[7].'/'.$id_public[8].'<br>';
            $img_delete = str_replace('.jpg', '', $id_public[7].'/'.$id_public[8]);
            echo $img_delete;
            // return;
            Configuration::instance([
                'cloud' => [
                    'cloud_name' => CLOUDINARY_NAME, 
                    'api_key' => CLOUDINARY_API_KEY, 
                    'api_secret' => CLOUDINARY_API_SECRET],
                    'url' => [
                    'secure' => true]]);
                    try {
                        $upload = (new AdminApi())->deleteAssets($img_delete, [
                            'resource_type' => 'image',
                            'type' => 'upload',
                        ]);
                    } catch (\Throwable $th) {
                        echo $th->getMessage();
                    }
                    $result = $this->productoModel->deleteProduct($id);
            if($result) {
                echo "Producto eliminado";
                header('Location: ../../public/index.php');
            }else {
                echo "Error al eliminar el producto";
            }
        }
    }



}

?>