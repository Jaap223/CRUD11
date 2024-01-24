<?php
require_once 'vendor/autoload.php';
require_once 'head/Head.php';
require_once 'int/db.php';

class Product extends Database
{

    // Voegt een nieuw product toe aan de database met opgegeven naam, categorie, prijs en voorraadhoeveelheid.
    public function addProduct($product_name, $category_id, $price, $stock_quantity)
    {
        try {
            $sql = "INSERT INTO Products (product_name, category_id, price, stock_quantity) VALUES (:product_name, :category_id, :price, :stock)";
            $stmt = $this->connect()->prepare($sql);

            $stmt->bindParam(":product_name", $product_name, PDO::PARAM_STR);
            $stmt->bindParam(":category_id", $category_id, PDO::PARAM_INT);
            $stmt->bindParam(":price", $price, PDO::PARAM_INT);
            $stmt->bindParam(":stock", $stock_quantity, PDO::PARAM_INT);

            $rowCount = $stmt->execute();
            return $rowCount;
        } catch (PDOException $e) {
            throw new Exception("Error adding product: " . $e->getMessage());
        }
    }


    public function deleteProduct($product_id)
    {
        try {
            $sql = "DELETE FROM Products WHERE product_id = :product_id LIMIT 1";
            $stmt = $this->connect()->prepare($sql);

            $stmt->bindParam(":product_id", $product_id, PDO::PARAM_INT);

            $rowCount = $stmt->execute();

            return $rowCount;
        } catch (PDOException $e) {
            throw new Exception("Error deleting product " . $e->getMessage());
        }
    }



    // Laat alle producten zien met de select statement
    public function getProducts()
    {
        try {
            $sql = "SELECT * FROM Products";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error, geen product gevonden " . $e->getMessage());
        }
    }

    public function updateProduct($product_id, $product_name, $price, $stock)
    {
        try {

            $sql = "UPDATE Products SET product_name = :product_name, price = :price, stock_quantity = :stock WHERE product_id = :product_id";

            $stmt = $this->connect()->prepare($sql);

            $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
            $stmt->bindParam(':product_name', $product_name, PDO::PARAM_STR);
            $stmt->bindParam(':price', $price, PDO::PARAM_INT);
            $stmt->bindParam(':stock', $stock, PDO::PARAM_INT);

            $rowCount = $stmt->execute();

            return $rowCount;
        } catch (PDOException $e) {
            
            
            throw new Exception("Error met het updaten van een product " .  $e->getMessage());
        }
    }
}

$pMessage = '';
$uMes = '';
$delMessag = '';
$delProduct = new Product();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['addProduct'])) {
        $product_name = $_POST['product_name'];
        $category_id = $_POST['category_id'];
        $price = $_POST['price'];
        $stock_quantity = $_POST['stock_quantity'];

        $productIn = new Product();
        $product2 = $productIn->addProduct($product_name, $category_id, $price, $stock_quantity);

        if ($product2 > 0) {
            $pMessage = 'Product inserted';
        } else {
            $pMessage = 'Product insertion failed';
        }
    }

    if (isset($_POST['updateProduct'])) {
        $product_id = $_POST['product_id'];
        $product_name = $_POST['product_name'];
        $price = $_POST['price'];
        $stock_quantity = $_POST['stock_quantity'];

        
        $upProduct = new Product();
        $product3 = $upProduct->updateProduct($product_id, $product_name, $price, $stock_quantity);

        if ($product3 > 0) {
            $uMes = 'Product Updated';
        } else {
            $uMes = 'Product not updated';
        }
    }

    // Checkt of de action bestaat en controleert de deleteProduct functie en verwijdert vervolgens een record uit de tabel 
    if (isset($_POST['action']) && ($_POST['action'] == 'deleteProduct')) {
        $product_id = $_POST['product_id'];
        $del = $delProduct->deleteProduct($product_id);

        if ($del > 0) {
            $delMessag = 'Deletion succesfull';
        } else {
            $delMessag = 'Deletion not succesfull';
        }
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
        <input type="text" name="stock_quantity" id="stock_quantity">

        <input type="submit" name="addProduct" value="addProduct">
    </form>

    <a href="Categoriess.php">Categoriess</a>
</section>
<br>
<br>

<section class="formR">
    <form method="post">
        <label for="product_name">Product_name</label>
        <input type="text" name="product_name" id="product_name">

        <label for="category_id">category_id</label>
        <input type="text" name="category_id" id="category_id">

        <label for="price">price</label>
        <input type="text" name="price" id="price">

        <label for="stock_quantity">stock_quantity</label>
        <input type="text" name="stock_quantity" id="stock_quantity">
        
        
        <input type="hidden" name="product_id" value="<?php echo isset($_POST['product_id']) ? $_POST['product_id'] : ''; ?>">

        <input type="submit" name="updateProduct" value="updateProduct">
    </form>

    <a href="Categoriess.php">Categoriess</a>
</section>

<table class="tab2">
    <h2>Producten</h2>
    <tr>
        <th>ProductID</th>
        <th>Product Name</th>
        <th>Category ID</th>
        <th>Price</th>
        <th>Stock</th>
        <th>Action</th>
    </tr>
    <?php

    $productIn = new Product();
    $productData = $productIn->getProducts();

    foreach ($productData as $product) {
        echo "<tr>";
        echo "<td>{$product['product_id']}</td>";
        echo "<td>{$product['product_name']}</td>";
        echo "<td>{$product['category_id']}</td>";
        echo "<td>{$product['price']}</td>";
        echo "<td>{$product['stock_quantity']}</td>";
        echo "<td>
                <form method='post' action='{$_SERVER['PHP_SELF']}'>
                    <input type='hidden' name='product_id' value='{$product['product_id']}'>
                    <input type='hidden' name='action' value='deleteProduct'>
                    <button type='submit'>Delete</button>
                </form>
              </td>";
        echo "</tr>";
    }
    ?>
</table>

<?php echo $pMessage; ?>
<?php echo $uMes; ?>
<?php echo $delMessag; ?>