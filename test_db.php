<?php
// test_db.php
$conn = new mysqli('127.0.0.1', 'root', '', 'ensaprojects', 3306);
if ($conn->connect_error) {
    die("Test échoué : " . $conn->connect_error);
}
echo "✅ Connexion MySQL réussie !";
?>
