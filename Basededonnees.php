<?php
$host = '127.0.0.1';    // utiliser l’IP plutôt que 'localhost'
$port = 3306;           // port MySQL par défaut sous XAMPP
$user = 'root';
$pass = '';
$dbname = 'gestion_projets_ensa';

$conn = new mysqli($host, $user, $pass, $dbname, $port);

if ($conn->connect_error) {
    die("Erreur de connexion MySQL : " . $conn->connect_error);
}
?>
