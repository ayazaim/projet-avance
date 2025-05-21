<?php
session_start();
require_once '../Basededonnees.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.html");
    exit();
}

$id_etudiant = $_SESSION['user_id'];
$titre = $_POST['titre'];
$description = $_POST['description'];
$categorie = $_POST['categorie'];
$type_projet = $_POST['type_projet'];

$stmt = $conn->prepare("INSERT INTO projets (titre, description, categorie, type_projet, id_etudiant) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("ssssi", $titre, $description, $categorie, $type_projet, $id_etudiant);
$stmt->execute();
$id_projet = $stmt->insert_id;

// Upload de fichiers
$upload_dir = "../uploads/";
foreach ($_FILES['livrables']['tmp_name'] as $index => $tmp_name) {
    if ($_FILES['livrables']['error'][$index] === 0) {
        $filename = basename($_FILES['livrables']['name'][$index]);
        $destination = $upload_dir . time() . "_" . $filename;

        if (move_uploaded_file($tmp_name, $destination)) {
            $type_fichier = mime_content_type($destination);
            $stmt2 = $conn->prepare("INSERT INTO livrables (nom_fichier, type_fichier, id_projet) VALUES (?, ?, ?)");
            $stmt2->bind_param("ssi", $destination, $type_fichier, $id_projet);
            $stmt2->execute();
        }
    }
}

header("Location: my_projects.php?success=1");
exit();
