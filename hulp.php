<?php 


//validatie voor de recten toegang voor een gebruiker.
$user_name = $_SESSION['user_name'];

$conn = new PDO("mysql:host=localhost;dbname=kerkelanden", "root", "");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = "SELECT * FROM gebruiker WHERE user_name = :user_name";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':user_name', $user_name);
$stmt->execute();

$result = $stmt->fetch(PDO::FETCH_ASSOC);

// checkt of de gebruiker geen assistent is, als de gebruiker een medewerker of klant is heeft hij geen toegagn tot de app 
if ($result['Rol'] != 'assistent') {
  header("Location: BaseUser.php");
  exit();
}












?>