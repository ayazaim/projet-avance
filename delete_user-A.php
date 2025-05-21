<?php
session_start();
require_once '../Basededonnees.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.html");
    exit();
}

if (isset($_POST['id'])) {
    $id = intval($_POST['id']);
    // On ne supprime pas les admins par sécurité
    $stmt = $conn->prepare("DELETE FROM utilisateurs WHERE id=? AND role <> 'admin'");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}
header("Location: users_list.php");
exit();
?>
