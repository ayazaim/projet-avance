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
  <title>Dashboard Étudiant</title>
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

<section class="hero">
  <div class="hero-content">
    <h1>Bienvenue sur votre espace étudiant</h1>
    <p>Vous pouvez gérer vos projets, consulter vos livrables et suivre leur validation ici.</p>
    <div class="hero-buttons">
      <a href="submit_project.php" class="btn">Soumettre un projet</a>
      <a href="my_projects.php" class="btn secondary">Mes projets</a>
    </div>
  </div>
  <div class="hero-image">
    <img src="../img/student_dashboard.svg" alt="Dashboard Étudiant">
  </div>
</section>

</body>
</html>
