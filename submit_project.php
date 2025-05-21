<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'etudiant') {
    header("Location: ../login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Soumettre un Projet</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

<header>
    <div class="logo">Portail Étudiant</div>
    <nav>
        <ul>
            <li><a href="dashboard.php">Accueil</a></li>
            <li><a href="submit_project.php">Soumettre un projet</a></li>
            <li><a href="my_projects.php">Mes projets</a></li>
            <li><a class="btn-connexion" href="../logout.php">Déconnexion</a></li>
        </ul>
    </nav>
</header>

<div class="container">
    <div class="form-title">Soumettre un nouveau projet</div>
    <form action="submit_project_process.php" method="POST" enctype="multipart/form-data">

        <div class="input-group">
            <input type="text" name="titre" required placeholder=" ">
            <label>Titre du projet</label>
        </div>

        <div class="input-group">
            <input type="text" name="categorie" required placeholder=" ">
            <label>Catégorie</label>
        </div>

        <div class="input-group">
            <select name="type_projet" required>
                <option value="" disabled selected hidden>Choisir le type</option>
                <option value="stage">Stage</option>
                <option value="module">Module</option>
            </select>
            <label>Type de projet</label>
        </div>

        <div class="input-group">
            <textarea name="description" rows="4" placeholder=" " style="width:100%; padding:10px; border:1px solid #ccc; border-radius:5px;"></textarea>
            <label style="top:-20px; left:10px; font-size:14px;">Description du projet</label>
        </div>

        <div class="input-group">
            <label style="color:#1e3c72;">Livrables (PDF, PPT, ZIP...)</label><br><br>
            <input type="file" name="livrables[]" multiple required>
        </div>

        <button type="submit" class="btn">Soumettre</button>
    </form>
</div>

</body>
</html>