<?php
require_once 'int/db.php';
require_once 'vendor/autoload.php';
require_once 'head/Head.php';

class Categoriess extends Database
{
    //Voegt een category toe in de tabek=l
    public function addCat($category_id, $category_name)
    {
        try {
            $sql = "INSERT INTO Categoriess (category_id, category_name) VALUES (:category_id, :category_name)";
            $stmt = $this->connect()->prepare($sql);

            $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
            $stmt->bindParam(':category_name', $category_name, PDO::PARAM_STR);

            $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Adding category: " . $e->getMessage());
        }
    }

    //Selecteert alles vanuit de table categoriess
    public function getCat()
    {
        try {
            $sql = "SELECT * FROM Categoriess";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error " . $e->getMessage());
        }
    }
    //Verwijdert een geselecteerde row uit de tabel
    public function deleteCategory($category_id)
    {
        try {
            $sql = "DELETE FROM Categoriess WHERE category_id = :category_id";
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->rowCount();
        } catch (PDOException $e) {
            throw new Exception("Deleting category: " . $e->getMessage());
        }
    }
//Update een row 
    public function updateCat($category_id, $category_name)
    {
        try {
            $sql = "UPDATE Categoriess SET category_name = :category_name WHERE category_id = :category_id";
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(":category_name", $category_name, PDO::PARAM_STR);
            $stmt->bindParam(":category_id", $category_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("error" . $e->getMessage());
        }
    }
}

$inCat = '';
$deCat = '';
$uCat = '';
$addCat = new Categoriess();
$delCat = new Categoriess();
$upCat = new Categoriess();


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['addCat'])) {
        $category_id = $_POST['category_id'];
        $category_name = $_POST['category_name'];

        $addCat = new Categoriess();
        $addCat2 = $addCat->addCat($category_id, $category_name);

        if ($addCat2 > 0) {
            $inCat = 'category added';
        } else {
            $inCat = 'failed to add category';
        }
    }

    if (isset($_POST['deleteCategory'])) {
        $category_id = $_POST['category_id'];

        $delCat = new Categoriess();
        $delCat2 = $delCat->deleteCategory($category_id);

        if ($delCat2 > 0) {
            $deCat = 'Category deleted';
        } else {
            $deCat = 'failed to delete a category';
        }
    }

    if (isset($_POST['updateCat'])) {
        $category_id = $_POST['category_id'];
        $category_name = $_POST['category_name'];

        $upCat = new Categoriess();
        $upcat2 = $upCat->updateCat($category_id, $category_name);

        if ($upcat2 > 0) {
            $uCat = "category updated";
        } else {
            $uCat = "failed to update category.";
        }
    }
    
}
?>

<section class="formR">
    <h2>Add category</h2>
    <form method="post">
        <label for="category_id">category_id</label>
        <input type="text" name="category_id" id="category_id">

        <label for="category_name">Category_name</label>
        <input type="text" name="category_name" id="category_name">

        <input type="submit" name="addCat" value="addCat">
    </form>

    <a href="Categoriess.php">Categoriess</a>
</section>

<br>


<section class="formR">

    <form method="post">
        <h2>Update category</h2>
        <label for="category_id">Category_id</label>
        <input type="text" name="category_id" id="category_id">
        <label for="category_name">Category_name</label>
        <input type="text" name="category_name" id="category_name">

        <input type="submit" name="updateCat" value="updateCat">
    </form>
</section>
<br>


    <table class="tab2">
        <thead>
            <tr>
                <th>Category ID</th>
                <th>Category Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            try {
                $categories = $addCat->getCat();

                if ($categories) {
                    foreach ($categories as $cat) {
                        echo "<tr>";
                        echo "<td>{$cat['category_id']}</td>";
                        echo "<td>{$cat['category_name']}</td>";
                        echo "<td>
                            <form method='post' action='{$_SERVER['PHP_SELF']}'>
                                <input type='hidden' name='category_id' value='{$cat['category_id']}'>
                                <input type='hidden' name='deleteCategory' value='1'>
                                <button type='submit'>Delete</button>
                            </form>
                        </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>No categories found</td></tr>";
                }
            } catch (Exception $e) {
                echo "Error fetching categories: " . $e->getMessage();
            }
            ?>
        </tbody>
    </table>