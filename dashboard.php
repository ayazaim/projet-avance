<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'enseignant') {
    header("Location: ../login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Enseignant</title>
  <link rel="stylesheet" href="../style.css">
</head>
<body>

<header>
  <div class="logo">Espace Enseignant</div>
  <nav>
    <ul>
      <li><a href="dashboard.php">Accueil</a></li>
      <li><a href="projects_list.php">Projets à valider</a></li>
      <li><a href="projects_validated.php">Projets validés</a></li>
      <li><a class="btn-connexion" href="../logout.php">Déconnexion</a></li>
    </ul>
  </nav>
</header>

<div class="container">
  <div class="form-title">Bienvenue sur votre espace enseignant !</div>
  <p style="text-align:center;">Consultez et validez les projets soumis par les étudiants.</p>
  <div style="text-align:center; margin-top:2rem;">
    <a href="projects_list.php" class="btn">Voir tous les projets</a>
  </div>
</div>

</body>
</html>
