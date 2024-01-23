<?php
require_once 'vendor/autoload.php';
require_once 'int/db.php';
require_once 'head/head.php';

class BoekOverzicht extends Database
{
    public function getBoeken()
    {

        try {
            $sql = "SELECT * FROM boeken";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return $e->getMessage();
            return array();
        }

    }

    public function deleteBoek($boek_id)
    {
        try {
            $sql = "DELETE FROM boeken WHERE boek_id = :boek_id";
            $stmt = $this->connect()->prepare($sql);

            $stmt->bindParam(':boek_id', $boek_id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function boekInvoeren($status, $datum, $tijd)
    {
        try {
            $sql = "INSERT INTO boeken(status, datum, tijd) VALUES(:status, :datum, :tijd)";
            $stmt = $this->connect()->prepare($sql);

            $stmt->bindParam(":status", $status, PDO::PARAM_STR);
            $stmt->bindParam(":datum", $datum, PDO::PARAM_INT);
            $stmt->bindParam(":tijd", $tijd, PDO::PARAM_INT);

            $rowCount = $stmt->execute();

            return $rowCount;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }


    public function BoekUpdaten($boek_id, $status, $tijd)
    {
        try {
            $sql = "UPDATE boeken SET status = :status, tijd = :tijd WHERE boek_id = :boek_id";

            $stmt = $this->connect()->prepare($sql);

            $stmt->bindParam(':boek_id', $boek_id, PDO::PARAM_INT);
            $stmt->bindParam(':status', $status, PDO::PARAM_STR);
            $stmt->bindParam(':tijd', $tijd, PDO::PARAM_STR);

            $rowCount = $stmt->execute();

            return $rowCount;

        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
}

$boekOverzicht = new BoekOverzicht();
$boeken = $boekOverzicht->getBoeken();


$delResult = new BoekOverzicht();
$mes = "";


$updateB = new BoekOverzicht();
$uMes = "";


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['BoekUpdaten'])) {
        $boek_id = $_POST['boek_id'];
        $status = isset($_POST['status']) ? $_POST['status'] : '';
        $datum = isset($_POST['datum']) ? $_POST['datum'] : '';
        $tijd = isset($_POST['tijd']) ? $_POST['tijd'] : '';
    
        echo "Debug: Boek ID: $boek_id, Status: $status, Datum: $datum, Tijd: $tijd";
        $result = $updateB->BoekUpdaten($boek_id, $status, $datum, $tijd);
    
        if ($result > 0) {
            $uMes = 'Boek geupdatet';
        } else {
            $uMes = 'Boek niet geupdatet';
        }
    }
    

    if (isset($_POST['deleteBoek'])) {
        $boek_id = $_POST['boek_id'];

        $delResult = $boekOverzicht->deleteBoek($boek_id);

        echo $delResult > 0 ? "Deletion successful" : "error";
    }

    if (isset($_POST['boekInvoeren'])) {

        $status = $_POST['status'];
        $datum = $_POST['datum'];
        $tijd = $_POST['tijd'];

        $boekOverzicht1 = new BoekOverzicht();
        $boeken1 = $boekOverzicht1->boekInvoeren($status, $datum, $tijd);

        if ($boeken1 > 0) {
            $mes = "Boek ingevoerd";
        } else {
            $mes = "Boek niet ingevoerd";
        }
    }
}



?>
<br>
<section class="formR">
    <h2>Boek overzicht</h2>
    <table>
        <tr>
            <th>Boek ID</th>
            <th>Status</th>
            <th>Tijd</th>
            <th>Action</th>
        </tr>
        <?php foreach ($boeken as $boek) : ?>
            <tr>
                <td><?php echo $boek['boek_id']; ?></td>
                <td><?php echo $boek['status']; ?></td>
                <td><?php echo $boek['tijd']; ?></td>
                <td>
                    <form method='post' action='<?php echo $_SERVER['PHP_SELF']; ?>'>
                        <input type='hidden' name='boek_id' value='<?php echo $boek['boek_id']; ?>'>
                        <button type='submit' name='deleteBoek'>Delete</button>
                    </form>
                    <!-- <form method='post' action='<?php echo $_SERVER['PHP_SELF']; ?>'>
                        <input type='hidden' name='boek_id' value='<?php echo $boek['boek_id']; ?>'>
                        <button type='submit' name='BoekUpdaten'>Update</button>
                    </form> -->
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <?php echo $mes; ?>

    <?php echo $uMes; ?>

</section>


<br>
</table>

<br>

<section class="formR">
    <form method="post">
        <h2>Boek invoeren</h2>
        <label for="status">status</label>
        <input type="text" name="status" id="status">
        <label for="datum">datum uitgave</label>
        <input type="date" name="datum" id="datum">
        <label for="tijd">tijd om te lezen</label>
        <input type="time" name="tijd" id="tijd">
        <input type="submit" name="boekInvoeren" value="boekInvoeren">
    </form>

</section>


<br>

<section class="formR">
<form method="post">
    <h2>Boek updaten</h2>
    <label for="boek_id">Boek ID</label>
    <input type='text' name='boek_id' id="boek_id">
    <label for="status">status</label>
    <input type="text" name="status" id="status">
    <label for="datum">datum uitgave</label>
    <input type="date" name="datum" id="datum">
    <label for="tijd">tijd om te lezen</label>
    <input type="time" name="tijd" id="tijd">
    <input type="submit" name="BoekUpdaten" value="BoekUpdaten">
</form>

</section>