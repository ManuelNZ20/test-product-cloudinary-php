<?php
// Cloudinary
require_once __DIR__.'../../vendor/autoload.php';
// use Cloudinary\Configuration\Configuration;

$dontenv = Dotenv\Dotenv::createImmutable(__DIR__.'../../');
$dontenv->load();

define('DRIVER', $_ENV['DRIVER']);
define('HOST', $_ENV['HOST']);
define('USER', $_ENV['USER']);
define('PASS', $_ENV['PASSWORD']);

define('BASE', $_ENV['BASE']);
define('PORT', $_ENV['PORT']);

define('CLOUDINARY_NAME', $_ENV['CLOUDINARY_NAME']);
define('CLOUDINARY_API_KEY', $_ENV['CLOUDINARY_API_KEY']);
define('CLOUDINARY_API_SECRET', $_ENV['CLOUDINARY_API_SECRET']);

  
?>