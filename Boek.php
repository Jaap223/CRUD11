<?php
require_once 'vendor/autoload.php';
require_once 'head/head.php';
require_once 'int/db.php';

class Boek extends Database
{
    public function BoekKopen($status, $datum, $tijd)
    {
        try {
            $sql = "INSERT INTO boeken (status, datum, tijd) VALUES (:status, :datum, :tijd)";
            $stmt = $this->connect()->prepare($sql);

            $stmt->bindParam(':status', $status, PDO::PARAM_STR);
            $stmt->bindParam(':datum', $datum, PDO::PARAM_STR);
            $stmt->bindParam(':tijd', $tijd, PDO::PARAM_INT);

            $stmt->execute();
            $rowCount = $stmt->rowCount();

            header("Location: BoekOverzicht.php");
            exit();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function BoekUpdaten()
    {
        try {
            $sql = "UPDATE boeken WHERE boek_id = :boek_id LIMIT 1";
            $stmt = $this->connect()->prepare($sql);

            $stmt->bindParam(':boek_id', $boek_id, PDO::PARAM_INT);
            $stmt->bindParam(':status', $status, PDO::PARAM_STR);
            $stmt->bindParam(':tijd', $tijd, PDO::PARAM_INT);

            $stmt->execute();
            $rowCount = $stmt->execute();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function deleteBoek($boek_id)
    {
        try {
            $sql = "DELETE FROM boeken WHERE boek_id = :boek_id";
            $stmt = $this->connect()->prepare($sql);

            $stmt->bindParam(':boek_id', $boek_id, PDO::PARAM_INT);
            $stmt->execute();
            $rowCount = $stmt->rowCount();
            return $rowCount;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }


    public function getAllBoeken($sql)
    {
        try {
            $stmt = $this->connect()->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {

            return $e->getMessage();
        }
    }
    
}

$inBoek = new Boek();
$upBoek = new Boek();
$delBoek = new Boek();
$insertMessage = "";
$upMessage = "";

$user_id = $_SESSION['user_id'] ?? null;

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    if (isset($_POST['boekKopen'])) {
        $status = $_POST['status'];
        $datum = $_POST['datum'];
        $tijd = $_POST['tijd'];

        $result = $inBoek->BoekKopen($status, $datum, $tijd);

        if ($result > 0) {
            $insertMessage = 'Boek toegevoegd';
        } else {
            $insertMessage = 'Boek niet toegevoegd';
        }
    }


    if (isset($_POST['BoekUpdaten'])) {
        $status = $_POST['status'];
        $datum = $_POST['datum'];
        $tijd = $_POST['tijd'];

        $result = $upBoek->BoekUpdaten($status, $datum, $tijd);

        if ($result > 0) {
            $upMessage = 'Boek geupdate';
        } else {
            $upMessage = 'boek niet gheupdate';
        }
    }


    if (isset($_POST['deleteBoek'])){
        $boek_id = $_POST['boek_id'];
        $del = $delBoek->deleteBoek($boek_id);

        echo $delBoek > 0 ? "Deletion succesful" : "error";
        
    };
}

?>

<br>
<section class="formR">
    <form method="post">
        <label for="status">status</label>
        <input type="text" name="status" id="status">
        <label for="datum">datum uitgave</label>
        <input type="date" name="datum" id="datum">
        <label for="tijd">tijd om te lezen</label>
        <input type="time" name="tijd" id="tijd">
        <input type="submit" name="boekKopen" value="boekKopen">
    </form>
</section>
<br>
<br>