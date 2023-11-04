<?php
include __DIR__.'/../../config/database.php';


class ProductModel {
    private $dbCon;
    public function __construct() {
        $this->dbCon = new ConnectionDataBase();
    }

    public function getProducts() {
        $sql = "SELECT * FROM product";
        $stmt = $this->dbCon->getConnection()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function createProduct($name,$state,$imgUrl) {
        $sql = "INSERT INTO product (nameProduct,imgProduct,statusProduct) VALUES (:name,:imgUrl,:state)";
        $stmt = $this->dbCon->getConnection()->prepare($sql);
        $stmt->bindParam(':nameProduct',$name,PDO::PARAM_STR);
        $stmt->bindParam(':imgProduct',$imgUrl, PDO::PARAM_STR);
        $stmt->bindParam(':statusProduct',$state,PDO::PARAM_STR);
        $stmt->execute();
        if($stmt) {
            return true;
        }else {
            return false;
        }

    }
}

?>