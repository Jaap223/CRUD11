<?php
require_once 'vendor/autoload.php';
require_once 'head/head.php';
require_once 'int/db.php';

class UpdateBoek extends Database
{
    public function boekUpdaten()
    {

        try {
            $sql = "UPDATE boeken SET status= :status, datum = :datum , tijd = :tijd WHERE boek_id = :boek_id";
            $stmt = $this->connect()->prepare($sql);

            $stmt->bindParam(':status', $status, PDO::PARAM_INT);
            $stmt->bindParam(':datum', $datum, PDO::PARAM_STR);
            $stmt->bindParam(':tijd', $tijd, PDO::PARAM_STR);
            $stmt->bindParam(':book_id', $book_id, PDO::PARAM_INT);
            
            $stmt->execute();
         
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
}
?>

<section class="formR">
    <h2>Update boek </h2>
    <form method="post">
        <label for="status">status</label>
        <input type="text" name="status" id="status">
        <label for="datum">datum uitgave</label>
        <input type="date" name="datum" id="datum">
        <label for="tijd">tijd om te lezen</label>
        <input type="time" name="tijd" id="tijd">
        <input type="submit" name="boekUpdaten" value="boekUpdaten">
    </form>
</section>