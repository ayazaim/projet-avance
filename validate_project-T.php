<?php
session_start();
require_once '../Basededonnees.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'enseignant') {
    header("Location: ../login.html");
    exit();
}

$id_projet = $_POST['id_projet'];
$remarque = $_POST['remarque'] ?? '';
$action = $_POST['action'];

if ($action === 'valider') {
    // Validation projet
    $stmt = $conn->prepare("UPDATE projets SET valide = 1 WHERE id = ?");
    $stmt->bind_param("i", $id_projet);
    $stmt->execute();
    // Ajouter une évaluation/remarque
    if ($remarque) {
        $stmt2 = $conn->prepare("INSERT INTO evaluations (remarque, id_projet, id_enseignant) VALUES (?, ?, ?)");
        $stmt2->bind_param("sii", $remarque, $id_projet, $_SESSION['user_id']);
        $stmt2->execute();
    }
    header("Location: projects_list.php?msg=valide");
    exit();
} else {
    // Projet refusé, on ajoute seulement la remarque (option)
    if ($remarque) {
        $stmt2 = $conn->prepare("INSERT INTO evaluations (remarque, id_projet, id_enseignant) VALUES (?, ?, ?)");
        $stmt2->bind_param("sii", $remarque, $id_projet, $_SESSION['user_id']);
        $stmt2->execute();
    }
    header("Location: projects_list.php?msg=refuse");
    exit();
}
?>
