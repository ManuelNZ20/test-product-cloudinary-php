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
        $stmt->bindParam(':name',$name,PDO::PARAM_STR);
        $stmt->bindParam(':imgUrl',$imgUrl, PDO::PARAM_STR);
        $stmt->bindParam(':state',$state,PDO::PARAM_STR);
        $stmt->execute();
        if($stmt) {
            return true;
        }else {
            return false;
        }

    }
}

?>