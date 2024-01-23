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


?>

<section class="formR">
    <form method="post">
        <label for="product_name">Naam</label>
        <input type="text" name="product_name" id="product_name">

        <label for="category_id">Wachtwoord</label>
        <input type="text" name="category_id" id="category_id">

        <label for="price">Adres</label>
        <input type="text" name="price" id="price">

        <label for="stock_quantity">Telefoonnummer</label>
        <input type="text" name="tel_nr" id="tel_nr">

        <input type="submit" name="Products" value="Products">
    </form>

    <a href="Login.php">Inloggen</a>
</section>f