<?php
require_once 'vendor/autoload.php';
require_once 'head/Head.php';
require_once 'int/db.php';

class Product extends Database
{

    public function addProduct($product_name, $category_id, $price, $stock_quantity)
    {
        try {
            $sql = "INSERT INTO Products (product_name, category_id, price, stock_quantity) VALUES (:product_name, :category_id, :price, :stock)";
            $stmt = $this->connect()->prepare($sql);

            $stmt->bindParam("product_name", $product_name, PDO::PARAM_STR);
            $stmt->bindParam("category_id", $category_id, PDO::PARAM_INT);
            $stmt->bindParam("price", $price, PDO::PARAM_INT);
            $stmt->bindParam("stock_quantity", $stock_quantity, PDO::PARAM_INT);

            $rowCount = $stmt->execute();
            return $rowCount;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
}


if($_SERVER['REQUEST_METHOD'] == 'POST') {

    if(isset($_POST['addProduct'])) {


    }

}
?>

<section class="formR">
    <form method="post">
        <label for="product_name">Product_name</label>
        <input type="text" name="product_name" id="product_name">

        <label for="category_id">category_id</label>
        <input type="text" name="category_id" id="category_id">

        <label for="price">price</label>
        <input type="text" name="price" id="price">

        <label for="stock_quantity">stock_quantity</label>
        <input type="text" name="stock_quantity" id="quantity">

        <input type="submit" name="addProduct" value="addProduct">
    </form>

    <a href="Categoriess.php">Categoriess</a>
</section>f