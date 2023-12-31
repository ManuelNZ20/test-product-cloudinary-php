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
        return ($stmt) ? true : false;
    }

    public function deleteProduct($id) {
        $sql = "DELETE FROM product WHERE idProduct = :id";
        $stmt = $this->dbCon->getConnection()->prepare($sql);
        $stmt->bindParam(':id',$id,PDO::PARAM_INT);
        $stmt->execute();
        return ($stmt) ? true : false;
    }

    public function countProducts() {
        $sql = "SELECT COUNT(*) FROM product";
        $stmt = $this->dbCon->getConnection()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchColumn();
        return $result;
    }

    public function getProduct($id) {
        $sql = "SELECT * FROM product WHERE idProduct = :id";
        $stmt = $this->dbCon->getConnection()->prepare($sql);
        $stmt->bindParam(':id',$id,PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function updateProduct($idProduct,$nameProduct,$statusProduct,$imgProduct) {
        $sql = "UPDATE product SET nameProduct = :nameProduct, statusProduct = :statusProduct, imgProduct = :imgProduct WHERE idProduct = :idProduct";
        $stmt = $this->dbCon->getConnection()->prepare($sql);
        $stmt->bindParam(':idProduct',$idProduct,PDO::PARAM_INT);
        $stmt->bindParam(':nameProduct',$nameProduct,PDO::PARAM_STR);
        $stmt->bindParam(':statusProduct',$statusProduct,PDO::PARAM_STR);
        $stmt->bindParam(':imgProduct',$imgProduct,PDO::PARAM_STR);
        $stmt->execute();
        return ($stmt) ? true : false;
    }
}

?>