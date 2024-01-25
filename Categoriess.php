<?php
require_once 'int/db.php';
require_once 'vendor/autoload.php';
require_once 'head/Head.php';


class Categoriess extends Database
{
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

    public function getCat()
    {
        try {
        } catch (PDOException $e) {
        }
    }
}

$inCat = '';
$addCat = new Categoriess();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['getCat'])) {
        $category_id = $_POST['category_id'];
        $category_name = $_POST['category_name'];

        $addCat = new Categoriess();
        $addCat2 =  $addCat->addCat($category_id, $category_name);

        if ($addCat2 > 0) {
            $inCat = 'category added';
        } else {
            $inCat = 'failed to add category';
        }
    }
}
?>


<section class="formR">
    <form method="post">

        <form method="post">

            <label for="category_id">category_id</label>
            <input type="text" name="category_id" id="category_id">

            <label for="category_name">Product_name</label>
            <input type="text" name="category_name" id="category_name">


            <input type="submit" name="addCat" value="addCat">
        </form>

        <a href="Categoriess.php">Categoriess</a>
</section>


<section class="categories-table">
    <table>
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

                foreach ($categories as $cat) {
                    echo "<tr>";
                    echo "<td>{$cat['category_id']}</td>";
                    echo "<td>{$cat['category_name']}</td>";
                    echo "<td>
                            <form method='post' action='{$_SERVER['PHP_SELF']}'>
                                <input type='hidden' name='category_id' value='{$cat['category_id']}'>
                                <input type='hidden' name='action' value='deleteCategory'>
                                <button type='submit'>Delete</button>
                            </form>
                          </td>";
                    echo "</tr>";
                }
            } catch (Exception $e) {
                echo "Error fetching categories: " . $e->getMessage();
            }
            
            ?>
        </tbody>
    </table>
</section>