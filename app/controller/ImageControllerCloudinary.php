<?php
require __DIR__ . '../../../vendor/autoload.php';
use Cloudinary\Configuration\Configuration;
// Use the SearchApi class for searching assets
use Cloudinary\Api\Search\SearchApi;
// Use the AdminApi class for managing assets
use Cloudinary\Api\Admin\AdminApi;
// Use the UploadApi class for uploading assets
use Cloudinary\Api\Upload\UploadApi;
Configuration::instance('cloudinary://218575917988582:uSEuwLNqIrCGJLGHwpRtbM4VWNA@dqpzipc8i?secure=true');

class ImageControllerCloudinary {
    
    public function index() {
        Configuration::instance([
            'cloud' => [
                'cloud_name' => CLOUDINARY_NAME, 
                'api_key' => CLOUDINARY_API_KEY, 
                'api_secret' => CLOUDINARY_API_SECRET],
            'url' => [
                'secure' => true]]);
    }

    public function uploadImage($img,$route) {
        $upload = (new UploadApi())->upload($route.$img, [
            'folder' => 'products',
            'resource_type' => 'auto',
        ]);
        return $upload['secure_url'];
    }

    public function deleteImage($img) {
        try {
            $id_public = explode('/', $img);// separar la url de la imagen
            $img_delete = str_replace('.jpg', '', $id_public[7].'/'.$id_public[8]); // obtener el id de la imagen
            $upload = (new AdminApi())->deleteAssets($img_delete, [
                'resource_type' => 'image',
                'type' => 'upload',
            ]);
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }
    public function updateImage($imgOriginal,$imgNew,$route) {
        $this->deleteImage($imgOriginal);
        $uploadSecure = $this->uploadImage($imgNew,$route);
        return $uploadSecure;
    }
}

?>
<!-- subir imagen -->
<!-- // $upload = (new UploadApi())->upload($_SERVER['DOCUMENT_ROOT'].'/test-products/app/controller/img/'.$img, [
//     'folder' => 'products',
//     'resource_type' => 'auto',
// ]);

// $secure_url = $upload['secure_url']; -->

<!-- eliminar imagen -->
<!-- $id_public = explode('/', $img);// separar la url de la imagen
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
        } -->